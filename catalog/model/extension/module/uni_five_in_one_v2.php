<?php
class ModelExtensionModuleUniFiveInOneV2 extends Model {	
	public function getLatest($limit, $qty) {
		$products = [];
		
		$sql = "SELECT p.product_id FROM `".DB_PREFIX."product` p LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1'";
		$sql .= $qty ? " AND p.quantity > 0" : '';
		$sql .= " AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
		$sql .= " ORDER BY p.date_added DESC LIMIT ".(int)$limit;
		
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$products[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $products;
	}
	
	public function getSpecial($limit, $qty) {
		$products = [];
		
		$sql = "SELECT DISTINCT ps.product_id FROM `".DB_PREFIX."product_special` ps LEFT JOIN `".DB_PREFIX."product` p ON (ps.product_id = p.product_id) LEFT JOIN ".DB_PREFIX."product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1'";
		$sql .= $qty ? " AND p.quantity > 0" : '';
		$sql .= " AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."' AND ps.customer_group_id = '".(int)$this->config->get('config_customer_group_id')."'";
		$sql .= " AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";
		$sql .= " GROUP BY ps.product_id LIMIT ".(int)$limit;
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$products[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $products;
	}
	
	public function getPopular($limit, $qty) {
		$products = [];
		
		$sql = "SELECT p.product_id FROM `".DB_PREFIX."product` p LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1'";
		$sql .= $qty ? " AND p.quantity > 0" : '';
		$sql .= " AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
		$sql .= " ORDER BY p.viewed DESC, p.date_added DESC LIMIT ".(int)$limit;
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$products[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $products;
	}
	
	public function getBestseller($limit, $qty) {
		$products = [];
		
		$sql = "SELECT op.product_id, SUM(op.quantity) AS total FROM `".DB_PREFIX."order_product` op LEFT JOIN `".DB_PREFIX."order` o ON (op.order_id = o.order_id) LEFT JOIN `".DB_PREFIX."product` p ON (op.product_id = p.product_id) LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0'";
		$sql .= $qty ? " AND p.quantity > 0" : '';
		$sql .= " AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."'";
		$sql .= " GROUP BY op.product_id ORDER BY total DESC LIMIT ".(int)$limit;
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$products[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $products;
	}
	
	public function getProducts($category_id = 0, $results, $sorts, $limit, $qty) {
		$products = [];
		
		if($category_id || $results) {
		
			$sort_order = 'p.sort_order ASC, LCASE(pd.name) ASC';
		
			$sql = "SELECT";
		
			if($category_id) {
				$sql .= " p2c.product_id";
			} else {
				$sql .= " p.product_id";
			}
		
			if($sorts) {
				$sort_arr = explode('|', $sorts);
			
				$sort = $sort_arr[0];
				$order = isset($sort_arr[1]) ? $sort_arr[1] : 'ASC';
			
				$sort_data = [
					'pd.name',
					'p.price',
					'rating',
					'p.sort_order',
					'p.date_added'
				];
			
				$order_data = ['ASC', 'DESC'];
			
				if(in_array($sort, $sort_data) && in_array($order, $order_data)) {
					$sort_order = $sort.' '.$order.', LCASE(pd.name) '.$order;
				}
			
				if($sort == 'rating') {
					$sql .= " , (SELECT AVG(rating) AS total FROM `".DB_PREFIX."review` r1 WHERE r1.product_id";
			
					if($category_id) {
						$sql .= " = p2c.product_id";
					} else {
						$sql .= " = p.product_id";
					}
			
					$sql .= " AND r1.status = '1' GROUP BY r1.product_id) AS rating";
				}
			}
		
			$sql .= " FROM";
		
			if($category_id) {
				$sql .= " `".DB_PREFIX."product_to_category` p2c LEFT JOIN `".DB_PREFIX."product` p ON (p.product_id = p2c.product_id)";
			} else {
				$sql .= " `".DB_PREFIX."product` p";
			}
		
			$sql .= " LEFT JOIN `".DB_PREFIX."product_description` pd ON (p.product_id = pd.product_id) LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) WHERE";
		
			if($category_id) {
				$sql .= " p2c.category_id = '".(int)$category_id."' AND";
			} else {
				$sql .= " p.product_id IN (".implode(',', array_map('intval', $results)).") AND";
			}
		
			if($qty) {
				$sql .= " p.quantity > 0 AND";
			}
		
			$sql .= " p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '".(int)$this->config->get('config_store_id')."' GROUP BY p.product_id ORDER BY ".$sort_order." LIMIT 0, ".(int)$limit;
		
			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$products[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
			}
		}

		return $products;
	}
}
?>