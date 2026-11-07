<?php
class ModelExtensionModuleUniSearch extends Controller {
	public function getProducts($data = []) {
		$uniset = $this->config->get('config_unishop2');
		$customer_group_id = (int)$this->config->get('config_customer_group_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$store_id = (int)$this->config->get('config_store_id');
		
		if(!trim($data['filter_name']) && !trim($data['filter_tag'])) {
			return [];
		}
		
		$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM `".DB_PREFIX."review` r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM `".DB_PREFIX."product_discount` pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM `".DB_PREFIX."product_special` ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" .$customer_group_id. "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM `".DB_PREFIX."category_path` cp LEFT JOIN `".DB_PREFIX."product_to_category` p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM `".DB_PREFIX."product_to_category` p2c";
			}

			$sql .= " LEFT JOIN `".DB_PREFIX."product` p ON (p2c.product_id = p.product_id)";
		} else {
			$sql .= " FROM `".DB_PREFIX."product` p";
		}
		
		$sql .= " LEFT JOIN `".DB_PREFIX."product_description` pd ON (p.product_id = pd.product_id)";
		
		if (isset($uniset['search']['types']['attr']) && !empty($data['filter_name'])) {
			$sql .= " LEFT JOIN `".DB_PREFIX."product_attribute` pa ON (p.product_id = pa.product_id)";
		}
		
