<?php
class ControllerProductUniSearch extends Controller {
	private $uniset = [];
	
	public function index($params = ['filter_data' => [], 'products' => []]) {
		
		$uniset = $this->config->get('config_unishop2');
		$lang_id = $this->config->get('config_language_id');
		
		$this->uniset = $uniset;
		
		$this->load->model('extension/module/uni_search');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$this->load->language('extension/module/uni_othertext');
		$this->load->language('extension/module/uni_search');
		
		$data['categories_search'] = $this->getCategories($params['filter_data']);
		$data['manufacturers_search'] = $this->getManufacturers($params['filter_data']);
		$data['product_categories_search'] = $this->getProductCategories($params['products']);
		
		return $data;
	}
	
	private function getCategories($params) {
		$uniset = $this->uniset;
		
		$result = [];
				
		if(isset($uniset['search']['condition']['category']) && $params) {
			$categories = $this->model_extension_module_uni_search->getCategories($params);
				
			foreach ($categories as $category) {
				$result[] = [
					'category_id' => $category['category_id'],
					'name' 		  => $category['name'],
					'thumb' 	  => isset($uniset['search']['condition']['category_img']) && $category['image'] ? $this->model_tool_image->resize($category['image'], $this->config->get('theme_'.$this->config->get('config_theme').'_image_category_width'), $this->config->get('theme_'.$this->config->get('config_theme').'_image_category_height')) : '',
					'href'        => $this->url->link('product/category', 'path='.(int)$category['category_id'], true)
				];
			}
		}
		
		return $result;
	}
	
	private function getManufacturers($params) {
		$uniset = $this->uniset;
		
		$result = [];
				
		if(isset($uniset['search']['condition']['manufacturer']) && $params) {
			$manufacturers = $this->model_extension_module_uni_search->getManufacturers($params);
				
			foreach ($manufacturers as $manufacturer) {
				$result[] = [
					'manufacturer_id' => $manufacturer['manufacturer_id'],
					'name' 		  	  => $manufacturer['name'],
					'thumb' 	      => isset($uniset['search']['condition']['manufacturer_img']) && $manufacturer['image'] ? $this->model_tool_image->resize($manufacturer['image'], $this->config->get('theme_'.$this->config->get('config_theme').'_image_category_width'), $this->config->get('theme_'.$this->config->get('config_theme').'_image_category_height')) : '',
					'href'   		  => $this->url->link('product/manufacturer/info', 'manufacturer_id='.(int)$manufacturer['manufacturer_id'], true)
				];
			}
		}
		
		return $result;
	}
	
	private function getProductCategories($params) {
		$uniset = $this->uniset;
		
		$result = [];
		
		if(isset($uniset['search']['condition']['product_category']) && $params && !isset($this->request->get['category_id']) && !isset($this->request->get['sub_category'])) {
		
			$url = '';
		
			if (isset($this->request->get['search'])) {
				$url .= '&search=' . rawurlencode(html_entity_decode(trim($this->request->get['search']), ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . rawurlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$categories = $this->model_extension_module_uni_search->getProductCategories($params);
		
			foreach ($categories as $category) {
				$result[] = [
					'category_id'	=> $category['category_id'],
					'name'			=> $category['name'],
					'href'   	 	=> $this->url->link('product/search', '&category_id='.(int)$category['category_id'] . $url, true)
				];
			}
		}
		
		return $result;
	}
}