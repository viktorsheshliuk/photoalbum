<?php
class ControllerExtensionModuleUniFiveInOneV2 extends Controller {
	private $error = [];

	public function index() {
		$this->load->language('extension/module/uni_five_in_one_v2');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/module');
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		$this->load->model('localisation/language');
		
		//$this->document->addStyle('view/stylesheet/unishop.css');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['lang_code'] = $this->config->get('config_admin_language_id');
		$data['lang_id'] = isset($data['languages'][$data['lang_code']]) ? $data['languages'][$data['lang_code']] : 1;

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('uni_five_in_one_v2', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->cache->delete('product.unishop.five_in_one_v2');
			
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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
			'href'      => $this->url->link('extension/module/uni_five_in_one_v2', 'user_token='.$this->session->data['user_token'], true),
   		];

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/uni_five_in_one_v2', 'user_token='.$this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/uni_five_in_one_v2', 'user_token='.$this->session->data['user_token'] . '&module_id='.$this->request->get['module_id'], true);
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
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach($languages as $language) {
			$text_latest[$language['language_id']] = $this->language->get('entry_tab_latest');
			$text_special[$language['language_id']] = $this->language->get('entry_tab_special');
			$text_popular[$language['language_id']] = $this->language->get('entry_tab_popular');
			$text_bestseller[$language['language_id']] = $this->language->get('entry_tab_bestseller');
			$text_featured[$language['language_id']] = $this->language->get('entry_tab_featured');
		}
			
		if (isset($this->request->post['set'])) {
			$data['tabs'] = $this->request->post['set'];
		} elseif (!empty($module_info['set'])) {
			$data['tabs'] = $module_info['set'];
		} else {
			
			$data['tabs'] = [];
			
			$tabs = [
				'latest' 		=> ['title' => $text_latest],
				'special'		=> ['title' => $text_special], 
				'popular' 		=> ['title' => $text_popular], 
				'bestseller'	=> ['title' => $text_bestseller], 
				'featured' 		=> ['title' => $text_featured]
			];
			
			$default_settings = [
				'limit' => 5,
				'thumb_width' => 220,
				'thumb_height' => 230,
				'type' => 0,
				'qiantity' => 0,
				'sort_order' => 1,
				'status' => 0,
				'products_selected ' => [],
				'category_name' => 0,
				'category_id' => 0
			];
			
			foreach($tabs as $key => $tab) {
				$data['tabs'][$key] = array_merge($tab, $default_settings);
			}
		}
		
		if(isset($data['tabs'][0])) {
			unset($data['tabs'][0]);
		}

		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		
		foreach($data['tabs'] as $key => $tab) {
			$data['tabs'][$key]['products_selected'] = [];
			
			if(isset($tab['products'])) {
				foreach ($tab['products'] as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						$data['tabs'][$key]['products_selected'][] = [
							'product_id' => $product_info['product_id'],
							'name'       => $product_info['name']
						];
					}
				}
			}
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info['status'])) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_five_in_one_v2', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_five_in_one_v2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}