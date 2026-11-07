<?php
class ControllerExtensionModuleUniFiveInOneV2 extends Controller {
	public function index($setting) {
		static $module = 0;
		
		$this->load->language('extension/module/uni_othertext');

		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('extension/module/uni_five_in_one_v2');
		$this->load->model('extension/module/uni_new_data');
		
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$currency = $this->session->data['currency'];
		$customer_group = $this->customer->getGroupId() ? $this->customer->getGroupId() : $this->config->get('config_customer_group_id');
		
		$uniset = $this->config->get('config_unishop2');
		
		$settings = isset($setting['set']) ? $setting['set'] : [];
		
		$data['show_quick_order_text'] = isset($uniset['show_quick_order_text']) ? $uniset['show_quick_order_text'] : '';			
		$data['quick_order_icon'] = isset($uniset['show_quick_order']) ? $uniset[$lang_id]['quick_order_icon'] : '';
		$data['quick_order_title'] = isset($uniset['show_quick_order']) ? $uniset[$lang_id]['quick_order_title'] : '';
		$data['show_rating'] = isset($uniset['show_rating']) ? true : false;
		$data['wishlist_btn_disabled'] = isset($uniset['wishlist']['disabled']) ? true : false;
		$data['compare_btn_disabled'] = isset($uniset['compare']['disabled']) ? true : false;
		
		$tabs = [];

		$i = 0;
		
		if(count($settings) > 1) {
			array_multisort(array_column($settings, 'sort_order'), SORT_ASC, $settings);
		}
			
		foreach($settings as $key => $tab_settings) {
			if(isset($tab_settings['status'])) {
			
				$tabs[$i]['title'] = isset($tab_settings['title'][$lang_id]) ? $tab_settings['title'][$lang_id] : '';
				$tabs[$i]['img_width'] = $tab_settings['thumb_width'];
				$tabs[$i]['img_height'] = $tab_settings['thumb_height'];
				$tabs[$i]['type'] = isset($tab_settings['type']) ? 'grid' : 'carousel';
				
				$category_id = isset($tab_settings['category_id']) && $tab_settings['category_id'] ? (int)$tab_settings['category_id'] : 0;
				$sorts = isset($tab_settings['products_sort']) ? $tab_settings['products_sort'] : '';
				$limit = isset($tab_settings['limit']) ? $tab_settings['limit'] : 5;
				$qty = isset($tab_settings['quantity']) ? $tab_settings['quantity'] : 0;
					
				$cache_name = 'product.unishop.five_in_one_v2.'.substr(md5($tabs[$i]['title'].$tabs[$i]['type']), 0, 8).'.'.$limit.'.'.$qty.'.'.$category_id.'.'.$customer_group.'.'.$lang_id.'.'.$store_id;
					
				$tabs[$i]['products'] = [];
				
				$products = $this->cache->get($cache_name);
				
				if(!$products) {
					switch($key) {
						case 'latest':
							$products = $this->model_extension_module_uni_five_in_one_v2->getLatest($limit, $qty);
							break;
						case 'special':
							$products = $this->model_extension_module_uni_five_in_one_v2->getSpecial($limit, $qty);
							break;
						case 'bestseller':
							$products = $this->model_extension_module_uni_five_in_one_v2->getBestseller($limit, $qty);
							break;
						case 'popular':
							$products = $this->model_extension_module_uni_five_in_one_v2->getPopular($limit, $qty);
							break;
						default:
							$results = array_slice(isset($tab_settings['products']) ? $tab_settings['products'] : [], 0, (int)$limit);
							
							$products = $this->model_extension_module_uni_five_in_one_v2->getProducts($category_id, $results, $sorts, $limit, $qty);
					}
					
					if($products) {
						$this->cache->set($cache_name, $products);
					}
				}
				
				if($products) {
					foreach ($products as $result) {
						if($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $tab_settings['thumb_width'], $tab_settings['thumb_height']);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $tab_settings['thumb_width'], $tab_settings['thumb_height']);
						}

						if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
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
							$rating = $result['rating'];
						} else {
							$rating = false;
						}
				
						$new_data = $this->model_extension_module_uni_new_data->getNewData($result, ['width' => $tab_settings['thumb_width'], 'height' => $tab_settings['thumb_height']]);
				
						if($new_data['special_date_end']) {
							$tabs[$i]['show_timer'] = true;
						}

						$tabs[$i]['products'][] = [
							'product_id' 		=> $result['product_id'],
							'thumb'   	 		=> $image,
							'name'    			=> $result['name'],
							'description' 		=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_'.$this->config->get('config_theme').'_product_description_length')) . '..',
							'tax'         		=> $tax,
							'price'   	 		=> $price,
							'special' 	 		=> $special,
							'rating'     		=> $rating,
							'reviews'    		=> sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
							'num_reviews' 		=> isset($uniset['show_rating_count']) ? $result['reviews'] : '',
							'href'    	 		=> $this->url->link('product/product', 'product_id='.$result['product_id']),
							'model'				=> $new_data['model'],
							'additional_image'	=> $new_data['additional_image'],
							'stickers' 			=> $new_data['stickers'],
							'special_date_end' 	=> $new_data['special_date_end'],
							'minimum' 			=> $result['minimum'] ? $result['minimum'] : 1,
							'quantity_indicator'=> $new_data['quantity_indicator'],
							'price_value' 		=> $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency),
							'special_value' 	=> $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency),
							'discounts'			=> $new_data['discounts'],
							'attributes' 		=> $new_data['attributes'],
							'options'			=> $new_data['options'],
							'show_description'	=> $new_data['show_description'],
							'show_quantity'		=> $new_data['show_quantity'],
							'cart_btn_icon'		=> $new_data['cart_btn_icon'],
							'cart_btn_text'		=> $new_data['cart_btn_text'],
							'cart_btn_class'	=> $new_data['cart_btn_class'],
							'quick_order'		=> $new_data['quick_order']
						];
					}
					
					if($tabs[$i]['products']) {
						$i++;
					}
				}
			}
		}

		$data['tabs'] = $tabs;
		$data['module'] = $module++;
		
		return $this->load->view('extension/module/uni_five_in_one_v2', $data);
	}
}