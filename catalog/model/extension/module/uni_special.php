<?php
class ModelExtensionModuleUniSpecial extends Model {
	
	public function getProductSpecials($data = []) {
		$customer_group_id = (int)$this->config->get('config_customer_group_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$store_id = (int)$this->config->get('config_store_id');
		
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM `".DB_PREFIX."review` r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM `".DB_PREFIX ."product_special` ps";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN `".DB_PREFIX."product_to_category` p2c ON (ps.product_id = p2c.product_id)";
		}
		
		$sql .= " LEFT JOIN ".DB_PREFIX."product p ON (ps.product_id = p.product_id) LEFT JOIN `".DB_PREFIX."product_description` pd ON (p.product_id = pd.product_id) LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id)";
		
		$sql .= " WHERE p.status = '1'";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " AND p2c.category_id = '".(int)$data['filter_category_id']."'";
		}
		
		$sql .= " AND p.date_available <= NOW() AND p2s.store_id = '".$store_id."' AND ps.customer_group_id = '".$customer_group_id."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = [
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
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

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = [];

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct((int)$result['product_id']);
		}

		return $product_data;
	}
	
	public function getProductCategories() {
		$customer_group_id = (int)$this->config->get('config_customer_group_id');
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$products = [];
		
		$cache_name = 'product.unishop.categories_specials.'.$customer_group_id.'.'.$lang_id.'.'.$store_id;
		
		$result = $this->cache->get($cache_name);
		
		if(!$result) {
			$sql = "SELECT DISTINCT ps.product_id FROM `".DB_PREFIX ."product_special` ps LEFT JOIN `".DB_PREFIX."product` p ON (ps.product_id = p.product_id) LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (ps.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".$store_id."'";
			$sql .= " AND ps.customer_group_id = '".$customer_group_id."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";
		
			$query = $this->db->query($sql);

			if($query->rows) {
				$products = array_column($query->rows, 'product_id');
			}
		
			if($products) {
				$sql = "SELECT c.category_id, cd.name FROM `".DB_PREFIX."product_to_category` p2c LEFT JOIN `".DB_PREFIX."category` c ON (p2c.category_id = c.category_id) LEFT JOIN `".DB_PREFIX."category_description` cd ON (p2c.category_id = cd.category_id)";
				$sql .= " LEFT JOIN ".DB_PREFIX."category_to_store c2s ON (p2c.category_id = c2s.category_id)";
				$sql .= " WHERE product_id IN (".implode(',', array_map('intval', $products)).") AND cd.language_id = '".$lang_id."' AND c2s.store_id = '".$store_id."' AND c.status = '1' GROUP BY c.category_id ORDER BY LCASE(cd.name) ASC LIMIT 0, 50";
			
				$query = $this->db->query($sql);
			
				$result = $query->rows;
				
				$this->cache->set($cache_name, $result);
			}
		}

		return $result;
	}
	
	public function getTotalProductSpecials($data = []) {
		$customer_group_id = (int)$this->config->get('config_customer_group_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$store_id = (int)$this->config->get('config_store_id');
		
		$sql = "SELECT COUNT(DISTINCT ps.product_id) AS total FROM `".DB_PREFIX."product_special` ps";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " LEFT JOIN `".DB_PREFIX."product_to_category` p2c ON (ps.product_id = p2c.product_id)";
		}
		
		$sql .= " LEFT JOIN `".DB_PREFIX."product` p ON (ps.product_id = p.product_id) LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id)";
		
		$sql .= " WHERE p.status = '1'";
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " AND p2c.category_id = '".(int)$data['filter_category_id']."'";
		}
		
		$sql .= " AND p.date_available <= NOW() AND p2s.store_id = '".$store_id."' AND ps.customer_group_id = '".$customer_group_id."' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";
		
		$query = $this->db->query($sql);

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}
}
?>