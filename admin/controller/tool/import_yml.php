<?php 
class ControllerToolImportYml extends Controller { 
  private $error = array();

  private $categoryMap = array();

  private $columnsUpdate = array();

  private $skuProducts = array();

  private $flushCount = 50;

  private $file;

  private $fileXML;

  private $settings = array();

  private $productsAdded = 0;

  private $productsUpdated = 0;
  
  public function index() 
  {
    set_time_limit(0);
    $this->load->language('tool/import_yml');
    $this->document->setTitle($this->language->get('page_title'));
    
    $this->load->model('tool/import_yml');
    $this->load->model('catalog/product');
    $this->load->model('catalog/manufacturer');
    $this->load->model('catalog/category');
    $this->load->model('catalog/attribute');
    $this->load->model('catalog/attribute_group');
    $this->load->model('localisation/language');
    $this->load->model('setting/setting');

    $this->settings = $this->model_setting_setting->getSetting('import_yml');
    if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
      $this->model_setting_setting->editSetting('import_yml', $this->request->post);

      $file = DIR_DOWNLOAD . 'import.yml';
      
      if ((isset( $this->request->files['import_yml_upload'] )) && (is_uploaded_file($this->request->files['import_yml_upload']['tmp_name']))) {
        move_uploaded_file($this->request->files['import_yml_upload']['tmp_name'], $file);
      }
	  elseif (!empty($this->request->post['import_yml_url'])) {
        if (filter_var($this->request->post['import_yml_url'], FILTER_VALIDATE_URL)){
    			$file_content = file_get_contents($this->request->post['import_yml_url']);
    			file_put_contents($file, $file_content);
    		} else {
    			$this->error['warning'] = $this->language->get('error_empty');	
    		}
	  } else {
		$this->error['warning'] = $this->language->get('error_empty');
	  }
      
	if (isset($this->error['warning'])) {
		$data['error_warning'] = $this->error['warning'];
	} else {
		  
		$force = (isset($this->request->post['import_yml_force']) && $this->request->post['import_yml_force'] == 'on');

		if (!empty($this->request->post)) {
      $this->columnsUpdate = $this->request->post;
    }

		$this->parseFile($file, $force);

		$this->session->data['success'] = sprintf(
			$this->language->get('text_success'),
			$this->productsAdded,
			$this->productsUpdated
		);
	  }
    }

    $data['settings'] = $this->settings = $this->model_setting_setting->getSetting('import_yml');
    
    $data['save'] = $this->url->link('tool/import_yml/save', 'user_token=' . $this->session->data['user_token'], true);

