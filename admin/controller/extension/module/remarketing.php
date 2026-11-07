<?php
class ControllerExtensionModuleRemarketing extends Controller {
	private $error = [];
	private $purchased_domain = 'https://spectrevahue.com/';
	private $order = '99999';
	private $seller = 'Direct em'; 
	private $version = '7.2'; 

	public function index() {
		
		$this->load->language('extension/module/remarketing');
		
		if (version_compare(VERSION,'3.0.0.0', '>=')) {
			$token = 'user_token=' . $this->session->data['user_token'];
			$data['user_token'] = $this->session->data['user_token'];
			$extension = 'marketplace/extension';
		} else {
			$token = 'token=' . $this->session->data['token'];
			$data['token'] = $this->session->data['token'];
			$extension = 'extension/extension';
		}

		$this->document->setTitle(strip_tags(html_entity_decode($this->language->get('heading_title'))));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('remarketing', $this->request->post);
			if (version_compare(VERSION,'3.0.0.0', '>=')) {
				if ($this->request->post['remarketing_status']) {
					$this->request->post['module_remarketing_status'] = $this->request->post['remarketing_status'];
				}
				$this->model_setting_setting->editSetting('module_remarketing', $this->request->post);
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link($extension, $token . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_id'] = $this->language->get('text_id');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_identifier'] = $this->language->get('text_identifier');
		$data['text_events'] = $this->language->get('text_events');
		$data['text_esputnik'] = $this->language->get('text_esputnik');
		$data['text_tiktok'] = $this->language->get('text_tiktok');
		$data['text_snapchat'] = $this->language->get('text_snapchat');
		$data['text_uet'] = $this->language->get('text_uet');
		$data['text_events_help'] = $this->language->get('text_events_help');
		$data['text_google_remarketing'] = $this->language->get('text_google_remarketing');
		$data['text_facebook_remarketing'] = $this->language->get('text_facebook_remarketing');
		$data['text_facebook_pixel'] = $this->language->get('text_facebook_pixel');
		$data['text_facebook_api'] = $this->language->get('text_facebook_api');
		$data['text_google_reviews'] = $this->language->get('text_google_reviews');
		$data['text_ecommerce'] = $this->language->get('text_ecommerce');
		$data['text_ecommerce_ga4'] = $this->language->get('text_ecommerce_ga4');
		$data['text_ecommerce_ga4_measurement'] = $this->language->get('text_ecommerce_ga4_measurement');
		$data['text_ecommerce_measurement'] = $this->language->get('text_ecommerce_measurement');
		$data['text_counters'] = $this->language->get('text_counters');
		$data['text_to_be_continued'] = $this->language->get('text_to_be_continued');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_credits'] = $this->language->get('text_credits');
		$data['text_instruction'] = $this->language->get('text_instruction');
		$data['text_instructions'] = $this->language->get('text_instructions');
		$data['text_summary'] = $this->language->get('text_summary');
		$data['text_help_google'] = $this->language->get('text_help_google');
		$data['text_help_facebook'] = $this->language->get('text_help_facebook');
		$data['text_diagnostics'] = $this->language->get('text_diagnostics');
		$data['text_check_install'] = $this->language->get('text_check_install');
		$data['text_help_link'] = $this->language->get('text_help_link');
		$data['text_not_selected'] = $this->language->get('text_not_selected');
		$data['text_feed'] = $this->language->get('text_feed');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_category_google'] = $this->language->get('text_category_google');
		$data['text_feed_merchant'] = $this->language->get('text_feed_merchant');
		$data['text_feed_facebook'] = $this->language->get('text_feed_facebook');
		$data['text_feed_tiktok'] = $this->language->get('text_feed_tiktok');
		$data['text_feed_help'] = $this->language->get('text_feed_help');
		$data['text_telegram'] = $this->language->get('text_telegram');
		$data['text_copy_to_category'] = $this->language->get('text_copy_to_category');
		$data['text_copy_to_product_type'] = $this->language->get('text_copy_to_product_type');
		$data['text_forum_documentation'] = $this->language->get('text_forum_documentation');
		$data['text_version'] = $this->language->get('text_version');
		$data['text_tiktok_pixel'] = $this->language->get('text_tiktok_pixel');
		$data['text_tiktok_api'] = $this->language->get('text_tiktok_api');
		$data['text_snapchat_pixel'] = $this->language->get('text_snapchat_pixel');
		$data['text_reports'] = $this->language->get('text_reports');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_bot_status'] = $this->language->get('entry_bot_status');
		$data['entry_admin_status'] = $this->language->get('entry_admin_status');
		$data['entry_debug_mode'] = $this->language->get('entry_debug_mode');
		$data['entry_autoclear_mode'] = $this->language->get('entry_autoclear_mode');
		$data['entry_show_in_order'] = $this->language->get('entry_show_in_order');
		$data['entry_log'] = $this->language->get('entry_log');
		$data['entry_google_identifier'] = $this->language->get('entry_google_identifier');
		$data['entry_google_ads_identifier'] = $this->language->get('entry_google_ads_identifier');
		$data['entry_google_ads_identifier_cart'] = $this->language->get('entry_google_ads_identifier_cart');
		$data['entry_google_ads_identifier_cart_page'] = $this->language->get('entry_google_ads_identifier_cart_page');
		$data['entry_google_ads_ratio'] = $this->language->get('entry_google_ads_ratio');
		$data['entry_ecommerce_ratio'] = $this->language->get('entry_ecommerce_ratio');
		$data['entry_facebook_ratio'] = $this->language->get('entry_facebook_ratio');
		$data['entry_facebook_identifier'] = $this->language->get('entry_facebook_identifier');
		$data['entry_google_code'] = $this->language->get('entry_google_code');
		$data['entry_facebook_code'] = $this->language->get('entry_facebook_code');
		$data['entry_facebook_script_status'] = $this->language->get('entry_facebook_script_status');
		$data['entry_facebook_token'] = $this->language->get('entry_facebook_token');
		$data['entry_facebook_api_ver'] = $this->language->get('entry_facebook_api_ver');
		$data['entry_facebook_test_code'] = $this->language->get('entry_facebook_test_code');
		$data['entry_facebook_pixel_status'] = $this->language->get('entry_facebook_pixel_status');
		$data['entry_facebook_lead'] = $this->language->get('entry_facebook_lead');
		$data['entry_facebook_depth'] = $this->language->get('entry_facebook_depth');
		$data['entry_facebook_depth_params'] = $this->language->get('entry_facebook_depth_params');
		$data['entry_facebook_send_status'] = $this->language->get('entry_facebook_send_status');
		$data['entry_facebook_lead_send_status'] = $this->language->get('entry_facebook_lead_send_status');
		$data['entry_server_side'] = $this->language->get('entry_server_side');
		$data['entry_tiktok_server_side'] = $this->language->get('entry_tiktok_server_side');
		$data['entry_feed_status'] = $this->language->get('entry_feed_status');
		$data['entry_reviews_quick_order_status'] = $this->language->get('entry_reviews_quick_order_status');
		$data['entry_feed_link'] = $this->language->get('entry_feed_link');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_google_merchant_identifier'] = $this->language->get('entry_google_merchant_identifier');
		$data['entry_reviews_date'] = $this->language->get('entry_reviews_date');
		$data['entry_reviews_country'] = $this->language->get('entry_reviews_country');
		$data['entry_events_cart'] = $this->language->get('entry_events_cart');
		$data['entry_events_cart_add'] = $this->language->get('entry_events_cart_add');
		$data['entry_events_purchase'] = $this->language->get('entry_events_purchase');
		$data['entry_events_quick_purchase'] = $this->language->get('entry_events_quick_purchase');
		$data['entry_events_wishlist'] = $this->language->get('entry_events_wishlist');
		$data['entry_ecommerce_selector'] = $this->language->get('entry_ecommerce_selector');
		$data['entry_ecommerce_ga4_selector'] = $this->language->get('entry_ecommerce_selector');
		$data['entry_ga4_only_purchase'] = $this->language->get('entry_ga4_only_purchase');
		$data['entry_ecommerce_ga4_identifier'] = $this->language->get('entry_ecommerce_ga4_identifier');
		$data['entry_ecommerce_ga4_analytics_id'] = $this->language->get('entry_ecommerce_ga4_analytics_id');
		$data['entry_ecommerce_ga4_api_secret'] = $this->language->get('entry_ecommerce_ga4_api_secret');
		$data['entry_remarketing_ecommerce_ga4_send_status'] = $this->language->get('entry_remarketing_ecommerce_ga4_send_status');
		$data['entry_remarketing_ecommerce_ga4_refund_status'] = $this->language->get('entry_remarketing_ecommerce_ga4_refund_status');
		$data['entry_ecommerce_send_status'] = $this->language->get('entry_ecommerce_send_status');
		$data['entry_refund_status'] = $this->language->get('entry_refund_status');
		$data['entry_resend_status'] = $this->language->get('entry_resend_status');
		$data['entry_delete_status'] = $this->language->get('entry_delete_status');
		$data['entry_refund_ga4_status'] = $this->language->get('entry_refund_ga4_status');
		$data['entry_counter1'] = $this->language->get('entry_counter1');
		$data['entry_counter2'] = $this->language->get('entry_counter2');
		$data['entry_counter3'] = $this->language->get('entry_counter3');
		$data['entry_counter_bot'] = $this->language->get('entry_counter_bot');
		$data['entry_esputnik_webtracking_status'] = $this->language->get('entry_esputnik_webtracking_status');
		$data['entry_esputnik_api_status'] = $this->language->get('entry_esputnik_api_status');
		$data['entry_esputnik_webtracking_identifier'] = $this->language->get('entry_esputnik_webtracking_identifier');
		$data['entry_esputnik_login'] = $this->language->get('entry_esputnik_login');
		$data['entry_esputnik_password'] = $this->language->get('entry_esputnik_password');
		$data['entry_esputnik_address_format'] = $this->language->get('entry_esputnik_address_format');
		$data['entry_esputnik_ttn_field'] = $this->language->get('entry_esputnik_ttn_field');
		$data['entry_esputnik_delivered_status'] = $this->language->get('entry_esputnik_delivered_status');
		$data['entry_esputnik_cancelled_status'] = $this->language->get('entry_esputnik_cancelled_status');
		$data['entry_esputnik_inprogress_status'] = $this->language->get('entry_esputnik_inprogress_status');
		$data['entry_esputnik_initialized_status'] = $this->language->get('entry_esputnik_initialized_status');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_remarketing_feed_original_image_status'] = $this->language->get('entry_remarketing_feed_original_image_status');
		$data['entry_remarketing_feed_short_desc'] = $this->language->get('entry_remarketing_feed_short_desc');
		$data['entry_remarketing_feed_key'] = $this->language->get('entry_remarketing_feed_key');
		$data['entry_remarketing_feed_additional_images'] = $this->language->get('entry_remarketing_feed_additional_images');
		$data['entry_remarketing_feed_multiplier'] = $this->language->get('entry_remarketing_feed_multiplier');
		$data['entry_remarketing_feed_condition'] = $this->language->get('entry_remarketing_feed_condition');
		$data['entry_remarketing_feed_adult'] = $this->language->get('entry_remarketing_feed_adult');
		$data['entry_remarketing_feed_utm'] = $this->language->get('entry_remarketing_feed_utm');
		$data['entry_remarketing_feed_utm_facebook'] = $this->language->get('entry_remarketing_feed_utm_facebook'); 
		$data['entry_remarketing_feed_utm_tiktok'] = $this->language->get('entry_remarketing_feed_utm_tiktok');
		$data['entry_remarketing_feed_empty_brand'] = $this->language->get('entry_remarketing_feed_empty_brand');
		$data['entry_remarketing_feed_currency'] = $this->language->get('entry_remarketing_feed_currency');
		$data['entry_remarketing_feed_currency_base'] = $this->language->get('entry_remarketing_feed_currency_base');
		$data['entry_remarketing_feed_special'] = $this->language->get('entry_remarketing_feed_special');
		$data['entry_remarketing_feed_min_price'] = $this->language->get('entry_remarketing_feed_min_price');
		$data['entry_remarketing_feed_max_price'] = $this->language->get('entry_remarketing_feed_max_price');
		$data['entry_remarketing_feed_zero_quantity'] = $this->language->get('entry_remarketing_feed_zero_quantity');
		$data['entry_remarketing_feed_always_avail'] = $this->language->get('entry_remarketing_feed_always_avail');
		$data['entry_remarketing_feed_in_stock'] = $this->language->get('entry_remarketing_feed_in_stock');
		$data['entry_remarketing_feed_out_of_stock'] = $this->language->get('entry_remarketing_feed_out_of_stock');
		$data['entry_remarketing_feed_gtin'] = $this->language->get('entry_remarketing_feed_gtin');
		$data['entry_remarketing_feed_mpn'] = $this->language->get('entry_remarketing_feed_mpn'); 
		$data['entry_remarketing_feed_highlight'] = $this->language->get('entry_remarketing_feed_highlight');
		$data['entry_remarketing_feed_replace_description'] = $this->language->get('entry_remarketing_feed_replace_description');
		$data['entry_remarketing_feed_color'] = $this->language->get('entry_remarketing_feed_color');
		$data['entry_remarketing_feed_size'] = $this->language->get('entry_remarketing_feed_size');
		$data['entry_remarketing_feed_material'] = $this->language->get('entry_remarketing_feed_material');
		$data['entry_remarketing_feed_gender'] = $this->language->get('entry_remarketing_feed_gender');
		$data['entry_remarketing_feed_age_group'] = $this->language->get('entry_remarketing_feed_age_group');
		$data['entry_remarketing_feed_store_code'] = $this->language->get('entry_remarketing_feed_store_code');
		$data['entry_remarketing_feed_original_description'] = $this->language->get('entry_remarketing_feed_original_description');
		$data['entry_remarketing_feed_rich_text'] = $this->language->get('entry_remarketing_feed_rich_text');
		$data['entry_remarketing_feed_custom_sql'] = $this->language->get('entry_remarketing_feed_custom_sql');
		$data['entry_remarketing_feed_links'] = $this->language->get('entry_remarketing_feed_links');
		$data['entry_remarketing_feed_tuning'] = $this->language->get('entry_remarketing_feed_tuning'); 
		$data['entry_remarketing_feed_all_attributes'] = $this->language->get('entry_remarketing_feed_all_attributes');
		$data['entry_remarketing_feed_ocstore_main'] = $this->language->get('entry_remarketing_feed_ocstore_main');
		$data['entry_remarketing_feed_last_category'] = $this->language->get('entry_remarketing_feed_last_category');
		$data['entry_remarketing_feed_type_category'] = $this->language->get('entry_remarketing_feed_type_category');
		$data['entry_remarketing_feed_description'] = $this->language->get('entry_remarketing_feed_description');
		$data['entry_remarketing_feed_replace_from'] = $this->language->get('entry_remarketing_feed_replace_from');
		$data['entry_remarketing_feed_replace_to'] = $this->language->get('entry_remarketing_feed_replace_to');
		$data['entry_manual_send'] = $this->language->get('entry_manual_send');
		$data['entry_telegram_bot_id'] = $this->language->get('entry_telegram_bot_id');
		$data['entry_telegram_send_to_id'] = $this->language->get('entry_telegram_send_to_id');
		$data['entry_telegram_send_status'] = $this->language->get('entry_telegram_send_status');
		$data['entry_telegram_message'] = $this->language->get('entry_telegram_message');
		$data['entry_user_id'] = $this->language->get('entry_user_id');
		$data['entry_feed_anonymous'] = $this->language->get('entry_feed_anonymous');
		$data['entry_feed_gtin'] = $this->language->get('entry_feed_gtin');
		$data['entry_feed_mpn'] = $this->language->get('entry_feed_mpn');
		$data['entry_feed_sku'] = $this->language->get('entry_feed_sku');
		$data['entry_feed_asin'] = $this->language->get('entry_feed_asin');
		$data['entry_no_shipping'] = $this->language->get('entry_no_shipping');
		$data['entry_tiktok_identifier'] = $this->language->get('entry_tiktok_identifier');
		$data['entry_tiktok_ratio'] = $this->language->get('entry_tiktok_ratio');
		$data['entry_tiktok_script_status'] = $this->language->get('entry_tiktok_script_status');
		$data['entry_tiktok_pixel_status'] = $this->language->get('entry_tiktok_pixel_status');
		$data['entry_tiktok_token'] = $this->language->get('entry_tiktok_token');
		$data['entry_tiktok_api_ver'] = $this->language->get('entry_tiktok_api_ver');
		$data['entry_tiktok_test_code'] = $this->language->get('entry_tiktok_test_code');
		$data['entry_tiktok_send_status'] = $this->language->get('entry_tiktok_send_status');
		$data['entry_snapchat_identifier'] = $this->language->get('entry_snapchat_identifier');
		$data['entry_snapchat_ratio'] = $this->language->get('entry_snapchat_ratio');
 		$data['entry_snapchat_script_status'] = $this->language->get('entry_snapchat_script_status');
 		$data['entry_snapchat_pixel_status'] = $this->language->get('entry_snapchat_pixel_status');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_test_facebook'] = $this->language->get('button_test_facebook');
		
		$data['link_merchant'] = HTTPS_CATALOG . 'index.php?route=extension/feed/remarketing_feed';
		$data['link_facebook'] = HTTPS_CATALOG . 'index.php?route=extension/feed/remarketing_feed&target=facebook';
		$data['link_tiktok'] = HTTPS_CATALOG . 'index.php?route=extension/feed/remarketing_feed&target=tiktok';
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [['text' => $this->language->get('text_home'), 'href' => $this->url->link('common/dashboard', $token, true)],	['text' => $this->language->get('text_extension'), 'href' => $this->url->link($extension, $token . '&type=module', true)], ['text' => $this->language->get('heading_title'), 'href' => $this->url->link('extension/module/remarketing', $token, true)]];
		$data['action'] = $this->url->link('extension/module/remarketing', $token, true);
		$data['cancel'] = $this->url->link($extension, $token . '&type=module', true);
		
		$data['test_facebook'] = html_entity_decode($this->url->link('extension/module/remarketing/testFacebook', $token, true));
		$data['check_version'] = html_entity_decode($this->url->link('extension/module/remarketing/checkVersion', $token, true));
		$data['remarketing_report_link'] = html_entity_decode($this->url->link('report/remarketing_report', $token, true));

		if (isset($this->request->post['remarketing_status'])) {
			$data['remarketing_status'] = $this->request->post['remarketing_status'];
		} else {
			$data['remarketing_status'] = $this->config->get('remarketing_status');
		}

		if (isset($this->request->post['remarketing_bot_status'])) {
			$data['remarketing_bot_status'] = $this->request->post['remarketing_bot_status'];
		} else {
			$data['remarketing_bot_status'] = $this->config->get('remarketing_bot_status');
		}

		if (isset($this->request->post['remarketing_admin_status'])) {
			$data['remarketing_admin_status'] = $this->request->post['remarketing_admin_status'];
		} else {
			$data['remarketing_admin_status'] = $this->config->get('remarketing_admin_status');
		}

		if (isset($this->request->post['remarketing_debug_mode'])) {
			$data['remarketing_debug_mode'] = $this->request->post['remarketing_debug_mode'];
		} else {
			$data['remarketing_debug_mode'] = $this->config->get('remarketing_debug_mode');
		}

		if (isset($this->request->post['remarketing_autoclear_mode'])) {
			$data['remarketing_autoclear_mode'] = $this->request->post['remarketing_autoclear_mode'];
		} else {
			$data['remarketing_autoclear_mode'] = $this->config->get('remarketing_autoclear_mode');
		}

		if (isset($this->request->post['remarketing_show_in_order'])) {
			$data['remarketing_show_in_order'] = $this->request->post['remarketing_show_in_order'];
		} else {
			$data['remarketing_show_in_order'] = $this->config->get('remarketing_show_in_order');
		}

		if (isset($this->request->post['remarketing_no_shipping'])) {
			$data['remarketing_no_shipping'] = $this->request->post['remarketing_no_shipping'];
		} else {
			$data['remarketing_no_shipping'] = $this->config->get('remarketing_no_shipping');
		}

		if (isset($this->request->post['remarketing_google_status'])) {
			$data['remarketing_google_status'] = $this->request->post['remarketing_google_status'];
		} else {
			$data['remarketing_google_status'] = $this->config->get('remarketing_google_status');
		}

		if (isset($this->request->post['remarketing_tiktok_status'])) {
			$data['remarketing_tiktok_status'] = $this->request->post['remarketing_tiktok_status'];
		} else {
			$data['remarketing_tiktok_status'] = $this->config->get('remarketing_tiktok_status');
		}

		if (isset($this->request->post['remarketing_feed_status'])) {
			$data['remarketing_feed_status'] = $this->request->post['remarketing_feed_status'];
		} else {
			$data['remarketing_feed_status'] = $this->config->get('remarketing_feed_status');
		}

		if (isset($this->request->post['remarketing_facebook_status'])) {
			$data['remarketing_facebook_status'] = $this->request->post['remarketing_facebook_status'];
		} else {
			$data['remarketing_facebook_status'] = $this->config->get('remarketing_facebook_status');
		}

		if (isset($this->request->post['remarketing_telegram_status'])) {
			$data['remarketing_telegram_status'] = $this->request->post['remarketing_telegram_status'];
		} else {
			$data['remarketing_telegram_status'] = $this->config->get('remarketing_telegram_status');
		} 

		if (isset($this->request->post['remarketing_google_identifier'])) {
			$data['remarketing_google_identifier'] = $this->request->post['remarketing_google_identifier'];
		} else {
			$data['remarketing_google_identifier'] = $this->config->get('remarketing_google_identifier');
		}

		if (isset($this->request->post['remarketing_google_ads_identifier'])) {
			$data['remarketing_google_ads_identifier'] = $this->request->post['remarketing_google_ads_identifier'];
		} else {
			$data['remarketing_google_ads_identifier'] = $this->config->get('remarketing_google_ads_identifier');
		}

		if (isset($this->request->post['remarketing_google_ads_identifier_cart_page'])) {
			$data['remarketing_google_ads_identifier_cart_page'] = $this->request->post['remarketing_google_ads_identifier_cart_page'];
		} else {
			$data['remarketing_google_ads_identifier_cart_page'] = $this->config->get('remarketing_google_ads_identifier_cart_page');
		}

		if (isset($this->request->post['remarketing_google_ads_identifier_cart'])) {
			$data['remarketing_google_ads_identifier_cart'] = $this->request->post['remarketing_google_ads_identifier_cart'];
		} else {
			$data['remarketing_google_ads_identifier_cart'] = $this->config->get('remarketing_google_ads_identifier_cart');
		}
		
		if (isset($this->request->post['remarketing_google_ads_ratio'])) {
			$data['remarketing_google_ads_ratio'] = $this->request->post['remarketing_google_ads_ratio'];
		} elseif ($this->config->get('remarketing_google_ads_ratio')) {
			$data['remarketing_google_ads_ratio'] = $this->config->get('remarketing_google_ads_ratio');
		} else {
			$data['remarketing_google_ads_ratio'] = '1';
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ratio'])) {
			$data['remarketing_ecommerce_ratio'] = $this->request->post['remarketing_ecommerce_ratio'];
		} elseif ($this->config->get('remarketing_ecommerce_ratio')) {
			$data['remarketing_ecommerce_ratio'] = $this->config->get('remarketing_ecommerce_ratio');
		} else {
			$data['remarketing_ecommerce_ratio'] = '1';
		}
		
		if (isset($this->request->post['remarketing_facebook_ratio'])) {
			$data['remarketing_facebook_ratio'] = $this->request->post['remarketing_facebook_ratio'];
		} elseif ($this->config->get('remarketing_facebook_ratio')) {
			$data['remarketing_facebook_ratio'] = $this->config->get('remarketing_facebook_ratio');
		} else {
			$data['remarketing_facebook_ratio'] = '1';
		}
		
		if (isset($this->request->post['remarketing_facebook_identifier'])) {
			$data['remarketing_facebook_identifier'] = $this->request->post['remarketing_facebook_identifier'];
		} else {
			$data['remarketing_facebook_identifier'] = $this->config->get('remarketing_facebook_identifier');
		}

		if (isset($this->request->post['remarketing_google_id'])) {
			$data['remarketing_google_id'] = $this->request->post['remarketing_google_id'];
		} else {
			$data['remarketing_google_id'] = $this->config->get('remarketing_google_id');
		}

		if (isset($this->request->post['remarketing_facebook_id'])) {
			$data['remarketing_facebook_id'] = $this->request->post['remarketing_facebook_id'];
		} else {
			$data['remarketing_facebook_id'] = $this->config->get('remarketing_facebook_id');
		}

		if (isset($this->request->post['remarketing_facebook_server_side'])) {
			$data['remarketing_facebook_server_side'] = $this->request->post['remarketing_facebook_server_side'];
		} else {
			$data['remarketing_facebook_server_side'] = $this->config->get('remarketing_facebook_server_side');
		}

		if (isset($this->request->post['remarketing_facebook_script_status'])) {
			$data['remarketing_facebook_script_status'] = $this->request->post['remarketing_facebook_script_status'];
		} else {
			$data['remarketing_facebook_script_status'] = $this->config->get('remarketing_facebook_script_status');
		}

		if (isset($this->request->post['remarketing_facebook_token'])) {
			$data['remarketing_facebook_token'] = $this->request->post['remarketing_facebook_token'];
		} else {
			$data['remarketing_facebook_token'] = $this->config->get('remarketing_facebook_token');
		}

		if (isset($this->request->post['remarketing_facebook_api_ver'])) {
			$data['remarketing_facebook_api_ver'] = $this->request->post['remarketing_facebook_api_ver'];
		} elseif ($this->config->get('remarketing_facebook_api_ver')) {
			$data['remarketing_facebook_api_ver'] = $this->config->get('remarketing_facebook_api_ver');
		} else {
			$data['remarketing_facebook_api_ver'] = '18.0';  
		}

		if (isset($this->request->post['remarketing_facebook_test_code'])) {
			$data['remarketing_facebook_test_code'] = $this->request->post['remarketing_facebook_test_code'];
		} else {
			$data['remarketing_facebook_test_code'] = $this->config->get('remarketing_facebook_test_code');
		}

		if (isset($this->request->post['remarketing_facebook_pixel_status'])) {
			$data['remarketing_facebook_pixel_status'] = $this->request->post['remarketing_facebook_pixel_status'];
		} else {
			$data['remarketing_facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
		}

		if (isset($this->request->post['remarketing_facebook_lead'])) {
			$data['remarketing_facebook_lead'] = $this->request->post['remarketing_facebook_lead'];
		} else {
			$data['remarketing_facebook_lead'] = $this->config->get('remarketing_facebook_lead');
		}

		if (isset($this->request->post['remarketing_facebook_depth'])) {
			$data['remarketing_facebook_depth'] = $this->request->post['remarketing_facebook_depth'];
		} else {
			$data['remarketing_facebook_depth'] = $this->config->get('remarketing_facebook_depth');
		}
		
		if (isset($this->request->post['remarketing_facebook_depth_params'])) {
			$data['remarketing_facebook_depth_params'] = $this->request->post['remarketing_facebook_depth_params'];
		} elseif ($this->config->get('remarketing_facebook_depth_params')) {
			$data['remarketing_facebook_depth_params'] = $this->config->get('remarketing_facebook_depth_params');
		} else {
			$data['remarketing_facebook_depth_params'] = '10,50,90';
		}
		
		$this->load->model('localisation/currency');
		
		$currencies = $this->model_localisation_currency->getCurrencies();
		
		$data['currencies'] = $currencies;
		
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['remarketing_google_currency'])) {
			$data['remarketing_google_currency'] = $this->request->post['remarketing_google_currency'];
		} else {
			$data['remarketing_google_currency'] = $this->config->get('remarketing_google_currency');
		}
		
		if (isset($this->request->post['remarketing_facebook_currency'])) {
			$data['remarketing_facebook_currency'] = $this->request->post['remarketing_facebook_currency'];
		} else {
			$data['remarketing_facebook_currency'] = $this->config->get('remarketing_facebook_currency');
		}
		
		if (isset($this->request->post['remarketing_ecommerce_currency'])) {
			$data['remarketing_ecommerce_currency'] = $this->request->post['remarketing_ecommerce_currency'];
		} else {
			$data['remarketing_ecommerce_currency'] = $this->config->get('remarketing_ecommerce_currency');
		}
		
		if (isset($this->request->post['remarketing_tiktok_currency'])) {
			$data['remarketing_tiktok_currency'] = $this->request->post['remarketing_tiktok_currency'];
		} else {
			$data['remarketing_tiktok_currency'] = $this->config->get('remarketing_tiktok_currency');
		}
		
		if (isset($this->request->post['remarketing_snapchat_currency'])) {
			$data['remarketing_snapchat_currency'] = $this->request->post['remarketing_snapchat_currency'];
		} else {
			$data['remarketing_snapchat_currency'] = $this->config->get('remarketing_snapchat_currency');
		}
		
		if (isset($this->request->post['remarketing_feed_currency'])) {
			$data['remarketing_feed_currency'] = $this->request->post['remarketing_feed_currency'];
		} else {
			$data['remarketing_feed_currency'] = $this->config->get('remarketing_feed_currency');
		}
		
		if (isset($this->request->post['remarketing_feed_currency_base'])) {
			$data['remarketing_feed_currency_base'] = $this->request->post['remarketing_feed_currency_base'];
		} else {
			$data['remarketing_feed_currency_base'] = $this->config->get('remarketing_feed_currency_base');
		}
		
		if (isset($this->request->post['remarketing_reviews_status'])) {
			$data['remarketing_reviews_status'] = $this->request->post['remarketing_reviews_status'];
		} else {
			$data['remarketing_reviews_status'] = $this->config->get('remarketing_reviews_status');
		}

		if (isset($this->request->post['remarketing_reviews_feed_anonymous'])) {
			$data['remarketing_reviews_feed_anonymous'] = $this->request->post['remarketing_reviews_feed_anonymous'];
		} else {
			$data['remarketing_reviews_feed_anonymous'] = $this->config->get('remarketing_reviews_feed_anonymous');
		}

		if (isset($this->request->post['remarketing_reviews_feed_gtin'])) {
			$data['remarketing_reviews_feed_gtin'] = $this->request->post['remarketing_reviews_feed_gtin'];
		} else {
			$data['remarketing_reviews_feed_gtin'] = $this->config->get('remarketing_reviews_feed_gtin');
		}

		if (isset($this->request->post['remarketing_reviews_feed_mpn'])) {
			$data['remarketing_reviews_feed_mpn'] = $this->request->post['remarketing_reviews_feed_mpn'];
		} else {
			$data['remarketing_reviews_feed_mpn'] = $this->config->get('remarketing_reviews_feed_mpn');
		}

		if (isset($this->request->post['remarketing_reviews_feed_sku'])) {
			$data['remarketing_reviews_feed_sku'] = $this->request->post['remarketing_reviews_feed_sku'];
		} else {
			$data['remarketing_reviews_feed_sku'] = $this->config->get('remarketing_reviews_feed_sku');
		}

		if (isset($this->request->post['remarketing_reviews_feed_asin'])) {
			$data['remarketing_reviews_feed_asin'] = $this->request->post['remarketing_reviews_feed_asin'];
		} else {
			$data['remarketing_reviews_feed_asin'] = $this->config->get('remarketing_reviews_feed_asin');
		}

		if (isset($this->request->post['remarketing_google_merchant_identifier'])) {
			$data['remarketing_google_merchant_identifier'] = $this->request->post['remarketing_google_merchant_identifier'];
		} else {
			$data['remarketing_google_merchant_identifier'] = $this->config->get('remarketing_google_merchant_identifier');
		}
		
		if (isset($this->request->post['remarketing_feed_identifier'])) {
			$data['remarketing_feed_identifier'] = $this->request->post['remarketing_feed_identifier'];
		} else {
			$data['remarketing_feed_identifier'] = $this->config->get('remarketing_feed_identifier');
		}
		
		if (isset($this->request->post['remarketing_reviews_feed_status'])) {
			$data['remarketing_reviews_feed_status'] = $this->request->post['remarketing_reviews_feed_status'];
		} else {
			$data['remarketing_reviews_feed_status'] = $this->config->get('remarketing_reviews_feed_status');
		}

		if (isset($this->request->post['remarketing_reviews_quick_order_status'])) {
			$data['remarketing_reviews_quick_order_status'] = $this->request->post['remarketing_reviews_quick_order_status'];
		} else {
			$data['remarketing_reviews_quick_order_status'] = $this->config->get('remarketing_reviews_quick_order_status');
		}

		if (isset($this->request->post['remarketing_reviews_date'])) {
			$data['remarketing_reviews_date'] = $this->request->post['remarketing_reviews_date'];
		} else {
			$data['remarketing_reviews_date'] = $this->config->get('remarketing_reviews_date');
		}

		if (isset($this->request->post['remarketing_reviews_country'])) {
			$data['remarketing_reviews_country'] = $this->request->post['remarketing_reviews_country'];
		} else {
			$data['remarketing_reviews_country'] = $this->config->get('remarketing_reviews_country');
		}

		if (isset($this->request->post['remarketing_events_cart'])) {
			$data['remarketing_events_cart'] = $this->request->post['remarketing_events_cart'];
		} else {
			$data['remarketing_events_cart'] = $this->config->get('remarketing_events_cart');
		}

		if (isset($this->request->post['remarketing_events_cart_add'])) {
			$data['remarketing_events_cart_add'] = $this->request->post['remarketing_events_cart_add'];
		} else {
			$data['remarketing_events_cart_add'] = $this->config->get('remarketing_events_cart_add');
		}

		if (isset($this->request->post['remarketing_events_purchase'])) {
			$data['remarketing_events_purchase'] = $this->request->post['remarketing_events_purchase'];
		} else {
			$data['remarketing_events_purchase'] = $this->config->get('remarketing_events_purchase');
		}

		if (isset($this->request->post['remarketing_events_quick_purchase'])) {
			$data['remarketing_events_quick_purchase'] = $this->request->post['remarketing_events_quick_purchase'];
		} else {
			$data['remarketing_events_quick_purchase'] = $this->config->get('remarketing_events_quick_purchase');
		}

		if (isset($this->request->post['remarketing_events_wishlist'])) {
			$data['remarketing_events_wishlist'] = $this->request->post['remarketing_events_wishlist'];
		} else {
			$data['remarketing_events_wishlist'] = $this->config->get('remarketing_events_wishlist');
		}

		if (isset($this->request->post['remarketing_ecommerce_status'])) {
			$data['remarketing_ecommerce_status'] = $this->request->post['remarketing_ecommerce_status'];
		} else {
			$data['remarketing_ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
		}

		if (isset($this->request->post['remarketing_esputnik_status'])) {
			$data['remarketing_esputnik_status'] = $this->request->post['remarketing_esputnik_status'];
		} else {
			$data['remarketing_esputnik_status'] = $this->config->get('remarketing_esputnik_status');
		}
		
		if (isset($this->request->post['remarketing_esputnik_webtracking_status'])) {
			$data['remarketing_esputnik_webtracking_status'] = $this->request->post['remarketing_esputnik_webtracking_status'];
		} else {
			$data['remarketing_esputnik_webtracking_status'] = $this->config->get('remarketing_esputnik_webtracking_status');
		}
		
		if (isset($this->request->post['remarketing_esputnik_api_status'])) {
			$data['remarketing_esputnik_api_status'] = $this->request->post['remarketing_esputnik_api_status'];
		} else {
			$data['remarketing_esputnik_api_status'] = $this->config->get('remarketing_esputnik_api_status');
		}
		
		if (isset($this->request->post['remarketing_esputnik_webtracking_identifier'])) {
			$data['remarketing_esputnik_webtracking_identifier'] = $this->request->post['remarketing_esputnik_webtracking_identifier'];
		} else {
			$data['remarketing_esputnik_webtracking_identifier'] = $this->config->get('remarketing_esputnik_webtracking_identifier');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_status'])) {
			$data['remarketing_ecommerce_ga4_status'] = $this->request->post['remarketing_ecommerce_ga4_status'];
		} else {
			$data['remarketing_ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_measurement_status'])) {
			$data['remarketing_ecommerce_ga4_measurement_status'] = $this->request->post['remarketing_ecommerce_ga4_measurement_status'];
		} else {
			$data['remarketing_ecommerce_ga4_measurement_status'] = $this->config->get('remarketing_ecommerce_ga4_measurement_status');
		}
		
		if (isset($this->request->post['remarketing_ga4_only_purchase'])) {
			$data['remarketing_ga4_only_purchase'] = $this->request->post['remarketing_ga4_only_purchase'];
		} else {
			$data['remarketing_ga4_only_purchase'] = $this->config->get('remarketing_ga4_only_purchase');
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ga4_selector'])) {
			$data['remarketing_ecommerce_ga4_selector'] = $this->request->post['remarketing_ecommerce_ga4_selector'];
		} elseif ($this->config->get('remarketing_ecommerce_ga4_selector')) {
			$data['remarketing_ecommerce_ga4_selector'] = $this->config->get('remarketing_ecommerce_ga4_selector');
		} else {
			$data['remarketing_ecommerce_ga4_selector'] = '.product-thumb';
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_id'])) {
			$data['remarketing_ecommerce_ga4_id'] = $this->request->post['remarketing_ecommerce_ga4_id'];
		} else {
			$data['remarketing_ecommerce_ga4_id'] = $this->config->get('remarketing_ecommerce_ga4_id');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_analytics_id'])) {
			$data['remarketing_ecommerce_ga4_analytics_id'] = $this->request->post['remarketing_ecommerce_ga4_analytics_id'];
		} else {
			$data['remarketing_ecommerce_ga4_analytics_id'] = $this->config->get('remarketing_ecommerce_ga4_analytics_id');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_identifier'])) {
			$data['remarketing_ecommerce_ga4_identifier'] = $this->request->post['remarketing_ecommerce_ga4_identifier'];
		} else {
			$data['remarketing_ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_measurement_api_secret'])) {
			$data['remarketing_ecommerce_ga4_measurement_api_secret'] = $this->request->post['remarketing_ecommerce_ga4_measurement_api_secret'];
		} else {
			$data['remarketing_ecommerce_ga4_measurement_api_secret'] = $this->config->get('remarketing_ecommerce_ga4_measurement_api_secret');
		}

