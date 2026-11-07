<?php
class ControllerExtensionModuleNotificationTelegram extends Controller {
	private $error = array();

	public function index() {

		$this->load->language('extension/module/notificationTelegram');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_notificationTelegram', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['module_notificationTelegram_boot_token'])) {
			$data['error_no_key'] = $this->error['module_notificationTelegram_boot_token'];
		} else {
			$data['error_no_key'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/notificationTelegram', 'user_token=' . $this->session->data['user_token'], true)
			);

		$data['action'] = $this->url->link('extension/module/notificationTelegram', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

//      $this->load->model('setting/setting');
//      $setting = $this->model_setting_setting->getSetting('module_notificationTelegram');

        $data['testUrl'] = htmlspecialchars_decode($this->url->link('extension/module/notificationTelegram/testToken', 'user_token=' . $this->session->data['user_token'], 'SSL'));

		if(isset($this->request->post['module_notificationTelegram_boot_token'])) {
			$data['module_notificationTelegram_boot_token'] = $this->request->post['module_notificationTelegram_boot_token'];
		} elseif ($this->config->get('module_notificationTelegram_boot_token')){
			$data['module_notificationTelegram_boot_token'] = $this->config->get('module_notificationTelegram_boot_token');
		} else{
			$data['module_notificationTelegram_boot_token'] = '';
		}

		if(isset($this->request->post['module_notificationTelegram_order_alert'])) {
			$data['module_notificationTelegram_order_alert'] = $this->request->post['module_notificationTelegram_order_alert'];
		} elseif ($this->config->get('module_notificationTelegram_order_alert')){
			$data['module_notificationTelegram_order_alert'] = $this->config->get('module_notificationTelegram_order_alert');
		} else{
			$data['module_notificationTelegram_order_alert'] = '';
		}

		if(isset($this->request->post['module_notificationTelegram_customer_alert'])) {
			$data['module_notificationTelegram_customer_alert'] = $this->request->post['module_notificationTelegram_customer_alert'];
		} elseif ($this->config->get('module_notificationTelegram_customer_alert')){
			$data['module_notificationTelegram_customer_alert'] = $this->config->get('module_notificationTelegram_customer_alert');
		} else{
			$data['module_notificationTelegram_customer_alert'] = '';
		}

		if(isset($this->request->post['module_notificationTelegram_status'])) {
			$data['module_notificationTelegram_status'] = $this->request->post['module_notificationTelegram_status'];
		} elseif ($this->config->get('module_notificationTelegram_status')){
			$data['module_notificationTelegram_status'] = $this->config->get('module_notificationTelegram_status');
		} else{
			$data['module_notificationTelegram_status'] = '';
		}

		if(isset($this->request->post['module_notificationTelegram_chat_ids'])) {
			$data['module_notificationTelegram_chat_ids'] = $this->request->post['module_notificationTelegram_chat_ids'];
		} elseif ($this->config->get('module_notificationTelegram_chat_ids')){
			$data['module_notificationTelegram_chat_ids'] = $this->config->get('module_notificationTelegram_chat_ids');
		} else{
			$data['module_notificationTelegram_chat_ids'] = '';
		}

		if(isset($this->request->post['module_notificationTelegram_return_alert'])) {
			$data['module_notificationTelegram_return_alert'] = $this->request->post['module_notificationTelegram_return_alert'];
		} elseif ($this->config->get('module_notificationTelegram_return_alert')){
			$data['module_notificationTelegram_return_alert'] = $this->config->get('module_notificationTelegram_return_alert');
		} else{
			$data['module_notificationTelegram_return_alert'] = '';
		}

        if(isset($this->request->post['module_notificationTelegram_meassage'])) {
			$data['module_notificationTelegram_meassage'] = $this->request->post['module_notificationTelegram_meassage'];
		} elseif ($this->config->get('module_notificationTelegram_meassage')){
			$data['module_notificationTelegram_meassage'] = $this->config->get('module_notificationTelegram_meassage');
		} else{
			$data['module_notificationTelegram_meassage'] = '';
		}

        if(isset($this->request->post['module_notificationTelegram_new_account_meassage'])) {
			$data['module_notificationTelegram_new_account_meassage'] = $this->request->post['module_notificationTelegram_new_account_meassage'];
		} elseif ($this->config->get('module_notificationTelegram_new_account_meassage')){
			$data['module_notificationTelegram_new_account_meassage'] = $this->config->get('module_notificationTelegram_new_account_meassage');
		} else{
			$data['module_notificationTelegram_new_account_meassage'] = '';
		}
		
		$data['header'] =      $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] =      $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/module/notificationTelegram', $data));
	}
	
    public function install(){
        $this->load->model('setting/event');
        $this->model_setting_event->addEvent('notificationTelegram', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/module/notificationTelegram/sendOrderAlert');
        $this->model_setting_event->addEvent('notificationTelegram', 'catalog/model/account/customer/addCustomer/after', 'extension/module/notificationTelegram/sendAccountAlert');
        $this->model_setting_event->addEvent('notificationTelegram', 'catalog/model/account/return/addReturn/after', 'extension/module/notificationTelegram/sendReturnProductAlert');
    }
	
    public function uninstall(){
	    $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('module_notificationTelegram');
    }
	
    /*
     * Send test message, to see if the push functionality is working
     */
    public function testToken() {
		
        $botToken = $this->request->get['module_notificationTelegram_boot_token'];
        $website  = "https://api.telegram.org/bot".$botToken;
        $chatId   = $this->request->get['module_notificationTelegram_chat_ids'];  //Receiver Chat Id
        $params=[
            'chat_id'=>$chatId,
            'text'=>'Test notification Telegram ',
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
		
    }
	
    protected function validate() {

		if (!$this->user->hasPermission('modify', 'extension/module/notificationTelegram')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['module_notificationTelegram_boot_token']) {
			$this->error['module_notificationTelegram_boot_token'] = $this->language->get('error_no_key');
		}

		return !$this->error;
	}
}