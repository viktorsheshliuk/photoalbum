<?php
class ControllerCheckoutAbandoned extends Controller {
	public function check() {
		$this->log->write('Work abandoned');

		//invoice_no = 0 для новых заказов всегда, по ним еще не отправлено письмо
		$sql = "SELECT * FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id =  0 AND o.invoice_no = 0 AND o.date_added < NOW() - INTERVAL 61 MINUTE AND o.date_added > NOW() - INTERVAL 2 DAY ORDER BY o.order_id DESC";
			
		$query = $this->db->query($sql);
		
		if ($query->num_rows){

			$this->load->model('checkout/order');
			$this->load->language('mail/order_alert');
				
			foreach ($query->rows as $key => $order) {

				$order_id = $order['order_id'];

				$order_info = $this->model_checkout_order->getOrder($order_id);

				if ($order_info){  // устанавливаем поле invoice_no в 1 для тех заказов по которым уже отправлено письмо админу
					$sql = " UPDATE `" . DB_PREFIX . "order` o SET o.invoice_no = '1' WHERE o.order_id ='" . (int)$order_id . "'";
					$this->db->query($sql);
				}

				// Load the language for any mails that might be required to be sent out
				$language = new Language($order_info['language_code']);
				$language->load($order_info['language_code']);
				$language->load('mail/order_add');

				// HTML Mail
				$data['title'] = $order_info['store_name'].' - Потерянный заказ '. $order_info['order_id'];

				$data['text_greeting'] = sprintf($language->get('text_greeting'), $order_info['store_name']);
				$data['text_link'] = $language->get('text_link');
				$data['text_download'] = $language->get('text_download');
				$data['text_order_detail'] = $language->get('text_order_detail');
				$data['text_instruction'] = $language->get('text_instruction');
				$data['text_order_id'] = $language->get('text_order_id');
				$data['text_date_added'] = $language->get('text_date_added');
				$data['text_payment_method'] = $language->get('text_payment_method');
				$data['text_shipping_method'] = $language->get('text_shipping_method');
				$data['text_email'] = $language->get('text_email');
				$data['text_telephone'] = $language->get('text_telephone');
				$data['text_ip'] = $language->get('text_ip');
				$data['text_order_status'] = $language->get('text_order_status');
				$data['text_payment_address'] = $language->get('text_payment_address');
				$data['text_shipping_address'] = $language->get('text_shipping_address');
				$data['text_product'] = $language->get('text_product');
				$data['text_model'] = $language->get('text_model');
				$data['text_quantity'] = $language->get('text_quantity');
				$data['text_price'] = $language->get('text_price');
				$data['text_total'] = $language->get('text_total');
				$data['text_footer'] = $language->get('text_footer');

				$data['logo'] = $order_info['store_url'] . 'image/' . $this->config->get('config_logo');
				$data['store_name'] = $order_info['store_name'];
				$data['store_url'] = $order_info['store_url'];
				$data['customer_id'] = $order_info['customer_id'];
				$data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_info['order_id'];

				// if ($download_status) {
				// 	$data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
				// } else {
				// 	$data['download'] = '';
				// }

				$data['order_id'] = $order_info['order_id'];
				$data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
				$data['payment_method'] = $order_info['payment_method'];
				$data['shipping_method'] = $order_info['shipping_method'];
				$data['email'] = $order_info['email'];
				$data['telephone'] = $order_info['telephone'];
				$data['ip'] = $order_info['ip'];

				// $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
			
				// if ($order_status_query->num_rows) {
				// 	$data['order_status'] = $order_status_query->row['name'];
				// } else {
				// 	$data['order_status'] = '';
				// }

				// if ($comment && $notify) {
				// 	$data['comment'] = nl2br($comment);
				// } else {
				// 	$data['comment'] = '';
				// }

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

		
				$data['products'] = array();

				$order_products = $this->model_checkout_order->getOrderProducts($order_id);

				foreach ($order_products as $order_product) {
					$option_data = array();
					
					$order_options = $this->model_checkout_order->getOrderOptions($order_info['order_id'], $order_product['order_product_id']);
					
					foreach ($order_options as $order_option) {
						if ($order_option['type'] != 'file') {
							$value = $order_option['value'];
						} 

						$option_data[] = array(
							'name'  => $order_option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
						);					
					}
						
					$data['products'][] = array(
						'name'     => $order_product['name'],
						'model'    => $order_product['model'],
						'quantity' => $order_product['quantity'],
						'option'   => $option_data,
						'total'    => html_entity_decode($this->currency->format($order_product['total'] + ($this->config->get('config_tax') ? ($order_product['tax'] * $order_product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')
					);
				}
				
				$data['vouchers'] = array();
				
				$order_vouchers = $this->model_checkout_order->getOrderVouchers($order_id);

				foreach ($order_vouchers as $order_voucher) {
					$data['vouchers'][] = array(
						'description' => $order_voucher['description'],
						'amount'      => html_entity_decode($this->currency->format($order_voucher['amount'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')
					);					
				}

				$data['totals'] = array();
				
				$order_totals = $this->model_checkout_order->getOrderTotals($order_id);

				foreach ($order_totals as $order_total) {
					$data['totals'][] = array(
						'title' => $order_total['title'],
						'value' => html_entity_decode($this->currency->format($order_total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')
					);
				}

				$data['comment'] = strip_tags($order_info['comment']);

				$this->load->model('setting/setting');
		
				$mail = new Mail($this->config->get('config_mail_engine'));
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($order_info['store_name'].' - Потерянный заказ '. $order_info['order_id'], ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($this->load->view('mail/order_add', $data));
				$mail->send();

			}	
		}
	}

	
}