     if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }
    
    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
    
      unset($this->session->data['success']);
    } else {
      $data['success'] = '';
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('page_title'),
      'href'      => $this->url->link('tool/import_yml', 'user_token=' . $this->session->data['user_token'], true),
    );
    
    $data['action'] = $this->url->link('tool/import_yml', 'user_token=' . $this->session->data['user_token'], true);

    $data['export'] = $this->url->link('tool/import_yml/download', 'user_token=' . $this->session->data['user_token'], true);

    $this->settings = $this->model_setting_setting->getSetting('import_yml');

    if (!empty($this->settings['import_yml_url'])) {
      $data['loaded'] = $this->settings['import_yml_url'];
      
      if ($data['loaded']) {
        $this->session->data['success'] = sprintf(
          $this->language->get('text_success_multiload'),
          $this->settings['import_yml_url'],
          $this->url->link('tool/import_yml/cancel', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['reload'] = true;
      }
    }
    $data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	
	$this->response->setOutput($this->load->view('tool/import_yml', $data));
  }

  private function parseFile($file, $force = false, $cli = false) 
  {
    set_time_limit(0);
    
    $xmlstr = file_get_contents($file);
    $xml = new SimpleXMLElement($xmlstr);

    $this->fileXML = $xml;
	
    if ($force) {
      $this->model_tool_import_yml->deleteCategories();
      $this->model_tool_import_yml->deleteProducts();
      $this->model_tool_import_yml->deleteManufactures();
      $this->model_tool_import_yml->deleteAttributes();
      $this->model_tool_import_yml->deleteAttributeGroups();
    }

    $result = $this->model_tool_import_yml->loadProducts();
  //  echo '<pre>';var_dump($result);echo '</pre>';die();
	if (!empty($result)) {
      foreach ($result as $row) {
		$this->skuProducts[ $row['model'] ] = $row['product_id'];
      }
    }
    
    // Prepare big file upload feature
    if (!$cli) {
      if (empty($this->settings['import_yml_file_hash'])
        || $this->settings['import_yml_file_hash'] != md5($this->file)
      ) {
		$this->model_setting_setting->editSetting('import_yml', $this->settings + array(
          'import_yml_file_hash' => md5($this->file),
          'import_yml_file_name' => DIR_DOWNLOAD . 'import.yml',
          'import_yml_loaded' => 0
        ));

        $this->settings = $this->model_setting_setting->getSetting('import_yml');
      }
    }
    
    $this->addCategories($xml->shop->categories);
    $this->addProducts($xml->shop->offers, $force, $cli);
  }

  private function addCategories($categories) {
    $this->categoryMap[0] = array(
      'category_id' 	=> 0,
	  'name' 			=> 0
    );
    
    $categoriesList = array();
    
    foreach ($categories->category as $category) {
        $categoriesList[ (string)$category['id'] ] = array(
            'parent_id'   => (int)$category['parentId'],
            'name'        => trim((string)$category)
        );
    }
    
    // Compare categories level by level and create new one, if it doesn't exist
    while (count($categoriesList) > 0) {
      $previousCount = count($categoriesList);
      
      foreach ($categoriesList as $source_category_id => $item) {
		if (array_key_exists((int)$item['parent_id'], $this->categoryMap)) {
          $category = $this->model_tool_import_yml->loadCategory($this->categoryMap[$item['parent_id']]['category_id'], $item['name']);
		  if ($category->row) {
            $this->categoryMap[(int)$source_category_id] = array(
				'category_id' 	=> $category->row['category_id'],
				'name' 			=> $item['name']
				);
          } else {
            $category_data = array (
			  'sort_order' => 0,
              'parent_id' => $this->categoryMap[ (int)$item['parent_id'] ]['category_id'],
              'top' => 0,
              'status' => 1,
              'column' => '',
              'category_description' => array (
                1 => array(
                  'name' => $item['name'],
                  'meta_title' => $item['name'],
                  'meta_h1' => $item['name'],
                  'meta_keyword' => '',
                  'meta_description' => '',
                  'description' => '',
                )
              ),
              'keyword' => $this->translitText($item['name']),
              'category_store' => array (
                0
              ),
            );
            
            if ($category_data['parent_id'] == 0) {
              $category_data['top'] = 1;
            }
        
            $this->categoryMap[(int)$source_category_id] = array(
				'category_id'	=> $this->model_catalog_category->addCategory($category_data),
				'name' 			=> $item['name']
				);
          }
          unset($categoriesList[$source_category_id]);
        }
      }
      
      if (count($categoriesList) === $previousCount) {
        break;
        //echo("Unliked tree path:\n");
        //print_r($categoriesList);
        //die();
      }
    }
  }

  private function addProducts($offers, $force = false, $cli = false) {
	$this->error['warning'] = "";
	// get first attribute group
	$res = $this->model_tool_import_yml->loadAttributeGroup();
    if (!$res->row) {
      $attr_group_data = array (
        'sort_order' => 0,
        'attribute_group_description' => array (
          1 => array (
            'name' => 'Basic',
          ),
        )
      );
      $attrGroupId = $this->model_catalog_attribute_group->addAttributeGroup($attr_group_data);
    } else {
      $attrGroupId = (int)$res->row['attribute_group_id'];
    }
    
    /*
        if ($force && is_dir(DIR_IMAGE . 'data/import_yml')) {
            $this->rrmdir(DIR_IMAGE . 'data/import_yml');
        }
    */
    
    if (!is_dir(DIR_IMAGE . 'catalog/import_yml')) {
        mkdir(DIR_IMAGE . 'catalog/import_yml');
    }

    $vendorMap = $this->model_tool_import_yml->loadManufactures();
    
    $attrMap = $this->model_tool_import_yml->loadAttributes();
	
    if (!$cli && !empty($this->settings)) {
      $start = (int)$this->settings['import_yml_loaded'];
    } else {
      $start = 0;
    }

    //Here is start adding products
    $n = count($offers->offer);
    $flushCounter = $this->flushCount;
    for ($i = $start; $i < $n; $i++) {
      $offer = $offers->offer[ $i ];

      $product_images = array();
      
      $dir_name = 'catalog/import_yml/' . implode('/', str_split((string)$offer['id'], 3)) . '/';
      if (!is_dir(DIR_IMAGE . $dir_name)) {
        mkdir(DIR_IMAGE . $dir_name, 0777, true);
      }
      //было $offer->picture поменял на $offer->image т.к. для Прома используется <image> 
      foreach ($offer->image as $picture) {        
        $img_name = substr(strrchr($picture, '/'), 1);
  
        if (!empty($img_name)) {
          $image = $this->loadImageFromHost($picture, DIR_IMAGE . $dir_name . $img_name);
          if ($image) {
            $product_images[] = array('image' => $dir_name . $img_name, 'sort_order' => count($product_images));
          }
        }
      }

      $image_path = array_shift($product_images);
      if (is_array($image_path)) {
        $image_path = $image_path['image'];
      }

      $productName = (string)$offer->name_ua;

      if (!$productName) {
        if (isset($offer->typePrefix)) {
          $productName = (string)$offer->typePrefix . ' ' . (string)$offer->model;
        } else {
          $productName = (string)$offer->model;
        }
      }
      
      $languages = $this->model_localisation_language->getLanguages();

      foreach ($languages as $language) {
        $product_description[ $language['language_id'] ] = array (
          'name' => $productName,
          'meta_title' => $productName,
          'meta_h1' => $productName,
          'meta_keyword' => str_replace(' ', ',', $productName),
          'meta_description' => $productName,
          'description' => (string)$offer->description_ua,
          'tag' => '',
        );
      }
    
	  if ((int)$offer->categoryId == 0 || !isset($this->categoryMap[(int)$offer->categoryId])) {
		foreach ($this->categoryMap as $key => $cat) {
			if (in_array((string)$offer->categoryId, $cat)){
				$id_category = $cat['category_id'];
			}
		}
	  } else {
		  $id_category = $this->categoryMap[(int)$offer->categoryId]['category_id'];
	  } 
	  $data = array(
        'product_description' => $product_description,
        'product_special' => array (),
        'product_store' => array(0),
        'main_category_id' => '',//$id_category,
        'product_category' => '',//array (     $id_category,     ),
        'product_attribute' => array(),
        'model' => (!empty($offer->vendorCode))? (string)$offer->vendorCode : (string)$offer['id'],
        'image' => $image_path,
        'sku'   => (!empty($offer->vendorCode))? (string)$offer->vendorCode : (string)$offer['id'],
        'keyword' => $this->translitText($productName),
        'upc'  => '',
        'ean'  => (isset($offer->ean)) ? $offer->ean : '',
        'jan'  => '',
        'isbn' => '',
        'mpn'  => '',
        'location' => '',
        'quantity' =>  (isset($offer->quantity_in_stock)) ? (int)$offer->quantity_in_stock : '0',
        'minimum' => (isset($offer->minimum)) ? $offer->minimum : '',
        'subtract' => 1,
        'stock_status_id' => ($offer['available'] == 'true')? 7:8,
        'date_available' => $offer->date_available, //date('Y-m-d'),
        'manufacturer_id' => '',
        'shipping' => 1,
        'price' => (float)$offer->price,
        'points' => '',
        'weight' => '', 
        'weight_class_id' => '',
        'length' => '',
        'width' => '',
        'height' => '',
        'length_class_id' => '',
        'status' => '1',
        'tax_class_id' => '',
        'sort_order' => '',
        'product_image' => $product_images,
        'no_index' => 0,
        'product_tag' => array(), // for ocstore 1.5.1
       );

       if ((float)$offer->clear_price < (float)$offer->price){

          $data['product_special'][] =array(
            'customer_group_id' => 1,
            'price'=> (float)$offer->clear_price,
            'priority'=>'',
            'date_start'=>'0000-00-00',
            'date_end'=> '0000-00-00'
          );

        }

       if (isset($offer->vendor)) {
        $vendor_name = (string)$offer->vendor;
        
        if (!isset($vendorMap[$vendor_name])) {
          $manufacturer_data = array (
            'name' => $vendor_name,
            'sort_order' => 0,
            'manufacturer_description' => array (
              1 => array (
                'name' => $vendor_name,
                'description' => $vendor_name,
                'meta_title' => $vendor_name,
                'meta_h1' => $vendor_name,
                'meta_keyword' => $vendor_name,
                'meta_description' => $vendor_name,
              )
            ),
            'manufacturer_store' => array ( 0 ),
            'keyword' => $this->translitText($vendor_name),
          );
          
          $vendorMap[$vendor_name] = $this->model_catalog_manufacturer->addManufacturer($manufacturer_data);
        }
        
        $data['manufacturer_id'] = $vendorMap[(string)$offer->vendor];
      }
      
      if (isset($offer->param)) {
        $params = $offer->param;
        
        foreach ($params as $param) {
          $attr_name = (string)$param['name'];
          $attr_value = (string)$param;
          
          if (array_key_exists($attr_name, $attrMap) === false) {
            $attr_data = array (
              'sort_order' => 0,
              'attribute_group_id' => $attrGroupId,
              'attribute_description' => array (
                1 => array (
                  'name' => $attr_name,
                ),
                3 => array (
                  'name' => $attr_name,
                )
              ),
            );
            
            $attrMap[$attr_name] = $this->model_catalog_attribute->addAttribute($attr_data);
          }
          
          $data['product_attribute'][] = array (
            'attribute_id' => $attrMap[$attr_name],
            'product_attribute_description' => array (
              1 => array (
                'text' => $attr_value,
              ),
               3 => array (
                'text' => $attr_value,
              )
            )
          );
        }
      }
	  if (array_key_exists($data['model'], $this->skuProducts)) {
		$data = $this->changeDataByColumns($this->skuProducts[ $data['model'] ], $data);
        $this->model_catalog_product->editProduct($this->skuProducts[ $data['model'] ], $data);
        $this->productsUpdated++;
		if ($force) { $this->error['warning'] .= "Update Product : " . $data['model'] . " ";}
      } else {
        $this->skuProducts[ $data['model'] ] = $this->model_catalog_product->addProduct($data);
        $this->productsAdded++;
      }

      --$flushCounter;
      
      if ($flushCounter <= 0) {
        $loaded = $i;

        $this->model_setting_setting->editSetting('import_yml', $this->settings + array(
          'import_yml_file_hash' => md5($this->file),
          'import_yml_offers' => count($offers->offer),
          'import_yml_loaded' => $loaded
        ));

        $flushCounter = $this->flushCount;
      }
    } //end for
  //echo '<pre>';var_dump($offers);echo '</pre>';die();
    $n = count($offers->offer);
    $products_on_shop = $this->skuProducts;
    foreach( $products_on_shop as $model=>$product_id){
        //echo '<pre>';var_dump($model);echo '</pre>';

       for ($i = 0; $i < $n; $i++) {
            $offer = $offers->offer[ $i ];  
            if ($offer->model == (string)$model){
                //echo $offer->model . ' модель фида'."<br>";
                //echo $model . ' модель на сайте'."<br>";
               unset($products_on_shop[$model]);
            }
        }   
   
      
    }

    $this->load->model('catalog/product');
    
    foreach ($products_on_shop as $model=>$product_id){
      $this->model_catalog_product->editProductStatus($product_id,0);
    }
    //echo '<pre>';var_dump($products_on_shop);echo '</pre>';//  [289]=> string(2) "95"  95-id товара который нужно выключить
    



  }

  private function loadImageFromHost($link, $img_path)
  {
    if (!file_exists($img_path)) {
      $ch = curl_init($link);
      $fp = fopen($img_path, "wb");
      if ($fp) {
        $options = array(CURLOPT_FILE => $fp,
                 CURLOPT_HEADER => 0,
                 /*CURLOPT_FOLLOWLOCATION => 1,*/
                 CURLOPT_TIMEOUT => 60,
              );

        curl_setopt_array($ch, $options);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
      }

      return file_exists($img_path);
    }
    
    return true;
  }

  private function rrmdir($dir)
  {
    foreach(glob($dir . '/*') as $file) {
      if(is_dir($file))
          rrmdir($file);
      else
          unlink($file);
    }
    rmdir($dir);
  }

  private function changeDataByColumns($product_id, $data)
  {
    $productData = $this->model_catalog_product->getProduct($product_id);
    $productAttributes = $this->model_catalog_product->getProductAttributes($product_id);

    if (empty($this->columnsUpdate['name'])) {
      $data['product_description'][1]['import_yml_name'] = $productData['name'];
    }

    if (empty($this->columnsUpdate['import_yml_description'])) {
      $data['product_description'][1]['description'] = $productData['description'];
    }

    if (empty($this->columnsUpdate['import_yml_category'])) {
      $productData = array_merge($productData, array('product_category' => $this->model_catalog_product->getProductCategories($product_id)));
      $data['product_category'] = $productData['product_category'];
    }
    
    if (empty($this->columnsUpdate['import_yml_price'])) {
      $data['price'] = $productData['price'];
    }

    if (empty($this->columnsUpdate['import_yml_image'])) {
      $data['image'] = $productData['image'];
    }

    if (empty($this->columnsUpdate['import_yml_manufacturer'])) {
      $data['manufacturer_id'] = $productData['manufacturer_id'];
    }

    if (empty($this->columnsUpdate['import_yml_attributes'])) {
      $data['product_attribute'] = $productAttributes;
    }

    return $data;
  }

  public function cron()
  {
    $this->load->language('tool/import_yml');
    $this->load->model('tool/import_yml');
    $this->load->model('catalog/product');
    $this->load->model('catalog/manufacturer');
    $this->load->model('catalog/category');
    $this->load->model('catalog/attribute');
    $this->load->model('catalog/attribute_group');
    $this->load->model('localisation/language');
    $this->load->model('setting/setting');

    $this->settings = $this->model_setting_setting->getSetting('import_yml');

    if (!empty($this->settings['import_yml_url'])) {
      $force = (isset($this->settings['import_yml_force']) && $this->settings['import_yml_force'] == 'on');

      if (!empty($this->settings)) {
        $this->columnsUpdate = $this->settings;
      }

      $this->parseFile($this->settings['import_yml_url'], $force, true);
    }
  }

  public function save()
  {
    $this->load->model('setting/setting');
    $this->load->language('tool/import_yml');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
      		
  	  $this->model_setting_setting->editSetting('import_yml', $this->request->post);

      $this->session->data['success'] = $this->language->get('text_settings_success');
  	  
  	  $this->response->redirect($this->url->link('tool/import_yml', 'user_token=' . $this->session->data['user_token'], true));
    
	   }
  }

  public function resume()
  {
    $this->load->model('tool/import_yml');
    $this->load->model('setting/setting');
  }
  
  public function cancel()
  {
    $this->load->model('tool/import_yml');
    $this->load->model('setting/setting');

    unlink(DIR_DOWNLOAD . 'import.yml');
    
    $this->model_setting_setting->editSetting('import_yml', array());

    $this->response->redirect($this->url->link('tool/import_yml', 'user_token=' . $this->session->data['user_token'], true));
  }
  
  private function validate()
  {
    if (!$this->user->hasPermission('modify', 'tool/import_yml')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
  }  
  private function translitText($string) 
  { 
    $replace = array(
      "А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
      "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z",
      "И"=>"I","и"=>"i", 
      "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
      "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
      "Х"=>"H","х"=>"h","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
      "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"",
      "«"=>"", "»"=>"", "„"=>"", "“"=>"", "“"=>"", "”"=>"", "\•"=>"", "%"=>"", "$"=>"", "_"=>"-", " "=>"-", "."=>"-", ","=>"-",
      "І"=>"I","і"=>"i",
      "Ї"=>"Yi","ї"=>"yi",
      "Є"=>"Ye","є"=>"ye",
    );

    $output = iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    $output = strtolower($output);
    $output = preg_replace('~[^-a-z0-9_]+~u', '-', $output);
    $output = trim($output, "-");
    $output = str_replace("----", "-", $output);
    $output = str_replace("---", "-", $output);
    $output = str_replace("--", "-", $output);
    return $output; 
  }
}
?>
