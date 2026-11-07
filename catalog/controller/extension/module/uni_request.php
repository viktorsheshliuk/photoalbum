<?php  
class ControllerExtensionModuleUniRequest extends Controller {
	public function index() {
		if(!$this->return404()) {
			$this->load->language('extension/module/uni_othertext');
			$this->load->language('extension/module/uni_request');
			$this->load->language('account/register');
	
			$uniset = $this->config->get('config_unishop2');
			$lang_id = $this->config->get('config_language_id');
		
			$data['name_text'] = $uniset[$lang_id]['callback_name_text'];
			$data['phone_text'] = $uniset[$lang_id]['callback_phone_text'];
			$data['mail_text'] = $uniset[$lang_id]['callback_mail_text'];
			$data['comment_text'] = $uniset[$lang_id]['callback_comment_text'];
		
			$data['customer_firstname'] = $this->customer->isLogged() ? ($this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName()) : '';
			$data['customer_email'] = $this->customer->getEmail();
			$data['customer_telephone'] = $this->customer->getTelephone();
	
			$show_phone = isset($this->request->get['phone']) ? true : false;
			$show_mail = isset($this->request->get['mail']) ? true : false;
			$show_comment = isset($this->request->get['comment']) ? true : false;
		
			$data['reason'] = isset($this->request->get['reason']) && $this->request->get['reason'] != '' ? htmlspecialchars(strip_tags($this->request->get['reason'])) : '';
			$data['product_id'] = isset($this->request->get['p_id']) && $this->request->get['p_id'] != '' ? (int)$this->request->get['p_id'] : 0;
		
			$settings = $this->config->get('uni_request') ? $this->config->get('uni_request') : [];
		
			if ($settings) {
				switch ($data['reason']) {
					case $settings['heading_notify'][$lang_id]:
						$data['show_phone'] = isset($settings['notify_phone']) ? true : false;
						$data['show_email'] = isset($settings['notify_email']) ? true : false;
						$data['show_comment'] = false;
						break;
					case $settings['heading_question'][$lang_id]:
						$data['show_phone'] = isset($settings['question_phone']) ? true : false;
						$data['show_email'] = isset($settings['question_email']) ? true : false;
						$data['show_comment'] = true;
						break;
					default:
						$data['show_phone'] = $show_phone;
						$data['show_email'] = $show_mail;
						$data['show_comment'] = $show_comment;
						break;
				}
			} else {
				$data['show_phone'] = $show_phone;
				$data['show_email'] = $show_mail;
				$data['show_comment'] = $show_comment;
			}
			
			$data['mask_telephone'] = isset($uniset['callback']['mask']['telephone'][$lang_id]) ? $uniset['callback']['mask']['telephone'][$lang_id] : '';
		
			$data['show_reason1'] = isset($uniset['show_reason1']) ? true : false;
			$data['text_reason1'] = $uniset[$lang_id]['text_reason1'];
			$data['show_reason2'] = isset($uniset['show_reason2']) ? true : false;
			$data['text_reason2'] = $uniset[$lang_id]['text_reason2'];
			$data['show_reason3'] = isset($uniset['show_reason3']) ? true : false;
			$data['text_reason3'] = $uniset[$lang_id]['text_reason3'];
		
			if (isset($uniset['callback']['captcha']) && $this->config->get('captcha_'.$this->config->get('config_captcha').'_status')) {
				$data['captcha'] = $this->load->controller('extension/captcha/'.$this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}
		
			if ($this->config->get('config_account_id') && isset($uniset['callback_confirm'])) {
				$this->load->model('catalog/information');
			
				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
				$data['text_agree'] = $information_info ? sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), true), $information_info['title'], $information_info['title']) : '';
			} else {
				$data['text_agree'] = '';
			}
	
