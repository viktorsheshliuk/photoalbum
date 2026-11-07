<?php
class ControllerExtensionModuleVideo extends Controller {
	private $error = array(); 

	public function index() {   
		$this->load->language('extension/module/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('video', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');                
                $data['entry_status'] = $this->language->get('entry_status');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_module'] = $this->language->get('tab_module');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/video', 'user_token=' . $this->session->data['user_token'], true),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('extension/module/video', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

		$data['token'] = $this->session->data['user_token'];

		$data['modules'] = array();

		if (isset($this->request->post['video_status'])) {
			$data['video_status'] = $this->request->post['video_status'];
		} elseif ($this->config->get('video_status')) { 
			$data['video_status'] = $this->config->get('video_status');
		}	
                
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/video', $data));
	}
        
        public function install(){
            //insert video column if no exists 
            $query = $this->db->query("DESC `".DB_PREFIX."product_image` video");
            if (!$query->num_rows) {
                $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_image` ADD  `video` VARCHAR( 250 ) NULL AFTER  `image` ;");
            }
        }
        
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/video')) {
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