		$sql .= " LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '".$lang_id."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".$store_id."'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '".(int)$data['filter_category_id']."'";
			} else {
				$sql .= " AND p2c.category_id = '".(int)$data['filter_category_id']."'";
			}
		}

		$sql .= " AND (";
		
		if (!empty($data['filter_name'])) {
			$search_string = trim(preg_replace('/\s+/', ' ', $data['filter_name']));

			$implode = [];

			$translit = $this->translit($search_string);
			
			if($translit) {
				$sql .= " (";
				
				foreach ($translit as $key => $words_arr) {
					$implode = [];
					
					$words = explode(' ', $words_arr);
					
					foreach ($words as $word) {
						$implode[] = "pd.name LIKE '%".$this->db->escape($word)."%'";
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode)."";
					}
					
					if($key+1 < count($translit)) {
						$sql .= " OR ";
					}
				}
				
				$sql .= ") ";
			} else {
				$words = explode(' ', $search_string);
				
				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%".$this->db->escape($word)."%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode)."";
				}
			}
			
			if(isset($uniset['search']['types'])) {
				foreach($uniset['search']['types'] as $type) {
					$sql .= " OR ".$this->db->escape($type)." LIKE '%".$this->db->escape($search_string)."%'";
				}
			}
		}
		
		if (empty($data['filter_name']) && !empty($data['filter_tag'])) {
			
			$implode = [];

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

			foreach ($words as $word) {
				$implode[] = "pd.tag LIKE '%".$this->db->escape($word)."%'";
			}

			if ($implode) {
				$sql .= " ".implode(" AND ", $implode)."";
			}
		}

		$sql .= ") GROUP BY p.product_id";

		$sort_data = [
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.date_added'
		];
		
		$sort_qty = '';
				
		if($uniset['sort_qty'] == 1){
			if(isset($data['sort']) && $data['sort'] == 'p.sort_order') {
				$sort_qty = '(p.quantity > 0) DESC,';
			}
		} elseif($uniset['sort_qty'] == 2) {
			$sort_qty = '(p.quantity > 0) DESC,';
		}

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY ".$sort_qty." LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY ".$sort_qty." (CASE WHEN special IS NOT NULL THEN special ELSE p.price END)";
			} else {
				$sql .= " ORDER BY ".$sort_qty." ".$data['sort'];
			}
		} else {
			$sql .= " ORDER BY ".$sort_qty." p.sort_order";
		}

		if ($data['order'] == 'DESC') {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT ".(int)$data['start'].", ".(int)$data['limit'];
		}
		
		$product_data = [];

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct((int)$result['product_id']);
		}

		return $product_data;
	}
	
	public function getCategories($data = []) {
		if(!trim($data['filter_name'])) {
			return [];
		}
		
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		
		$parent_id = !empty($data['filter_category_id']) ? (int)$data['filter_category_id'] : 0;
		
		$sql = "SELECT c.category_id, cd.name, c.image FROM `".DB_PREFIX."category` c LEFT JOIN `".DB_PREFIX ."category_description` cd ON (c.category_id = cd.category_id) LEFT JOIN `".DB_PREFIX."category_to_store` c2s ON (c.category_id = c2s.category_id)";
		$sql .= " WHERE";
		$sql .= $parent_id ? " c.parent_id = '".(int)$parent_id."' AND" : '';	
		$sql .= " cd.language_id = '".$lang_id."' AND c2s.store_id = '".$store_id."' AND c.status = '1'";
		$sql .= " AND (";

		$implode = [];
		
		$search_string = trim(preg_replace('/\s+/', ' ', $data['filter_name']));

		$words = explode(' ', $search_string);
		
		$translit = $this->translit($search_string);
			
		if($translit) {
			$words = $translit;
		}

		foreach ($words as $word) {
			$implode[] = "cd.name LIKE '%".$this->db->escape($word)."%'";
		}

		if ($implode) {
			$sql .= " ".implode(" OR ", $implode)."";
		}

		$sql .= ") ";
		$sql .= " GROUP BY c.category_id ORDER BY c.sort_order, LCASE(cd.name) ASC LIMIT 0, 10";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getManufacturers($data = []) {
		if(!trim($data['filter_name'])) {
			return [];
		}
		
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		
		$sql = "SELECT m.manufacturer_id, m.name, m.image FROM `".DB_PREFIX."manufacturer` m LEFT JOIN `".DB_PREFIX."manufacturer_to_store` m2s ON (m.manufacturer_id = m2s.manufacturer_id)";
		$sql .= " WHERE m2s.store_id = '".$store_id."'";
		$sql .= " AND (";

		$implode = [];
		
		$search_string = trim(preg_replace('/\s+/', ' ', $data['filter_name']));
		
		$words = explode(' ', $search_string);
		
		$translit = $this->translit($search_string);
			
		if($translit) {
			$words = $translit;
		}

		foreach ($words as $word) {
			$implode[] = "m.name LIKE '%".$this->db->escape($word)."%'";
		}

		if ($implode) {
			$sql .= " ".implode(" OR ", $implode)."";
		}

		$sql .= ") ";
		$sql .= " GROUP BY m.manufacturer_id ORDER BY m.sort_order, LCASE(m.name) ASC LIMIT 0, 10";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getProductCategories($products = []) {
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$result = [];
		
		if($products) {
			$sql = "SELECT c.category_id, cd.name FROM `".DB_PREFIX."product_to_category` p2c LEFT JOIN `".DB_PREFIX."category` c ON (p2c.category_id = c.category_id) LEFT JOIN `".DB_PREFIX."category_description` cd ON (p2c.category_id = cd.category_id)";
			$sql .= " LEFT JOIN ".DB_PREFIX."category_to_store c2s ON (p2c.category_id = c2s.category_id)";
			$sql .= " WHERE product_id IN (".implode(',', array_map('intval', $products)).") AND cd.language_id = '".$lang_id."' AND c2s.store_id = '".$store_id."' AND c.status = '1' GROUP BY c.category_id ORDER BY LCASE(cd.name) ASC LIMIT 0, 50";
			
			$query = $this->db->query($sql);
			
			$result = $query->rows;
		}

		return $result;
	}
	
	public function getTotalProducts($data = []) {
		$uniset = $this->config->get('config_unishop2');
		
		if(!trim($data['filter_name']) && !trim($data['filter_tag'])) {
			return '';
		}
		
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM `".DB_PREFIX."category_path` cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM `".DB_PREFIX."product_to_category` p2c";
			}

			$sql .= " LEFT JOIN `".DB_PREFIX."product` p ON (p2c.product_id = p.product_id)";
		} else {
			$sql .= " FROM `".DB_PREFIX."product` p";
		}

		$sql .= " LEFT JOIN `".DB_PREFIX."product_description` pd ON (p.product_id = pd.product_id)";
		
		if (isset($uniset['search']['types']['attr']) && !empty($data['filter_name'])) {
			$sql .= " LEFT JOIN `".DB_PREFIX."product_attribute` pa ON (p.product_id = pa.product_id)";
		}
		
		$sql .= " LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '".(int)$this->config->get('config_language_id')."' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '".(int)$data['filter_category_id']."'";
			} else {
				$sql .= " AND p2c.category_id = '".(int)$data['filter_category_id']."'";
			}
		}

		$sql .= " AND (";

		if (!empty($data['filter_name'])) {
			$search_string = trim(preg_replace('/\s+/', ' ', $data['filter_name']));

			$implode = [];

			$translit = $this->translit($search_string);
			
			if($translit) {
				$sql .= " (";
				
				foreach ($translit as $key => $words_arr) {
					$implode = [];
					
					$words = explode(' ', $words_arr);
					
					foreach ($words as $word) {
						$implode[] = "pd.name LIKE '%".$this->db->escape($word)."%'";
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode)."";
					}
					
					if($key+1 < count($translit)) {
						$sql .= " OR ";
					}
				}
				
				$sql .= ") ";
			} else {
				$words = explode(' ', $search_string);
				
				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%".$this->db->escape($word)."%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode)."";
				}
			}
			
			if(isset($uniset['search']['types'])) {
				foreach($uniset['search']['types'] as $type) {
					$sql .= " OR ".$this->db->escape($type)." LIKE '%".$this->db->escape($search_string)."%'";
				}
			}
		}
		
		if (empty($data['filter_name']) && !empty($data['filter_tag'])) {
			
			$implode = [];

			$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

			foreach ($words as $word) {
				$implode[] = "pd.tag LIKE '%".$this->db->escape($word)."%'";
			}

			if ($implode) {
				$sql .= " ".implode(" AND ", $implode)."";
			}
		}

		$sql .= ")";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getProTotal($data = []) {
		return $this->getTotalProducts($data);
	}
	
	private function translit($text) {
		$uniset = $this->config->get('config_unishop2');
		
		$result = [];
		
		if(isset($uniset['search']['translit']['status']) && $text) {
			$text = mb_strtolower(trim(preg_replace('/[^a-zA-Zа-яА-Я0-9 ]/ui', ' ', $text)));
			
			$arr = [
				'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
				'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',	'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
				'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
				'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
				'Ь' => '', 'Ы' => 'Y', 'Ъ' => '', 'Э' => 'E', 'Ю' => 'Yu','Я' => 'Ya'
			];
			
			$rules = $uniset['search']['translit']['own_rules'];
			
			if($rules) {
				$rules_arr = [];

				foreach(explode (',', $rules) as $r) {
					$a = explode('=', $r);
					
					if($a[0] && isset($a[1])) {
						$rules_arr[trim($a[0])] = trim($a[1]);
					}
				}
				
				$arr = array_merge($arr, $rules_arr);
			}
			
			$new_arr = [];
			
			foreach(explode(' ', $text) as $item) {
				if(mb_strlen($item) >= 2 && $item != 'quot') {
					$new_arr[] = $item;
				}
			}

			$new_arr = array_slice($new_arr, 0, 4);

			$new_string = implode(' ', $new_arr);
			
			$result[] = $new_string;

			foreach($new_arr as $word) {
				if(mb_strlen($word) >= 2) {
					$result[] = str_replace($word, strtr($word, $arr), $new_string);
				}
			}
			
			$result[] = strtr($new_string, $arr);
			
			return array_values(array_unique($result));
		}
		
		return $result;
	}
}