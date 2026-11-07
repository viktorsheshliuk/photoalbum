<?php
class ModelExtensionModuleUniCategoryWallv2 extends Model {
	
	public function getCategoryInfo($category_id = 0) {
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		
		$query = $this->db->query("SELECT c.category_id, cd.name, c.image FROM `".DB_PREFIX."category` c LEFT JOIN `".DB_PREFIX."category_description` cd ON (c.category_id = cd.category_id) LEFT JOIN ".DB_PREFIX."category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '".(int)$category_id."' AND cd.language_id = '".$lang_id."' AND c2s.store_id = '".$store_id."' AND c.status = '1'");
	
		return $query->row;
	}
	
	public function getChildCategories($categories = []) {	
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		$result = [];
		
		if($categories) {
			$query = $this->db->query("SELECT c.category_id, cd.name, c.image FROM `".DB_PREFIX."category` c LEFT JOIN `".DB_PREFIX."category_description` cd ON (c.category_id = cd.category_id) LEFT JOIN ".DB_PREFIX ."category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id IN (".implode(',', array_map('intval', $categories)).") AND cd.language_id = '".$lang_id."' AND c2s.store_id = '".$store_id."' AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
			$result = $query->rows;
		}
		
		return $result;
	}
}
?>