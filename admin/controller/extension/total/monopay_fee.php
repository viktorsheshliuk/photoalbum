<?php
// *	@copyright Fedka 2017.
// *	@forum	https://opencartforum.com/profile/707994-fedka/
// *	@license LICENSE.txt

class ControllerExtensionTotalMonopayFee extends Controller {
	private $error = array();
	 
	public function index() {
		$this->load->language('extension/total/monopay_fee');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('total_monopay_fee', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total', true));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_percents'] = $this->language->get('text_percents');
		
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_fee'] = $this->language->get('entry_fee');
		$data['entry_fee_help'] = $this->language->get('entry_fee_help');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['entry_custom_title'] = $this->language->get('entry_custom_title');
		$data['entry_custom_title_help'] = $this->language->get('entry_custom_title_help');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/monopay_fee', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/total/monopay_fee', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total', true);
		
		if (isset($this->request->post['monopay_fee_fee'])) {
			$data['total_monopay_fee_fee'] = $this->request->post['total_monopay_fee_fee'];
		} else {
			$data['total_monopay_fee_fee'] = $this->config->get('total_monopay_fee_fee');
		}
		
		if (isset($this->request->post['total_monopay_fee_percents'])) {
			$data['total_monopay_fee_percents'] = $this->request->post['total_monopay_fee_percents'];
		} elseif ($this->config->get('total_monopay_fee_percents')) {
			$data['total_monopay_fee_percents'] = $this->config->get('total_monopay_fee_percents');
		} else {
			$data['total_monopay_fee_percents'] = 1;
		}
		
		if (isset($this->request->post['total_monopay_fee_tax_class_id'])) {
			$data['total_monopay_fee_tax_class_id'] = $this->request->post['total_monopay_fee_tax_class_id'];
		} else {
			$data['total_monopay_fee_tax_class_id'] = $this->config->get('total_monopay_fee_tax_class_id');
		}
		
		if (isset($this->request->post['total_monopay_fee_custom_title'])) {
			$data['total_monopay_fee_custom_title'] = $this->request->post['total_monopay_fee_custom_title'];
		} else {
			$data['total_monopay_fee_custom_title'] = $this->config->get('total_monopay_fee_custom_title');
		}
		
		if (isset($this->request->post['total_monopay_fee_status'])) {
			$data['total_monopay_fee_status'] = $this->request->post['total_monopay_fee_status'];
		} else {
			$data['total_monopay_fee_status'] = $this->config->get('total_monopay_fee_status');
		}

		if (isset($this->request->post['total_monopay_fee_sort_order'])) {
			$data['total_monopay_fee_sort_order'] = $this->request->post['total_monopay_fee_sort_order'];
		} else {
			$data['total_monopay_fee_sort_order'] = $this->config->get('total_monopay_fee_sort_order');
		}
		
		$this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/total/monopay_fee', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/monopay_fee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}