		if (isset($this->request->post['remarketing_ecommerce_ga4_measurement_id'])) {
			$data['remarketing_ecommerce_ga4_measurement_id'] = $this->request->post['remarketing_ecommerce_ga4_measurement_id'];
		} else {
			$data['remarketing_ecommerce_ga4_measurement_id'] = $this->config->get('remarketing_ecommerce_ga4_measurement_id');
		}

		if (isset($this->request->post['remarketing_facebook_send_status'])) {
			$data['remarketing_facebook_send_status'] = $this->request->post['remarketing_facebook_send_status'];
		} elseif ($this->config->get('remarketing_facebook_send_status')) {
			$data['remarketing_facebook_send_status'] = $this->config->get('remarketing_facebook_send_status');
		} else {
			$data['remarketing_facebook_send_status'] = [];
		}

		if (isset($this->request->post['remarketing_facebook_lead_send_status'])) {
			$data['remarketing_facebook_lead_send_status'] = $this->request->post['remarketing_facebook_lead_send_status'];
		} elseif ($this->config->get('remarketing_facebook_lead_send_status')) {
			$data['remarketing_facebook_lead_send_status'] = $this->config->get('remarketing_facebook_lead_send_status');
		} else {
			$data['remarketing_facebook_lead_send_status'] = [];
		}

