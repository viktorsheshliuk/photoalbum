<?php
class ModelExtensionModuleUniCategoryWallv2 extends Model {
	public function getCategoryInfo($category_id) {
		$lang_id = (int)$this->config->get('config_language_id');
		
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' > ') FROM `".DB_PREFIX."category_path` cp LEFT JOIN `".DB_PREFIX."category_description` cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id) WHERE cp.category_id = c.category_id AND cd1.language_id = '".$lang_id."' GROUP BY cp.category_id) AS path FROM `".DB_PREFIX."category` c LEFT JOIN `".DB_PREFIX."category_description` cd2 ON (c.category_id = cd2.category_id) WHERE c.category_id = '".(int)$category_id."' AND cd2.language_id = '".$lang_id."'");
		
		return $query->row;
	}
	
	public function getCategories($data = []) {
		$lang_id = (int)$this->config->get('config_language_id');
		
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' > ') AS name, c1.parent_id, c1.sort_order FROM `".DB_PREFIX."category_path` cp LEFT JOIN `".DB_PREFIX."category` c1 ON (cp.category_id = c1.category_id) LEFT JOIN `".DB_PREFIX."category` c2 ON (cp.path_id = c2.category_id) LEFT JOIN `".DB_PREFIX."category_description` cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN `".DB_PREFIX."category_description` cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '".$lang_id."' AND cd2.language_id = '".$lang_id."'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		//todo
		
		//if (!empty($data['store_id'])) {
			//$sql .= " AND c2s.store_id = '" . (int)$data['store_id'] . "'";
		//}

		$sql .= " GROUP BY cp.category_id ORDER BY name, sort_order ASC LIMIT 0, 10";
		
		$query = $this->db->query($sql);
		
		$results = [];
		
		if($query->rows) {
			if (!empty($data['max_level'])) {
				foreach($query->rows as $result) {
					if(substr_count($result['name'], '>') <= (int)$data['max_level']) {
						$results[] = [
							'category_id' => $result['category_id'],
							'name'        => $result['name']
						];
					}
				}
				
				if(!$results) {
					$results[0] = [
						'category_id' => 0,
						'name'        => 'Only first or second level categories!'
					];
				}
			} else {
				$results = $query->rows;
			}
		}
		
		return $results;
	}
	
	public function getChildCategories($parent_id = 0, $store_id = 0) {
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."category` c LEFT JOIN `".DB_PREFIX."category_description` cd ON (c.category_id = cd.category_id) LEFT JOIN `".DB_PREFIX."category_to_store` c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$store_id . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
		
		return $query->rows;
	}
}
?>