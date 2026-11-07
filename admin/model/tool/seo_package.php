<?php
class ModelToolSeoPackage extends Model {
  
  private $store_names = array();
  private $store_countries = array();

  public function __construct($registry) {
    parent::__construct($registry);
    
    if (version_compare(VERSION, '3', '>=')) {
      $this->url_alias = 'seo_url';
    } else {
      $this->url_alias = 'url_alias';
    }
  }
    
  public function getFriendlyUrls($lang) {

  }
  
  public function getProductOptions($product_id, $lang) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
      $options_values = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON(pov.option_value_id = ov.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY ov.sort_order ASC");
      
			foreach ($product_option_value_query->rows as $product_option_value) {
        $opt_value = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "' AND ovd.language_id = '" . (int)$lang . "'")->row;

        if (isset($opt_value['name'])) {
          $options_values[] = $opt_value['name'];
        }
			}

			$product_option_data[strtolower($product_option['name'])] = implode(' ', $options_values);
		}

		return $product_option_data;
	}
  
  public function getAttributes($product_id, $lang, $asArray = false) {
    
		$product_attribute_query = $this->db->query("SELECT pa.text, ad.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute_description ad ON ad.attribute_id = pa.attribute_id WHERE pa.product_id = '" . (int)$product_id . "' AND pa.language_id = " . (int) $lang . " AND ad.language_id = " . (int) $lang . " GROUP BY pa.attribute_id");

    if ($asArray) {
      $output = array();
      
      foreach ($product_attribute_query->rows as $product_attribute) {
        $output[strtolower($product_attribute['name'])] = $product_attribute['text'];
      }
    } else {
      $output = '';
      
 		  foreach ($product_attribute_query->rows as $product_attribute) {
        $output .= ($output ? ', ': '') . $product_attribute['name'] . ': ' . $product_attribute['text'];
 		  }
		}
    
    return $output;
	}
  
	public function getProductCategoryName($product_id, $lang, $parent = false) {
    if ($parent) {
      $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category c ON c.category_id = pc.category_id LEFT JOIN " . DB_PREFIX . "category_path cp ON (cp.category_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON cd.category_id = c.parent_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id = " . $lang . " ORDER BY cp.level DESC LIMIT 1")->row;
    } else {
      $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) LEFT JOIN " . DB_PREFIX . "category_path cp ON (p2c.category_id = cp.category_id) WHERE p2c.product_id = '" . (int)$product_id . "' AND cd.language_id = " . $lang . " ORDER BY cp.level DESC LIMIT 1")->row;
    }
		
		if (isset($query['name']))
			return $query['name'];
		return '';
	}
  
  public function getCategoryName($category_id, $lang, $parent = false) {
    if (is_array($category_id)) {
      $cat_ids = implode(',', array_map('intval', $category_id));
      
      if ($parent) {
        $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_path cp ON (cp.category_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.parent_id) WHERE c.category_id IN (" . $cat_ids . ") AND cd.language_id = " . $lang . " ORDER BY cp.level DESC")->row;
      } else {
        $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = cp.category_id) WHERE cp.category_id IN (" . $cat_ids . ") AND cd.language_id = " . $lang . " ORDER BY cp.level DESC")->row;
      }
    } else if ($parent) {
      $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_path cp ON (cp.category_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON cd.category_id = c.parent_id WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = " . $lang . " ORDER BY cp.level DESC LIMIT 1")->row;
    } else {
      $query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category_description cd LEFT JOIN " . DB_PREFIX . "category_path cp ON (cp.category_id = cd.category_id) WHERE cd.category_id = '" . (int)$category_id . "' AND cd.language_id = " . $lang . " ORDER BY cp.level DESC LIMIT 1")->row;
    }
		
		if (isset($query['name']))
			return $query['name'];
		return '';
	}
  
  public function getCategoryPrice($category_id, $type = 'lowest') {
    if(!isset($this->tax)) {
      if (version_compare(VERSION, '2.2', '>=')) {
        $this->registry->set('tax', new \Cart\Tax($this->registry));
      } else {
        if(!class_exists('Tax')) {
          require_once(DIR_SYSTEM . 'library/tax.php');
        }
        if(!class_exists('Customer')) {
          require_once(DIR_SYSTEM . 'library/customer.php');
          $this->registry->set('customer', new Customer($this->registry));
        }
        $this->tax = new Tax($this->registry);
      }
      
      // set shipping address of store for tax calculation
      $this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
      $this->tax->setPaymentAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
      $this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
    }
    
    $order = ($type == 'lowest') ? 'ASC' : 'DESC';
    
    $query = $this->db->query("SELECT p.price, p.tax_class_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id = '" . (int)$category_id . "' ORDER BY p.price " . $order . " LIMIT 1")->row;
    
    if (!empty($query['price'])) {
			$price = $this->currency->format($this->tax->calculate($query['price'], $query['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency'));
      
      if (function_exists('mb_substr')) {
        if (mb_substr($price, -3) == '.00' || mb_substr($price, -3) == ',00') {
          return mb_substr($price, 0, -3);
        }
      } else {
        if (substr($price, -3) == '.00' || substr($price, -3) == ',00') {
          return substr($price, 0, -3);
        }
      }
      
      return $price;
    }
    
		return '';
  }
  
  public function getGrandParentCategoryName($category_id, $lang) {
		$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category ch ON (c.parent_id = ch.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = ch.parent_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = " . $lang . " LIMIT 1")->row;
		
		if (isset($query['name']))
			return $query['name'];
		return '';
	}
  
  public function getParentCategoryName($category_id, $lang) {
		//$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category_description cd LEFT JOIN " . DB_PREFIX . "category c ON c.category_id = cd.category_id WHERE cd.category_id = '" . (int)$category_id . "' AND language_id = " . $lang . " LIMIT 1")->row;
		$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON c.parent_id = cd.category_id WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = " . $lang . " LIMIT 1")->row;
		
		if (isset($query['name']))
			return $query['name'];
		return '';
	}
  
  public function getChildCategoryName($category_id, $lang) {
		//$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category_description cd LEFT JOIN " . DB_PREFIX . "category c ON c.category_id = cd.category_id WHERE cd.category_id = '" . (int)$category_id . "' AND language_id = " . $lang . " LIMIT 1")->row;
		$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON c.category_id = cd.category_id WHERE c.parent_id = '" . (int)$category_id . "' AND cd.language_id = " . $lang . " LIMIT 1")->row;
		
		if (isset($query['name']))
			return $query['name'];
		return '';
	}
	
	public function getProductCategoryId($product_id) {
		$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' LIMIT 1")->row;
		
		if (isset($query['category_id']))
			return $query['category_id'];
		return '';
	}
	
  public function getManufacturerData($manufacturer_id, $lang, $store_id) {
		$query = $this->db->query("SELECT m.name as orig_name, d.name, d.description as 'desc', d.meta_description as meta_desc, d.meta_title as title, d.meta_keyword as keywords, d.seo_h1 as h1, d.seo_h2 as h2, d.seo_h3 as h3 FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "seo_manufacturer_description d ON (m.manufacturer_id = d.manufacturer_id AND d.language_id=" . (int) $lang . " AND d.store_id = '" . (int) $store_id . "') WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' LIMIT 1")->row;
		
    if (empty($query['name']) && isset($query['orig_name'])) {
      $query['name'] = $query['orig_name'];
    }
    
		return $query;
	}
	
	public function applyFunctions($value) {
    // apply functions
    $fn = 'upcase|lowcase|ucfirst';
    $value = preg_replace_callback('#\{('.$fn.')\}(.+?)\{\/(?:'.$fn.')\}#', array($this, 'pregFunctions'), $value);
    
    // truncate without breaking word
    if (preg_match('#{limit:(\d+)}#', $value, $limit)) {
      $value = str_replace($limit[0], '', $value);
      //$value = trim(mb_substr($value, 0, (int) $limit[1]));
      
      if (strlen($value) > (int) $limit[1]) {
        $newstr = substr($value, 0, (int) $limit[1]);
        if (substr($newstr,-1,1) != ' ') {
          $newstr = substr($newstr, 0, strrpos($newstr, ' '));
        }
        $value = $newstr;
      }  

    }
    
    // basic double comma removing
    $value = trim(preg_replace('/(?:,\s*,+)+/', ', ', $value), ', ');
    
    return $value;
  }
  
	public function pregFunctions($values) {
    if ($values[1] == 'upcase') {
      return strtoupper($values[2]);
    } else if ($values[1] == 'lowcase') {
      return strtolower($values[2]);
    } else if ($values[1] == 'ucfirst') {
      return ucwords(strtolower($values[2]));
    }
  }
	
	public function commonTransform($pattern, $lang, $row, $store_id = 0, $get_value = false) {
    $replace  = array();
    
    if ($this->config->get('mlseo_current_lang')) {
      $lang_code = $this->config->get('mlseo_current_lang');
    } else {
      $lang_code = $this->getLangCode($lang);
    }
    
    $replace['{'.$lang_code.'}'] = '';
    $replace['{/'.$lang_code.'}'] = '';
    
    if (function_exists('mb_substr')) {
      $replace['{'.mb_substr($lang_code, 0, 2).'}'] = '';
      $replace['{/'.mb_substr($lang_code, 0, 2).'}'] = '';
    } else {
      $replace['{'.substr($lang_code, 0, 2).'}'] = '';
      $replace['{/'.substr($lang_code, 0, 2).'}'] = '';
    }
    
    if (strpos($pattern, '[store]') !== false) {
      if (isset($this->store_names[$store_id])) {
        $replace['[store]'] = $this->store_names[$store_id];
      } else {
        if (!$store_id) {
          $this->store_names[$store_id] = $replace['[store]'] = $this->config->get('config_name');
        } else {
          $this->load->model('setting/store');
          $store_data = $this->model_setting_store->getStore($store_id);
          $this->store_names[$store_id] = $replace['[store]'] = $store_data['name'];
        }
      }
    }
    
    /*
    if (strpos($pattern, '[store_country]') !== false) {
      if (isset($this->store_countries[$store_id])) {
        $replace['[store_country]'] = $this->store_countries[$store_id];
      } else {
        $this->load->model('localisation/country');
        
        if (!$store_id) {
          $country = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));
          $this->store_countries[$store_id] = $replace['[store_country]'] = isset($country['name']) ? $country['name'] : '';
        } else {
          $this->load->model('setting/store');
          $store_data = $this->model_setting_store->getStore($store_id);
          $country = $this->model_localisation_country->getCountry($store_data['config_country_id']);
          $this->store_countries[$store_id] = $replace['[store_country]'] = isset($country['name']) ? $country['name'] : '';
        }
      }
    }
    */
    
    if (strpos($pattern, '[lang_id]') !== false)
			$replace['[lang_id]'] = $lang;
		if (strpos($pattern, '[lang]') !== false)
			$replace['[lang]'] = $lang_code;
    
    $pattern = preg_replace('#\[(.+?)\|(uppercase|lowercase)\]#', '{$2}[$1]{/$2}', $pattern);
    
    $pattern = str_replace(array_keys($replace), array_values($replace), $pattern);

    if ($this->config->get('mlseo_lang_codes')) {
      $lgCodes = array();
      foreach ($this->config->get('mlseo_lang_codes') as $lgCode) {
        $lgCodes[] = $lgCode;
        if (function_exists('mb_substr')) {
          $lgCodes[] = mb_substr($lgCode, 0, 2);
        } else {
          $lgCodes[] = substr($lgCode, 0, 2);
        }
      }
      $lgCodes = implode('|', $lgCodes);
      
      $pattern = preg_replace('/\{('.$lgCodes.')\}(.*)\{\/('.$lgCodes.')\}/isU', '', $pattern);
    }
    
    while (preg_match_all('#\{([^\{].+\|.+)\}#U', $pattern, $results, PREG_SET_ORDER)) {
      if ($results) {
        foreach ($results as $res) {
          $rand = explode('|', $res[1]);
          
          if (is_array($rand)) {
            if ($get_value) {
              if (isset($this->session->data['gkd_seorand'][abs(crc32($pattern))]) && $this->session->data['gkd_seorand'][abs(crc32($pattern))]+1 <= count($rand)-1) {
                $this->session->data['gkd_seorand'][abs(crc32($pattern))]++;
              } else {
                $this->session->data['gkd_seorand'][abs(crc32($pattern))] = 0;
              }
            
              $pattern = str_replace($res[0], $rand[$this->session->data['gkd_seorand'][abs(crc32($pattern))]], $pattern);
            } else {
              $pattern = str_replace($res[0], $rand[array_rand($rand)], $pattern);
            }
          }
        }
      }
    }
    
    return $pattern;
  }
  
	public function transformProduct($pattern, $lang, $row, $store_id = 0, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $store_id, $get_value);
    
		if (!isset($row['name'])) {
      if (isset($row['orig_name'])) {
        $row['name'] = $row['orig_name'];
      } else {
   			$row['name'] = isset($row['product_description'][$lang]['name']) ? $row['product_description'][$lang]['name'] : '';
      }
		}
    
    if (!isset($row['description'])) {
      if (isset($row['orig_description'])) {
        $row['description'] = $row['orig_description'];
      } else {
   			$row['description'] = isset($row['product_description'][$lang]['description']) ? $row['product_description'][$lang]['description'] : '';
      }
		}
    
    //$this->load->model('catalog/product');
    //$product_attributes = $this->model_catalog_product->getProductAttributes($row['product_id']);
    
    // $product_attributes = $this->db->query("SELECT ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$row['product_id'] . "' AND ad.language_id = '" . (int)$lang . "' AND pa.language_id = '" . (int)$lang . "' ORDER BY a.sort_order, ad.name")->rows;
		// var_dump($product_attributes);die;
    // preg_match('#\[attribute_name:(\d)\]#', $pattern, $res);
    
		$replace  = array();
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['name']);
		if (strpos($pattern, '[model]') !== false)
			$replace['[model]'] = trim($row['model']);
		if (strpos($pattern, '[upc]') !== false)
			$replace['[upc]'] = trim($row['upc']);
		if (strpos($pattern, '[sku]') !== false)
			$replace['[sku]'] = trim($row['sku']);
		if (strpos($pattern, '[ean]') !== false)
			$replace['[ean]'] = trim($row['ean']);
		if (strpos($pattern, '[jan]') !== false)
			$replace['[jan]'] = trim($row['jan']);
		if (strpos($pattern, '[isbn]') !== false)
			$replace['[isbn]'] = trim($row['isbn']);
		if (strpos($pattern, '[mpn]') !== false)
			$replace['[mpn]'] = trim($row['mpn']);
		if (strpos($pattern, '[location]') !== false)
			$replace['[location]'] = trim($row['location']);
    if (strpos($pattern, '[price_notax]') !== false) 
      $replace['[price_notax]'] = (float)$row['price'] ? $this->currency->format($row['price'], $this->config->get('config_currency')) : '';
    if (strpos($pattern, '[price]') !== false) {
      if (version_compare(VERSION, '2.2', '>=')) {
        $this->registry->set('tax', new \Cart\Tax($this->registry));
      } else {
        if(!class_exists('Tax')) {
          require_once(DIR_SYSTEM . 'library/tax.php');
        }
        if(!class_exists('Customer')) {
          require_once(DIR_SYSTEM . 'library/customer.php');
          $this->registry->set('customer', new Customer($this->registry));
        }
        $this->tax = new Tax($this->registry);
      }
      
      // set shipping address of store for tax calculation
      $this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
      $this->tax->setPaymentAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
      $this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
      
      
      if (!empty($row['product_special'])) {
        foreach ($row['product_special'] as $prod_special) {
          if ($prod_special['customer_group_id'] == $this->config->get('mlseo_special_group')) {
            if ((float)$prod_special['price']) {
              $replace['[price]'] = $this->currency->format($this->tax->calculate($prod_special['price'], $row['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency'));
            } else {
              $replace['[price]'] = (float)$row['price'] ? $this->currency->format($this->tax->calculate($row['price'], $row['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')) : '';
            }
          } else {
            $replace['[price]'] = (float)$row['price'] ? $this->currency->format($this->tax->calculate($row['price'], $row['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')) : '';
          }
        }
      } else if (isset($row['special']) && (float)$row['special']) {
        $replace['[price]'] = (float)$row['special'] ? $this->currency->format($this->tax->calculate($row['special'], $row['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')) : '';
      } else {
        $replace['[price]'] = (float)$row['price'] ? $this->currency->format($this->tax->calculate($row['price'], $row['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')) : '';
      }
    }
		if (strpos($pattern, '[prod_id]') !== false)
			$replace['[prod_id]'] = isset($row['product_id']) ? trim($row['product_id']) : '';
		if (strpos($pattern, '[cat_id]') !== false)
			$replace['[cat_id]'] = isset($row['product_id']) ? trim($this->getProductCategoryId($row['product_id'], $lang)) : '';
		if (strpos($pattern, '[category]') !== false) {
      if (!empty($this->request->post['product_category'])) {
        $replace['[category]'] = trim($this->getCategoryName($this->request->post['product_category'], $lang));
      } else if (!empty($row['product_category'])) {
        $replace['[category]'] = trim($this->getCategoryName($row['product_category'], $lang));
      } else if (isset($row['product_id'])) {
        $replace['[category]'] = trim($this->getProductCategoryName($row['product_id'], $lang));
      } else {
        $replace['[category]'] = '';
      }
    }
		if (strpos($pattern, '[parent_cat]') !== false) {
      if (!empty($this->request->post['product_category'])) {
        $replace['[parent_cat]'] = $replace['[parent_category]'] = trim($this->getCategoryName($this->request->post['product_category'], $lang, true));
      } else if (!empty($row['product_category'])) {
        $replace['[parent_cat]'] = $replace['[parent_category]'] = trim($this->getCategoryName($row['product_category'], $lang, true));
      } else if (isset($row['product_id'])) {
        $replace['[parent_cat]'] = $replace['[parent_category]'] = trim($this->getProductCategoryName($row['product_id'], $lang, true));
      } else {
        $replace['[parent_cat]'] = $replace['[parent_category]'] = '';
      }
    }
    
    if (preg_match_all('/\[brand(?:_(\w+))?\]/', $pattern, $brandMatches)) {
      $brandData = !empty($row['manufacturer_id']) ? $this->getManufacturerData($row['manufacturer_id'], $lang, $store_id) : array();
      
      if (!empty($brandMatches)) {
        foreach ($brandMatches[1] as $brandTag) {
          if (!$brandTag) {
            $replace['[brand]'] = isset($brandData['name']) ? $brandData['name'] : '';
          } else {
            $replace['[brand_'.$brandTag.']'] = isset($brandData[$brandTag]) ? $brandData[$brandTag] : '';
          }
        }
      }
    }
		
    if (strpos($pattern, '[desc]') !== false) {
      if (function_exists('mb_substr')) {
        $replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', mb_substr(strip_tags(str_replace(array('</p>', '</li>'), array('</p> ', '</li> '), html_entity_decode((isset($row['description']) ? $row['description'] : ''), ENT_QUOTES, 'UTF-8'))), 0, 220)));
      } else {
        $replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', substr(strip_tags(str_replace(array('</p>', '</li>'), array('</p> ', '</li> '), html_entity_decode((isset($row['description']) ? $row['description'] : ''), ENT_QUOTES, 'UTF-8'))), 0, 220)));
      }
    }
		if (strpos($pattern, '[desc_sentence]') !== false) {
       preg_match('#(.*?)(?:</p>|\.|\!)#is', html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8'), $desc_extract);
       
       if (isset($desc_extract[1])) {
         $replace['[desc_sentence]'] = strip_tags($desc_extract[1]);
       } else {
         $replace['[desc_sentence]'] = '';
       }
    }
    
    if (strpos($pattern, '[attr]') !== false || strpos($pattern, '[attributes]') !== false) {
      $replace['[attr]'] = $replace['[attributes]'] = !empty($row['product_id']) ? $this->getAttributes($row['product_id'], $lang) : '';
    }
    
    if (preg_match_all('#\[cat_(\d)\]#', $pattern, $catLevels)) {

      if (!empty($this->request->post['product_category'])) {
        $categories = $this->getFullProductPathNames($this->request->post['product_category'], $lang, true);
      } else if (!empty($row['product_category'])) {
        $categories = $this->getFullProductPathNames($row['product_category'], $lang, true);
      } else if (isset($row['product_id'])) {
        $categories = $this->getFullProductPathNames($row['product_id'], $lang);
      } else {
        $categories = array();
      }
      
      foreach ($catLevels[1] as $catLevel) {
        $replace['[cat_'.$catLevel.']'] = isset($categories[$catLevel-1]) ? $categories[$catLevel-1] : '';
      }
    }
    
    if (preg_match_all('#\[attr_(.+?)\]#', $pattern, $attrNames)) {
      $attrValues = !empty($row['product_id']) ? $this->getAttributes($row['product_id'], $lang, true) : array();
      
      foreach ($attrNames[1] as $attrName) {
        $replace['[attr_'.$attrName.']'] = isset($attrValues[strtolower($attrName)]) ? $attrValues[strtolower($attrName)] : '';
      }
    }
    
    if (preg_match_all('#\[opt_(.+?)\]#', $pattern, $optNames)) {
      $optValues = !empty($row['product_id']) ? $this->getProductOptions($row['product_id'], $lang) : array();
      
      foreach ($optNames[1] as $optName) {
        $replace['[opt_'.$optName.']'] = isset($optValues[strtolower($optName)]) ? $optValues[strtolower($optName)] : '';
      }
    }
			
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
    $value = $this->applyFunctions($value);
    
		return trim($value);
	}
	
	public function transformCategory($pattern, $lang, $row, $store_id = 0, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $store_id, $get_value);
    
		if (!isset($row['name'])) {
      if (isset($row['orig_name'])) {
        $row['name'] = $row['orig_name'];
      } else {
   			$row['name'] = isset($row['category_description'][$lang]['name']) ? $row['category_description'][$lang]['name'] : '';
      }
		}
    
    if (!isset($row['description'])) {
      if (isset($row['orig_description'])) {
        $row['description'] = $row['orig_description'];
      } else {
   			$row['description'] = isset($row['category_description'][$lang]['description']) ? $row['category_description'][$lang]['description'] : '';
      }
		}
		
		$replace  = array();
    
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['name']);
		if (strpos($pattern, '[desc]') !== false) {
      if (function_exists('mb_substr')) {
        $replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', mb_substr(strip_tags(str_replace(array('</p>', '</li>'), array('</p> ', '</li> '), html_entity_decode((isset($row['description']) ? $row['description'] : ''), ENT_QUOTES, 'UTF-8'))), 0, 220)));
      } else {
        $replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', substr(strip_tags(str_replace(array('</p>', '</li>'), array('</p> ', '</li> '), html_entity_decode((isset($row['description']) ? $row['description'] : ''), ENT_QUOTES, 'UTF-8'))), 0, 220)));
      }
    }
    if (strpos($pattern, '[desc_sentence]') !== false) {
       preg_match('#<p>(.*?)(?:</p>|\.)#is', html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8'), $desc_extract);
       
       if (isset($desc_extract[1])) {
         $replace['[desc_sentence]'] = strip_tags($desc_extract[1]);
       } else {
         $replace['[desc_sentence]'] = '';
       }
    }
		if (strpos($pattern, '[cat_id]') !== false)
			$replace['[cat_id]'] = trim($row['category_id']);
    if (strpos($pattern, '[grandparent]') !== false)
			$replace['[grandparent]'] = !empty($row['category_id']) ? trim($this->getGrandParentCategoryName($row['category_id'], $lang)) : '';
    if (strpos($pattern, '[parent]') !== false)
			$replace['[parent]'] = !empty($row['category_id']) ? trim($this->getParentCategoryName($row['category_id'], $lang)) : '';
    if (strpos($pattern, '[child]') !== false)
			$replace['[child]'] = !empty($row['category_id']) ? trim($this->getChildCategoryName($row['category_id'], $lang)) : '';
    if (strpos($pattern, '[lowest_price]') !== false)
			$replace['[lowest_price]'] = $this->getCategoryPrice($row['category_id'], 'lowest');
    if (strpos($pattern, '[highest_price]') !== false)
			$replace['[highest_price]'] = $this->getCategoryPrice($row['category_id'], 'highest');

			/*
		if (strpos($pattern, '[parent]') !== false)
			$replace['[parent]'] = $this->model_tool_seo_package->getParentCategoryName($row['category_id'], $lang);
			*/
			
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
    $value = $this->applyFunctions($value);
    
		return trim($value);
	}
	
	public function transformInformation($pattern, $lang, $row, $store_id = 0, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $store_id, $get_value);
    
		if (!isset($row['title'])) {
      if (isset($row['orig_title'])) {
        $row['title'] = $row['orig_title'];
      } else {
   			$row['title'] = isset($row['information_description'][$lang]['title']) ? $row['information_description'][$lang]['title'] : '';
      }
		}
    
    if (!isset($row['description'])) {
      if (isset($row['orig_description'])) {
        $row['description'] = $row['orig_description'];
      } else {
   			$row['description'] = isset($row['information_description'][$lang]['description']) ? $row['information_description'][$lang]['description'] : '';
      }
		}
		
		$replace  = array();
		if (strpos($pattern, '[name]') !== false)
			$replace['[name]'] = trim($row['title']);
		if (strpos($pattern, '[title]') !== false)
			$replace['[title]'] = trim($row['title']);
		if (strpos($pattern, '[desc]') !== false) {
      if (function_exists('mb_substr')) {
        $replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', mb_substr(strip_tags(str_replace(array('</p>', '</li>'), array('</p> ', '</li> '), html_entity_decode((isset($row['description']) ? $row['description'] : ''), ENT_QUOTES, 'UTF-8'))), 0, 220)));
      } else {
        $replace['[desc]'] = trim(preg_replace('/\s\s+/', ' ', substr(strip_tags(str_replace(array('</p>', '</li>'), array('</p> ', '</li> '), html_entity_decode((isset($row['description']) ? $row['description'] : ''), ENT_QUOTES, 'UTF-8'))), 0, 220)));
      }
    }
    
    if (strpos($pattern, '[desc_sentence]') !== false) {
       preg_match('#<p>(.*?)(?:</p>|\.)#is', html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8'), $desc_extract);
       
       if (isset($desc_extract[1])) {
         $replace['[desc_sentence]'] = strip_tags($desc_extract[1]);
       } else {
         $replace['[desc_sentence]'] = '';
       }
    }
    
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
    $value = $this->applyFunctions($value);
    
		return trim($value);
	}
	
	public function transformManufacturer($pattern, $lang, $row, $store_id = 0, $get_value = false) {
    $pattern = $this->commonTransform($pattern, $lang, $row, $store_id, $get_value);
    
		$replace  = array();
		if (strpos($pattern, '[name]') !== false) {
      if (!empty($row['seo_manufacturer_description'][$store_id][$lang]['name'])) {
        $replace['[name]'] = trim($row['seo_manufacturer_description'][$store_id][$lang]['name']);
      } else {
			  $replace['[name]'] = trim($row['name']);
      }
    }
				
		$value = str_replace(array_keys($replace), array_values($replace), $pattern);
		$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
		
    $value = $this->applyFunctions($value);
    
		return trim($value);
	}
	
	public function filter_seo($seo_kw, $type, $id, $lang = '', $simulate = false) {
		$whitespace = $this->config->get('mlseo_whitespace');
    
    if ($lang) {
      $translit = $this->config->get('mlseo_ascii_'.$lang);
      $remove = $this->config->get('mlseo_remove_'.$lang);
      $replace = $this->config->get('mlseo_replace_'.$lang);
    } else {
      $translit = $this->config->get('mlseo_ascii_'.$this->config->get('config_language_id'));
      $remove = $this->config->get('mlseo_remove_'.$this->config->get('config_language_id'));
      $replace = $this->config->get('mlseo_replace_'.$this->config->get('config_language_id'));
    }
    
    if (!empty($replace)) {
      foreach (explode('|', $replace) as $rep) {
        $r = explode(':', $rep);
        
        $seo_kw = str_replace(html_entity_decode($r[0], ENT_QUOTES, 'UTF-8'), isset($r[1]) ? $r[1] : '', $seo_kw);
      }
    }
    
		if (!empty($remove)) {
      $beforeWord = "(\\b|\\s|\\.|\\,|\\!|\\?|\\(|\\)|\\'|\\\"|^)";
      $afterWord =  "(\\b|\\s|\\.|\\,|\\!|\\?|\\(|\\)|\\'|\\\"|$)";
      $removeArray = array();
      
      foreach (explode(',', $remove) as $rem) {
        $removeArray[] = '`'.$beforeWord.preg_quote(trim($rem)).$afterWord.'`i';
      }
      
      if ($removeArray) {
        $seo_kw = preg_replace($removeArray, '$1$2', $seo_kw);
      }
    }
    
		if ($translit) {
      if ($this->config->get('mlseo_current_lang')) {
        $lang_code = $this->config->get('mlseo_current_lang');
      } else {
        $lang_code = $this->getLangCode($lang);
      }
      
      include_once(DIR_SYSTEM . 'library/gkd_urlify.php');
      
      if (function_exists('mb_substr')) {
        $seo_kw = URLify::downcode($seo_kw, mb_substr($lang_code, 0, 2));
      } else {
        $seo_kw = URLify::downcode($seo_kw, substr($lang_code, 0, 2));
      }
      
			// language specific tr
      /* now with urlify
			$seo_kw = $this->mb_strtr($seo_kw, array('À','Á','Â','Ã','Ä','Å','Ă','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ő','Ø','Œ','Ș','Ț','Ù','Ú','Û','Ü','Ű','Ý','Þ','ß','à','á','â','ã','ä','å','ă','æ','ç','è','é','ê','ë','ì','í','î','ï','ð','ñ','ò','ó','ô','õ','ö','ő','ø','œ','ș','ț','ù','ú','û','ü','ű','ý','þ','ÿ'),
                                         array('A','A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','O','OE','S','T','U','U','U','U','U','Y','TH','ss','a','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','d','n','o','o','o','o','o','o','o','oe','s','t','u','u','u','u','u','y','th','y')); // latin
			$seo_kw = $this->mb_strtr($seo_kw, 'αβγδεζηθικλμνξοπρστυφχψωάέίόύήώςϊΰϋΐΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩΆΈΊΌΎΉΏΪΫ', 'abgdezh8iklmn3oprstyfxpswaeioyhwsiyyiABGDEZH8IKLMN3OPRSTYFXPSWAEIOYHWIY'); // greek
			$seo_kw = $this->mb_strtr($seo_kw, 'ÁáČčĎďĚěŇňŘřŠšŤťÚúŮůÝýŽžĐđ', 'AaCcDdEeNnRrSsTtUuUuYyZzDd'); // czech, croatian, slovenian
			$seo_kw = $this->mb_strtr($seo_kw, 'ĄČĘĖĮYŠŲŪŽąčęėįyšųūž', 'ACEEIYSUUZaceeiysuuz'); // lithunanian
			$seo_kw = $this->mb_strtr($seo_kw, 'ĀČĒĢĪĶĻŅŠŪŽāčēģīķļņšūž', 'ACEGIKLNSUZacegiklnsuz'); // latvian
			$seo_kw = $this->mb_strtr($seo_kw, 'ÇçĞğİıÖöŞşÜü', 'CcGgIiOoSsUu'); // turkish
			$seo_kw = $this->mb_strtr($seo_kw, 'ăâîșțŢţ', 'aaistTt'); // romanian
			$seo_kw = $this->mb_strtr($seo_kw, 'ąćęłńóśźżĄĆĘŁŃÓŚŹŻ', 'acelnoszzACeLNOSZZ'); // polish
			$seo_kw = $this->mb_strtr($seo_kw, array('Г','Д','Е','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ь','Ъ','щ','ш','ч','ц','ю','я','ж','а','б','в','г','д','е','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ь','ъ'),
                                         array('Sht','Sh','Ch','C','Yu','Ya','J','A','B','V','G','D','E','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','','A','sht','sh','ch','c','yu','ya','j','a','b','v','g','d','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','','a')); // bulgarian
			$seo_kw = $this->mb_strtr($seo_kw, array('أ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي'), array('a','b','t','th','g','h','kh','d','th','r','z','s','sh','s','d','t','th','aa','gh','f','k','k','l','m','n','h','o','y')); // arabic
			$seo_kw = $this->mb_strtr($seo_kw, array('Ä','Ö','Ü','ä','ö','ü','ß','ẞ'), array('Ae','Oe','Ue','ae','oe','ue','ss','SS')); // german
			$seo_kw = $this->mb_strtr($seo_kw, array('ђ','ј','љ','њ','ћ','џ','đ','Ђ','Ј','Љ','Њ','Ћ','Џ','Đ'), array('dj','j','lj','nj','c','dz','dj','Dj','j','Lj','Nj','C','Dz','Dj',)); // serbian
			$seo_kw = $this->mb_strtr($seo_kw, array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','№'),
                                         array('a','b','v','g','d','e','yo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sh','','y','','e','yu','ya','A','B','V','G','D','E','Yo','Zh','Z','I','J','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Sh','','Y','','E','Yu','Ya','')); // russian
			$seo_kw = $this->mb_strtr($seo_kw, array('І', 'і', 'Ї', 'ї', 'Є', 'є', 'Ґ', 'ґ'), array('I','i','Yi','yi', 'Ye', 'ye', 'G', 'g')); // ukrainian
			*/
			
			// entities autodetect method (works for western europe languages)
			// $seo_kw = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($seo_kw, ENT_QUOTES, 'UTF-8'));
			// $seo_kw = html_entity_decode($seo_kw, ENT_QUOTES);
			// $seo_kw = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), $whitespace, $seo_kw);
			$seo_kw = trim($seo_kw, '_'.$whitespace);
		}
			
    if ($type != 'image' && $this->config->get('mlseo_lowercase')) {
      if (function_exists('mb_strtolower')) {
        $seo_kw = mb_strtolower($seo_kw, 'UTF-8');
      } else {
        $seo_kw = strtolower($seo_kw);
      }
		}
    
		$seo_kw = str_replace(' ', $whitespace, $seo_kw);
    $seo_kw = preg_replace('~\x{00a0}~siu', $whitespace, $seo_kw); // unicode non-breaking space
    
		//$seo_kw = str_replace(array('"',"'",'&','(',')','.','+',',','*',':',';','=','?','@','$','/','%','#'), '', $seo_kw);
    if (!$this->config->get('mlseo_safe_url')) {
      $seo_kw = preg_replace('/([^\w\-\._~:\[\]@!\$\'()*\+,;=%]+)/u', $whitespace, $seo_kw); 
    } else if ($this->config->get('mlseo_safe_url') == 'ext') {
		$seo_kw = str_replace(array('\'','`','‘','’','|','%7C', "\r\n", "\n", "\r",'/','\\',',',':','~','(', ')','.',','), $whitespace, $seo_kw);
		$seo_kw = str_replace(array('"','“','”','&','&amp;','+','?','!','/','%','#','&gt;','&lt;',';','<','>','™','®','©','&copy;','&reg;','&trade;'), '', $seo_kw);
    } else if ($this->config->get('mlseo_safe_url') == 'max') {
      $seo_kw = preg_replace('/(\W+)/u', $whitespace, $seo_kw);
    }
    
    if ($whitespace) {
      $seo_kw = preg_replace('/'.$whitespace.$whitespace.'+/', $whitespace, $seo_kw);
      $seo_kw = trim($seo_kw, $whitespace);
    }
		
		$exists = array(1);
    $number = '';
    $search_kw = $seo_kw;
    
    if ($type != 'image') {
      while(count($exists)) {
        /*
        if ($simulate && isset($this->session->data['kwCountArray']) && in_array($search_kw, (array) $this->session->data['kwCountArray'])) {
           $seo_kw .= '-[x]';
           break;
        }
        */
        
        if ($this->config->get('mlseo_absolute') && $this->config->get('mlseo_duplicate') && ($type == 'category' || $type == 'manufacturer')) break;
        elseif ($this->config->get('mlseo_absolute') && $type == 'category')
             $sql = "SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '".$type."_id=" . (int)$id . "' AND keyword='".$this->db->escape($search_kw)."'";
        elseif ($this->config->get('mlseo_duplicate'))
             $sql = "SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE query != '".$type."_id=" . (int)$id . "' AND keyword='".$this->db->escape($search_kw)."'";
        else $sql = "SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE keyword='".$this->db->escape($search_kw)."'";
        
        $exists = $this->db->query($sql)->row;
        
        if (count($exists)) {
          if ($simulate) {
            if (!isset($this->session->data['kwCountArray'][$seo_kw])) {
              $this->session->data['kwCountArray'][$seo_kw] = $number;
            }
            
            $this->session->data['kwCountArray'][$seo_kw]++;
          }
          
          $search_kw = $seo_kw .'-'. ++$number;
        }
        /*
        if ($this->config->get('mlseo_absolute')) break; // disable duplicate detection while absolute is enabled, todo: advanced detection of possible cases
        if ($this->config->get('mlseo_absolute') && $this->config->get('mlseo_duplicate') && $type == 'category') break;
        elseif ($this->config->get('mlseo_absolute') && $type == 'category')
             $sql = "SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '".$type."_id=" . (int)$id . "' AND keyword='".$this->db->escape($seo_kw)."'";
        elseif ($this->config->get('mlseo_duplicate'))
             $sql = "SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE query != '".$type."_id=" . (int)$id . "' AND keyword='".$this->db->escape($seo_kw)."'";
        else $sql = "SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE keyword='".$this->db->escape($seo_kw)."'";
        $exists = $this->db->query($sql)->row;
        if (count($exists)) $seo_kw .= '_';
        */
      }
      
      if ($number) {
        if ($simulate && isset($this->session->data['kwCountArray'][$seo_kw])) {
          //$seo_kw .= '-[x]';
          $seo_kw .= '-'.$this->session->data['kwCountArray'][$seo_kw];
        } else {
          $seo_kw .= '-'.$number;
        }
      }
    }
		
	  // config here the max chars (will cut after the current word) ; 0 = unlimited
		$this->config->set('multilingual_seo_wordlimit', 0);
	    
    if ($this->config->get('mlseo_wordlimit')) {
      $pos = strpos($seo_kw, $whitespace, $this->config->get('mlseo_wordlimit'));
      if ($pos > $this->config->get('mlseo_wordlimit')) {
        if (function_exists('mb_substr')) {
          $seo_kw = mb_substr($seo_kw, 0, $pos);
        } else {
          $seo_kw = substr($seo_kw, 0, $pos);
        }
      }
    }
    
		return $seo_kw;
	}
	
  public function getFullProductPathNames($product_id, $lang = false, $from_category = false) {
		$categories = array();

    if ($from_category) {
      if (!empty($product_id[0])) {
        $category_id = $product_id[0];
        $category = $this->db->query("SELECT cd.name, c.category_id, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$lang . "'")->row;
      }
    } else {
      $category = $this->db->query("SELECT cd.name, c.category_id, c.parent_id FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category c ON (p2c.category_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd ON (p2c.category_id = cd.category_id) WHERE product_id = '" . (int)$product_id . "' AND cd.language_id = '" . (int)$lang . "'")->row;
    }
		
    while (!empty($category['name'])) {
      $categories[] = $category['name'];
      
      $category = $this->db->query("SELECT cd.name, c.category_id, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . $category['parent_id']. "' AND cd.language_id = '" . (int)$lang . "'")->row;
    }
		
		return array_reverse($categories);
	}
  
	public function getFullProductPaths($product_id, $lang = false) {
		$path = array();
    
		$categories = $this->db->query("SELECT c.category_id, c.parent_id FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category c ON (p2c.category_id = c.category_id) WHERE product_id = '" . (int)$product_id . "'")->rows;
		
		foreach ($categories as $key => $category) {
			$path[$key] = '';
			if (!$category) continue;
      
			$path[$key] = $category['category_id'];
			
			while ($category['parent_id']) {
				$path[$key] = $category['parent_id'] . '_' . $path[$key];
				$category = $this->db->query("SELECT category_id, parent_id FROM " . DB_PREFIX . "category WHERE category_id = '" . $category['parent_id']. "'")->row;
			}
			
			$path[$key] = $path[$key];
		}
		
		if (!count($path)) return array();
		
		return $path;
	}
	
	public function getLangCode($lang_id) {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach($languages as $language) {
      if ($language['language_id'] == $lang_id) {
        return  $language['code'];
      }
    }
    
    return '';
  }
  
	private function mb_strtr($str, $from, $to = null) {
		if (is_array($from) && is_array($to))
			return str_replace($from, $to, $str);
		elseif (is_array($from))
			return str_replace(array_keys($from), array_values($from), $str);
		return str_replace(preg_split('~~u', $from, null, PREG_SPLIT_NO_EMPTY), preg_split('~~u', $to, null, PREG_SPLIT_NO_EMPTY), $str);
	}
	
}