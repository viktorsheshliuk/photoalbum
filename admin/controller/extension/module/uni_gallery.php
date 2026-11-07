<?php 
class ControllerExtensionModuleUniGallery extends Controller {
	private $error = [];

	public function index() {
		$this->load->language('extension/module/uni_gallery');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('extension/module/uni_gallery');
		
		$this->install();
		
		$this->getModule();
	}

	public function insert() {
		$this->load->language('extension/module/uni_gallery');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('extension/module/uni_gallery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_module_uni_gallery->addGallery($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('extension/module/uni_gallery');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('extension/module/uni_gallery');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_module_uni_gallery->editGallery($this->request->get['gallery_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort='.$this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order='.$this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page='.$this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/uni_gallery/getList', 'user_token='.$this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/module/uni_gallery');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('extension/module/uni_gallery');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $gallery_id) {
				$this->model_extension_module_uni_gallery->deleteGallery($gallery_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}
	
	private function getModule() {
		$this->load->model('localisation/language');
		$this->load->model('setting/setting');
		$this->load->model('setting/module');
		$this->load->model('extension/module/uni_gallery');
		
		$this->load->language('extension/module/uni_settings');
		$this->load->language('extension/module/uni_gallery');
		
		$this->document->addStyle('view/stylesheet/unishop.css');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['heading_title'] = strip_tags($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('uni_gallery', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		
		$data['error_title'] = isset($this->error['title']) ? $this->error['title'] : '';

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
       		'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true)
   		];

		$data['breadcrumbs'][] = [
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true)
		];

		$data['breadcrumbs'][] = [
       		'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'], true)
   		];

		$data['gallery_list'] = $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'], true);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/uni_gallery', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/uni_gallery', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true);

		$data['gallerys'] = [];

		$filter_data = array(
			'start' => 0,
			'limit' => 100,
			'status' => 1
		);

		$gallery_total = $this->model_extension_module_uni_gallery->getTotalGallerys();

		$results = $this->model_extension_module_uni_gallery->getGallerys($filter_data);

		foreach ($results as $result) {
			$data['gallerys'][] = array(
				'gallery_id'	=> $result['gallery_id'],
				'name'			=> $result['name']
			);
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
		
		if (isset($this->request->post['gallery_id'])) {
			$data['gallery_selected'] = $this->request->post['gallery_id'];
		} elseif (!empty($module_info['gallery_id'])) {
			$data['gallery_selected'] = $module_info['gallery_id'];
		} else {
			$data['gallery_selected'] = 0;
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}
		
		if (isset($this->request->post['view_type'])) {
			$data['view_type'] = $this->request->post['view_type'];
		} elseif (isset($module_info['view_type'])) {
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

		$this->response->setOutput($this->load->view('extension/module/uni_gallery', $data));
	}

	public function getList() {
		$this->load->model('extension/module/uni_gallery');
		
		$this->load->language('extension/module/uni_gallery');
		
		//$this->document->addStyle('view/stylesheet/unishop.css');
		
		$this->install();

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token='.$this->session->data['user_token'], true),
			'separator' => false
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/uni_gallery/getList', 'user_token='.$this->session->data['user_token'].$url, true)
		);

		$data['insert'] = $this->url->link('extension/module/uni_gallery/insert', 'user_token='.$this->session->data['user_token'].$url, true);
		$data['delete'] = $this->url->link('extension/module/uni_gallery/delete', 'user_token='.$this->session->data['user_token'].$url, true);

		$data['galleries'] = [];

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$gallery_total = $this->model_extension_module_uni_gallery->getTotalGallerys();

		$results = $this->model_extension_module_uni_gallery->getGallerys($filter_data);

		foreach ($results as $result) {
			$action = [];

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('extension/module/uni_gallery/update', 'user_token=' . $this->session->data['user_token'] . '&gallery_id=' . $result['gallery_id'] . $url, true)
			);

			$data['galleries'][] = array(
				'gallery_id' => $result['gallery_id'],
				'name'      => $result['name'],	
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'selected'  => isset($this->request->post['selected']) && in_array($result['gallery_id'], $this->request->post['selected']),
				'shop_href'	=> HTTPS_CATALOG.'index.php?route=information/uni_gallery&gallery_id='.$result['gallery_id'],				
				'action'    => $action
			);
		}

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');	

		$data['button_insert'] = $this->language->get('button_add');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $gallery_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_gallery_list', $data));
	}

