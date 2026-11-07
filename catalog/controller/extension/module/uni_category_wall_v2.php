<?php
class ControllerExtensionModuleUniCategoryWallv2 extends Controller {
	public function index($setting) {
		static $module = 0;
		
		$this->load->language('extension/module/uni_category_wall_v2');
		
		$this->load->model('extension/module/uni_category_wall_v2');
		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		
		$this->document->addStyle('catalog/view/theme/unishop2/stylesheet/category_wall.css');
		
		$store_id = (int)$this->config->get('config_store_id');
		$lang_id = (int)$this->config->get('config_language_id');
		
		$data['heading_title'] = $setting['title'][$lang_id];
		$data['type'] = isset($setting['type']) ? $setting['type'] : 1;
		$data['type_view'] = isset($setting['view_type']) ? 'carousel' : 'grid';
		$data['columns'] = isset($setting['columns']) ? $setting['columns'] : [6, 4, 3, 3, 2];
		
		$image_width = isset($setting['image_width']) ? $setting['image_width'] : 228;
		$image_height = isset($setting['image_height']) ? $setting['image_height'] : 174;
		
		$data['img_width'] = $image_width;
		$data['img_height'] = $image_height;
		
		$results = isset($setting['categories']) ? $setting['categories'] : [];
		
		$cache_name = 'category.unishop.catwall_v2.'.substr(md5(json_encode($results)), 0, 8).'.'.$lang_id.'.'.$store_id;
		
		$data['categories'] = $this->cache->get($cache_name);
		
		if(!$data['categories']) {
			foreach($results as $key => $result) {
			
				$category = $this->model_extension_module_uni_category_wall_v2->getCategoryInfo((int)$key);
				
				if($category) {
			
					$childs_data = [];
			
					if(isset($result['child'])) {
				
						$childs = $this->model_extension_module_uni_category_wall_v2->getChildCategories($result['child']);
				
						foreach($childs as $child) {
							$childs_data[] = [
								'category_id'	=> $child['category_id'],
								'name' 			=> $child['name'],
								'href' 			=> $this->url->link('product/category', 'path='.$category['category_id'].'_'.$child['category_id'])
							];
						}
					}
				
					if ($category['image']) {
						$image = $this->model_tool_image->resize($category['image'], $image_width, $image_height);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $image_width, $image_height);
					}
					
					$data['categories'][] = [
						'category_id' 	=> $category['category_id'],
						'name' 			=> $category['name'],
						'image' 		=> $image,
						'href'        	=> $this->url->link('product/category', 'path='.$category['category_id']),
						'sort_order'	=> $result['sort_order'] ? $result['sort_order'] : 1,
						'childs'		=> $childs_data
					];
			
					if(count($data['categories']) > 1) {
						array_multisort(array_column($data['categories'], 'sort_order'), SORT_ASC, $data['categories']);
					}
			
					if($data['categories']){
						$this->cache->set($cache_name, $data['categories']);
					}
				}
			}
		}	

		$data['module'] = $module++;

		return $this->load->view('extension/module/uni_category_wall_v2', $data);
	}
}