<?php  
class ControllerExtensionModuleUniQuickOrder extends Controller {
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
		
		$this->load->model('catalog/product');
		$this->load->model('extension/module/uni_new_data');
		
		$product_id = isset($this->request->post['id']) ? (int)$this->request->post['id'] : 0;
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if($product_info) {
			$this->document->addLink($this->url->link('product/product', 'product_id=' . $product_id), 'canonical');
		
			$this->load->language('product/product');
			$this->load->language('extension/module/uni_othertext');
			$this->load->language('account/register');
			$this->load->language('extension/module/uni_quick_order');

			$this->load->model('account/address');
			
			$data['is_product_page'] = isset($this->request->post['is_product_page']) ? (int)$this->request->post['is_product_page'] : false;
		
			$data['lang_code'] = $this->session->data['language'];
		
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', true));
		
			$uniset = $this->config->get('config_unishop2');
			$lang_id = $this->config->get('config_language_id');
				
			$data['show_model'] = isset($uniset['show_quick_order_model']) ? true : false;
			$data['show_manuf'] = isset($uniset['show_quick_order_manuf']) ? true : false;
			$data['show_reward'] = $uniset['quick_order']['reward'];
			$data['show_length'] = $uniset['quick_order']['length'];
			$data['change_opt_img_q'] = isset($uniset['change_opt_img_q']) ? $uniset['change_opt_img_q'] : '';
			
			if(isset($this->request->get['path'])) {
				$path = explode('_', $this->request->get['path']);
				$category_id = (int)array_pop($path);
			} else {
				$categories = $this->model_catalog_product->getCategories($product_id);
				$category_id = array_unique(array_column($categories, 'category_id'));
				$category_id = (int)array_pop($category_id);
			}
			
			$text_block_arr = isset($uniset['product']['textblock'][$category_id]) ? $uniset['product']['textblock'][$category_id] : $uniset['product']['textblock'][0];
		
			$data['textblock'] = isset($text_block_arr['quickorder']) && isset($text_block_arr['text'][$lang_id]) ? html_entity_decode($text_block_arr['text'][$lang_id], ENT_QUOTES, 'UTF-8') : '';
				
			$data['sku'] = $product_info['sku'];
			$data['upc'] = $product_info['upc'];
			$data['ean'] = $product_info['ean'];
			$data['jan'] = $product_info['jan'];
			$data['isbn'] = $product_info['isbn'];
			$data['mpn'] = $product_info['mpn'];
			$data['location'] = $product_info['location'];
		
			$data['show_sku'] = '';
		
			if(isset($uniset['product']['sku']['status']) && $product_info['sku']) {
				$data['show_sku'] = true;
				$data['text_sku'] = isset($uniset['product']['sku']['title'][$lang_id]) ? $uniset['product']['sku']['title'][$lang_id] : 'SKU';
			}
		
			$data['show_upc'] = '';
		
			if(isset($uniset['product']['upc']['status']) && $product_info['upc']) {
				$data['show_upc'] = true;
				$data['text_upc'] = isset($uniset['product']['upc']['title'][$lang_id]) ? $uniset['product']['upc']['title'][$lang_id] : 'UPC';
			}
		
			$data['show_ean'] = '';
		
			if(isset($uniset['product']['ean']['status']) && $product_info['ean']) {
				$data['show_ean'] = true;
				$data['text_ean'] = isset($uniset['product']['ean']['title'][$lang_id]) ? $uniset['product']['ean']['title'][$lang_id] : 'EAN';
			}
		
			$data['show_jan'] = '';
		
			if(isset($uniset['product']['jan']['status']) && $product_info['jan']) {
				$data['show_jan'] = true;
				$data['text_jan'] = isset($uniset['product']['jan']['title'][$lang_id]) ? $uniset['product']['jan']['title'][$lang_id] : 'JAN';
			}
		
			$data['show_isbn'] = '';
		
			if(isset($uniset['product']['isbn']['status']) && $product_info['isbn']) {
				$data['show_isbn'] = true;
				$data['text_isbn'] = isset($uniset['product']['isbn']['title'][$lang_id]) ? $uniset['product']['isbn']['title'][$lang_id] : 'ISBN';
			}
		
			$data['show_mpn'] = '';
		
			if(isset($uniset['product']['mpn']['status']) && $product_info['mpn']) {
				$data['show_mpn'] = true;
				$data['text_mpn'] = isset($uniset['product']['mpn']['title'][$lang_id]) ? $uniset['product']['mpn']['title'][$lang_id] : 'MPN';
			}
		
			$data['show_location'] = '';
		
			if(isset($uniset['product']['location']['status']) && $product_info['location']) {
				$data['show_location'] = true;
				$data['text_location'] = isset($uniset['product']['location']['title'][$lang_id]) ? $uniset['product']['location']['title'][$lang_id] : 'Location';
			}
			
			if($product_info['quantity'] > 0) {
				$data['cart_btn_icon'] = $uniset[$lang_id]['cart_btn_icon'];
				$data['cart_btn_text'] = $uniset[$lang_id]['cart_btn_text'];
				$data['cart_btn_class'] = '';
			} else {
				$data['cart_btn_icon'] = $uniset[$lang_id]['cart_btn_icon_disabled'];
				$data['cart_btn_text'] = $uniset[$lang_id]['cart_btn_text_disabled'];
				$data['cart_btn_class'] = $uniset['cart_btn_disabled'];
			}
				
			if ($product_info['quantity'] <= 0) {
				$data['stock'] = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $product_info['quantity'];
			} else {
				$data['stock'] = $this->language->get('text_instock');
			}
				
			$data['weight'] = ($product_info['weight'] > 0) ? round($product_info['weight'], 2).' '.$this->weight->getUnit($product_info['weight_class_id']) : '';
			$data['length'] = ($product_info['length'] > 0 && $product_info['width'] > 0 && $product_info['height'] > 0) ? round($product_info['length'], 2).'&times;'.round($product_info['width'], 2).'&times;'.round($product_info['height'], 2).' '.$this->length->getUnit($product_info['length_class_id']) : '';
		
			$this->load->model('tool/image');

			$thumb_w = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width');
			$thumb_h = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height');
			$small_w = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width');
			$small_h = $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height');

			if ($product_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $thumb_w, $thumb_h);
				$data['small'] = $this->model_tool_image->resize($product_info['image'], $small_w, $small_h);
			} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.jpg', $thumb_w, $thumb_h);
				$data['small'] = $this->model_tool_image->resize('no_image.jpg', $small_w, $small_h);
			}
		
			$data['images'] = [];
			
			$results = $this->model_catalog_product->getProductImages($product_id);
			
			foreach ($results as $result) {
				$data['images'][] = [
					'thumb' => $this->model_tool_image->resize($result['image'], $thumb_w, $thumb_h),
					'small' => $this->model_tool_image->resize($result['image'], $small_w, $small_h)
				];
			}
		
			$data['currency'] = $currency = $this->session->data['currency'];
		
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $currency);
			} else {
				$data['price'] = false;
			}
					
			if ((float)$product_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $currency);
			} else {
				$data['special'] = false;
			}
			
			$data['reward'] = $product_info['reward'];
			$data['points'] = $product_info['points'];
			$data['quantity'] = $product_info['quantity'];
			
			$discounts = $this->model_catalog_product->getProductDiscounts($product_id);

			$data['discounts'] = [];

			foreach ($discounts as $discount) {
				$data['discounts'][] = [
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $currency)
				];
			}
		
			$data['tax_value'] = (float)$product_info['special'] ? $product_info['special'] : $product_info['price'];
			$data['tax_class_id'] = $product_info['tax_class_id'];
			$data['tax_rates'] = $this->tax->getRates(0, $product_info['tax_class_id']);
			
			$o_quantity = 0;
			$required = false;
			
			if(isset($uniset['quick_order']['option_img_prop'])) {
				$thumb_w = $thumb_h;
			}

			$data['options'] = [];
			
			$show_ended_option_value = isset($uniset['catalog']['option']['show_ended_value']) ? true : false;

			foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {
				$product_option_value_data = [];

				if($option['required'] && ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox')) {
					$o_quantity = 0;
					$required = true;
				}
				
				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0) || $show_ended_option_value) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $currency);
						} else {
							$price = false;
						}

						$product_option_value_data[] = [
							'product_option_value_id' => $option_value['product_option_value_id'],
							'price_value'             => $option_value['price'],
							'weight'                  => $option_value['weight'],
							'weight_prefix'           => $option_value['weight_prefix'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $option_value['image'] ? $this->model_tool_image->resize($option_value['image'], $thumb_w/2 , $thumb_h/2) : '',
							'small'                   => $this->model_tool_image->resize($option_value['image'], $thumb_w, $thumb_h),
							'price'                   => $price,
							'price_value'             => $this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency),
							'price_prefix'            => $option_value['price_prefix'],
							'ended'					  => $option_value['subtract'] && $option_value['quantity'] <= 0 ? true : false
						];
					}
				
					$o_quantity = $o_quantity + $option_value['quantity'];
				}
			
				if($option['required'] && ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox')) {
					$o_quantity_arr[] = $o_quantity;
				}

				$data['options'][] = [
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				];
			}
			
			$data['attribute_groups'] = [];

			$attributes = isset($uniset['quick_order_attr']) ? $this->model_catalog_product->getProductAttributes($product_id) : [];
			
			foreach($attributes as $key => $attribute) {
				if($key < $uniset['quick_order_attr_group']) {
					foreach($attribute['attribute'] as $key => $attribute_value) {
						if($key < $uniset['quick_order_attr_item']) {
							$data['attribute_groups'][] = [
								'name' => $attribute_value['name'],
								'text' => $attribute_value['text']
							];
						}
					}	
				}
			}
			
			$product_info['options'] = $data['options'] ? true : false;
			$product_info['options_quantity'] = $required ? min($o_quantity_arr) : $o_quantity;
			$product_info['type'] = 'product';
			$product_info['product_page'] = true;
			
			$new_data = $this->model_extension_module_uni_new_data->getNewData($product_info);

			$data['product']['stickers'] = $new_data['stickers'];
			$data['special_timer'] = $new_data['special_date_end'];
			$data['product']['quantity_indicator'] = $new_data['quantity_indicator'];
	
			$data['price_value'] = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency);
			$data['special_value'] = $this->tax->calculate($product_info['special'],$product_info['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency);
			$data['discounts_value'] = $new_data['discounts'];

			$data['product_id'] = $product_id;
			$data['name'] = $product_info['name'];
			$data['href'] = $this->url->link('product/product&product_id=' . $product_id);
			$data['model'] = $product_info['model'];
			$data['minimum'] = $product_info['minimum'] ? $product_info['minimum'] : 1;
			$data['manufacturer'] = $product_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
			$data['description'] = isset($uniset['quick_order_description']) ? utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $uniset['quick_order_description_item']) : '';
		
			
			$data['uni_product_tabs'] = [];
			
			if(isset($uniset['show_additional_tab'])) {
				$data['uni_product_tabs'][] = [
					'id'			=> 'additional',
					'title' 		=> $uniset[$lang_id]['additional_tab_title'],
					'description'	=> html_entity_decode($uniset[$lang_id]['additional_tab_text'], ENT_QUOTES, 'UTF-8')
				];
			}
			
			/*
			if(isset($uniset['show_related_news']) && $this->config->get('uni_news')) {
			
				$news_related = $this->load->controller('extension/module/uni_news_related', $product_id);
				
				if($news_related) {
					$data['uni_product_tabs'][] = [
						'id'			=> 'news',
						'icon' 			=> $uniset[$lang_id]['related_news_icon'],
						'title' 		=> $uniset[$lang_id]['related_news_title'],
						'description'	=> $news_related
					];
				}
			}
			*/
		
			if(isset($uniset['product']['download_tab']) && $uniset['product']['download_tab']['status'] != 0) {
		
				$downloads = $this->load->controller('extension/module/uni_download', $product_id);
		
				if($downloads) {
					$data['uni_product_tabs'][] = [
						'id'			=> 'download',
						'title' 		=> $uniset['product']['download_tab']['title'][$lang_id],
						'description'	=> $downloads
					];
				}
			}
			
				
			//user and form data
			$data['firstname'] = $this->customer->getFirstName();
			$data['lastname'] = $this->customer->getLastName();
			$data['email'] = $this->customer->getEmail();
			$data['telephone'] = $this->customer->getTelephone();
			$address = $this->model_account_address->getAddress($this->customer->getAddressId());
			$data['address'] = isset($address['address_1']) ? $address['address_1'] : '';
				
			$data['show_quick_order_form'] = isset($uniset['show_quick_order_form']) ? $uniset['show_quick_order_form'] : '';
			$data['mask_telephone'] = isset($uniset['quick_order']['mask']['telephone'][$lang_id]) ? $uniset['quick_order']['mask']['telephone'][$lang_id] : '';
			$data['name_text'] = isset($uniset[$lang_id]['quick_order_name_text']) ? $uniset[$lang_id]['quick_order_name_text'] : '';
			$data['phone_text'] = isset($uniset[$lang_id]['quick_order_phone_text']) ? $uniset[$lang_id]['quick_order_phone_text'] : '';
		
			$data['mail'] = isset($uniset['quick_order_mail']) ? $uniset['quick_order_mail'] : '';
			$data['mail_text'] = $uniset[$lang_id]['quick_order_mail_text'];

			$data['delivery'] = isset($uniset['quick_order_delivery']) ? $uniset['quick_order_delivery'] : '';
			$data['delivery_text'] = $uniset[$lang_id]['quick_order_delivery_text'];

			$data['comment'] = isset($uniset['quick_order_comment']) ? $uniset['quick_order_comment'] : '';
			$data['comment_text'] = $uniset[$lang_id]['quick_order_comment_text'];
			
			$data['dadata'] = [];
		
			if(isset($uniset['dadata']['quickorder']['status']) && $uniset['dadata']['token']) {
				$data['dadata'] = [
					'status' => true,
					'token'	=> $uniset['dadata']['token']
				];
			}
		
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			if (isset($uniset['quick_order']['captcha']) && $this->config->get('captcha_'.$this->config->get('config_captcha').'_status')) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}
				
			if ($this->config->get('config_checkout_id') && isset($uniset['quick_order_confirm'])) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
				$data['text_agree'] = $information_info ? sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_checkout_id'), true), $information_info['title'], $information_info['title']) : '';
			} else {
				$data['text_agree'] = '';
			}
		
			$this->response->setOutput($this->load->view('extension/module/uni_quick_order', $data));
		} else {
			return false;
		}
	}
	
	public function add() {
		$this->load->model('catalog/product');
		$this->load->model('extension/module/uni_quick_order');
		
		$this->load->language('checkout/checkout');
		$this->load->language('checkout/cart');
		$this->load->language('extension/module/uni_othertext');
		$this->load->language('extension/module/uni_quick_order');

		$json = [];

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		if (!$product_id || !isset($this->request->post['comment2']) || (isset($this->request->post['comment2']) && ($this->request->post['comment2'] != ''))) {
			$this->response->redirect('error/not_found');
		}
		
		$currency = $this->session->data['currency'];

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = [];
			}
			
			$option_quantity_error = false;
			
			$product_price = $this->tax->calculate((float)$product_info['special'] ? (float)$product_info['special'] : $product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));

			$product_options = $this->model_catalog_product->getProductOptions($product_id);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
				
				if(isset($option[$product_option['product_option_id']])) {
					foreach($product_option['product_option_value'] as $value) {
						if($value['product_option_value_id'] == $option[$product_option['product_option_id']] || (is_array($option[$product_option['product_option_id']]) && in_array($value['product_option_value_id'], $option[$product_option['product_option_id']]))) {
							if($quantity > $value['quantity']) {
								$option_quantity_error = true;
							}
							
							switch($value['price_prefix']) {
								case '+':
									$product_price += (int)$value['price'];
									break;
								case '-':
									$product_price -= (int)$value['price'];
									break;
								case '*':
									$product_price = $product_price * (int)$value['price'];
									break;
								case '/':
									$product_price = $product_price / (int)$value['price'];
									break;
								case '=':
									$product_price = (int)$value['price'];
							}
						}
					}
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = [];

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}
			
			$uniset = $this->config->get('config_unishop2');
			$language_id = $this->config->get('config_language_id');
			
			$firstname = isset($this->request->post['firstname']) ? $this->request->post['firstname'] : '';
			$email = isset($this->request->post['email']) && $this->request->post['email'] != '' ? $this->request->post['email'] : $uniset['quick_order_mail_cap'];
			$telephone = isset($this->request->post['phone']) ? $this->request->post['phone'] : '';
			$address = isset($this->request->post['address']) ? $this->request->post['address'] : '';
			$comment = isset($this->request->post['comment']) ? $this->request->post['comment'] : '';
			$customer_ip = $this->request->server['REMOTE_ADDR'];
		
			$attempts_info = $this->model_extension_module_uni_quick_order->getAttempts($customer_ip);
		
			if ($attempts_info && ($attempts_info['total'] >= (int)$this->config->get('config_login_attempts')) && strtotime($attempts_info['date_modified']) > strtotime('-1 hour')) {
				$json['error']['limit'] = $this->language->get('error_limit');
			}
			
			if ((($quantity > $product_info['quantity']) || $option_quantity_error) && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$json['error']['stock'] = sprintf($this->language->get('error_stock'), $product_info['name']);
				
				if($this->config->get('config_stock_checkout')) {
					$ignore_stock_error = true;
				}
			}
			
			if(isset($uniset['quick_order']['min_summ']) && $uniset['quick_order']['min_summ'] > 0 && ($uniset['quick_order']['min_summ'] > ($product_price * $quantity))) {
				$json['error']['minimum'] = sprintf($this->language->get('error_minimum_summ'), $this->currency->format($uniset['quick_order']['min_summ'], $currency));		
			}
			
			if ((utf8_strlen($firstname) < 2) || (utf8_strlen($firstname) > 32)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}
			
			if ((utf8_strlen($telephone) < 3) || (utf8_strlen($telephone) > 32) || strpos($telephone, '_')) {
				$json['error']['phone'] = $this->language->get('error_telephone');
			}
			
			if(isset($this->request->post['email']) && $this->request->post['email'] != '') {
				if (utf8_strlen($email) > 64 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$json['error']['email'] = $this->language->get('error_email');
				}
			}
			
			if (isset($uniset['quick_order']['captcha']) && $this->config->get('captcha_'.$this->config->get('config_captcha').'_status')) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error']['captcha'] = $captcha;
				}
			}
			
			if($this->config->get('config_checkout_id') && isset($uniset['quick_order_confirm'])) {
				$this->load->model('catalog/information');
				
				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
					
				if ($information_info && !isset($this->request->post['confirm'])) {
					$json['error']['confirm'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}

			if (!$json) {
				$old_cart_products = $this->cart->getProducts();
				
				$this->cart->clear();
				$this->cart->add($product_id, $quantity, $option, $recurring_id);
				
				$user_data['customer_name'] = htmlspecialchars(strip_tags($firstname));
				$user_data['customer_email'] = htmlspecialchars(strip_tags($email));
				$user_data['customer_telephone'] = htmlspecialchars(strip_tags($telephone));
				$user_data['customer_address'] = htmlspecialchars(strip_tags($address));
				$user_data['customer_comment'] = htmlspecialchars(strip_tags($comment));
				
				$products_in_cart = $this->cart->getProducts();

				$products = [];

				if($products_in_cart) {
					foreach($products_in_cart as $product) {

						$opt = '';

						if($product['option']) {
							foreach($product['option'] as $option) {
								$opt .= $option['name'].': '.$option['value'];
							}
						}

						$products[] = [
							'id' 		=> $product['product_id'],
							'name' 		=> $product['name'],
							'variant'	=> $opt,
							'quantity'	=> $product['quantity'],
							'price'		=> $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))*$this->currency->getValue($currency)
						]; 
					}
				}
				
				$json['success']['products'] = $products;
				$json['success']['order_id'] = $this->addOrder($user_data);
				$json['success']['text'] = $this->language->get('text_order_success');
				
				$this->model_extension_module_uni_quick_order->addAttempt($customer_ip);
	
				if($old_cart_products) {
					foreach($old_cart_products as $product) {
						$options = [];
						
						if($product['option']) {
							foreach($product['option'] as $option) {
								if($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
									$options[$option['product_option_id']] = $option['value'];
								} elseif ($option['type'] == 'checkbox') {
									$options[$option['product_option_id']][] = $option['product_option_value_id'];
								} else {
									$options[$option['product_option_id']] = $option['product_option_value_id'];
								}
							}
						}
							
						$this->cart->add($product['product_id'], $product['quantity'], $options, 0);
					}
				}
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	private function addOrder($user_data) {
		if($this->cart->getProducts()) {
			$this->load->language('extension/module/uni_othertext');
			
			$this->load->model('setting/extension');
			$this->load->model('account/customer');
			
			$uniset = $this->config->get('config_unishop2');
			$language_id = $this->config->get('config_language_id');
			
			if(!isset($this->session->data['shipping_methods'])) {
				$this->session->data['shipping_methods'] = [];
			}
			
			if(!isset($this->session->data['shipping_method'])) {
				$this->session->data['shipping_method'] = [
					'code' 			=> '',
					'title' 		=> '',
					'cost' 			=> 0,
					'tax_class_id'	=> 0,
					'text' 			=> ''
				];
			}
			
			if(!isset($this->session->data['payment_methods'])) {
				$this->session->data['payment_methods'] = [];
			}
			
			if(!isset($this->session->data['payment_method'])) {
				$this->session->data['payment_method'] = '';
			}
		
			$data = [];

			$data['totals'] = [];
			$total = 0;
			$taxes = $this->cart->getTaxes();
		
			$total_data = [
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			];

			$sort_order = [];

			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);
			
			$this->config->set('total_shipping_status', false);

			foreach ($results as $result) {
				if ($this->config->get('total_' . $result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = [];

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			
			if(is_array($totals)) {
				array_multisort($sort_order, SORT_ASC, $totals);
			}
		
			$data['totals'] = $totals;
	
			$this->load->language('checkout/checkout');
			
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
			
			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTPS_SERVER;	
			}
			
			if ($this->customer->isLogged()) {		
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getGroupId();
				$data['lastname'] = $this->customer->getLastName();
			} else {
				$data['customer_id'] = 0;
				$data['customer_group_id'] = $this->config->get('config_customer_group_id');
				$data['lastname'] = '';
			}
			
			$data['firstname'] = $user_data['customer_name'];
			$data['email'] = $user_data['customer_email'];
			$data['telephone'] = $user_data['customer_telephone'];
			$data['fax'] = '';
			$data['payment_address_1'] = $data['shipping_address_1'] = $user_data['customer_address'];
			$data['comment'] = $user_data['customer_comment'];
			
			$data['payment_firstname'] = $data['firstname'];
			$data['payment_lastname'] = $data['lastname'];	
			$data['payment_company'] = '';	
			$data['payment_company_id'] = '';	
			$data['payment_tax_id'] = '';	
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_zone'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_country'] = '';
			$data['payment_country_id'] = $this->config->get('config_country_id');
			$data['payment_address_format'] = '';
			$data['payment_method'] = 'Быстрый заказ';
			$data['payment_code'] = 'cod';
						
			$data['shipping_firstname'] = $data['firstname'];
			$data['shipping_lastname'] = $data['lastname'];	
			$data['shipping_company'] = '';	
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_zone'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_country'] = '';
			$data['shipping_country_id'] = $this->config->get('config_country_id');
			$data['shipping_address_format'] = '';
			$data['shipping_method'] = 'Быстрый заказ';
			$data['shipping_code'] = 'flat';
			
			$data['custom_field'] = [];
			$data['payment_custom_field'] = [];
			$data['shipping_custom_field'] = [];
			
			$product_data = [];
		
			foreach ($this->cart->getProducts() as $product) {
				$option_data = [];
	
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];	
					} else {
						$value = $this->encryption->decrypt($option['option_value']);
					}	
					
					$option_data[] = [
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],								   
						'name'                    => $option['name'],
						'value'                   => $value,
						'type'                    => $option['type']
					];					
				}
	 
				$product_data[] = [
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'download'   => $product['download'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'     => $product['reward']
				]; 
			}
			
			$voucher_data = [];
			
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$voucher_data[] = [
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],						
						'amount'           => $voucher['amount']
					];
				}
			}  
						
			$data['products'] = $product_data;
			$data['vouchers'] = $voucher_data;
			
			$data['total'] = $total;
			
			if (isset($this->request->cookie['tracking'])) {
				$data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$affiliate_info = $this->model_account_customer->getAffiliateByTracking($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['customer_id'];
					$data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}

				// Marketing
				$this->load->model('checkout/marketing');

				$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

				if ($marketing_info) {
					$data['marketing_id'] = $marketing_info['marketing_id'];
				} else {
					$data['marketing_id'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
				$data['marketing_id'] = 0;
				$data['tracking'] = '';
			}
			
			$currency = $this->session->data['currency'];
			
			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->currency->getId($currency);
			$data['currency_code'] = $currency;
			$data['currency_value'] = $this->currency->getValue($currency);
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
			} else {
				$data['forwarded_ip'] = '';
			}
			
			$data['user_agent'] = isset($this->request->server['HTTP_USER_AGENT']) ? $this->request->server['HTTP_USER_AGENT'] : '';	
			$data['accept_language'] = isset($this->request->server['HTTP_ACCEPT_LANGUAGE']) ? $this->request->server['HTTP_ACCEPT_LANGUAGE'] : '';	
			
			$this->load->model('checkout/order');
			
			$order_status_id = isset($this->request->post['order_status_id']) ? $this->request->post['order_status_id'] : $this->config->get('config_order_status_id');

			$order_id = $this->model_checkout_order->addOrder($data);
			
			$this->session->data['order_id'] = $order_id;
			$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);
			$this->cart->clear();
			
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
				
			return $order_id;
		} else {
			$this->response->redirect($this->url->link('error/not_found', '', 'SSL'));
		}
	}
}
?>