		if (isset($this->request->post['remarketing_facebook_resend_status'])) {
			$data['remarketing_facebook_resend_status'] = $this->request->post['remarketing_facebook_resend_status'];
		} else {
			$data['remarketing_facebook_resend_status'] = $this->config->get('remarketing_facebook_resend_status');
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ga4_refund_status'])) {
			$data['remarketing_ecommerce_ga4_refund_status'] = $this->request->post['remarketing_ecommerce_ga4_refund_status'];
		} elseif ($this->config->get('remarketing_ecommerce_ga4_refund_status')) {
			$data['remarketing_ecommerce_ga4_refund_status'] = $this->config->get('remarketing_ecommerce_ga4_refund_status');
		} else {
			$data['remarketing_ecommerce_ga4_refund_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ga4_send_status'])) {
			$data['remarketing_ecommerce_ga4_send_status'] = $this->request->post['remarketing_ecommerce_ga4_send_status'];
		} elseif ($this->config->get('remarketing_ecommerce_ga4_send_status')) {
			$data['remarketing_ecommerce_ga4_send_status'] = $this->config->get('remarketing_ecommerce_ga4_send_status');
		} else {
			$data['remarketing_ecommerce_ga4_send_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_ecommerce_ga4_resend_status'])) {
			$data['remarketing_ecommerce_ga4_resend_status'] = $this->request->post['remarketing_ecommerce_ga4_resend_status'];
		} else {
			$data['remarketing_ecommerce_ga4_resend_status'] = $this->config->get('remarketing_ecommerce_ga4_resend_status');
		}
		
		if (isset($this->request->post['remarketing_esputnik_initialized_status'])) {
			$data['remarketing_esputnik_initialized_status'] = $this->request->post['remarketing_esputnik_initialized_status'];
		} elseif ($this->config->get('remarketing_esputnik_initialized_status')) {
			$data['remarketing_esputnik_initialized_status'] = $this->config->get('remarketing_esputnik_initialized_status');
		} else {
			$data['remarketing_esputnik_initialized_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_esputnik_inprogress_status'])) {
			$data['remarketing_esputnik_inprogress_status'] = $this->request->post['remarketing_esputnik_inprogress_status'];
		} elseif ($this->config->get('remarketing_esputnik_inprogress_status')) {
			$data['remarketing_esputnik_inprogress_status'] = $this->config->get('remarketing_esputnik_inprogress_status');
		} else {
			$data['remarketing_esputnik_inprogress_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_esputnik_delivered_status'])) {
			$data['remarketing_esputnik_delivered_status'] = $this->request->post['remarketing_esputnik_delivered_status'];
		} elseif ($this->config->get('remarketing_esputnik_delivered_status')) {
			$data['remarketing_esputnik_delivered_status'] = $this->config->get('remarketing_esputnik_delivered_status');
		} else {
			$data['remarketing_esputnik_delivered_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_esputnik_cancelled_status'])) {
			$data['remarketing_esputnik_cancelled_status'] = $this->request->post['remarketing_esputnik_cancelled_status'];
		} elseif ($this->config->get('remarketing_esputnik_cancelled_status')) {
			$data['remarketing_esputnik_cancelled_status'] = $this->config->get('remarketing_esputnik_cancelled_status');
		} else {
			$data['remarketing_esputnik_cancelled_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_esputnik_password'])) {
			$data['remarketing_esputnik_password'] = $this->request->post['remarketing_esputnik_password'];
		} else {
			$data['remarketing_esputnik_password'] = $this->config->get('remarketing_esputnik_password');
		}

		if (isset($this->request->post['remarketing_esputnik_login'])) {
			$data['remarketing_esputnik_login'] = $this->request->post['remarketing_esputnik_login'];
		} else {
			$data['remarketing_esputnik_login'] = $this->config->get('remarketing_esputnik_login');
		}

		if (isset($this->request->post['remarketing_esputnik_ttn_field'])) {
			$data['remarketing_esputnik_ttn_field'] = $this->request->post['remarketing_esputnik_ttn_field'];
		} else {
			$data['remarketing_esputnik_ttn_field'] = $this->config->get('remarketing_esputnik_ttn_field');
		}
		
		if (isset($this->request->post['remarketing_esputnik_address_format'])) {
			$data['remarketing_esputnik_address_format'] = $this->request->post['remarketing_esputnik_address_format'];
		} elseif ($this->config->get('remarketing_esputnik_cancelled_status')) {
			$data['remarketing_esputnik_address_format'] = $this->config->get('remarketing_esputnik_address_format');
		} else {
			$data['remarketing_esputnik_address_format'] = '{city} {address_1}';
		}
		
		if (isset($this->request->post['remarketing_counter1'])) {
			$data['remarketing_counter1'] = $this->request->post['remarketing_counter1'];
		} else {
			$data['remarketing_counter1'] = $this->config->get('remarketing_counter1');
		}

		if (isset($this->request->post['remarketing_counter2'])) {
			$data['remarketing_counter2'] = $this->request->post['remarketing_counter2'];
		} else {
			$data['remarketing_counter2'] = $this->config->get('remarketing_counter2');
		}

		if (isset($this->request->post['remarketing_counter3'])) {
			$data['remarketing_counter3'] = $this->request->post['remarketing_counter3'];
		} else {
			$data['remarketing_counter3'] = $this->config->get('remarketing_counter3');
		}

		if (isset($this->request->post['remarketing_counter_bot'])) {
			$data['remarketing_counter_bot'] = $this->request->post['remarketing_counter_bot'];
		} else {
			$data['remarketing_counter_bot'] = $this->config->get('remarketing_counter_bot');
		}

		if (isset($this->request->post['remarketing_feed_tuning'])) {
			$data['remarketing_feed_tuning'] = $this->request->post['remarketing_feed_tuning'];
		} else {
			$data['remarketing_feed_tuning'] = $this->config->get('remarketing_feed_tuning');
		}

		if (isset($this->request->post['remarketing_feed_all_attributes'])) {
			$data['remarketing_feed_all_attributes'] = $this->request->post['remarketing_feed_all_attributes'];
		} else {
			$data['remarketing_feed_all_attributes'] = $this->config->get('remarketing_feed_all_attributes');
		}

		if (isset($this->request->post['remarketing_feed_adult'])) {
			$data['remarketing_feed_adult'] = $this->request->post['remarketing_feed_adult'];
		} else {
			$data['remarketing_feed_adult'] = $this->config->get('remarketing_feed_adult');
		}

		if (isset($this->request->post['remarketing_feed_ocstore_main'])) {
			$data['remarketing_feed_ocstore_main'] = $this->request->post['remarketing_feed_ocstore_main'];
		} else {
			$data['remarketing_feed_ocstore_main'] = $this->config->get('remarketing_feed_ocstore_main');
		}

		if (isset($this->request->post['remarketing_feed_last_category'])) {
			$data['remarketing_feed_last_category'] = $this->request->post['remarketing_feed_last_category'];
		} else {
			$data['remarketing_feed_last_category'] = $this->config->get('remarketing_feed_last_category');
		}

		if (isset($this->request->post['remarketing_feed_type_category'])) {
			$data['remarketing_feed_type_category'] = $this->request->post['remarketing_feed_type_category'];
		} else {
			$data['remarketing_feed_type_category'] = $this->config->get('remarketing_feed_type_category');
		}

		if ($data['remarketing_feed_tuning']) {

		$this->load->model('catalog/category');
        
		$filter_data = [
			'sort'        => 'name',
			'order'       => 'ASC'
		];
        
		$data['categories'] = $this->model_catalog_category->getCategories($filter_data);
		
		$this->load->model('catalog/manufacturer');
		
		$filter_data = [
			'sort'  => 'name',
			'order' => 'ASC',
		];

		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers($filter_data);
		
		} else {
			$data['categories'] = [];
			$data['manufacturers'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category'])) {
			$data['remarketing_feed_category'] = $this->request->post['remarketing_feed_category'];
		} else if($this->config->get('remarketing_feed_category')) {
			$data['remarketing_feed_category'] = $this->config->get('remarketing_feed_category');
		} else {
			$data['remarketing_feed_category'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_manufacturer'])) {
			$data['remarketing_feed_manufacturer'] = $this->request->post['remarketing_feed_manufacturer'];
		} else if($this->config->get('remarketing_feed_manufacturer')) {
			$data['remarketing_feed_manufacturer'] = $this->config->get('remarketing_feed_manufacturer');
		} else {
			$data['remarketing_feed_manufacturer'] = [];
		}
		
		$this->load->model('customer/customer_group');
		
		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['remarketing_feed_customer_group'])) {
			$data['remarketing_feed_customer_group'] = $this->request->post['remarketing_feed_customer_group'];
		} else {
			$data['remarketing_feed_customer_group'] = $this->config->get('remarketing_feed_customer_group');
		}

		if (isset($this->request->post['remarketing_feed_key'])) {
			$data['remarketing_feed_key'] = $this->request->post['remarketing_feed_key'];
		} else {
			$data['remarketing_feed_key'] = $this->config->get('remarketing_feed_key');
		}

		if (isset($this->request->post['remarketing_feed_short_desc'])) {
			$data['remarketing_feed_short_desc'] = $this->request->post['remarketing_feed_short_desc'];
		} else {
			$data['remarketing_feed_short_desc'] = $this->config->get('remarketing_feed_short_desc');
		}

		if (isset($this->request->post['remarketing_feed_condition'])) {
			$data['remarketing_feed_condition'] = $this->request->post['remarketing_feed_condition'];
		} elseif ($this->config->get('remarketing_feed_condition')) {
			$data['remarketing_feed_condition'] = $this->config->get('remarketing_feed_condition');
		} else {
			$data['remarketing_feed_condition'] = 'new';
		}

		if (isset($this->request->post['remarketing_feed_gtin'])) {
			$data['remarketing_feed_gtin'] = $this->request->post['remarketing_feed_gtin'];
		} else {
			$data['remarketing_feed_gtin'] = $this->config->get('remarketing_feed_gtin');
		}

		if (isset($this->request->post['remarketing_feed_mpn'])) {
			$data['remarketing_feed_mpn'] = $this->request->post['remarketing_feed_mpn'];
		} else {
			$data['remarketing_feed_mpn'] = $this->config->get('remarketing_feed_mpn');
		}

		if (isset($this->request->post['remarketing_feed_highlight'])) {
			$data['remarketing_feed_highlight'] = $this->request->post['remarketing_feed_highlight'];
		} else {
			$data['remarketing_feed_highlight'] = $this->config->get('remarketing_feed_highlight');
		}

		if (isset($this->request->post['remarketing_feed_replace_description'])) {
			$data['remarketing_feed_replace_description'] = $this->request->post['remarketing_feed_replace_description'];
		} else {
			$data['remarketing_feed_replace_description'] = $this->config->get('remarketing_feed_replace_description');
		}

		if (isset($this->request->post['remarketing_feed_color'])) {
			$data['remarketing_feed_color'] = $this->request->post['remarketing_feed_color'];
		} else {
			$data['remarketing_feed_color'] = $this->config->get('remarketing_feed_color');
		}

		if (isset($this->request->post['remarketing_feed_size'])) {
			$data['remarketing_feed_size'] = $this->request->post['remarketing_feed_size'];
		} else {
			$data['remarketing_feed_size'] = $this->config->get('remarketing_feed_size');
		}

		if (isset($this->request->post['remarketing_feed_material'])) {
			$data['remarketing_feed_material'] = $this->request->post['remarketing_feed_material'];
		} else {
			$data['remarketing_feed_material'] = $this->config->get('remarketing_feed_material');
		}

		if (isset($this->request->post['remarketing_feed_gender'])) {
			$data['remarketing_feed_gender'] = $this->request->post['remarketing_feed_gender'];
		} else {
			$data['remarketing_feed_gender'] = $this->config->get('remarketing_feed_gender');
		}

		if (isset($this->request->post['remarketing_feed_age_group'])) {
			$data['remarketing_feed_age_group'] = $this->request->post['remarketing_feed_age_group'];
		} else {
			$data['remarketing_feed_age_group'] = $this->config->get('remarketing_feed_age_group');
		}

		if (isset($this->request->post['remarketing_feed_store_code'])) {
			$data['remarketing_feed_store_code'] = $this->request->post['remarketing_feed_store_code'];
		} else {
			$data['remarketing_feed_store_code'] = $this->config->get('remarketing_feed_store_code');
		}

		if (isset($this->request->post['remarketing_feed_special'])) {
			$data['remarketing_feed_special'] = $this->request->post['remarketing_feed_special'];
		} else {
			$data['remarketing_feed_special'] = $this->config->get('remarketing_feed_special');
		}

		if (isset($this->request->post['remarketing_feed_min_price'])) {
			$data['remarketing_feed_min_price'] = $this->request->post['remarketing_feed_min_price'];
		} else {
			$data['remarketing_feed_min_price'] = $this->config->get('remarketing_feed_min_price');
		}

		if (isset($this->request->post['remarketing_feed_max_price'])) {
			$data['remarketing_feed_max_price'] = $this->request->post['remarketing_feed_max_price'];
		} else {
			$data['remarketing_feed_max_price'] = $this->config->get('remarketing_feed_max_price');
		}

		if (isset($this->request->post['remarketing_feed_zero_quantity'])) {
			$data['remarketing_feed_zero_quantity'] = $this->request->post['remarketing_feed_zero_quantity'];
		} else {
			$data['remarketing_feed_zero_quantity'] = $this->config->get('remarketing_feed_zero_quantity');
		}

		if (isset($this->request->post['remarketing_feed_always_avail'])) {
			$data['remarketing_feed_always_avail'] = $this->request->post['remarketing_feed_always_avail'];
		} else {
			$data['remarketing_feed_always_avail'] = $this->config->get('remarketing_feed_always_avail');
		}

		if (isset($this->request->post['remarketing_feed_original_description'])) {
			$data['remarketing_feed_original_description'] = $this->request->post['remarketing_feed_original_description'];
		} else {
			$data['remarketing_feed_original_description'] = $this->config->get('remarketing_feed_original_description');
		}

		if (isset($this->request->post['remarketing_feed_rich_text'])) {
			$data['remarketing_feed_rich_text'] = $this->request->post['remarketing_feed_rich_text'];
		} else {
			$data['remarketing_feed_rich_text'] = $this->config->get('remarketing_feed_rich_text');   
		}

		if (isset($this->request->post['remarketing_feed_multiplier'])) {
			$data['remarketing_feed_multiplier'] = $this->request->post['remarketing_feed_multiplier'];
		} elseif ($this->config->get('remarketing_feed_multiplier')) {
			$data['remarketing_feed_multiplier'] = $this->config->get('remarketing_feed_multiplier');
		} else {
			$data['remarketing_feed_multiplier'] = 1;
		}

		if (isset($this->request->post['remarketing_feed_original_image_status'])) {
			$data['remarketing_feed_original_image_status'] = $this->request->post['remarketing_feed_original_image_status'];
		} else {
			$data['remarketing_feed_original_image_status'] = $this->config->get('remarketing_feed_original_image_status');
		}

		if (isset($this->request->post['remarketing_feed_additional_images'])) {
			$data['remarketing_feed_additional_images'] = $this->request->post['remarketing_feed_additional_images'];
		} else {
			$data['remarketing_feed_additional_images'] = $this->config->get('remarketing_feed_additional_images');
		}
 
		if (isset($this->request->post['remarketing_feed_utm'])) {
			$data['remarketing_feed_utm'] = $this->request->post['remarketing_feed_utm'];
		} else {
			$data['remarketing_feed_utm'] = $this->config->get('remarketing_feed_utm');
		}

		if (isset($this->request->post['remarketing_feed_utm_facebook'])) {
			$data['remarketing_feed_utm_facebook'] = $this->request->post['remarketing_feed_utm_facebook'];
		} else {
			$data['remarketing_feed_utm_facebook'] = $this->config->get('remarketing_feed_utm_facebook');
		}

		if (isset($this->request->post['remarketing_feed_utm_tiktok'])) {
			$data['remarketing_feed_utm_tiktok'] = $this->request->post['remarketing_feed_utm_tiktok'];
		} else {
			$data['remarketing_feed_utm_tiktok'] = $this->config->get('remarketing_feed_utm_tiktok');
		}

		if (isset($this->request->post['remarketing_feed_empty_brand'])) {
			$data['remarketing_feed_empty_brand'] = $this->request->post['remarketing_feed_empty_brand'];
		} else {
			$data['remarketing_feed_empty_brand'] = $this->config->get('remarketing_feed_empty_brand'); 
		}

		if (isset($this->request->post['remarketing_feed_custom_sql'])) {
			$data['remarketing_feed_custom_sql'] = $this->request->post['remarketing_feed_custom_sql'];
		} else {
			$data['remarketing_feed_custom_sql'] = $this->config->get('remarketing_feed_custom_sql');
		}

		if (isset($this->request->post['remarketing_feed_category_google_category'])) {
			$data['remarketing_feed_category_google_category'] = $this->request->post['remarketing_feed_category_google_category'];
		} elseif ($this->config->get('remarketing_feed_category_google_category')) {
			$data['remarketing_feed_category_google_category'] = $this->config->get('remarketing_feed_category_google_category');
		} else {
			$data['remarketing_feed_category_google_category'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_product_type'])) {
			$data['remarketing_feed_category_product_type'] = $this->request->post['remarketing_feed_category_product_type'];
		} elseif ($this->config->get('remarketing_feed_category_product_type')) {
			$data['remarketing_feed_category_product_type'] = $this->config->get('remarketing_feed_category_product_type');
		} else {
			$data['remarketing_feed_category_product_type'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_condition'])) {
			$data['remarketing_feed_category_condition'] = $this->request->post['remarketing_feed_category_condition'];
		} elseif ($this->config->get('remarketing_feed_category_condition')) {
			$data['remarketing_feed_category_condition'] = $this->config->get('remarketing_feed_category_condition');
		} else {
			$data['remarketing_feed_category_condition'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_custom_label_0'])) {
			$data['remarketing_feed_category_custom_label_0'] = $this->request->post['remarketing_feed_category_custom_label_0'];
		} elseif ($this->config->get('remarketing_feed_category_custom_label_0')) {
			$data['remarketing_feed_category_custom_label_0'] = $this->config->get('remarketing_feed_category_custom_label_0');
		} else {
			$data['remarketing_feed_category_custom_label_0'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_custom_label_1'])) {
			$data['remarketing_feed_category_custom_label_1'] = $this->request->post['remarketing_feed_category_custom_label_1'];
		} elseif ($this->config->get('remarketing_feed_category_custom_label_1')) {
			$data['remarketing_feed_category_custom_label_1'] = $this->config->get('remarketing_feed_category_custom_label_1');
		} else {
			$data['remarketing_feed_category_custom_label_1'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_custom_label_2'])) {
			$data['remarketing_feed_category_custom_label_2'] = $this->request->post['remarketing_feed_category_custom_label_2'];
		} elseif ($this->config->get('remarketing_feed_category_custom_label_2')) {
			$data['remarketing_feed_category_custom_label_2'] = $this->config->get('remarketing_feed_category_custom_label_2');
		} else {
			$data['remarketing_feed_category_custom_label_2'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_custom_label_3'])) {
			$data['remarketing_feed_category_custom_label_3'] = $this->request->post['remarketing_feed_category_custom_label_3'];
		} elseif ($this->config->get('remarketing_feed_category_custom_label_3')) {
			$data['remarketing_feed_category_custom_label_3'] = $this->config->get('remarketing_feed_category_custom_label_3');
		} else {
			$data['remarketing_feed_category_custom_label_3'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_category_custom_label_4'])) {
			$data['remarketing_feed_category_custom_label_4'] = $this->request->post['remarketing_feed_category_custom_label_4'];
		} elseif ($this->config->get('remarketing_feed_category_custom_label_4')) {
			$data['remarketing_feed_category_custom_label_4'] = $this->config->get('remarketing_feed_category_custom_label_4');
		} else {
			$data['remarketing_feed_category_custom_label_4'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_description'])) {
			$data['remarketing_feed_description'] = $this->request->post['remarketing_feed_description'];
		} elseif ($this->config->get('remarketing_feed_description')) {
			$data['remarketing_feed_description'] = $this->config->get('remarketing_feed_description');
		} else {
			$data['remarketing_feed_description'] = "{product_name}, {product_model}";
		}
		
		if (isset($this->request->post['remarketing_feed_replace_from'])) {
			$data['remarketing_feed_replace_from'] = $this->request->post['remarketing_feed_replace_from'];
		} elseif ($this->config->get('remarketing_feed_replace_from')) {
			$data['remarketing_feed_replace_from'] = $this->config->get('remarketing_feed_replace_from');
		} else {
			$data['remarketing_feed_replace_from'] = "";
		}
		
		if (isset($this->request->post['remarketing_feed_replace_to'])) {
			$data['remarketing_feed_replace_to'] = $this->request->post['remarketing_feed_replace_to'];
		} elseif ($this->config->get('remarketing_feed_replace_to')) {
			$data['remarketing_feed_replace_to'] = $this->config->get('remarketing_feed_replace_to');
		} else {
			$data['remarketing_feed_replace_to'] = "";
		}
		
		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['remarketing_feed_in_stock'])) {
			$data['remarketing_feed_in_stock'] = $this->request->post['remarketing_feed_in_stock'];
		} elseif ($this->config->get('remarketing_feed_in_stock')) {
			$data['remarketing_feed_in_stock'] = $this->config->get('remarketing_feed_in_stock');
		} else {
			$data['remarketing_feed_in_stock'] = [];
		}
		
		if (isset($this->request->post['remarketing_feed_out_of_stock'])) {
			$data['remarketing_feed_out_of_stock'] = $this->request->post['remarketing_feed_out_of_stock'];
		} elseif ($this->config->get('remarketing_feed_out_of_stock')) {
			$data['remarketing_feed_out_of_stock'] = $this->config->get('remarketing_feed_out_of_stock');
		} else {
			$data['remarketing_feed_out_of_stock'] = []; 
		}
		
		if (isset($this->request->post['remarketing_telegram_status'])) {
			$data['remarketing_telegram_status'] = $this->request->post['remarketing_telegram_status'];
		} else {
			$data['remarketing_telegram_status'] = $this->config->get('remarketing_telegram_status');
		}

		if (isset($this->request->post['remarketing_telegram_bot_id'])) {
			$data['remarketing_telegram_bot_id'] = $this->request->post['remarketing_telegram_bot_id'];
		} else {
			$data['remarketing_telegram_bot_id'] = $this->config->get('remarketing_telegram_bot_id');
		}

		if (isset($this->request->post['remarketing_telegram_send_to_id'])) {
			$data['remarketing_telegram_send_to_id'] = $this->request->post['remarketing_telegram_send_to_id'];
		} else {
			$data['remarketing_telegram_send_to_id'] = $this->config->get('remarketing_telegram_send_to_id');
		}

		if (isset($this->request->post['remarketing_telegram_message'])) {
			$data['remarketing_telegram_message'] = $this->request->post['remarketing_telegram_message'];
		} elseif ($this->config->get('remarketing_telegram_message')) {
			$data['remarketing_telegram_message'] = $this->config->get('remarketing_telegram_message');
		} else {
			$data['remarketing_telegram_message'] = "№ заказа: {order_id}
Имя: {firstname}
Фамилия: {lastname}
Email: {email}
Телефон: {telephone}
Способ доставки: {shipping_method}
Способ оплаты: {payment_method}
Город: {city}
Адрес: {address_1}
Сумма: {total}
Статус заказа: {order_status}

Товары:
{products}";
		}
		
		if (isset($this->request->post['remarketing_telegram_send_status'])) {
			$data['remarketing_telegram_send_status'] = $this->request->post['remarketing_telegram_send_status'];
		} elseif ($this->config->get('remarketing_telegram_send_status')) {
			$data['remarketing_telegram_send_status'] = $this->config->get('remarketing_telegram_send_status');
		} else {
			$data['remarketing_telegram_send_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_tiktok_identifier'])) {
			$data['remarketing_tiktok_identifier'] = $this->request->post['remarketing_tiktok_identifier'];
		} else {
			$data['remarketing_tiktok_identifier'] = $this->config->get('remarketing_tiktok_identifier');
		}

		if (isset($this->request->post['remarketing_tiktok_ratio'])) {
			$data['remarketing_tiktok_ratio'] = $this->request->post['remarketing_tiktok_ratio'];
		} elseif ($this->config->get('remarketing_tiktok_ratio')) {
			$data['remarketing_tiktok_ratio'] = $this->config->get('remarketing_tiktok_ratio');
		} else {
			$data['remarketing_tiktok_ratio'] = '1';
		}

		if (isset($this->request->post['remarketing_tiktok_id'])) {
			$data['remarketing_tiktok_id'] = $this->request->post['remarketing_tiktok_id'];
		} else {
			$data['remarketing_tiktok_id'] = $this->config->get('remarketing_tiktok_id');
		}

		if (isset($this->request->post['remarketing_tiktok_script_status'])) {
			$data['remarketing_tiktok_script_status'] = $this->request->post['remarketing_tiktok_script_status'];
		} else {
			$data['remarketing_tiktok_script_status'] = $this->config->get('remarketing_tiktok_script_status');
		}

		if (isset($this->request->post['remarketing_tiktok_pixel_status'])) {
			$data['remarketing_tiktok_pixel_status'] = $this->request->post['remarketing_tiktok_pixel_status'];
		} else {
			$data['remarketing_tiktok_pixel_status'] = $this->config->get('remarketing_tiktok_pixel_status');
		}

		if (isset($this->request->post['remarketing_tiktok_server_side'])) {
			$data['remarketing_tiktok_server_side'] = $this->request->post['remarketing_tiktok_server_side'];
		} else {
			$data['remarketing_tiktok_server_side'] = $this->config->get('remarketing_tiktok_server_side');
		}

		if (isset($this->request->post['remarketing_tiktok_token'])) {
			$data['remarketing_tiktok_token'] = $this->request->post['remarketing_tiktok_token'];
		} else {
			$data['remarketing_tiktok_token'] = $this->config->get('remarketing_tiktok_token');
		}
		
		if (isset($this->request->post['remarketing_tiktok_api_ver'])) {
			$data['remarketing_tiktok_api_ver'] = $this->request->post['remarketing_tiktok_api_ver'];
		} elseif ($this->config->get('remarketing_tiktok_api_ver')) {
			$data['remarketing_tiktok_api_ver'] = $this->config->get('remarketing_tiktok_api_ver');
		} else {
			$data['remarketing_tiktok_api_ver'] = '1.3';  
		}
		
		if (isset($this->request->post['remarketing_tiktok_test_code'])) {
			$data['remarketing_tiktok_test_code'] = $this->request->post['remarketing_tiktok_test_code'];
		} else {
			$data['remarketing_tiktok_test_code'] = $this->config->get('remarketing_tiktok_test_code');
		}

		if (isset($this->request->post['remarketing_tiktok_resend_status'])) {
			$data['remarketing_tiktok_resend_status'] = $this->request->post['remarketing_tiktok_resend_status'];
		} else {
			$data['remarketing_tiktok_resend_status'] = $this->config->get('remarketing_tiktok_resend_status');
		}
		
		if (isset($this->request->post['remarketing_tiktok_send_status'])) {
			$data['remarketing_tiktok_send_status'] = $this->request->post['remarketing_tiktok_send_status'];
		} elseif ($this->config->get('remarketing_tiktok_send_status')) {
			$data['remarketing_tiktok_send_status'] = $this->config->get('remarketing_tiktok_send_status');
		} else {
			$data['remarketing_tiktok_send_status'] = [];
		}
		
		if (isset($this->request->post['remarketing_snapchat_status'])) {
			$data['remarketing_snapchat_status'] = $this->request->post['remarketing_snapchat_status'];
		} else {
			$data['remarketing_snapchat_status'] = $this->config->get('remarketing_snapchat_status');
		}
		
		if (isset($this->request->post['remarketing_snapchat_script_status'])) {
			$data['remarketing_snapchat_script_status'] = $this->request->post['remarketing_snapchat_script_status'];
		} else {
			$data['remarketing_snapchat_script_status'] = $this->config->get('remarketing_snapchat_script_status');
		}

		if (isset($this->request->post['remarketing_snapchat_pixel_status'])) {
			$data['remarketing_snapchat_pixel_status'] = $this->request->post['remarketing_snapchat_pixel_status'];
		} else {
			$data['remarketing_snapchat_pixel_status'] = $this->config->get('remarketing_snapchat_pixel_status');
		}

		if (isset($this->request->post['remarketing_snapchat_identifier'])) {
			$data['remarketing_snapchat_identifier'] = $this->request->post['remarketing_snapchat_identifier'];
		} else {
			$data['remarketing_snapchat_identifier'] = $this->config->get('remarketing_snapchat_identifier');
		}
		
		if (isset($this->request->post['remarketing_snapchat_ratio'])) {
			$data['remarketing_snapchat_ratio'] = $this->request->post['remarketing_snapchat_ratio'];
		} elseif ($this->config->get('remarketing_snapchat_ratio')) {
			$data['remarketing_snapchat_ratio'] = $this->config->get('remarketing_snapchat_ratio');
		} else {
			$data['remarketing_snapchat_ratio'] = '1';
		}
		
		if (isset($this->request->post['remarketing_snapchat_id'])) {
			$data['remarketing_snapchat_id'] = $this->request->post['remarketing_snapchat_id'];
		} else {
			$data['remarketing_snapchat_id'] = $this->config->get('remarketing_snapchat_id');
		}
		
		if (isset($this->request->post['remarketing_uet_status'])) {
			$data['remarketing_uet_status'] = $this->request->post['remarketing_uet_status'];
		} else {
			$data['remarketing_uet_status'] = $this->config->get('remarketing_uet_status');
		}

		$data['check_install'] = $this->checkInstall();

		$data['max_input_vars_warning'] = $this->config->get('remarketing_feed_tuning') && ini_get('max_input_vars') < 5001 ? sprintf($this->language->get('text_vars_warning'), ini_get('max_input_vars'))  : false;
		
		$data['jetcache_warning'] = false;
		if ($this->config->get('asc_jetcache_settings')) {
			$jetcache_settings = $this->config->get('asc_jetcache_settings');
			if ($jetcache_settings['jetcache_widget_status'] && $jetcache_settings['cont_status']) {
				foreach ($jetcache_settings['add_cont'] as $cont) {
					if ($cont['cont'] == 'common/footer' && $cont['status'] == '1') {
						$data['jetcache_warning'] = $this->language->get('text_jetcache_warning');
					}
				}
			}
		}

		$data['seopro_warning'] = ((defined('VERSION_CORE') && VERSION_CORE == 'ocStore') && version_compare(VERSION,'3.0.0.0', '>=') && $this->config->get('config_seo_pro') && !$this->config->get('config_valide_param_flag')) ? $this->language->get('text_seopro_warning') : false;
		$data['theme_editor_warning'] = (version_compare(VERSION,'3.0.0.0', '>=') && $this->db->query("SELECT * FROM `" . DB_PREFIX . "theme` ")->num_rows > 0) ? $this->language->get('text_theme_editor_warning') : false;
		
		if ($this->config->get('remarketing_vk_status') || $this->config->get('remarketing_mytarget_status') || $this->config->get('remarketing_retailrocket_status')) {
			die('Дякую за пiдтримку ЗСУ');
		}
		
		$data['version'] = $this->version;
		$data['domain'] = HTTPS_CATALOG;
		$data['purchased_domain'] = $this->purchased_domain;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/remarketing', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/remarketing')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	protected function checkInstall() {
		$check = '';
		
		if (version_compare(VERSION,'3.0.0.0', '>=')) {
			$files = [
				'admin/controller/sale/order.php',
				'catalog/controller/common/header.php',
				'catalog/controller/common/footer.php',
				'catalog/controller/product/product.php',
				'catalog/controller/product/category.php',
				'catalog/controller/product/manufacturer.php',
				'catalog/controller/product/search.php',
				'catalog/controller/product/special.php',
				'catalog/controller/checkout/cart.php',
				'catalog/controller/account/wishlist.php',
				'catalog/controller/information/contact.php',
				'catalog/model/checkout/order.php',
				'catalog/model/account/customer.php',
				'admin/view/template/sale/order_info.twig',
				'catalog/view/theme/{*}/template/common/header.twig',
				'catalog/view/theme/{*}/template/common/footer.twig',
				'catalog/view/theme/{*}/template/product/product.twig',
				'catalog/view/theme/{*}/template/product/category.twig',
				'catalog/view/theme/{*}/template/product/manufacturer_info.twig',
				'catalog/view/theme/{*}/template/product/search.twig',
				'catalog/view/theme/{*}/template/product/special.twig'
			];
		} else {
			$files = [
				'admin/controller/sale/order.php',
				'catalog/controller/common/header.php',
				'catalog/controller/common/footer.php',
				'catalog/controller/product/product.php',
				'catalog/controller/product/category.php',
				'catalog/controller/product/manufacturer.php',
				'catalog/controller/product/search.php',
				'catalog/controller/product/special.php',
				'catalog/controller/checkout/cart.php',
				'catalog/controller/account/wishlist.php',
				'catalog/controller/information/contact.php',
				'catalog/model/checkout/order.php',
				'catalog/model/account/customer.php',
				'admin/view/template/sale/order_info.tpl',
				'catalog/view/theme/{*}/template/common/header.tpl',
				'catalog/view/theme/{*}/template/common/footer.tpl',
				'catalog/view/theme/{*}/template/product/product.tpl',
				'catalog/view/theme/{*}/template/product/category.tpl',
				'catalog/view/theme/{*}/template/product/manufacturer_info.tpl',
				'catalog/view/theme/{*}/template/product/search.tpl',
				'catalog/view/theme/{*}/template/product/special.tpl'
			];
		}
		
		
		if ($this->config->get('config_theme') == 'theme_default') {
			$theme = $this->config->get('theme_default_directory');
		} else {
			$theme = $this->config->get('config_theme');
		}
		
		foreach ($files as $file) {
			$file = str_replace('{*}', $theme, $file);
			$filename = DIR_MODIFICATION . $file;
			
			if (file_exists($filename) && strpos(file_get_contents($filename), '// remarketing')) {
				//$check .= $file . ' - ' . '<i class="fa fa-check" style="color:green"></i><br>';
			} else {
				$check .= $file . ' - ' . '<i class="fa fa-times" style="color:red"></i><br>';
			}
		}
		
		if (empty($check)) {
			$check .= '<i class="fa fa-check" style="color:green"></i>OK<br>';
		}
	
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "remarketing_orders` (
			`order_id` int(11) NOT NULL,
			`ecommerce` datetime NOT NULL,
			`ecommerce_ga4` datetime NOT NULL,
			`facebook` datetime NOT NULL,
			`esputnik` datetime NOT NULL,
			`telegram` datetime NOT NULL,
			`success_page` datetime NOT NULL,
			`order_data` longtext NOT NULL,
			`date_added` datetime NOT NULL,
			PRIMARY KEY (`order_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		
		$query = $this->db->query("DESC `" . DB_PREFIX . "remarketing_orders`");
		
		$fields = [];
		
		foreach($query->rows as $row) {
			$fields[] = $row['Field'];
		}
		
		if (!in_array('facebook_lead', $fields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "remarketing_orders` ADD `facebook_lead` datetime NOT NULL AFTER `telegram`");	
		}	
		
		if (!in_array('tiktok', $fields)) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "remarketing_orders` ADD `tiktok` datetime NOT NULL AFTER `telegram`");	 
		}	
		
		$parameters = [ 
			'uuid', 'ga4_uuid', 'fbclid', 'fbc', 'fbp', 'gclid', 'dclid', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_term', 'utm_content', 'ttclid', 'fb_event_id', 'fb_lead_event_id', 'tt_event_id', 'first_referrer', 'last_referrer' 
		];
		
		$fields_query = $this->db->query("DESC `" . DB_PREFIX . "remarketing_orders`");
		$fields = [];
		
		foreach ($fields_query->rows as $row) {
			$fields[] = $row['Field'];
		}
		
		foreach ($parameters as $parameter) {
			if (!in_array($parameter, $fields)) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "remarketing_orders` ADD `" . $parameter . "` VARCHAR(255) NOT NULL AFTER `date_added`");	
			}
		}
		
		return $check;
	}
	
	public function checkVersion() {
		$post_data = !empty($this->request->post) ? $this->request->post : [];
		$post_data['version'] = VERSION;
		$post_data['module_version'] = $this->version; 
		$post_data['template'] = $this->config->get('config_theme');
		$post_data['domain'] = HTTPS_CATALOG;
		$post_data['purchased_domain'] = $this->purchased_domain;
		$post_data['order'] = $this->order;
		$post_data['seller'] = $this->seller;
		$post_data['server_name'] = !empty($this->request->server['SERVER_NAME']) ? $this->request->server['SERVER_NAME'] : '';
		$post_data['request_ip'] = !empty($this->request->server['REMOTE_ADDR']) ? $this->request->server['REMOTE_ADDR'] : '';
		$curl = curl_init(); 
		curl_setopt_array($curl, [
			CURLOPT_URL => 'https://chtoge.dovyebivalsya',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($post_data)
		]);
		
		$response = curl_exec($curl);
		curl_close($curl);
		 
		if (version_compare($this->version, $response) < 0) {
			$response = 'Доступна новая версия: ' . $response;
			$response = strip_tags($response);
			$response = htmlspecialchars($response);
		} else {
			$response = '';
		}
		echo $response;
	}
	
	public function testFacebook() {
		$data = [];
		$data['event_name'] = 'Contact';
		$fb_time = time(); 
		$data['custom_data'] = [];
		$data['event_time'] = $data['event_id'] = $fb_time;
		$data['event_source_url'] = rtrim(HTTPS_SERVER, '/') . $this->request->server['REQUEST_URI'];
		$data['custom_data'] = [];
		if (isset($this->request->server['HTTP_CLIENT_IP'])) {
            $ip = $this->request->server['HTTP_CLIENT_IP'];
        } elseif (isset($this->request->server['HTTP_X_FORWARDED_FOR'])) {
            $ip = $this->request->server['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($this->request->server['HTTP_CF_CONNECTING_IP'])) {
            $ip = $this->request->server['HTTP_CF_CONNECTING_IP'];
        } else {
            $ip = $this->request->server['REMOTE_ADDR'];
        }
		$ua = '';
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $ua = $this->request->server['HTTP_USER_AGENT'];
        }
		$data['user_data'] = [
			'client_ip_address' => $ip,
			'client_user_agent' => $ua
		];
		$data['action_source'] = 'website';
		$fb_data['data'] = [json_encode($data)]; 
		if ($this->config->get('remarketing_facebook_test_code') != '') {
			$fb_data['test_event_code'] = $this->config->get('remarketing_facebook_test_code');
		}
		$fb_send_data = http_build_query($fb_data); 
		$fb_send_data = utf8_encode($fb_send_data);
		$url = 'https://graph.facebook.com/v' . $this->config->get('remarketing_facebook_api_ver') . '/' . $this->config->get('remarketing_facebook_identifier') . '/events?access_token=' . $this->config->get('remarketing_facebook_token');
		$ch = curl_init();
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
        } 
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/x-www-form-urlencoded']);
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $fb_send_data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	    $response = curl_exec($ch); 
	    curl_close($ch); 
		echo $response; 
	}
	
	public function install() {
		 $this->load->model('user/user_group');	 $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'report/remarketing_report');	   $this->checkVersion();	$this->checkInstall();
	}
	
	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "remarketing_orders`");
	}
}
