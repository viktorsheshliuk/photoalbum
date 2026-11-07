<?php
class ModelExtensionModuleUniGallery extends Model {	
	public function getGallerys() {
		$language_id = (int)$this->config->get('config_language_id');
		$store_id = (int)$this->config->get('config_store_id');
		
		$sql = "SELECT * FROM ".DB_PREFIX."uni_gallery g LEFT JOIN ".DB_PREFIX."uni_gallery_description gd ON (g.gallery_id = gd.gallery_id) LEFT JOIN `".DB_PREFIX."uni_gallery_to_store` g2s ON (g.gallery_id = g2s.gallery_id)";
		$sql .= " WHERE gd.language_id = '".$language_id."' AND g2s.store_id = '".$store_id."' AND g.status = '1' ORDER BY g.sort_order ASC";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getGallery($gallery_id) {
		$language_id = (int)$this->config->get('config_language_id');
		$store_id = (int)$this->config->get('config_store_id');
		
		$sql = "SELECT * FROM ".DB_PREFIX."uni_gallery g LEFT JOIN ".DB_PREFIX."uni_gallery_description gd ON (g.gallery_id = gd.gallery_id) LEFT JOIN `".DB_PREFIX."uni_gallery_to_store` g2s ON (g.gallery_id = g2s.gallery_id)";
		$sql .= " WHERE g.gallery_id = '".(int)$gallery_id."' AND gd.language_id = '".$language_id ."' AND g2s.store_id = '".$store_id."' AND g.status = '1'";
		
		$query = $this->db->query($sql);
		
		return $query->row;
	}
	
	public function getGalleryImages($data) {
		$sql = "SELECT * FROM ".DB_PREFIX."uni_gallery_image gi LEFT JOIN ".DB_PREFIX."uni_gallery_image_description gid ON (gi.image_id  = gid.image_id) WHERE gi.gallery_id = '".(int)$data['gallery_id']."' AND gid.language_id = '".(int)$this->config->get('config_language_id')."'";
		
		$sql .= " ORDER BY gi.sort_order ASC";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getGalleryImagesTotal($gallery_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."uni_gallery_image WHERE gallery_id = '".(int)$gallery_id."'");

		return $query->row['total'];
	}
}
?>