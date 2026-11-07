<?php
class ControllerExtensionModuleUniViewed extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/uni_viewed');
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$uniset = $this->config->get('config_unishop2');
		$lang_id = $this->config->get('config_language_id');
		
		$data['heading_title'] = isset($setting['title'][$lang_id]) ? $setting['title'][$lang_id] : $this->language->get('heading_title');
		
		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];
		$data['limit'] = $setting['limit'];
		$data['type_view'] = isset($setting['view_type']) ? 'grid' : 'carousel';
		
		$data['products'] = [];
		
		if(isset($this->request->cookie['viewedProducts'])) {
			return $this->load->view('extension/module/uni_viewed', $data);
		} else {
			return false;
		}
	}
	
	public function ajax() {
		$this->load->language('extension/module/uni_viewed');
		$this->load->language('extension/module/uni_othertext');
		
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->load->model('extension/module/uni_new_data');
		
		$uniset = $this->config->get('config_unishop2');
		$lang_id = $this->config->get('config_language_id');
		
		$currency = $this->session->data['currency'];
		
		$data['show_quick_order_text'] = isset($uniset['show_quick_order_text']) ? $uniset['show_quick_order_text'] : '';			
		$data['quick_order_icon'] = isset($uniset['show_quick_order']) ? $uniset[$lang_id]['quick_order_icon'] : '';
		$data['quick_order_title'] = isset($uniset['show_quick_order']) ? $uniset[$lang_id]['quick_order_title'] : '';
		$data['show_rating'] = isset($uniset['show_rating']) ? true : false;
		$data['wishlist_btn_disabled'] = isset($uniset['wishlist']['disabled']) ? true : false;
		$data['compare_btn_disabled'] = isset($uniset['compare']['disabled']) ? true : false;
		
		$data['products'] = [];
		
		if(isset($this->request->cookie['viewedProducts'])) {
			
			$img_width = isset($this->request->post['width']) && $this->request->post['width'] != '' ? (int)$this->request->post['width'] : 200;
			$img_height = isset($this->request->post['height']) && $this->request->post['height'] != '' ? (int)$this->request->post['height'] : 180;
			$limit = isset($this->request->post['limit']) && $this->request->post['limit'] != '' ? (int)$this->request->post['limit'] : 5;
			
			$data['img_width'] = $img_width;
			$data['img_height'] = $img_height;
			
			$viewed = explode(',', $this->request->cookie['viewedProducts']);
			$products = array_slice($viewed, 0, $limit);
			
			if($products) {
				foreach($products as $product_id) {
					
					$result = $this->model_catalog_product->getProduct((int)$product_id);
					
					if($result) {
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $img_width, $img_height);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $img_width, $img_height);
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
				
						if ($this->config->get('config_review_status')) {
							$rating = (int)$result['rating'];
						} else {
							$rating = false;
						}
			
						if ($this->config->get('config_tax')) {
							$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $currency);
						} else {
							$tax = false;
						}
				
						$new_data = $this->model_extension_module_uni_new_data->getNewData($result, ['width' => $img_width, 'height' => $img_height]);
							
						$data['products'][] = [
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
							'minimum' 			=> $result['minimum'] ? $result['minimum'] : 1,
							'price_value' 		=> $this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency),
							'special_value' 	=> $this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency),
							'model'				=> $new_data['model'],
							'additional_image'	=> $new_data['additional_image'],
							'stickers' 			=> $new_data['stickers'],
							'special_date_end' 	=> $new_data['special_date_end'],
							'discounts'			=> $new_data['discounts'],
							'attributes' 		=> $new_data['attributes'],
							'options'			=> $new_data['options'],
							'show_description'	=> $new_data['show_description'],
							'show_quantity'		=> $new_data['show_quantity'],
							'quantity_indicator'=> $new_data['quantity_indicator'],
							'cart_btn_icon'		=> $new_data['cart_btn_icon'],
							'cart_btn_text'		=> $new_data['cart_btn_text'],
							'cart_btn_class'	=> $new_data['cart_btn_class'],
							'quick_order'		=> $new_data['quick_order']
						];
					}
				}
			}
			
			$this->response->setOutput($this->load->view('extension/module/uni_viewed', $data));
		} else {
			return false;
		}
	}
}