	private function getForm() {
		$this->load->language('extension/module/uni_gallery');
		
		$this->load->model('extension/module/uni_gallery');
		$this->install();
		
		//$this->document->addStyle('view/stylesheet/unishop.css');
		
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addStyle('view/javascript/codemirror/theme/monokai.css');
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/codemirror/lib/xml.js');
		$this->document->addScript('view/javascript/codemirror/lib/formatting.js');
		
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/summernote-image-attributes.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');
		
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');			

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');		
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_gallery'] = $this->language->get('button_add_gallery');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		$data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';
		$data['error_gallery_image'] = isset($this->error['gallery_image']) ? $this->error['gallery_image'] : [];
		$data['error_keyword'] = isset($this->error['keyword']) ? $this->error['keyword'] : '';

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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . $url, true),
		);

		if (!isset($this->request->get['gallery_id'])) { 
			$data['action'] = $this->url->link('extension/module/uni_gallery/insert', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/uni_gallery/update', 'user_token=' . $this->session->data['user_token'] . '&gallery_id=' . $this->request->get['gallery_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'] . $url, true);
		
		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		
		$gallery_id = isset($this->request->get['gallery_id']) ? (int)$this->request->get['gallery_id'] : 0;

		if (isset($this->request->get['gallery_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$gallery_info = $this->model_extension_module_uni_gallery->getGallery($gallery_id);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['gallery_description'])) {
			$data['gallery_description'] = $this->request->post['gallery_description'];
		} elseif (!empty($gallery_info)) {
			$data['gallery_description'] = $gallery_info['gallery_description'];
		} else {
			$data['gallery_description'] = [];
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($gallery_info)) {
			$data['sort_order'] = $gallery_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['stores'])) {
			$data['gallery_stores'] = $this->request->post['stores'];
		} elseif (!empty($gallery_info)) {
			$data['gallery_stores'] = $gallery_info['stores'];
		} else {
			$data['gallery_stores'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($gallery_info)) {
			$data['status'] = $gallery_info['status'];
		} else {
			$data['status'] = true;
		}
		
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($gallery_info['seo_url'])) {
			$data['seo_url'] = $gallery_info['seo_url'];
		} else {
			$data['seo_url'] = [];
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['gallery_image'])) {
			$gallery_images = $this->request->post['gallery_image'];
		} elseif (isset($this->request->get['gallery_id'])) {
			$gallery_images = $this->model_extension_module_uni_gallery->getGalleryImages($gallery_id);	
		} else {
			$gallery_images = [];
		}

		$data['images'] = [];

		foreach ($gallery_images as $image) {
			if ($image['image'] && file_exists(DIR_IMAGE . $image['image'])) {
				$img = $image['image'];
			} else {
				$img = 'no_image.jpg';
			}

			$data['images'][] = [
				'image' 		=> $img,
				'thumb' 		=> $this->model_tool_image->resize($img, 100, 100),
				'description'	=> $image['description'],
				'sort_order' 	=> $image['sort_order'],
			];	
		}

		$data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_gallery_form', $data));
	}
	
	public function setting() {	
		$this->load->language('extension/module/uni_gallery');
		
		$this->load->model('localisation/language');
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		
		$this->install();
		
		//$this->document->addStyle('view/stylesheet/unishop.css');
		
		$this->document->addStyle('view/javascript/codemirror/lib/codemirror.css');
		$this->document->addStyle('view/javascript/codemirror/theme/monokai.css');
		$this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
		$this->document->addScript('view/javascript/codemirror/lib/xml.js');
		$this->document->addScript('view/javascript/codemirror/lib/formatting.js');
		
		$this->document->addStyle('view/javascript/summernote/summernote.css');
		$this->document->addScript('view/javascript/summernote/summernote.js');
		$this->document->addScript('view/javascript/summernote/summernote-image-attributes.js');
		$this->document->addScript('view/javascript/summernote/opencart.js');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href'		=> $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
			'text'		=> $this->language->get('text_home'),
		);
		
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token='.$this->session->data['user_token'].'&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'href'		=> $this->url->link('extension/module/uni_gallery/setting', 'user_token=' . $this->session->data['user_token'], true),
			'text'		=> $this->language->get('heading_title'),
		);

		$data['uni_gallery'] = $this->config->get('uni_gallery') ? $this->config->get('uni_gallery') : [];
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateSettings()) {
			$this->model_setting_setting->editSetting('uni_gallery', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module/uni_gallery/getList', 'user_token=' . $this->session->data['user_token'], true));
		}
		
		$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		$data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_gallery_setting', $data));
	}
	
	public function install() {
		$this->load->model('setting/setting');
		$this->load->model('extension/module/uni_gallery');
		$this->model_extension_module_uni_gallery->install();
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach($languages as $language) {
			$name[$language['language_id']] = 'Фотогалерея';
			$meta_description[$language['language_id']] = '';
			$meta_keyword[$language['language_id']] = '';
			$description[$language['language_id']] = '';
		}
		
		$default_settings['uni_gallery'] = [
			'name' 				=> $name,
			'meta_description' 	=> $meta_description,
			'meta_keyword' 		=> $meta_keyword,
			'description' 		=> $description,
			'image_width' 		=> 360,
			'image_height' 		=> 270,
			'image_popup_width' => 1200,
			'image_popup_height'=> 800
		];
		
		if(!$this->config->get('uni_gallery')) {
			$this->model_setting_setting->editSetting('uni_gallery', $default_settings);
		}
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if(isset($this->request->post['name'])) {
			if (strlen($this->request->post['name']) < 2 || strlen($this->request->post['name']) > 250) {
				$this->error['title'] = $this->language->get('error_title');
			}
		}
		
		if(isset($this->request->post['title'])) {
			foreach ($this->request->post['title'] as $language_id => $value) {
				if ((strlen($value) < 3) || (strlen($value) > 250)) {
					$this->error['title'] = $this->language->get('error_title');
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['gallery_description'] as $language_id => $value) {
			if ((strlen($value['name']) < 3) || (strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if ($this->request->post['seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
							$this->error['warning'] = $this->language->get('error_seo_url');
						}

						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
	
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['gallery_id']) || ($seo_url['query'] != 'gallery_id=' . $this->request->get['gallery_id']))) {		
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
								$this->error['warning'] = $this->language->get('error_seo_url');
								break;
							}
						}
					}
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	private function validateSettings() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['uni_gallery']['name'] as $language_id => $value) {
			if ((strlen($value) < 3) || (strlen($value) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_main_page_gallery_name');
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_gallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>