<?php
class ControllerExtensionFeedRemarketingFeed extends Controller {
	private $currencies = array();
	private $categories = array();
	private $eol = ''; 
	private $part_size = 3000;
	private	$sleep_time = 1;
	private	$product_images = [];
	private	$override_language = false;
	private	$override_currency = false;

	public function index() {
		
		if ($this->config->get('remarketing_status') && $this->config->get('remarketing_feed_status')) {
			$key = $this->config->get('remarketing_feed_key');
		
			if (!empty($key) && (!isset($this->request->get['key']) || $this->request->get['key'] != $key)) {
				die;
			}
					
			$this->generateFeed();
		
		}
	}

	private function generateFeed() {
		
		header('Content-Type: application/xml');
		
		$this->load->model('localisation/currency');
		
		$this->eol = "\n";
		
		if (!empty($this->request->get['currency'])) {
			$query = $this->db->query("SELECT currency_id FROM `" . DB_PREFIX . "currency` WHERE code = '" . $this->db->escape($this->request->get['currency']) . "' AND status = '1'"); 
			if ($query->num_rows) {
				$this->session->data['currency'] = $this->request->get['currency'];
				$this->override_currency = $this->request->get['currency'];
			} else {
				die;
			}
		}
		
		if (!empty($this->request->get['language'])) {
			$query = $this->db->query("SELECT language_id FROM `" . DB_PREFIX . "language` WHERE code='" . $this->db->escape($this->request->get['language']) . "' AND status = '1'"); 
			if ($query->num_rows) {
				$this->session->data['language'] = $this->request->get['language'];
				$this->config->set('config_language_id', $query->row['language_id']);
				$this->config->set('config_language', $this->request->get['language']);
			} else {
				die;
			}
		}
		
		$head  = '<?xml version="1.0" encoding="UTF-8"?>' . $this->eol;
		$head .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">' . $this->eol;
		$head .= '<channel>' . $this->eol;
		$head .= '<title>' . $this->config->get('config_name') . '</title>' . $this->eol ;
		$head .= '<link>' . HTTPS_SERVER . '</link>' . $this->eol ;
		$head .= '<description>' . $this->config->get('config_name') . '</description>' . $this->eol ;
		
		echo $head; 
		
		if ($this->config->get('remarketing_feed_additional_images')) {
			$this->product_images = $this->getImages();
		}
		
		$page = 0;
		$feed_part = $this->getXml($page);
		while ($feed_part != 'EMPTY') {
			echo $feed_part;
			unset($feed_part);
			sleep($this->sleep_time);
			$page++;
			$feed_part = $this->getXml($page);
		}
		
		echo '</channel></rss>';
	}

