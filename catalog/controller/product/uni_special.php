<?php
class ControllerProductUniSpecial extends Controller {
	private $uniset = [];
	
	public function index() {
		$uniset = $this->config->get('config_unishop2');
		$lang_id = $this->config->get('config_language_id');
		
		$this->uniset = $uniset;
		
		$this->load->model('extension/module/uni_search');
		$this->load->language('product/uni_special');
		
		$category_id = isset($this->request->get['cat_id']) ? (int)$this->request->get['cat_id'] : 0;
		
		$data['specials_href'] = $this->url->link('product/special', '', true);
		$data['category_id'] = $category_id;
		$data['product_categories'] = $this->getProductCategories($category_id);
		
		//if($category_id && in_array($category_id, array_column($data['product_categories'], 'category_id'))) {
		//	$this->document->addLink($this->url->link('product/special', 'cat_id='.(int)$this->request->get['cat_id']), 'canonical');
		//}
		
		return $data;
	}
	
	private function getProductCategories($category_id) {
		$uniset = $this->uniset;
		
		$result = [];
		
		if(isset($uniset['catalog']['special_page']['product_category'])) {
			
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
				}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$categories = $this->model_extension_module_uni_special->getProductCategories();
			
			if($categories) {
				foreach ($categories as $category) {
					$result[] = [
						'category_id'  => $category['category_id'],
						'name'		=> $category['name'],
						'selected'	=> $category['category_id'] == $category_id ? true : false,
						'href'   	=> $this->url->link('product/special', '&cat_id='.(int)$category['category_id'] . $url, true)
					];
				}
			}
		}
		
		return $result;
	}
}