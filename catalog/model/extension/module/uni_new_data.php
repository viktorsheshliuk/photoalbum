<?php 
class ModelExtensionModuleUniNewData extends Controller {
	private $uniset = [];
	
	public function getNewData($result = [], $img_size = []) {
		$uniset = $this->uniset = $this->config->get('config_unishop2');
		$lang_id = (int)$this->config->get('config_language_id');
		
		if(!isset($result['product_id'])) {
			return ['model' => '', 'stickers' => [], 'additional_image' => '', 'attributes' => [], 'options' => [], 'special_date_end' => [], 'discounts' => '', 'quantity_indicator' => [], 'show_description'	=> '', 'show_quantity' => '', 'cart_btn_icon' => '', 'cart_btn_text' => '',	'cart_btn_class' => '', 'quick_order' => ''];
		}
		
		$quantity = $result['quantity'];
		
		$hide_price = !$this->customer->isLogged() && $this->config->get('config_customer_price') ? 'hidden' : '';
			
		if($quantity > 0) {
			$show_quantity = isset($result['product_page']) || isset($uniset['qty_switch']['enabled']) ? true : false;
			$cart_btn_icon = $uniset[$lang_id]['cart_btn_icon'];
			$cart_btn_text = $uniset[$lang_id]['cart_btn_text'];
			$cart_btn_class = $hide_price;
			$quick_order = isset($uniset['show_quick_order']) ? true : false;
		} else {
			$show_quantity = isset($uniset['qty_switch']['enabled_all']) ? true : false;
			$cart_btn_icon = $uniset[$lang_id]['cart_btn_icon_disabled'];
			$cart_btn_text = $uniset[$lang_id]['cart_btn_text_disabled'];
			$cart_btn_class = $uniset['cart_btn_disabled'].' '.$hide_price;
			$quick_order = isset($uniset['show_quick_order']) && isset($uniset['show_quick_order_quantity']) ? true : false;
		}

		if(!isset($result['product_page'])) {
			$img_width = isset($img_size['width']) ? $img_size['width'] : 220;
			$img_height = isset($img_size['height']) ? $img_size['height'] : 200;
			
			$options = $this->getOptions($result['product_id'], $result['tax_class_id'], $img_width, $img_height);
			
			$attributes = $this->getAttributes($result['product_id']);
			
			$special_date_end = $this->getSpecialDateEnd($result['product_id'], $result['special'], $quantity, false);
			
			$model = isset($uniset['catalog']['show_model']) && $uniset['catalog']['show_model'] != 'disabled' ? $uniset['catalog']['show_model'] : '';
			
			$show_description = isset($uniset['show_description']) && !isset($uniset['show_description_alt']) || isset($uniset['show_description_alt']) && !$attributes ? true : false;
			
			$data = [
				'model'				 => $model ? ($model == 'model' ? $result['model'] : $result['sku']) : '',
				'stickers' 			 => $this->getStickers($result),
				'additional_image' 	 => $this->getAdditionalImage($result['product_id'], $img_width, $img_height),
				'attributes' 		 => $attributes,
				'options' 			 => $options['options'],
				'special_date_end'	 => $special_date_end['timer_end'],
				'discounts' 		 => $this->getDiscounts($result['product_id'], $result['tax_class_id']),
				'quantity_indicator' => $this->getQuantityIndicator($quantity, $options['quantity'], ($options['options'] ? true : false)),
				'show_description'	 => $show_description,
				'show_quantity' 	 => $show_quantity,
				'cart_btn_icon' 	 => $cart_btn_icon,
				'cart_btn_text' 	 => $cart_btn_text,
				'cart_btn_class' 	 => $cart_btn_class,
				'quick_order' 		 => $quick_order
			];
		} else {
			$special_date_end = $this->getSpecialDateEnd($result['product_id'], $result['special'], $quantity, true);
if($special_date_end['microdata_end'] == ''){
	$special_date_end['microdata_end'] = date('Y-m-d', strtotime("+7 days"));
};	
	
			$data = [
				'stickers' 					 => $this->getStickers($result),
				'special_date_end' 			 => $special_date_end['timer_end'],
				'special_date_microdata_end' => $special_date_end['microdata_end'],
				'discounts'					 => $this->getDiscounts($result['product_id'], $result['tax_class_id']),
				'quantity_indicator' 		 => $this->getQuantityIndicator($quantity, $result['options_quantity'], ($result['options'] ? true : false)),
				'show_quantity' 	 		 => $show_quantity,
				'cart_btn_icon' 	 		 => $cart_btn_icon,
				'cart_btn_text'				 => $cart_btn_text,
				'cart_btn_class'			 => $cart_btn_class,
				'quick_order'				 => $quick_order
			];
		}
		
		return $data;
	}
	
