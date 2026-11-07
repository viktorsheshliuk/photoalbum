<?php
class ControllerExtensionModuleUniCategoryWallv2 extends Controller {
	private $error = [];

	public function index() {
		$this->load->language('extension/module/uni_category_wall_v2');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/module');
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		$this->load->model('extension/module/uni_category_wall_v2');
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('uni_category_wall_v2', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			
			$this->cache->delete('category.unishop');
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [];
		
		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
   		];

   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true),
   		];
		
   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/uni_category_wall_v2', 'user_token='.$this->session->data['user_token'], true),
   		];

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/uni_category_wall_v2', 'user_token='.$this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/uni_category_wall_v2', 'user_token='.$this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true);
		
		$data['user_token'] = $this->session->data['user_token'];
		
		$stores = $this->model_setting_store->getStores();
		
		$data['stores'][] = [
			'store_id' 	=> 0,
			'name'    	=> $this->config->get('config_name'),
		];
 
    	foreach ($stores as $store) {		
			$data['stores'][] = [
				'store_id'	=> $store['store_id'],
				'name'     	=> html_entity_decode($store['name'], ENT_QUOTES, 'UTF-8'),
			];
		}
		
		$data['categories'] = [];
		
		$filter_data = [
			'sort'        => 'name',
			'order'       => 'ASC'
		];
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($module_info['title'])) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = '';
		}
		
		if (isset($this->request->post['categories'])) {
			$data['categories_selected'] = $this->request->post['categories'];
		} elseif (!empty($module_info['categories'])) {
			$data['categories_selected'] = $module_info['categories'];
		} else {
			$data['categories_selected'] = [];
		}
		
		$data['categories'] = [];
		
		if($data['categories_selected']) {
			foreach($data['categories_selected'] as $key => $category) {
		
				$category_arr = $this->model_extension_module_uni_category_wall_v2->getCategoryInfo((int)$key);
				
				if($category_arr) {
				
					$childs = [];
				
					$childrens = $this->model_extension_module_uni_category_wall_v2->getChildCategories((int)$key);
					
					foreach($childrens as $children) {
						$childs[$children['category_id']] = [
							'category_id' => $children['category_id'],
							'name'		  => $children['name'],
						];
					}
			
					$data['categories'][$category_arr['category_id']] = [
						'category_id' => $category_arr['category_id'],
						'name'		  => $category_arr['name'],
						'path'		  => ($category_arr['path'] ? $category_arr['path'].' > ' : '').$category_arr['name'],
						'child'		  => $childs,
						'sort_order'  => $category['sort_order'],
					];
				}
			}
		}
		
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info['image_width'])) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 220;
		}
		
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info['image_height'])) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 200;
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($module_info['type'])) {
			$data['type'] = $module_info['type'];
		} else {
			$data['type'] = '';
		}
		
		if (isset($this->request->post['columns'])) {
			$data['columns'] = $this->request->post['columns'];
		} elseif (!empty($module_info)) {
			$data['columns'] = $module_info['columns'];
		} else {
			$data['columns'] = '';
		}
		
		if (isset($this->request->post['view_type'])) {
			$data['view_type'] = $this->request->post['view_type'];
		} elseif (!empty($module_info['view_type'])) {
			$data['view_type'] = $module_info['view_type'];
		} else {
			$data['view_type'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_category_wall_v2', $data));
	}
	
	public function autocomplete() {
		$json = [];
		
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : '';

		if ($filter_name) {
			$this->load->model('extension/module/uni_category_wall_v2');
			
			$no_child = isset($this->request->get['no_child']) ? true : false;
			$max_level = isset($this->request->get['max_level']) ? (int)$this->request->get['max_level'] : '';
			
			$filter_data = [
				'filter_name' 	=> $filter_name,
				'max_level' 	=> $max_level
			];

			$results = $this->model_extension_module_uni_category_wall_v2->getCategories($filter_data);

			foreach ($results as $result) {
				
				$childs = [];
				
				if(!$no_child) {
					$childs_arr = $this->model_extension_module_uni_category_wall_v2->getChildCategories($result['category_id']);
				
					foreach($childs_arr as $child) {
						$childs = [
							'category_id' => $child['category_id'],
							'name'        => $child['name'],
						];
					}
				}
				
				$json[] = [
					'category_id' => $result['category_id'],
					'name'        => $result['name'],
					'child'		  => $childs
				];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function autocomplete2() {
		$json = [];

		if (isset($this->request->get['category_id'])) {
			$this->load->model('extension/module/uni_category_wall_v2');

			$results = $this->model_extension_module_uni_category_wall_v2->getChildCategories((int)$this->request->get['category_id']);
				
			foreach($results as $result) {
				$json[] = [
					'category_id' => $result['category_id'],
					'name'        => $result['name'],
				];
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_category_wall_v2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}