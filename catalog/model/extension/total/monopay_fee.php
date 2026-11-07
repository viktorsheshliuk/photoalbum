<?php
// *	@copyright Fedka 2017.
// *	@forum	https://opencartforum.com/profile/707994-fedka/
// *	@license LICENSE.txt

class ModelExtensionTotalMonopayFee extends Model {
	public function getTotal($total) {
		if (isset($this->session->data['payment_method']) && ($this->session->data['payment_method']['code'] == 'wayforpay')) {
			$this->load->language('extension/total/monopay_fee');
			
			$percents = '';
		
			if ($this->config->get('total_monopay_fee_percents') == 1) {
				$monopay_fee_fee = ($this->cart->getSubTotal() / 100) * $this->config->get('total_monopay_fee_fee');
				$percents = '%';
			} else {
				$monopay_fee_fee = $this->config->get('total_monopay_fee_fee');
			}
			
			/*
			if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
				if ($this->config->get('monopay_fee_percents') == 1) {
					$delivery_fee = ((float)$this->session->data['shipping_method']['cost'] / 100) * $this->config->get('monopay_fee_fee');
					$monopay_fee_fee = $monopay_fee_fee + $delivery_fee;
				}
			}
			*/
			
			$title = ($this->config->get('total_monopay_fee_custom_title')) ? $this->config->get('total_monopay_fee_custom_title') : $this->language->get('text_title');
			
			$total['totals'][] = array( 
				'code'       => 'monopay_fee',
				'title'      => $title . sprintf($this->language->get('text_monopay_fee_amount'), $this->config->get('total_monopay_fee_fee') . $percents),
				'value'      => $monopay_fee_fee,
				'sort_order' => $this->config->get('total_monopay_fee_sort_order')
			);
			
			if ($this->config->get('total_monopay_fee_tax_class_id')) {
				$tax_rates = $this->tax->getRates($monopay_fee_fee, $this->config->get('total_monopay_fee_tax_class_id'));
				
				foreach ($tax_rates as $tax_rate) {
					if (!isset($total['taxes'][$tax_rate['tax_rate_id']])) {
						$total['taxes'][$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$total['taxes'][$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}
			
			$total['total'] += $monopay_fee_fee;

		}
	}
}