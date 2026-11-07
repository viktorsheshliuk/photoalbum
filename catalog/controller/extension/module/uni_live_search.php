<?php
class ControllerExtensionModuleUniLiveSearch extends Controller {
	public function index() {
		
		if (!isset($this->request->server['HTTP_X_REQUESTED_WITH']) || strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
			
			return;
		}
		
		$this->load->model('extension/module/uni_search');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$this->load->language('extension/module/uni_live_search');
		
		$uniset = $this->config->get('config_unishop2');
		$language_id = $this->config->get('config_language_id');
		$currency = $this->session->data['currency'];
			
		$search = isset($this->request->post['filter_name']) ? trim($this->request->post['filter_name']) : '';
		$search_sort = isset($uniset['livesearch']['sort']) ? $uniset['livesearch']['sort'] : '';
		$search_order = isset($uniset['livesearch']['order']) ? $uniset['livesearch']['order'] : '';
		$search_description = isset($uniset['search']['types']['description']) ? true : false;
			
		$category_id = isset($this->request->post['category_id']) ? (int)$this->request->post['category_id'] : 0;
			
		$data['categories'] = [];
		$data['manufacturers'] = [];
		$data['product_categories'] = [];
		$data['products'] = [];
		
		if ($search) {
			$filter_data = [
				'filter_name'         => $search,
				'filter_tag'          => $search,
				'filter_description'  => $search_description,
				'filter_category_id'  => $category_id,
				'filter_sub_category' => 1,
				'sort'                => $search_sort,
				'order'               => $search_order,
				'start'               => 0,
				'limit'               => $uniset['livesearch']['limit']
			];
			
			$products = $this->{isset($uniset['search']['status']) ? 'model_extension_module_uni_search' : 'model_catalog_product'}->getProducts($filter_data);
			
			if(isset($uniset['search']['status'])) {
				if(isset($uniset['search']['condition']['category'])) {
					$categories = $this->model_extension_module_uni_search->getCategories($filter_data);
	
					foreach ($categories as $category) {
						$data['categories'][] = [
							'category_id' => $category['category_id'],
							'name' 		  => $category['name'],
							'href'        => $this->url->link('product/category', 'path='.$category['category_id'], true)
						];
					}
				}
				
				if(isset($uniset['search']['condition']['manufacturer'])) {
					$manufacturers = $this->model_extension_module_uni_search->getManufacturers($filter_data);
	
					foreach ($manufacturers as $manufacturer) {
						$data['manufacturers'][] = [
							'manufacturer_id' => $manufacturer['manufacturer_id'],
							'name' 		  	  => $manufacturer['name'],
							'href'   		  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'], true)
						];
					}
				}
		
				if(isset($uniset['search']['condition']['product_category']) && $products && !$category_id) {
		
					$url = '';
		
					if ($search) {
						$url .= '&search=' . rawurlencode(html_entity_decode(trim($search), ENT_QUOTES, 'UTF-8'));
					}

					if ($search_description ) {
						$url .= '&description=' . $search_description;
					}

					if ($search_sort) {
						$url .= '&sort=' . $search_sort;
					}

					if ($search_order) {
						$url .= '&order=' . $search_order;
					}
			
					$product_categories = $this->model_extension_module_uni_search->getProductCategories(array_column($products, 'product_id'));
		
					foreach ($product_categories as $product_category) {
						$data['product_categories'][] = [
							'category_id'  => $product_category['category_id'],
							'name'		=> $product_category['name'],
							'href'   	=> $this->url->link('product/search', $url . '&category_id='.(int)$product_category['category_id'], true)
						];
					}
				}
			}
			
			$products_total = 0;
			
			if($products) {
				
				$products_total = $this->{isset($uniset['search']['status']) ? 'model_extension_module_uni_search' : 'model_catalog_product'}->getTotalProducts($filter_data);

				foreach ($products as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $uniset['livesearch']['image_w'], $uniset['livesearch']['image_h']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $uniset['livesearch']['image_w'], $uniset['livesearch']['image_h']);
					}
				
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
					} else {
						$price = false;
					}
				
					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $currency);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = (int)round($result['rating']);
					} else {
						$rating = false;
					}
				
					$name = (strlen($result['name']) > $uniset['livesearch']['name_length']) ? utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, $uniset['livesearch']['name_length']) : strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'));
					$model = isset($uniset['livesearch']['model']) && $uniset['livesearch']['model'] != 'disabled' ? $uniset['livesearch']['model'] : '';
					$description = isset($uniset['livesearch']['show_description']) ? utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $uniset['livesearch']['description_length']) . '..' : '';
					
					$data['products'][] = [
						'product_id'  	=> $result['product_id'],
						'image'      	=> isset($uniset['livesearch']['image']) ? $image : '',
						'name' 			=> $name,
						'model'			=> $model ? ($model == 'model' ? $result['model'] : $result['sku']) : '',
						'description' 	=> $description,
						'rating'		=> isset($uniset['livesearch']['rating']) ? $rating : -1,
						'price'      	=> isset($uniset['livesearch']['price']) ? $price : '',
						'special'     	=> $special,
						'href'       	=> $this->url->link('product/product', 'product_id='.$result['product_id'], true)
					];
				}
			}
			
			$data['products_total'] = $products_total;
			$data['show_more'] = $products_total > $uniset['livesearch']['limit'] ? true : false;
				
			$link = '&search='.rawurlencode(html_entity_decode($search, ENT_QUOTES, 'UTF-8'));
			$link .= $category_id ? '&category_id='.$category_id.'&sub_category=true' : '';
			$link .= $search_description ? '&description=true' : '';
			$link .= '&sort='.$search_sort.'&order='.$search_order;
				
			$data['show_more_link'] = $this->url->link('product/search', $link, true);
		}
		
		$this->response->setOutput($this->load->view('extension/module/uni_live_search', $data));
	}
	
	private function switcher($text, $arrow = 2) {
		
		if (!preg_match('/[^0-9a-zA-Z ]/u', $text)) {
			//echo 'en';
		}
		
		if (!preg_match('/[^0-9а-яёА-ЯЁ ]/u', $text)) {
			//echo 'ru';
		}
		
		$str[0] = [
			'й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd',
			'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm',
			'б' => ',', 'ю' => '.', 'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P', 'Х' => '[', 'Ъ' => ']', 'Ф' => 'A',
			'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ':', 'Э' => '\'', '?' => 'Z', 'ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B',
			'Т' => 'N', 'Ь' => 'M', 'Б' => '<', 'Ю' => '>',
		];
	
		$str[1] = [
			'q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в',
			'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь',
			',' => 'б', '.' => 'ю', 'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '[' => 'Х', ']' => 'Ъ', 'A' => 'Ф',
			'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ':' => 'Ж', '\'' => 'Э', 'Z' => '?', 'X' => 'ч', 'C' => 'С', 'V' => 'М', 'B' => 'И',
			'N' => 'Т', 'M' => 'Ь', '<' => 'Б', '>' => 'Ю',
		];

		//return strtr($text, array_merge($str[0], $str[1]));
		return strtr($text, isset($str[$arrow]) ? $str[$arrow] : array_merge($str[1], $str[0]));
	}
}
