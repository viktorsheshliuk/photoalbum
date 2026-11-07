<?php class ModelExtensionModuleUniGallery extends Model {
	public function addGallery($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."uni_gallery SET sort_order = '".(int)$data['sort_order']."', status = '".(int)$data['status']."'");
		
		$gallery_id = $this->db->getLastId();
		
		foreach ($data['gallery_description'] as $language_id => $description) {
			$sql = "INSERT INTO ".DB_PREFIX."uni_gallery_description SET name = '". $this->db->escape($description['name'])."', description = '". $this->db->escape($description['description']). "',";
			$sql .= " meta_keyword = '". $this->db->escape($description['meta_keyword'])."', meta_description = '". $this->db->escape($description['meta_description'])."',";
			$sql .= " language_id = '".(int)$language_id."', gallery_id = '".(int)$gallery_id."'";
				
			$this->db->query($sql);
		}

		if (isset($data['gallery_image'])) {
			foreach ($data['gallery_image'] as $gallery_image) {
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_image` SET gallery_id = '".(int)$gallery_id."', image = '". $this->db->escape($gallery_image['image'])."', sort_order = '".(int)$gallery_image['sort_order']."'");

				$gallery_image_id = $this->db->getLastId();

				foreach ($gallery_image['description'] as $language_id => $image_description) {				
					$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_image_description` SET image_id = '".(int)$gallery_image_id."', title = '". $this->db->escape($image_description['title'])."', link = '". $this->db->escape($image_description['link'])."', language_id = '".(int)$language_id."'");
				}
			}
		}
		
		if (isset($data['stores'])) {
			foreach ($data['stores'] as $store_id) {
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_to_store` SET gallery_id = '".(int)$gallery_id."', store_id = '".(int)$store_id."'");
			}
		}
		
		if (isset($data['seo_url'])) {
			foreach ($data['seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (trim($keyword)) {
						$this->db->query("INSERT INTO `".DB_PREFIX."seo_url` SET store_id = '".(int)$store_id."', language_id = '".(int)$language_id."', query = 'gallery_id=".(int)$gallery_id."', keyword = '".$this->db->escape($keyword)."'");
					}
				}
			}
		}
	}

	public function editGallery($gallery_id, $data) {
		$this->db->query("UPDATE `".DB_PREFIX."uni_gallery` SET sort_order = '".(int)$data['sort_order']."', status = '".(int)$data['status']."' WHERE gallery_id = '".(int)$gallery_id."'");
		
		$this->db->query("DELETE FROM `".DB_PREFIX."uni_gallery_description` WHERE gallery_id = '".(int)$gallery_id."'");
		
		foreach ($data['gallery_description'] as $language_id => $description) {
			$sql = "INSERT INTO `".DB_PREFIX."uni_gallery_description` SET name = '". $this->db->escape($description['name'])."', description = '". $this->db->escape($description['description']). "',";
			$sql .= " meta_keyword = '". $this->db->escape($description['meta_keyword'])."', meta_description = '". $this->db->escape($description['meta_description'])."',";
			$sql .= " language_id = '".(int)$language_id."', gallery_id = '".(int)$gallery_id."'";
				
			$this->db->query($sql);
		}
		
		$query = $this->db->query("SELECT image_id FROM `".DB_PREFIX."uni_gallery_image` WHERE gallery_id = '".(int)$gallery_id."'");
		
		if($query->rows) {
			foreach($query->rows as $image) {
				$this->db->query("DELETE FROM `".DB_PREFIX."uni_gallery_image_description` WHERE image_id = '".(int)$image['image_id']."'");
			}
		}
		
		$this->db->query("DELETE FROM `".DB_PREFIX."uni_gallery_image` WHERE gallery_id = '".(int)$gallery_id."'");

		if (isset($data['gallery_image'])) {
			foreach ($data['gallery_image'] as $gallery_image) {
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_image` SET gallery_id = '".(int)$gallery_id."', image = '". $this->db->escape($gallery_image['image'])."', sort_order = '".(int)$gallery_image['sort_order']."'");

				$gallery_image_id = $this->db->getLastId();

				foreach ($gallery_image['description'] as $language_id => $image_description) {				
					$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_image_description` SET image_id = '".(int)$gallery_image_id."', title = '". $this->db->escape($image_description['title'])."', link = '". $this->db->escape($image_description['link'])."', language_id = '".(int)$language_id."'");
				}
			}
		}
		
		$this->db->query("DELETE FROM `".DB_PREFIX."uni_gallery_to_store` WHERE gallery_id = '".(int)$gallery_id."'");
		
		if (isset($data['stores'])) {
			foreach ($data['stores'] as $store_id) {
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_to_store` SET gallery_id = '".(int)$gallery_id."', store_id = '".(int)$store_id."'");
			}
		}
		
		$this->db->query("DELETE FROM `".DB_PREFIX."seo_url` WHERE query = 'gallery_id=".(int)$gallery_id."'");
		
		if (isset($data['seo_url'])) {
			foreach ($data['seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (trim($keyword)) {
						$this->db->query("INSERT INTO `".DB_PREFIX."seo_url` SET store_id = '".(int)$store_id."', language_id = '".(int)$language_id."', query = 'gallery_id=".(int)$gallery_id."', keyword = '".$this->db->escape($keyword)."'");
					}
				}
			}
		}
	}

	public function deleteGallery($gallery_id) {
		$this->db->query("DELETE FROM ".DB_PREFIX."uni_gallery WHERE gallery_id = '".(int)$gallery_id."'");
		$this->db->query("DELETE FROM ".DB_PREFIX."uni_gallery_description WHERE gallery_id = '".(int)$gallery_id."'");
		
		$query = $this->db->query("SELECT image_id FROM `".DB_PREFIX."uni_gallery_image` WHERE gallery_id = '".(int)$gallery_id."'");
		
		if($query->rows) {
			foreach($query->rows as $image) {
				$this->db->query("DELETE FROM ".DB_PREFIX."uni_gallery_image_description WHERE image_id = '".(int)$image['image_id']."'");
			}
		}
		
		$this->db->query("DELETE FROM ".DB_PREFIX."uni_gallery_image WHERE gallery_id = '".(int)$gallery_id."'");
		$this->db->query("DELETE FROM ".DB_PREFIX."uni_gallery_to_store WHERE gallery_id = '".(int)$gallery_id."'");
	}

	public function getGallery($gallery_id) {
		$result = [];
			
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."uni_gallery` WHERE gallery_id = '".(int)$gallery_id."'");
			
		$gallery = $query->row;
		
		if($gallery) {
			$query2 = $this->db->query("SELECT * FROM `".DB_PREFIX."uni_gallery_description` WHERE gallery_id = '".(int)$gallery_id."'");
			
			$description = [];
			
			foreach ($query2->rows as $info) {			
				$description[$info['language_id']] = [
					'name' 				=> $info['name'],
					'description' 		=> $info['description'],
					'meta_description' 	=> $info['meta_description'],
					'meta_keyword'		=> $info['meta_keyword']
				];
			}
			
			$stores = [];

			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."uni_gallery_to_store WHERE gallery_id = '".(int)$gallery_id."'");

			foreach ($query->rows as $result) {
				$stores[] = $result['store_id'];
			}
			
			$seo_url = [];
		
			$query = $this->db->query("SELECT * FROM ".DB_PREFIX."seo_url WHERE query = 'gallery_id=".(int)$gallery_id."'");

			foreach ($query->rows as $result) {
				$seo_url[$result['store_id']][$result['language_id']] = $result['keyword'];
			}
			
			$result = [
				'gallery_id' 			=> $gallery['gallery_id'],
				'gallery_description'	=> $description,
				'sort_order' 			=> $gallery['sort_order'],
				'status' 				=> $gallery['status'],
				'stores'				=> $stores,
				'seo_url'				=> $seo_url
			];
		}

		return $result;
	}

	public function getGallerys($data = []) {
		
		$sql = "SELECT * FROM ".DB_PREFIX."uni_gallery g LEFT JOIN `".DB_PREFIX."uni_gallery_description` gd ON (g.gallery_id = gd.gallery_id) WHERE gd.language_id = '".(int)$this->config->get('config_language_id')."'";

		$sort_data = array(
			'g.sort_order',
			'g.status',
		);
		
		if (isset($data['status']) && $data['status'] == 1) {
			$sql .= " AND g.status = 1";
		}

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY ".$data['sort'];	
		} else {
			$sql .= " ORDER BY sort_order";	
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
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT ".(int)$data['start'].",".(int)$data['limit'];
		}		

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getGalleryImages($gallery_id) {
		
		$result = [];

		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."uni_gallery_image` WHERE gallery_id = '".(int)$gallery_id."'");
		
		foreach ($query->rows as $images) {
			$query = $this->db->query("SELECT DISTINCT * FROM `".DB_PREFIX."uni_gallery_image_description` WHERE image_id = '".(int)$images['image_id']."'");
			
			$description = [];
			
			foreach ($query->rows as $info) {			
				$description[$info['language_id']] = [
					'title'	=> $info['title'],
					'link' 	=> $info['link']
				];
			}
			
			$result[$images['image_id']] = [
				'image_id'		=> $images['image_id'],
				'image'			=> $images['image'],
				'description'	=> $description,
				'sort_order'	=> $images['sort_order']
			];
		}

		return $result;
	}

	public function getTotalGallerys() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."uni_gallery");
		return $query->row['total'];
	}

	public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."uni_gallery` (`gallery_id` int(11) NOT NULL AUTO_INCREMENT, `sort_order` int(3) NOT NULL DEFAULT '0', `status` tinyint(1) NOT NULL, PRIMARY KEY (`gallery_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."uni_gallery_description` (`gallery_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `name` varchar(255) NOT NULL, `description` text CHARACTER SET utf8 NOT NULL, `meta_description` VARCHAR(255) NOT NULL, `meta_keyword` varchar(255) NOT NULL, PRIMARY KEY (`gallery_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."uni_gallery_image` (`image_id` int(11) NOT NULL AUTO_INCREMENT, `gallery_id` int(11) NOT NULL, `image` varchar(255) NOT NULL, `sort_order` int(3) NOT NULL DEFAULT '0', PRIMARY KEY (`image_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."uni_gallery_image_description` (`image_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `title` varchar(255) NOT NULL, `link` varchar(255) NOT NULL, PRIMARY KEY (`image_id`,`language_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."uni_gallery_to_store` (`gallery_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, PRIMARY KEY (`gallery_id`,`store_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		$query = $this->db->query("SELECT keyword FROM `".DB_PREFIX."seo_url` WHERE `query` LIKE 'extension/module/uni_gallery' LIMIT 1");
		
		if ($query->num_rows) {
			$this->db->query("DELETE FROM ".DB_PREFIX."seo_url WHERE store_id = 0 AND query = 'extension/module/uni_gallery' AND keyword = 'gallery'");
			
			//foreach ($languages as $language) {
				$this->db->query("INSERT INTO `".DB_PREFIX . "seo_url` SET store_id = 0, language_id = '".(int)$this->config->get('config_language_id')."', query = 'information/uni_gallery', keyword = 'gallery'");
			//}
		}
		
		$this->upgrade();
	}
	
	public function upgrade() {
		$query = $this->db->query("show columns FROM `".DB_PREFIX."uni_gallery_image_description` WHERE Field = 'link'");
		
		if (!$query->num_rows) {
			
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			
			$query1 = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."uni_gallery");
			$query2 = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."uni_gallery_image");
			$query3 = $this->db->query("SELECT DISTINCT * FROM ".DB_PREFIX."uni_gallery_image g LEFT JOIN `".DB_PREFIX."uni_gallery_image_description` gd ON (g.gallery_image_id = gd.gallery_image_id)");
			
			$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."uni_gallery`");
			$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."uni_gallery_description`");
			$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."uni_gallery_image`");
			$this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."uni_gallery_image_description`");
			
			$this->install();
			
			foreach($query1->rows as $result) {
				
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery` SET gallery_id = '".(int)$result['gallery_id']."', status = '1'");
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_to_store` SET gallery_id = '".(int)$result['gallery_id']."', store_id = '0'");
				
				foreach ($languages as $language) {
					$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_description` SET gallery_id = '".(int)$result['gallery_id']."', language_id = '".(int)$language['language_id']."', name = '".$this->db->escape($result['name'])."'");
				}
			}
			
			foreach($query2->rows as $result) {
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_image` SET image_id = '".(int)$result['gallery_image_id']."', gallery_id = '".(int)$result['gallery_id']."', image = '".$this->db->escape($result['image'])."'");
			}
			
			foreach($query3->rows as $result) {
				$this->db->query("INSERT INTO `".DB_PREFIX."uni_gallery_image_description` SET image_id = '".(int)$result['gallery_image_id']."', language_id = '".(int)$result['language_id']."', title = '".$this->db->escape($result['title'])."', link = '".$this->db->escape($result['link'])."'");
			}
		}
	}
}
?>