	private function getAttributes($product_id) {
		$uniset = $this->uniset;
		$lang_id = (int)$this->config->get('config_language_id');
		
		$result = [];
		
		if(isset($uniset['show_attr']) && $uniset['show_attr_group'] > 0 && $uniset['show_attr_item'] > 0) {
			$sql = "SELECT ag.attribute_group_id FROM `".DB_PREFIX."product_attribute` pa LEFT JOIN `".DB_PREFIX."attribute` a ON (pa.attribute_id = a.attribute_id) LEFT JOIN `".DB_PREFIX."attribute_group` ag ON (a.attribute_group_id = ag.attribute_group_id)";
			$sql .= " WHERE pa.product_id = '".(int)$product_id . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order LIMIT ".(int)$uniset['show_attr_group']."";
			
			$query = $this->db->query($sql);
			
			if($query->rows) {
				foreach ($query->rows as $attribute_group) {
					$sql = "SELECT ad.name, pa.text FROM `".DB_PREFIX."product_attribute` pa LEFT JOIN `".DB_PREFIX."attribute` a ON (pa.attribute_id = a.attribute_id) LEFT JOIN `".DB_PREFIX."attribute_description` ad ON (a.attribute_id = ad.attribute_id)";
					$sql .= " WHERE pa.product_id = '".(int)$product_id."' AND a.attribute_group_id = '".(int)$attribute_group['attribute_group_id']."' AND ad.language_id = '".$lang_id."' AND pa.language_id = '".$lang_id."' ORDER BY a.sort_order, ad.name LIMIT ".(int)$uniset['show_attr_item']."";
					
					$query = $this->db->query($sql);
					
					if($query->rows) {
						foreach ($query->rows as $attribute) {
							$result[] = array(
								'name'	=> isset($uniset['show_attr_name']) ? $attribute['name'] : '',
								'text'	=> $attribute['text']
							);
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	private function getOptions($product_id, $tax_class_id, $img_width, $img_height) {
		$uniset = $this->uniset;
		$currency = $this->session->data['currency'];
		
		$o_quantity = 0;
		$required = false;
		$o_quantity_arr = [];
		
		if(isset($uniset['catalog']['option_img_prop'])) {
			$img_width = $img_height;
		}
			
		$data['options'] = [];
		
		if (isset($uniset['show_options']) && $uniset['show_options_item'] > 0) {
			
			$show_ended_option_value = isset($uniset['catalog']['option']['show_ended_value']) ? true : false;
			
			foreach ($this->model_catalog_product->getProductOptions((int)$product_id) as $key => $option) {
				if ($key < $uniset['show_options_item'] && ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox')) {
				
					$product_option_value_data = [];
					
					if($option['required']) {
						$o_quantity = 0;
						$required = true;
					}

					foreach ($option['product_option_value'] as $option_value) {
						if (!$option_value['subtract'] || ($option_value['quantity'] > 0) || $show_ended_option_value) {
							if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
								$option_price = $this->currency->format($this->tax->calculate($option_value['price'], $tax_class_id, $this->config->get('config_tax') ? 'P' : false), $currency);
							} else {
								$option_price = false;
							}
							
							$product_option_value_data[] = [
								'product_option_value_id' => $option_value['product_option_value_id'],
								'option_value_id'         => $option_value['option_value_id'],
								'name'                    => $option_value['name'],
								'image'                   => $option_value['image'] ? $this->model_tool_image->resize($option_value['image'], $img_width/4, $img_height/4) : '',
								'small' 				  => $this->model_tool_image->resize($option_value['image'], $img_width, $img_height),
								'price'                   => $option_price,
								'price_value'             => $this->tax->calculate($option_value['price'], $tax_class_id, $this->config->get('config_tax'))*$this->currency->getValue($currency),
								'price_prefix'            => $option_value['price_prefix'],
								'ended'					  => $option_value['subtract'] && $option_value['quantity'] <= 0 ? true : false
							];
						}
						
						$o_quantity = $o_quantity + $option_value['quantity'];
					}
					
					if($option['required']) {
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
			}
		}
		
		$data['quantity'] = $required ? min($o_quantity_arr) : $o_quantity;

		return $data;
	}
	
	private function getStickers($result) {
		$uniset = $this->uniset;
		$lang_id = $this->config->get('config_language_id');
		$currency = $this->session->data['currency'];
		
		$stickers = [];
		
		if($result) {			
			if (isset($uniset['sticker_reward']) && isset($result['reward']) && $result['reward'] > 0) {
				$value = round($result['reward'], 0);
				
				$stickers[] = [
					'name' 		=> 'reward',
					'text' 		=> $uniset[$lang_id]['sticker_reward_text'].' '.$value.' '.$uniset[$lang_id]['sticker_reward_text_after'],
					'length'	=> mb_strlen($uniset[$lang_id]['sticker_reward_text']) + mb_strlen($uniset[$lang_id]['sticker_reward_text_after']) + mb_strlen($value)
				];
			}
			
			if (isset($uniset['sticker_special']) && $result['special'] > 0 && $result['price'] > 0) {
				if(isset($uniset['sticker_special_percent'])) {
					$value = round((($result['special'] - $result['price'])/$result['price'])*100, 0) . '%';
				} else {
					$value = $this->currency->format($this->tax->calculate($result['price'] - $result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $currency);
				}

				$stickers[] = [
					'name' 		=> 'special',
					'text' 		=> $uniset[$lang_id]['sticker_special_text'].' '.$value,
					'length'	=> mb_strlen($uniset[$lang_id]['sticker_special_text']) + mb_strlen($value)
				];
			}
			
			if(isset($uniset['sticker_bestseller'])) {
				$bestseller = $this->getBestSellerSticker($result['product_id']);
				
				if ($bestseller) {
					$stickers[] = [
						'name'		=> 'bestseller',
						'text' 		=> $uniset[$lang_id]['sticker_bestseller_text'],
						'length'	=> mb_strlen($uniset[$lang_id]['sticker_bestseller_text'])
					];
				}
			}
			
			$date = strtotime($result['date_available']) + $uniset['sticker_new_date'] * 24 * 3600;
				
			if (isset($uniset['sticker_new']) && $date >= strtotime('now')) {
				$stickers['new'] = [
					'name' 		 => 'new',
					'text' 		 => $uniset[$lang_id]['sticker_new_text'],
					'length' 	 => mb_strlen($uniset[$lang_id]['sticker_new_text'])
				];		
			}
			
			if (isset($uniset['sku_as_sticker']) && $result['sku']) {
				$stickers[] = [
					'name'		 => 'sku',
					'text'       => $result['sku'],
					'length' 	 => mb_strlen($result['sku'])
				];
			}
			
			if (isset($uniset['upc_as_sticker']) && $result['upc']) {
				$stickers[] = [
					'name'		=> 'upc',
					'text'      => $result['upc'],
					'length'  	=> mb_strlen($result['upc'])
				];
			}
			
			if (isset($uniset['ean_as_sticker']) && $result['ean']) {
				$stickers[] = [
					'name' 		=> 'ean',
					'text' 		=> $result['ean'],
					'length' 	=> mb_strlen($result['ean'])
				];
			}
			
			if (isset($uniset['jan_as_sticker']) && $result['jan']) {
				$stickers[] = [
					'name' 		=> 'jan',
					'text'		=> $result['jan'],
					'length'	=> mb_strlen($result['jan'])
				];
			}
			
			if (isset($uniset['isbn_as_sticker']) && $result['isbn']) {
				$stickers[] = [
					'name' 		=> 'isbn',
					'text'		=> $result['isbn'],
					'length'	=> mb_strlen($result['isbn'])
				];
			}
			
			if (isset($uniset['mpn_as_sticker']) && $result['mpn']) {
				$stickers[] = [
					'name' 		=> 'mpn',
					'text' 		=> $result['mpn'],
					'length' 	=> mb_strlen($result['mpn'])
				];
			}
			
			if(count($stickers) > 1) { 
				array_multisort(array_column($stickers, 'length'), SORT_DESC, $stickers);
			}	
		}
		
		return $stickers;
	}
	
	private function getQuantityIndicator($quantity, $options_quantity, $options) {
		$uniset = $this->uniset;
		$lang_id = (int)$this->config->get('config_language_id');
		
		$result = [];
		
		if(isset($uniset['show_stock_indicator']) && $uniset['show_stock_indicator'] > 0) {
			
			$stock_indicator_result = isset($uniset['stock_indicator']['result']) ? $uniset['stock_indicator']['result'] : 2;
			
			if($stock_indicator_result == 1) {
				$quantity = $quantity + $options_quantity;
			} elseif($stock_indicator_result == 3 && $options_quantity > 0) {
				$quantity = $options_quantity;
			}
			
			$full = $options ? (int)$uniset['stock_indicator_full_opt'] : (int)$uniset['stock_indicator_full'];
				
			$stock = round((int)$quantity / (int)$full * 100, 0);
				
			$stock = $stock > 100 ? 100 : $stock;
			$stock = $stock < 1 ? 0.5 : $stock;
			
			switch($stock) {
				case ($stock >= 80):
					$title = $uniset[$lang_id]['stock_i_t_5'];
					$items = 5;
					break;
				case ($stock >= 60):
					$title = $uniset[$lang_id]['stock_i_t_4'];
					$items = 4;
					break;
				case ($stock >= 40):
					$title = $uniset[$lang_id]['stock_i_t_3'];
					$items = 3;
					break;
				case ($stock >= 20):
					$title = $uniset[$lang_id]['stock_i_t_2'];
					$items = 2;
					break;
				case ($stock >= 1):
					$title = $uniset[$lang_id]['stock_i_t_1'];
					$items = 1;
					break;
				default:
					$title = $uniset[$lang_id]['stock_i_t_0'];
					$items = 0;
			}
			
			$result = [
				'title' => $uniset['show_stock_indicator'] != 3 ? $title : $quantity, 
				'items' => $items, 
				'width' => $stock,
				'type'  => $uniset['show_stock_indicator']
			];
		}
		
		return $result;
	}
	
	private function getAdditionalImage($product_id, $img_width, $img_height) {
		$uniset = $this->uniset;
		
		$image = '';
		$limit = 10;
		
		if(isset($uniset['catalog']['addit_img']) && $uniset['catalog']['addit_img'] != 'disabled') {
			$query = $this->db->query("SELECT * FROM `".DB_PREFIX."product_image` WHERE product_id = '".(int)$product_id."' ORDER BY sort_order ASC LIMIT ".(int)$limit);

			$results = $query->rows;
			
			foreach($results as $key => $result) {
				$image .= $this->model_tool_image->resize($result['image'], $img_width, $img_height).($key+1 < count($results) ? '||' : '');
			}
		}
		
		return $image;
	}
	
	private function getSpecialDateEnd($product_id, $special, $quantity, $product_page) {
		$uniset = $this->uniset;
		
		$date_end = '';
		
		$show = isset($uniset['show_special_timer']) && $quantity ? true : false;
		
		if(($show || $product_page) && $special) {
			$query = $this->db->query("SELECT date_end FROM `".DB_PREFIX."product_special` WHERE product_id = '".(int)$product_id."' AND customer_group_id = '".(int)$this->config->get('config_customer_group_id')."' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
			
			if($query->num_rows && ($query->row['date_end'] != '0000-00-00')) {
				$date_end = $query->row['date_end'];
			}
		}
		
		return [
			'timer_end' 	 => $show ? $date_end : '',
			'microdata_end'  => $date_end
		];
	}
	
	private function getDiscounts($product_id, $tax_class_id) {
		$uniset = $this->uniset;

		$result = '';
		
		if(isset($uniset['liveprice'])) {
			$currency = $this->session->data['currency'];
			$store_id = (int)$this->config->get('config_store_id');
			$customer_group_id = (int)$this->config->get('config_customer_group_id');
			$customer_group_id = $customer_group_id > 0 ? $customer_group_id : 1;
			
			$cache_name = 'product.unishop.discount.'.$currency.'.'.$customer_group_id.'.'.$store_id;
			
			$discount = $this->cache->get($cache_name);
		
			if(!$discount) {
				$query = $this->db->query("SELECT product_id, quantity, price FROM ".DB_PREFIX."product_discount WHERE customer_group_id = '".$customer_group_id."' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

				$discount[0] = [];
				
				foreach($query->rows as $product) {
					$discount[$product['product_id']][] = [
						'quantity' => $product['quantity'],
						'price'    => $this->tax->calculate($product['price'], $tax_class_id, $this->config->get('config_tax'))*$this->currency->getValue($currency),
					];
				}
		
				$this->cache->set($cache_name, $discount);
			}
			
			if(isset($discount[$product_id])) {
				$result = str_replace('"', "'", json_encode($discount[$product_id]));
			}
		}
		
		return $result;
	}
	
	private function getBestSellerSticker($product_id) {
		$uniset = $this->uniset;
		
		$store_id = (int)$this->config->get('config_store_id');
		
		$cache_name = 'unishop.sticker.bestseller.'.$store_id;
		
		$result = $this->cache->get($cache_name);
		
		if(!$result) {
			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."product` p ON (op.product_id = p.product_id) LEFT JOIN `".DB_PREFIX."order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '0' AND p.date_available <= NOW() AND p.status = '1' GROUP BY op.product_id");
			
			$result = [0];
			
			foreach($query->rows as $product) {
				if((int)$product['total'] >= $uniset['sticker_bestseller_item']) {
					$result[] = $product['product_id'];
				}
			}
			
			$this->cache->set($cache_name, $result);
		}
		
		if(in_array($product_id, $result)) {
			return true;
		} else {
			return false;
		}
	}
}
?>