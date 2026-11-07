<?php
class ControllerExtensionPaymentPrivatiban extends Controller {
	public function index() {
		$this->load->language('extension/payment/privatiban');

		$data['bank'] = nl2br($this->config->get('payment_privatiban_bank' . $this->config->get('config_language_id')));

		return $this->load->view('extension/payment/privatiban', $data);
	}

	public function confirm() {
		$json = [];
		
		if (isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'privatiban') {
			$this->load->language('extension/payment/privatiban');

			$this->load->model('checkout/order');

			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			$dest_text = !empty($this->config->get('payment_privatiban_dest' . $this->config->get('config_language_id'))) ? $this->config->get('payment_privatiban_dest' . $this->config->get('config_language_id')) : $this->language->get('text_dest');

			$dest_text = str_replace('{order_id}', $this->session->data['order_id'], $dest_text);

			$payment_data = [
				"token" => $this->config->get('payment_privatiban_token'),
				"sum" => $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false),
				"parameters" => [
					"FIO" => $order_info['payment_firstname'] . " " . $order_info['payment_lastname'],
					"DEST" => $dest_text
				]
			];

			$payment_link = 'https://next.privat24.ua/payments/form/' . str_replace('+','%20', urlencode(json_encode($payment_data, JSON_UNESCAPED_UNICODE)));

			$comment = '';
			if ($this->config->get('payment_privatiban_bank' . $this->config->get('config_language_id'))) {
				$comment .= $this->config->get('payment_privatiban_bank' . $this->config->get('config_language_id')) . "\n\n";
			}
			$comment .= '<a target="_blank" href="' . $payment_link . '">' . $this->language->get('text_payment') . '</a>';

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('payment_privatiban_order_status_id'), $comment, true);

			//$json['redirect'] = $payment_link;

			if (isset($this->session->data['order_id'])) {
				$order_id = $this->session->data['order_id'];
				$this->cart->clear();

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				unset($this->session->data['guest']);
				unset($this->session->data['comment']);
				unset($this->session->data['order_id']);
				unset($this->session->data['coupon']);
				unset($this->session->data['reward']);
				unset($this->session->data['voucher']);
				unset($this->session->data['vouchers']);
				unset($this->session->data['totals']);
			}

			// Теперь перенаправляем на страницу благодарности
			$json['redirect'] = html_entity_decode($this->url->link('extension/payment/privatiban/success', 'order_id=' . $order_id, true));

			// Сохраняем ссылку на оплату в сессию (чтобы success мог её отобразить)
			$this->session->data['privatiban_payment_link'] = $payment_link;

		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}

	public function success() {
		$this->load->language('extension/payment/privatiban');

		$data['heading_title'] = 'Дякуємо за замовлення!';
		$data['text_message'] = 'Ваше замовлення прийнято до обробки. Для завершення — натисніть кнопку нижче, щоб оплатити через Приват24.';
		$data['text_order_id']= 'Номер Вашого замовлення: ';
		$data['warning'] = 'Замовлення не оплачене !';
		
		$data['payment_link'] = $this->session->data['privatiban_payment_link'] ?? '';
		$data['button_pay'] = 'Оплатити через Приват24';
		//$data['button_continue'] = 'Повернутись в магазин';
		$data['continue'] = $this->url->link('common/home');

		$data['order_id'] = $this->request->get['order_id'] ?? '';


		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/payment/privatiban_success', $data));
	}
}