			$this->response->setOutput($this->load->view('extension/module/uni_request_form', $data));
		}
  	}
	
	public function getQuestions($params = []) {
		$settings = $this->config->get('uni_request') ? $this->config->get('uni_request') : [];
		
		if($params) {
			$product_id = (int)$params['product_id'];
			$start = (int)$params['start'];
			$limit = (int)$params['limit'];
		} else {
			return;
		}
		
		$data['product_id'] = $product_id;
		$data['start'] = $start + $limit;
		$data['limit'] = $limit;
		
		if(!$settings || !isset($settings['question_list']) || !$product_id) {
			return;
		}
		
		$uniset = $this->config->get('config_unishop2');
		
		$this->document->addStyle('catalog/view/theme/unishop2/stylesheet/request.css');
		$this->document->addScript('catalog/view/theme/unishop2/js/jquery.maskedinput.min.js');
		
		$this->load->model('extension/module/uni_request');
			
		$this->load->language('extension/module/uni_othertext');
		$this->load->language('extension/module/uni_request');
		$this->load->language('product/product');
		$this->load->language('product/review');
		$this->load->language('account/register');
		
		$lang_id = $this->config->get('config_language_id');
			
		$data['customer_firstname'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
		$data['customer_email'] = $this->customer->getEmail();
		$data['customer_telephone'] = $this->customer->getTelephone();
		
		$data['type'] = $settings['heading_question'][$lang_id];
		$data['show_phone'] = isset($settings['question_phone']) ? true : false;
		$data['show_email'] = isset($settings['question_email']) ? true : false;
		$data['show_email_required'] = isset($settings['question_email_required']) ? true : false;
		$data['mask_telephone'] = isset($uniset['callback']['mask']['telephone'][$lang_id]) ? $uniset['callback']['mask']['telephone'][$lang_id] : '';
			
		if (isset($settings['question_captcha']) && $this->config->get('captcha_'.$this->config->get('config_captcha').'_status')) {
			$data['captcha'] = $this->load->controller('extension/captcha/'.$this->config->get('config_captcha'));
		} else {
			$data['captcha'] = '';
		}
		
		if ($this->config->get('config_account_id') && isset($uniset['callback_confirm'])) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			$data['text_agree'] = $information_info ? sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), true), $information_info['title'], $information_info['title']) : '';
		} else {
			$data['text_agree'] = '';
		}
		
		$this->customer->isLogged();
		
		$data['questions'] = $data['microdata'] = [];
		$data['request_guest'] = 1;
		$data['product_id'] = $product_id;
	
		$filter_data = [
			'product_id'	=> $product_id,
			'start' 		=> $start,
			'limit'         => $limit,
		];
			
		$data['requests_total'] = $results_total = 0;
	
		$results = $this->model_extension_module_uni_request->getRequests($filter_data);

		if($results) {
			$data['requests_total'] = $results_total = $this->model_extension_module_uni_request->getTotalRequests($filter_data);
			$data['question_show_more'] = $data['start'] < $results_total ? true : false;
				
			foreach ($results as $result) {
				$data['questions'][] = [
					'name' 			=> $result['name'],
					'date_added' 	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'comment' 		=> nl2br($result['comment']),
					'admin_comment' => nl2br($result['admin_comment']),
				];
					
				$data['microdata'][] = [
					'question'	=> $result['comment'],
					'answer'	=> $result['admin_comment']
				];
			}
		}
			
		$data['text_question_total'] = sprintf($this->language->get('text_question_total'), $results_total);
		
		return $this->load->view('extension/module/uni_request_list', $data);
	}
	
	public function getQuestionsRender() {
		if(!$this->return404()) {
			$product_id = isset($this->request->get['pid']) ? (int)$this->request->get['pid'] : 0;
			$start = isset($this->request->get['start']) ? (int)$this->request->get['start'] : 0;
			$limit = isset($this->request->get['limit']) ? (int)$this->request->get['limit'] : 0;

			if(isset($this->config->get('uni_request')['question_list']) && $product_id && $start && $limit) {
				$params = [
					'product_id' => $product_id,
					'start' => $start,
					'limit' => $limit
				];
			
				$this->response->setOutput($this->getQuestions($params));
			}
		}
	}
	
	private function return404() {
		if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return false;
		} else {
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
			
			return true;
		}
	}
	
	public function mail() {
		$this->load->model('account/customer');
		$this->load->model('extension/module/uni_request');
		
		$this->load->language('extension/module/uni_othertext');
		$this->load->language('extension/module/uni_request');
		$this->load->language('account/register');
		
		$uniset = $this->config->get('config_unishop2');
		$lang_id = $this->config->get('config_language_id');
		$store_id = (int)$this->config->get('config_store_id');
		$settings = $this->config->get('uni_request') ? $this->config->get('uni_request') : [];
		
		$type = isset($this->request->post['type']) ? htmlspecialchars(strip_tags($this->request->post['type']), ENT_QUOTES, 'UTF-8') : '';
		$type = isset($this->request->post['reason']) ? htmlspecialchars(strip_tags($this->request->post['reason']), ENT_QUOTES, 'UTF-8') : $type;
		
		$customer_name = isset($this->request->post['name']) ? htmlspecialchars(strip_tags($this->request->post['name']), ENT_QUOTES, 'UTF-8') : '';
		$customer_phone = isset($this->request->post['phone']) ? htmlspecialchars(strip_tags($this->request->post['phone']), ENT_QUOTES, 'UTF-8') : '';
		$customer_mail = isset($this->request->post['mail']) ? htmlspecialchars(strip_tags($this->request->post['mail']), ENT_QUOTES, 'UTF-8') : '';
		$customer_comment = isset($this->request->post['comment']) ? htmlspecialchars(strip_tags($this->request->post['comment']), ENT_QUOTES, 'UTF-8') : '';
		$customer_ip = $this->request->server['REMOTE_ADDR'];
		$location = isset($this->request->server['HTTP_REFERER']) ? strip_tags(trim($this->request->server['HTTP_REFERER'])) : '';
		
		$product_id = 0;
		
		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
		}
		
		$json = [];
		
		$attempts_info = $this->model_extension_module_uni_request->getAttempts($customer_ip);
		
		if ($attempts_info && ($attempts_info['total'] >= (int)$this->config->get('config_login_attempts')) && strtotime($attempts_info['date_modified']) > strtotime('-1 hour')) {
			$json['error']['limit'] = $this->language->get('error_limit');
		}
		
		if (utf8_strlen($customer_name) < 3 || utf8_strlen($customer_name) > 45) {
			$json['error']['name'] = $this->language->get('text_error_name');
		}
		
		if (isset($this->request->post['phone']) && (utf8_strlen($customer_phone) < 3 || utf8_strlen($customer_phone) > 25 || strpos($customer_phone, '_'))) {
			$json['error']['phone'] = $this->language->get('text_error_phone');
		}
		
		$notify_email_required = isset($settings['notify_email_required']) ? true : false;
		$heading_notify = isset($settings['heading_notify'][$lang_id]) ? $settings['heading_notify'][$lang_id] : '';
		$question_email_required = isset($settings['question_email_required']) ? true : false;
		$heading_question = isset($settings['heading_question'][$lang_id]) ? $settings['heading_question'][$lang_id] : '';
		
		$mail_required = true;
		
		if ($heading_notify == $type && !$notify_email_required) {
			$mail_required = false;
		} else if ($heading_question == $type && !$question_email_required) {
			$mail_required = false;
		}
		
		if($mail_required) {
			if (isset($this->request->post['mail']) && ((utf8_strlen($customer_mail) > 50) || !filter_var($customer_mail, FILTER_VALIDATE_EMAIL))) {
				$json['error']['mail'] = $this->language->get('text_error_mail');
			}
		}

		if (isset($this->request->post['comment']) && ((utf8_strlen($customer_comment) < 5 || utf8_strlen($customer_comment) > 300))) {
			$json['error']['comment'] = $this->language->get('text_error_comment');
		}
		
		$form_name = isset($this->request->post['form-name']) ? trim($this->request->post['form-name']) : '';
		
		$form_arr = ['callback', 'question'];
		
		if(!in_array($form_name, $form_arr)) {
			$json['error']['form'] = 'Unknown form';
		}
		
		$server = $this->request->server['HTTPS'] ? $this->config->get('config_ssl') : $this->config->get('config_url');
		
		if(!$location || (stripos($location, $server) === FALSE)) {
			$json['error']['location'] = 'Unknown location';
		}
		
		if(((isset($settings['question_captcha']) && $form_name == 'question') || (isset($uniset['callback']['captcha']) && $form_name == 'callback')) && $this->config->get('captcha_'.$this->config->get('config_captcha').'_status')) {
			$captcha = $this->load->controller('extension/captcha/'.$this->config->get('config_captcha').'/validate');

			if ($captcha) {
				$json['error']['captcha'] = $captcha;
			}
		}
		
		if(isset($uniset['callback_confirm'])) {
			if ($this->config->get('config_account_id')) {
				$this->load->model('catalog/information');
				
				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
					
				if ($information_info && !isset($this->request->post['confirm'])) {
					$json['error']['confirm'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}
		}
		
		if(!isset($json['error'])) {
			
			$product_name = $product_id ? strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')) : '';
			
			$text = $product_id ? $this->language->get('text_product').$product_name.'<br />' : '';
			$text .= $this->language->get('text_name').$customer_name.'<br />';
			$text .= $this->language->get('text_phone').$customer_phone.'<br />';
			$text .= $this->language->get('text_mail').$customer_mail.'<br />';
			$text .= $this->language->get('text_comment').$customer_comment.'<br />';
			$text .= $this->language->get('text_location').$location.'<br />';
		
			$subject = $type && $product_id ? sprintf($this->language->get('text_reason'), $type, $product_name) : sprintf($this->language->get('text_reason2'), $type);
			
			$this->load->model('setting/setting');
		
			$from = $this->model_setting_setting->getSettingValue('config_email', $store_id);
		
			if (!$from) {
				$from = $this->config->get('config_email');
			}
			
			$mail = new Mail($this->config->get('config_mail_engine'));
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($from);
			
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($text);
			$mail->send();
			
			$emails = explode(',', $this->config->get('config_mail_alert_email'));
			
			foreach ($emails as $email) {
				if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
			
			$request_data = [
				'type' 			=> $type,
				'name'			=> $customer_name,
				'phone'			=> $customer_phone,
				'mail'			=> $customer_mail,
				'comment'		=> $customer_comment,
				'product_id'	=> $product_id,
				'status'		=> '1',
			];
			
			if ($this->config->get('uni_request')) {
				$this->model_extension_module_uni_request->addRequest($request_data);
			}
			
			$this->model_extension_module_uni_request->addAttempt($customer_ip);
				
			$json['success'] = (isset($settings['heading_question'][$lang_id]) && $settings['heading_question'][$lang_id] == $type) ? $this->language->get('text_success2') : $this->language->get('text_success');
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>