	private function getXml($page = 0) {
		$xml = '';
		
		$original_image_dir = HTTPS_SERVER . 'image/';
		
		$this->load->model('tool/image');

		$start = $page * $this->part_size;
		$limit = $this->part_size;
		
		$items_currency = $this->config->get('remarketing_feed_currency');
		
		if ($this->override_currency) {
			$items_currency = $this->override_currency;
		}
		
		$shop_currency = $this->config->get('remarketing_feed_currency_base');
		
		$decimal = (int)$this->currency->getDecimalPlace($items_currency);
		
		$remarketing_feed_category_google_category = $this->config->get('remarketing_feed_category_google_category');
		$remarketing_feed_category_product_type = $this->config->get('remarketing_feed_category_product_type');
		$remarketing_feed_category_condition = $this->config->get('remarketing_feed_category_condition');
		$remarketing_feed_category_custom_label_0 = $this->config->get('remarketing_feed_category_custom_label_0');
		$remarketing_feed_category_custom_label_1 = $this->config->get('remarketing_feed_category_custom_label_1');
		$remarketing_feed_category_custom_label_2 = $this->config->get('remarketing_feed_category_custom_label_2');
		$remarketing_feed_category_custom_label_3 = $this->config->get('remarketing_feed_category_custom_label_3');
		$remarketing_feed_category_custom_label_4 = $this->config->get('remarketing_feed_category_custom_label_4');
		
		$id = $this->config->get('remarketing_feed_identifier');
		$gtin = $this->config->get('remarketing_feed_gtin');
		$mpn = $this->config->get('remarketing_feed_mpn');
		$product_highlight = $this->config->get('remarketing_feed_highlight');
		$replace_description = $this->config->get('remarketing_feed_replace_description');
		$condition = $this->config->get('remarketing_feed_condition');
		$adult = $this->config->get('remarketing_feed_adult');
		$utm = $this->config->get('remarketing_feed_utm');
		$original_description = $this->config->get('remarketing_feed_original_description');
		$original_images = $this->config->get('remarketing_feed_original_image_status');
		$special = $this->config->get('remarketing_feed_special');
		$multiplier = (float)$this->config->get('remarketing_feed_multiplier') > 0 ? (float)$this->config->get('remarketing_feed_multiplier') : 1;
		$empty_description = $this->config->get('remarketing_feed_description');
		$empty_brand = $this->config->get('remarketing_feed_empty_brand');
		$store_code = $this->config->get('remarketing_feed_store_code');
		$replace_from = $this->config->get('remarketing_feed_replace_from');
		$replace_from_array = array_map('trim', explode("\n", $replace_from));
		$replace_to = $this->config->get('remarketing_feed_replace_to');
		$replace_to_array = array_map('trim', explode("\n", $replace_to));
		
		$facebook = !empty($this->request->get['target']) && $this->request->get['target'] == 'facebook';
		$tiktok = !empty($this->request->get['target']) && $this->request->get['target'] == 'tiktok';
		
		$rich_text = $this->config->get('remarketing_feed_rich_text') && $facebook;
		
		if ($facebook) {
			$utm = $this->config->get('remarketing_feed_utm_facebook');
		}
		
		if ($tiktok) {
			$utm = $this->config->get('remarketing_feed_utm_tiktok');
		}
		
		$categories_setup = $this->config->get('remarketing_feed_category');
		$manufacturers_setup = $this->config->get('remarketing_feed_manufacturer');
		$last_category = $this->config->get('remarketing_feed_last_category');
		$type_category = $this->config->get('remarketing_feed_type_category');
		$always_avail = $this->config->get('remarketing_feed_always_avail');
		$in_stock = $this->config->get('remarketing_feed_in_stock');
		$out_of_stock = $this->config->get('remarketing_feed_out_of_stock');
		$all_attributes = $this->config->get('remarketing_feed_all_attributes');
		$truncate_description = $this->config->get('remarketing_feed_short_desc');
		
		$allowed_attributes = [];
		$color = explode(',', $this->config->get('remarketing_feed_color'));
		$size = explode(',', $this->config->get('remarketing_feed_size'));
		$material = explode(',', $this->config->get('remarketing_feed_material'));
		$gender = explode(',', $this->config->get('remarketing_feed_gender'));
		$age_group = explode(',', $this->config->get('remarketing_feed_age_group'));
		
		if (!empty($color)) $allowed_attributes = array_merge($allowed_attributes, $color);
		if (!empty($size)) $allowed_attributes = array_merge($allowed_attributes, $size);
		if (!empty($material)) $allowed_attributes = array_merge($allowed_attributes, $material);
		if (!empty($gender)) $allowed_attributes = array_merge($allowed_attributes, $gender);
		if (!empty($age_group)) $allowed_attributes = array_merge($allowed_attributes, $age_group);
		$allowed_attributes = array_diff($allowed_attributes, ['']);
		
		if (!empty($categories_setup)) {
			$categories = implode(',', $categories_setup);
		} else {
			$categories = false;
		}
		
		if (!empty($manufacturers_setup)) {
			$manufacturers = implode(',', $manufacturers_setup);
		} else {
			$manufacturers = false;
		}
		
		$empty = true;
		$ocstore = false;
		
		if ($this->config->get('remarketing_feed_ocstore_main')) {
			$ocstore_query = $this->db->query("DESC `" . DB_PREFIX . "product_to_category`");
			foreach ($ocstore_query->rows as $row) {
				if ($row['Field'] == 'main_category') $ocstore = true;
			}
		}
		
		$store_id = false;
		
		if (!empty($this->request->get['store_id'])) {
			$store_id = (int)$this->request->get['store_id'];
		}
		
		$xml = '';
		
		foreach ($this->getProducts($categories, $manufacturers, $special, $start, $limit, $ocstore, $store_id) as $product) {
			$empty = false;

			$xml .= '<item>'. $this->eol; 
			if (!$tiktok) {
				$xml .= '<g:id>' . $product[$id] . '</g:id>' . $this->eol;
			}
			if ($tiktok) {
				$xml .= '<g:sku_id>' . $product[$id] . '</g:sku_id>' . $this->eol;
			}
			$xml .= '<g:title>' . $this->prepareField($product['name']) . '</g:title>' . $this->eol;
			
			if (!empty($replace_description)) {
				$product['description'] = $product[$replace_description];
			}
			
			if (mb_strlen($product['description'], 'UTF-8') < 100) {
				$product['description'] = str_replace(['{product_name}' , '{product_model}'], [$product['name'], $product['model']], $empty_description);
			}
			
			if ($truncate_description) {
				$limit = $truncate_description;
				if (mb_strlen($product['description']) > $limit) { 
					$lastspacePos = mb_strrpos(mb_substr($product['description'], 0, $limit), ' ');
					$product['description'] = trim(mb_substr($product['description'], 0, $lastspacePos), '.,;&+-\//?!');
				}
			}
			
			if ($original_description) {
				$xml .= '<g:description><![CDATA[' . html_entity_decode($product['description']) . ']]></g:description>' . $this->eol; 
			} else {
				$xml .= '<g:description><![CDATA[' . $this->prepareField($product['description']) . ']]></g:description>' . $this->eol; 
			}  
			
			if ($rich_text) {
				$xml .= '<g:rich_text_description><![CDATA[' . html_entity_decode($product['description']) . ']]></g:rich_text_description>' . $this->eol; 
			} 
			
			$link = $this->url->link('product/product', 'product_id=' . $product['product_id']);
			
			if ($utm) {
				$utm_to_link = str_replace(['{product_id}' , '{product_model}'], [$product['product_id'], $product['model']], $utm);
				$link .= (strpos($link, '?') == false ? '?' : '&') . $utm_to_link;
			}
			
			$xml .= '<g:link>' . $this->prepareField($link) . '</g:link>' . $this->eol;
			
			if ($original_images) {
				$parts = explode('/', $product['image']);
				$image_url = implode('/', array_map('rawurlencode', $parts));		
				$xml .= '<g:image_link>' . $original_image_dir . $image_url . '</g:image_link>' . $this->eol;
			} else {
				if (version_compare(VERSION,'3.0.0.0', '>=')) {
					$xml .= '<g:image_link>' . $this->model_tool_image->resize($product['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')) . '</g:image_link>' . $this->eol;
				} else {
					$xml .= '<g:image_link>' . $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')) . '</g:image_link>' . $this->eol;
				}
			}
			
			if (!empty($this->product_images[$product['product_id']])) {
				foreach ($this->product_images[$product['product_id']] as $image) {
					if ($original_images) {
						$parts = explode('/', $image);
						$image_url = implode('/', array_map('rawurlencode', $parts));		
						$xml .= '<g:additional_image_link>' . $original_image_dir . $image_url . '</g:additional_image_link>' . $this->eol;
					} else {
						if (version_compare(VERSION,'3.0.0.0', '>=')) {
							$xml .= '<g:additional_image_link>' . $this->model_tool_image->resize($image, $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')) . '</g:additional_image_link>' . $this->eol;
						} else {
							$xml .= '<g:additional_image_link>' . $this->model_tool_image->resize($image, $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')) . '</g:additional_image_link>' . $this->eol;
						}
					}
				}
			}
			
			$product_in_stock = $product['quantity'] > 0 || $always_avail;
			
			if (is_array($in_stock) && in_array($product['stock_status_id'], $in_stock)) {
				$product_in_stock = true;
			}
			
			if (is_array($out_of_stock) && in_array($product['stock_status_id'] , $out_of_stock)) {
				$product_in_stock = false;
			}
			
			if (!$facebook && !$tiktok) {
				$availability = $product_in_stock ? 'in_stock' : 'out_of_stock';
			} else {
				$availability = $product_in_stock ? 'in stock' : 'out of stock';
			}
			
			$xml .= '<g:availability>' . $availability . '</g:availability>' . $this->eol;
			
			if ($product['special'] && $product['special'] < $product['price']) {
				$xml .= '<g:price>' . number_format($this->currency->convert($this->tax->calculate($product['price'] * $multiplier, $product['tax_class_id']), $shop_currency, $items_currency), $decimal, '.', '') . ' ' . $items_currency . '</g:price>' . $this->eol;
				$xml .= '<g:sale_price>' . number_format($this->currency->convert($this->tax->calculate($product['special'] * $multiplier, $product['tax_class_id']), $shop_currency, $items_currency), $decimal, '.', '') . ' ' . $items_currency . '</g:sale_price>' . $this->eol;
			}	else {
				$xml .= '<g:price>' . number_format($this->currency->convert($this->tax->calculate($product['price'] * $multiplier, $product['tax_class_id']), $shop_currency, $items_currency), $decimal, '.', '') . ' ' . $items_currency . '</g:price>' . $this->eol;
			}
			
			if ($last_category) {
				$product['category_id'] = $this->getLastCategory($product['product_id']);
			}
			
			if (!empty($remarketing_feed_category_google_category[$product['category_id']])) {
				$xml .= '<g:google_product_category>' . $remarketing_feed_category_google_category[$product['category_id']] . '</g:google_product_category>' . $this->eol;
			}
			
			if (!$type_category && !empty($remarketing_feed_category_product_type[$product['category_id']])) {
				$xml .= '<g:product_type>' . $remarketing_feed_category_product_type[$product['category_id']] . '</g:product_type>' . $this->eol;
			}
			
			if ($type_category) {
				$xml .= '<g:product_type>' . $this->getRemarketingFeedCategories($product['product_id'], $ocstore) . '</g:product_type>' . $this->eol;
			}
			
			$identifier = false;
			
			if (!empty($product['manufacturer'])) { 
				$xml .= '<g:brand><![CDATA[' . $this->prepareField($product['manufacturer']) . ']]></g:brand>';
				$identifier = true;
			} else if ($empty_brand) {
				$xml .= '<g:brand>' . $this->prepareField($empty_brand) . '</g:brand>';
				$identifier = true;
			}
			
			if (!empty($product[$gtin])) {
				$xml .= '<g:gtin>' . $product[$gtin] . '</g:gtin>';
				$identifier = true;
			}
			
			if (!empty($product[$mpn])) {
				$xml .= '<g:mpn>' . $product[$mpn] . '</g:mpn>';
				$identifier = true;
			}
			
			
			if (!$identifier) {
				$xml .= '<g:identifier_exists>no</g:identifier_exists>';
			}
			
			if (!empty($product[$product_highlight])) {
				$xml .= '<g:product_highlight>' . $product[$product_highlight] . '</g:product_highlight>';
			}
		
			if ($adult) {
				$xml .= '<g:age_group>adult</g:age_group>';
			}
			
			if ($store_code) {
				$xml .= '<g:store_code>' . $store_code . '</g:store_code>';
			}
			
			if (!empty($remarketing_feed_category_condition[$product['category_id']])) {
				$xml .= '<g:condition>' . $remarketing_feed_category_condition[$product['category_id']] . '</g:condition>' . $this->eol;
			} else {
				$xml .= '<g:condition>' . $condition . '</g:condition>' . $this->eol;
			}
			
			if (!empty($remarketing_feed_category_custom_label_0[$product['category_id']])) {
				$xml .= '<g:custom_label_0>' . $remarketing_feed_category_custom_label_0[$product['category_id']] . '</g:custom_label_0>' . $this->eol;
			} 

			if (!empty($remarketing_feed_category_custom_label_1[$product['category_id']])) {
				$xml .= '<g:custom_label_1>' . $remarketing_feed_category_custom_label_1[$product['category_id']] . '</g:custom_label_1>' . $this->eol;
			} 

			if (!empty($remarketing_feed_category_custom_label_2[$product['category_id']])) {
				$xml .= '<g:custom_label_2>' . $remarketing_feed_category_custom_label_2[$product['category_id']] . '</g:custom_label_2>' . $this->eol;
			} 

			if (!empty($remarketing_feed_category_custom_label_3[$product['category_id']])) {
				$xml .= '<g:custom_label_3>' . $remarketing_feed_category_custom_label_3[$product['category_id']] . '</g:custom_label_3>' . $this->eol;
			} 

			if (!empty($remarketing_feed_category_custom_label_4[$product['category_id']])) {
				$xml .= '<g:custom_label_4>' . $remarketing_feed_category_custom_label_4[$product['category_id']] . '</g:custom_label_4>' . $this->eol;
			} 
			
			if (!empty($allowed_attributes)) {
				$product_attributes = $this->getFastAttributes($product['product_id'], $allowed_attributes);
				foreach ($product_attributes as $attribute) {
					if (is_array($color) && in_array($attribute['attribute_id'], $color)) {
						$xml .= '<g:color>' . $attribute['text'] . '</g:color>';
					}
					if (is_array($size) && in_array($attribute['attribute_id'], $size)) {
						$xml .= '<g:size>' . $attribute['text'] . '</g:size>';
					}
					if (is_array($material) && in_array($attribute['attribute_id'], $material)) {
						$xml .= '<g:material>' . $attribute['text'] . '</g:material>';
					}
					if (is_array($gender) && in_array($attribute['attribute_id'], $gender)) {
						$xml .= '<g:gender>' . $attribute['text'] . '</g:gender>';
					}
					if (is_array($age_group) && in_array($attribute['attribute_id'], $age_group)) {
						$xml .= '<g:age_group>' . $attribute['text'] . '</g:age_group>';
					}
				}
			}
			
			if ($all_attributes) {
				$attribute_groups = $this->getProductAttributes($product['product_id']);
	
				if (!empty($attribute_groups)) {
					foreach ($attribute_groups as $attribute_group) {
						foreach ($attribute_group['attribute'] as $attribute) {
							$xml .=	'<g:product_detail>';
							$xml .=	'<g:section_name>' . $attribute_group['name'] . '</g:section_name>';
							$xml .=	'<g:attribute_name>' . $attribute['name'] . '</g:attribute_name>';
							$xml .=	'<g:attribute_value>' . $attribute['text'] . '</g:attribute_value>';
							$xml .=	'</g:product_detail>';
						}
					}
				}
			}
			$xml .= '</item>' . $this->eol;
		}
		
		if ($empty) {
			return 'EMPTY';
		}

		if (!empty($replace_from_array)) {
			$xml = str_replace($replace_from_array, $replace_to_array, $xml);
		}
		
		if (!empty($this->request->get['prefix'])) {
			$xml = str_replace(HTTPS_SERVER, HTTPS_SERVER . $this->request->get['prefix'] . '/', $xml);
		} 
		
		return $xml;
	}

	private function prepareField($field) {

		$field = htmlspecialchars_decode($field);
		$field = strip_tags($field);
		
		$from = array('"', '&', '>', '<', '°', '\''); 
		$to = array('&quot;', '&amp;', '&gt;', '&lt;', '&#176;', '&apos;');
		$field = str_replace($from, $to, $field);
		
		$field = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $field);

		return trim($field);
	}
	
	private function getProducts($categories, $manufacturers, $special = false, $start = 0, $limit = 3000, $ocstore = false, $store_id = false) {

		$customer_group = (int)$this->config->get('remarketing_feed_customer_group');		
		$zero_quantity = $this->config->get('remarketing_feed_zero_quantity');
		
		$min_price = (int)$this->config->get('remarketing_feed_min_price');		
		$max_price = (int)$this->config->get('remarketing_feed_max_price');
		$custom_sql = html_entity_decode($this->config->get('remarketing_feed_custom_sql'));
	
		if (!empty($this->request->get['categories'])) {
			$categories = $this->db->escape($this->request->get['categories']);
		} 
	
		if (!empty($this->request->get['manufacturers'])) {
			$manufacturers = $this->db->escape($this->request->get['manufacturers']);
		} 
	
		if (!empty($this->request->get['not_categories'])) {
			$custom_sql .= " AND p2c.category_id NOT IN (" . $this->db->escape($this->request->get['not_categories']) . ") ";
		}

		if (!empty($this->request->get['price_from'])) {
			$min_price = $this->request->get['price_from'];		
		}
			
		if (!empty($this->request->get['price_to'])) {
			$max_price = $this->request->get['price_to'];		
		}

		$sql = "SELECT p.*, pd.*, m.name AS manufacturer, " . ((!$categories && empty($this->request->get['not_categories'])) ? " NULL AS category_id" : " p2c.category_id ") . ", " . ($special ? " ps.price " : " NULL ") . " AS special FROM " . DB_PREFIX . "product p " . ($store_id ? " LEFT JOIN " . DB_PREFIX . "product_to_store AS p2s ON (p.product_id = p2s.product_id) " : "") . (($categories || !empty($this->request->get['not_categories'])) ? " JOIN " . DB_PREFIX . "product_to_category AS p2c ON (p.product_id = p2c.product_id " . ($ocstore ? " AND p2c.main_category = 1 " : "") . ") " : " ") . " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) " . ($special ? " LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id AND ps.customer_group_id = '" . (int)$customer_group . "' AND ps.date_start < NOW() AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) " : " " ). " WHERE 1 " . ($categories ? " AND p2c.category_id IN (" . $this->db->escape($categories) . ")" : "")	. ($manufacturers ? " AND p.manufacturer_id IN (" . $this->db->escape($manufacturers) . ")" : "") . " AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1'" . ($zero_quantity ? " AND p.quantity > 0 " : "") . ($min_price > 0 ? " AND p.price >= " . $min_price . " " : "") .  ($max_price > 0 ? " AND p.price <= " . $max_price . " " : "") . (!empty($custom_sql) ? ' ' . $custom_sql . ' ' : "") . ($store_id ? " AND p2s.store_id = '" . (int)$store_id . "'" : "") . "AND p.price > 0 AND p.image <> '' AND p.image IS NOT NULL GROUP BY p.product_id ORDER BY p.product_id LIMIT " . $start . ", " . $limit;
		
		$result = $this->db->query($sql);
		
		return $result->rows;
	}
	
	private function getImages($limit = 10) {
		$images = [];
		$query = $this->db->query("SELECT pi.product_id, pi.image FROM `" . DB_PREFIX . "product_image` pi ORDER BY pi.product_id, pi.sort_order");
		
		foreach ($query->rows as $row) {
			if (empty($images[$row['product_id']])) {
				$images[$row['product_id']] = [];
			}
			if (count($images[$row['product_id']]) < $limit) $images[$row['product_id']][] = $row['image'];
		}
		
		return $images;
	}
	
	private function getLastCategory($product_id) {
		$category_query = $this->db->query("SELECT pc.category_id FROM `" . DB_PREFIX . "product_to_category` pc LEFT JOIN `" . DB_PREFIX . "category_path` cp ON pc.category_id = cp.category_id WHERE pc.product_id = '" . (int)$product_id . "' ORDER BY cp.level DESC LIMIT 1");
		return $category_query->num_rows ? $category_query->row['category_id'] : 0;
	}
	
	public function googleReviews() {
		if ($this->config->get('remarketing_reviews_feed_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<feed xmlns:vc="http://www.w3.org/2007/XMLSchema-versioning"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xsi:noNamespaceSchemaLocation=
 "http://www.google.com/shopping/reviews/schema/product/2.2/product_reviews.xsd">
    <version>2.2</version>
    <aggregator>
        <name>Opencart</name>
    </aggregator>
    <publisher>
        <name>' . $this->config->get('config_name') . '</name>
		 <favicon>'.$this->config->get('config_ssl').'image/' . $this->config->get('config_icon').'</favicon>
    </publisher>';
	
			$output .= '  <reviews>';

			$this->load->model('catalog/category');
			$this->load->model('catalog/product');

			$this->load->model('tool/image');

			$review_data = array();
			
			$reviews = $this->getReviews();

				foreach ($reviews as $review) {
					if(!$review['status']) continue;
					$product = $this->model_catalog_product->getProduct($review['product_id']);
					if ($product) {
					$output .= '<review>';
					$output .= '<review_id>' . $review['review_id'] . '</review_id>';
					$output .= '<reviewer><name ' . ($this->config->get('remarketing_reviews_feed_anonymous') ? 'is_anonymous="true"' : '') . '>' . $review['author'] . '</name></reviewer>';
					$output .= '<review_timestamp>' . date('Y-m-d\TH:i:sP', strtotime($review['date_added'])) . '</review_timestamp>';
					$output .= '<content>' . $review['text'] . '</content>';
					$output .= '<review_url type="group">' . $this->url->link('product/product', 'product_id=' . $review['product_id']) . '</review_url>';
					$output .= '<ratings>
                <overall min="1" max="5">' . $review['rating'] . '</overall>
            </ratings>';
			$output .= ' <products>
                <product>
                    <product_url>' . $this->url->link('product/product', 'product_id=' . $review['product_id']) . '</product_url>
                    <product_name>' . $this->prepareField($review['name']) . '</product_name>';
					$output .= '<product_ids>';
                    if ($product['manufacturer']) { 
						$output .= '<brands><brand>' . $product['manufacturer'] . '</brand></brands>';
					}
					if ($this->config->get('remarketing_reviews_feed_gtin')) {
						if (!empty($product[$this->config->get('remarketing_reviews_feed_gtin')])) {
							$output .= '<gtins><gtin>' . $product[$this->config->get('remarketing_reviews_feed_gtin')] . '</gtin></gtins>';	
						}
					}
					if ($this->config->get('remarketing_reviews_feed_mpn')) {
						if (!empty($product[$this->config->get('remarketing_reviews_feed_mpn')])) {
							$output .= '<mpns><mpn>' . $product[$this->config->get('remarketing_reviews_feed_mpn')] . '</mpn></mpns>';	
						}
					}
					if ($this->config->get('remarketing_reviews_feed_sku')) {
						if (!empty($product[$this->config->get('remarketing_reviews_feed_sku')])) {
							$output .= '<skus><sku>' . $product[$this->config->get('remarketing_reviews_feed_sku')] . '</sku></skus>';	
						}
					}
					if ($this->config->get('remarketing_reviews_feed_asin')) {
						if (!empty($product[$this->config->get('remarketing_reviews_feed_asin')])) {
							$output .= ' <asins><asin>' . $product[$this->config->get('remarketing_reviews_feed_asin')] . '</asin></asins>';	
						}
					}
					$output .= '</product_ids>';
               $output .= ' </product>
				</products>';
					$output .= '</review>';
				}
				}
			
			$output .= '  </reviews>';
			$output .= '</feed>';

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	private function getReviews($data = array()) {
		$sql = "SELECT pd.*, r.*, r.review_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "review r LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_product'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10000;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getRemarketingFeedCategories($product_id, $ocstore = false) {
		$category_data = '';
		
		$category_query = $this->db->query("SELECT DISTINCT cd.name FROM `" . DB_PREFIX . "product_to_category` pc LEFT JOIN `" . DB_PREFIX . "category_path` cp ON pc.category_id = cp.category_id LEFT JOIN `" . DB_PREFIX . "category_description` cd ON cp.path_id = cd.category_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' " . ($ocstore ? " AND pc.main_category = 1 " : '') . " ORDER BY cp.level ASC LIMIT 5");
		
		foreach ($category_query->rows as $category) {
			$category_data .= $category['name'] . ' > ';
		}
		
		$category_data = rtrim($category_data, ' > ');
		
		return $category_data;
	}
	
	public function getAttributes($product_id, $allowed_attributes) {
		$product_attribute_data = [];

		$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.attribute_id IN (" . implode(',', $allowed_attributes) . ")");

		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['attribute_id'],
				'name'         => $product_attribute['name'],
				'text'         => $product_attribute['text']
			);
		}

		return $product_attribute_data;
	}
	
	public function getFastAttributes($product_id, $allowed_attributes) {
		$product_attribute_data = [];

		$product_attribute_query = $this->db->query("SELECT pa.attribute_id, pa.text FROM " . DB_PREFIX . "product_attribute pa WHERE pa.product_id = '" . (int)$product_id . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.attribute_id IN (" . implode(',', $allowed_attributes) . ")");
 
		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_data[] = array(
				'attribute_id' => $product_attribute['attribute_id'],
				'text'         => $product_attribute['text']
			);
		}

		return $product_attribute_data;
	}
	
	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();

		$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($product_attribute_group_query->rows as $product_attribute_group) {
			$product_attribute_data = array();

			$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute['attribute_id'],
					'name'         => $product_attribute['name'],
					'text'         => $product_attribute['text']
				);
			}

			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group['attribute_group_id'],
				'name'               => $product_attribute_group['name'],
				'attribute'          => $product_attribute_data
			);
		}

		return $product_attribute_group_data;
	}
}