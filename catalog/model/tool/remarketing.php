<?php
class ModelToolRemarketing extends Model {
	
	public function getRemarketingHeader() { 
		$output = ''; 
		if (!$this->isBot()) {
			if ($this->config->get('remarketing_counter1')) {
				$output .= "\n" . $this->config->get('remarketing_counter1');
			} 
			
			if ($this->customer->isLogged()) {
				if ($this->config->get('remarketing_ecommerce_status')) {
					$output .= "\n<script>window.dataLayer = window.dataLayer || []; dataLayer.push({'GA4_user_id':  '" . $this->customer->isLogged() . "'});</script>\n";
				}
				if ($this->config->get('remarketing_ecommerce_ga4_status')) {
					$output .= "\n<script>if (typeof gtag != 'undefined') { gtag('set', 'user_id', '" . $this->customer->isLogged() . "') };</script>\n";
				}
			} 
			
			if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_script_status') && $this->config->get('remarketing_facebook_identifier')) {
				$output .= "\n" . '<!-- Facebook Pixel Code -->' . "\n";
				$output .= '<script>' . "\n";
				$output .= '!function(f,b,e,v,n,t,s)';
				$output .= '{if(f.fbq)return;n=f.fbq=function(){n.callMethod?';
				$output .= 'n.callMethod.apply(n,arguments):n.queue.push(arguments)};';
				$output .= 'if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\'2.0\';';
				$output .= 'n.queue=[];t=b.createElement(e);t.async=!0;';
				$output .= 't.src=v;s=b.getElementsByTagName(e)[0];';
				$output .= 's.parentNode.insertBefore(t,s)}(window, document,\'script\',';
				$output .= '\'https://connect.facebook.net/en_US/fbevents.js\');' . "\n";
				$parameters = [];
				if ($this->customer->isLogged()) {
					$email = $this->customer->getEmail();
					$firstname = $this->customer->getFirstName();
					$lastname = $this->customer->getLastName();
					$telephone = $this->customer->getTelephone();
					if (!empty($email)) {
						$parameters[] = "em: '" . $email . "'";
						$parameters[] = "external_id: '" . $email . "'";
					}
					if (!empty($firstname)) {
						$parameters[] = "fn: '" . $firstname . "'";
					}
					if (!empty($lastname)) {
						$parameters[] = "ln: '" . $lastname . "'";
					}
					if (!empty($telephone)) {
						$parameters[] = "ph: '" . $telephone . "'";
					}
				}
				$output .= 'fbq(\'init\', \'' . $this->config->get('remarketing_facebook_identifier') . '\',{' . implode(",\n", $parameters) . '});' . "\n";
				$output .= 'fbq(\'track\', \'PageView\');' . "\n";
				$output .= '</script>' . "\n";
				$output .= '<noscript><img height="1" width="1" style="display:none" ';
				$output .= 'src="https://www.facebook.com/tr?id=' . $this->config->get('remarketing_facebook_identifier') . '&ev=PageView&noscript=1"';
				$output .= '/></noscript>' . "\n";
				$output .= '<!-- End Facebook Pixel Code -->' . "\n";
			}
			
			if ($this->config->get('remarketing_tiktok_status') && $this->config->get('remarketing_tiktok_script_status') && $this->config->get('remarketing_tiktok_identifier')) {
				$output .= '<script>' . "\n";
				$output .= '!function (w, d, t) {' . "\n";
				$output .= 'w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};' . "\n";
				$output .= "ttq.load('" . $this->config->get('remarketing_tiktok_identifier') . "');" . "\n";
				$output .= "ttq.page()}(window, document, 'ttq');" . "\n";
				$output .= '</script>' . "\n";
				
				if ($this->customer->isLogged()) {
					$email = $this->customer->getEmail();
					$firstname = $this->customer->getFirstName();
					$telephone = $this->customer->getTelephone();
					$output .= '<script>' . "\n";
					$output .= "if (typeof ttq != 'undefined') {" . "\n";
					$output .= "ttq.identify({
						sha256_email: '" . hash('sha256', $email) . "',
						sha256_phone_number: '" . hash('sha256', preg_replace("/[^0-9]/", '', $telephone)) . "',
					})" . "\n";
					$output .= '}</script>' . "\n";
				}
			}
			
			if ($this->config->get('remarketing_snapchat_status') && $this->config->get('remarketing_snapchat_script_status') && $this->config->get('remarketing_snapchat_identifier')) {
				$output .= '<!-- Snap Pixel Code -->' . "\n";
				$output .= '<script>' . "\n";
				$output .= '(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()' . "\n";
				$output .= '{a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};' . "\n";
				$output .= "a.queue=[];var s='script';r=t.createElement(s);r.async=!0;" . "\n";
				$output .= "r.src=n;var u=t.getElementsByTagName(s)[0];u.parentNode.insertBefore(r,u);})(window,document,'https://sc-static.net/scevent.min.js');" . "\n";
				$user_email = '';
				if ($this->customer->isLogged()) {
					$user_email = "'user_email': '" . $this->customer->getEmail() . "'";
				}
				$output .= "snaptr('init', '" . $this->config->get('remarketing_snapchat_identifier'). "', {" . $user_email . "});" . "\n";
				$output .= "snaptr('track', 'PAGE_VIEW');" . "\n";
				$output .= '</script>' . "\n";
				$output .= '<!-- End Snap Pixel Code -->' . "\n";
			}
		}
		
		if ($this->config->get('remarketing_counter_bot')) {
			$output .= "\n" . $this->config->get('remarketing_counter_bot');
		}
		
		return html_entity_decode($output, ENT_QUOTES, 'UTF-8');
	}
 
	public function getRemarketingFooter() { 
		
		$output = '';
		
		$esputnik_general_info = '';
		
		if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier')) {
			$output .= "<script> !function (t, e, c, n) { var s = e.createElement(c); s.async = 1, s.src = 'https://statics.esputnik.com/scripts/' + n + '.js'; var r = e.scripts[0]; r.parentNode.insertBefore(s, r); var f = function () { f.c(arguments); }; f.q = []; f.c = function () { f.q.push(arguments); }; t['eS'] = t['eS'] || f; }(window, document, 'script', '" . $this->config->get('remarketing_esputnik_webtracking_identifier') . "'); </script><script>eS('init');</script>\n\n";
		}
		
		$this->load->model('catalog/product');
		$this->load->model('checkout/order');	
		
		$route = !empty($this->request->get['route']) ? $this->request->get['route'] : '';
		$google_id = $this->config->get('remarketing_google_id') == 'id' ? 'product_id' : 'model';
		$facebook_id = $this->config->get('remarketing_facebook_id') == 'id' ? 'product_id' : 'model';
		$tiktok_id = $this->config->get('remarketing_tiktok_id') == 'id' ? 'product_id' : 'model';
		$snapchat_id = $this->config->get('remarketing_snapchat_id') == 'id' ? 'product_id' : 'model';
		$ecommerce_ga4_id = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? 'product_id' : 'model';
		  
		$google_ids = [];
		$facebook_ids = [];
		$tiktok_ids = [];
		$snapchat_ids = [];
		$uet_ids = [];
		$total_value = 0;
		$google_page = false;
		$facebook_page = false;
		$tiktok_page = false;
		$google_reviews_page = false;
		$google_currency = $this->config->get('remarketing_google_currency'); 
		$facebook_currency = $this->config->get('remarketing_facebook_currency'); 
		$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency'); 
		$tiktok_currency = $this->config->get('remarketing_tiktok_currency'); 
		$snapchat_currency = $this->config->get('remarketing_snapchat_currency'); 
		$fb_time = time();
		$fb_event_id = $this->genEventId();
		$tt_event_id = $this->genEventId(); 
		
		if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier') && $this->customer->isLogged()) {
			$esputnik_general_info = '"GeneralInfo": {
				"externalCustomerId": "' . $this->customer->getEmail() . '", 
				"user_email": "' . $this->customer->getEmail() . '",
				"user_phone": "' . preg_replace("/[^0-9]/", '', $this->customer->getTelephone()) . '"}';
			    $output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'CustomerData', {" . str_replace('GeneralInfo', 'CustomerData', $esputnik_general_info) . "});}</script>\n\n";
		}
		
		switch ($route) {
			case '':			
			case 'common/home':	
				if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier')) {
					$output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'MainPage', {" . $esputnik_general_info . "});}</script>\n\n";
				}
				if ($this->config->get('remarketing_uet_status')) {
					$output .= "<script>window.uetq = window.uetq || [];window.uetq.push('event', '', {'ecomm_pagetype': 'home'});</script>\n\n";
				}
				break;
			case 'product/category':
				if (isset($this->request->get['path'])) {
					$parts = explode('_', (string)$this->request->get['path']);
					$category_id = (int)array_pop($parts);
					
					if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier') && $category_id) {
						$output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'CategoryPage', {'CategoryPage': {'categoryKey': '" . $category_id . "'}}, {" . $esputnik_general_info . "});}</script>\n\n";
					}
				}  
				break;
			case 'account/success':
				if (!empty($this->session->data['remarketing_register'])) {
					if ($this->config->get('remarketing_ecommerce_status')) {
						$output .= "<script>window.dataLayer = window.dataLayer || []; dataLayer.push({'event': 'ga4_registration'})</script>\n";
					}
					if ($this->config->get('remarketing_ecommerce_ga4_status')) {
						$output .= "<script>if (typeof gtag != 'undefined') {gtag('event', 'registration')}</script>\n";
					}
					unset($this->session->data['remarketing_register']);
				}
				break;	 
			case 'information/contact/success':
				if (!empty($this->session->data['remarketing_contact'])) {
					if ($this->config->get('remarketing_ecommerce_status')) {
						$output .= "<script>window.dataLayer = window.dataLayer || []; dataLayer.push({'event': 'ga4_contact'})</script>\n";
					}
					if ($this->config->get('remarketing_ecommerce_ga4_status')) {
						$output .= "<script>if (typeof gtag != 'undefined') {gtag('event', 'contact')}</script>\n";
					}
					unset($this->session->data['remarketing_contact']);
				}
				break;	 
			case 'product/product':
				$google_page = 'view_item';
				$facebook_page = false;
				if (empty($this->request->get['product_id'])) return;
				$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
				if (!$product_info) return; 
				$product_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
				$price = $this->currency->format($this->tax->calculate($product_price, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', false);
				$google_ids[] = $product_info[$google_id];
				$facebook_ids[] = $product_info[$facebook_id];
				$total_value = $price;
				$google_total = $this->currency->format($product_price, $google_currency, '', false); 
				$facebook_total = $this->currency->format($product_price, $facebook_currency, '', false); 
				$ecommerce_total = $this->currency->format($product_price, $ecommerce_currency, '', false);
				if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier')) {
					$output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'ProductPage', {'ProductPage': {'productKey': '" . $product_info['product_id'] . "', 'price': '" . $ecommerce_total . "', 'isInStock': '" . ($product_info['quantity'] > 0 ? '1' : '0') . "', }}, {" . $esputnik_general_info . "});}</script>\n\n";
				} 
				break;					
			case 'checkout/cart':
			case 'checkout/simplecheckout':
			case 'checkout/checkout':
			case 'checkout/unicheckout':
			case 'checkout/uni_checkout':
			case 'checkout/revcheckout':
			case 'revolution/revcheckout':
			case 'checkout/oct_fastorder':
			case 'checkout/onepcheckout':
			case 'checkout/buy':
			case 'extension/quickcheckout/checkout':
			case 'lightcheckout/checkout':
			case 'extension/module/custom':
			case 'quickcheckout/checkout':
				$google_page = 'add_to_cart';
				$google_page = false; 
				$facebook_page = 'initiate';
				$tiktok_page = 'initiate';
				$ga4_products = [];
				
				if ($this->config->get('remarketing_events_cart')) {
					$output .= "<script>\n";
					$output .= html_entity_decode($this->config->get('remarketing_events_cart'));
					$output .= "</script>\n";     
				}
				
				$products = $this->cart->getProducts();
				$cart_json = [];
				
				foreach ($products as $product) {
					$google_ids[]   = $product[$google_id];
					$facebook_ids[] = $product;
					$tiktok_ids[] = $product;
					$snapchat_ids[] = $product[$snapchat_id];
					$cart_json[$product['cart_id']] = $product;
				} 
				
				if ($this->config->get('remarketing_ecommerce_status') || $this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
					$i = 1;
					foreach ($products as $product) {
						$product_info = $this->model_catalog_product->getProduct($product['product_id']);
						$ga4_categories = $this->getRemarketingCategoriesGa4($product['product_id']);
						
						$ga4_product = [
							'item_id'   => ($this->config->get('remarketing_ecommerce_ga4_id') == 'id') ? $product['product_id'] : $product['model'],
							'item_name' => addslashes($product['name']),
							'quantity' => $product['quantity'],
							'index'  => $i, 
							'price' => $this->currency->format($product['price'], $ecommerce_currency, '', false),
							'currency' => $ecommerce_currency
						];
						
						if (!empty($ga4_categories[0])) $ga4_product['item_category'] = $ga4_categories[0];
						if (!empty($ga4_categories[1])) $ga4_product['item_category2'] = $ga4_categories[1];
						if (!empty($ga4_categories[2])) $ga4_product['item_category3'] = $ga4_categories[2];
						if (!empty($ga4_categories[3])) $ga4_product['item_category4'] = $ga4_categories[3];
						
						if (!empty($product_info['manufacturer'])) $ga4_product['item_brand'] = $product_info['manufacturer'];
						$ga4_products[] = $ga4_product;
						$i++;
					}	
				}
				
				$output .= "<script>\n";
				$output .= "window.cart_products = " . json_encode($cart_json) . "\n";
				$output .= "</script>\n";
				
				$cart_total = $this->cart->getTotal();
				$total_value = $this->currency->format($cart_total, $this->session->data['currency'], '', false); 
				$google_total = $this->currency->format($cart_total * (float)$this->config->get('remarketing_google_ads_ratio'), $google_currency, '', false); 
				$facebook_total = $this->currency->format($cart_total * (float)$this->config->get('remarketing_facebook_ratio'), $facebook_currency, '', false); 
				$ecommerce_total = $this->currency->format($cart_total * (float)$this->config->get('remarketing_ecommerce_ratio'), $ecommerce_currency, '', false); 
				$tiktok_total = $this->currency->format($cart_total * (float)$this->config->get('remarketing_tiktok_ratio'), $tiktok_currency, '', false); 
				$snapchat_total = $this->currency->format($cart_total * (float)$this->config->get('remarketing_snapchat_ratio'), $snapchat_currency, '', false); 
				
				if ($this->config->get('remarketing_ecommerce_status')) {
					$output .= '<script>' . "\n";
					$output .= 'window.dataLayer = window.dataLayer || [];' . "\n";
					$output .= 'dataLayer.push({ ecommerce: null });' . "\n";
					$output .= 'dataLayer.push({' . "\n";
					$output .= "'event': '" . ($route != 'checkout/cart' ? 'ga4_begin_checkout' : 'ga4_view_cart') . "'," . "\n"; 
					$output .= "'ecommerce': {" . "\n";
					$output .= "'currency': '" . $ecommerce_currency . "',\n"; 
					$output .= "'value': " . $ecommerce_total . ",\n"; 
					$output .= "'items': " . json_encode($ga4_products) . "\n"; 
					$output .= '}});' . "\n</script>\n";
				}
				
				if ($this->config->get('remarketing_ecommerce_ga4_status')) {
					$output .= '<script>' . "\n";
					$output .= "if (typeof gtag != 'undefined') {" . "\n";
					$output .= 'gtag("event", "' . ($route != 'checkout/cart' ? 'begin_checkout' : 'view_cart') . '" , {'."\n";
					$output .= "'send_to': '" . $this->config->get('remarketing_ecommerce_ga4_identifier') . "',\n";
					$output .= "'currency': '" . $ecommerce_currency . "',\n";
					$output .= "'value': " . $ecommerce_total . ",\n"; 
					$output .= "'items': " . json_encode($ga4_products) ."\n";
					$output .= '})};' . "\n";
					$output .= '</script>' . "\n";
				}
				
				if ($this->config->get('remarketing_google_ads_identifier_cart_page')) {
					$output .= '<script>' . "\n";
					$output .= "if (typeof gtag != 'undefined') {" . "\n";
					$output .= 'gtag("event", "conversion", {' . "\n";
					$output .= "'send_to': '" . $this->config->get('remarketing_google_ads_identifier_cart_page') . "'," . "\n";
					$output .= "'value': " . $google_total . ",\n";
					$output .= "'currency': '" . $google_currency . "'\n";
					$output .= '})};' . "\n</script>\n";
				} 
				
				if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
					$ecommerce_ga4_data = [
						'events' => [[
							'name' => $route != 'checkout/cart' ? 'begin_checkout' : 'view_cart',
							'params' => [
								'currency' => $this->config->get('remarketing_ecommerce_currency'),
								'items' => $ga4_products,										
								'value' => $ecommerce_total
							]],
						],
					];
					$output .= '<script>window.ecommerce_ga4_data = window.ecommerce_ga4_data || {};' . "\n";
					$output .= 'ecommerce_ga4_data = ' . json_encode($ecommerce_ga4_data) . ";\n";
					$output .= "if (typeof sendGa4Cart !== 'undefined') {\n";
					$output .= "sendGa4Cart(ecommerce_ga4_data); \n";
					$output .= "}\n"; 
					$output .= '</script>' . "\n";
				}
				
				if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
					$facebook_data['event_name'] = 'InitiateCheckout';
					$facebook_data['time'] = $fb_time;
					$facebook_data['event_id'] = $fb_event_id;
					$fb_products = [];
					foreach ($facebook_ids as $product) {
						$fb_products[] = [
							'id'         => $product[$facebook_id],
							'quantity'   => $product['quantity'],
							'item_price' => $this->currency->format($product['price'], $facebook_currency, '', false)
						];
					}
					$facebook_data['custom_data'] = [
						'value'        => $facebook_total,
						'currency'     => $facebook_currency,
						'contents'     => $fb_products,
						'num_items'    => count($fb_products),
						'content_type' => 'product',
						'opt_out'      => false
					];
					
					$output .= '<script>window.facebook_data = window.facebook_data || {};' . "\n";
					$output .= 'facebook_data = ' . json_encode($facebook_data) . ";\n";
					$output .= "if (typeof sendFacebookCart !== 'undefined') {\n";
					$output .= "sendFacebookCart(facebook_data); \n";
					$output .= "}\n";
					$output .= '</script>' . "\n";
				}
				
				if ($this->config->get('remarketing_tiktok_status') && $this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token')) {
					$tiktok_data['event_name'] = 'InitiateCheckout';
					$tt_products = [];
					foreach ($tiktok_ids as $product) {
						$tt_products[] = [
							'content_id' => $product[$tiktok_id],
							'quantity'   => $product['quantity'],
							'content_type'     => 'product',
							'content_name'   => $product['name'],
							'price' => $this->currency->format($product['price'], $tiktok_currency, '', false)
						];
					}
					
					$tiktok_data['properties'] = [
						'contents' => $tt_products,
						'value'    => $tiktok_total,
						'currency' => $tiktok_currency
					];
					$tiktok_data['event_id'] = $tt_event_id;
					$tiktok_data['url'] = $this->url->link($route);
					
					$output .= '<script>window.tiktok_data = window.tiktok_data || {};' . "\n";
					$output .= 'tiktok_data = ' . json_encode($tiktok_data) . ";\n";
					$output .= "if (typeof sendTiktokCart !== 'undefined') {\n";
					$output .= "sendTiktokCart(tiktok_data); \n";
					$output .= "}\n";
					$output .= '</script>' . "\n";
				}
				
				if ($this->config->get('remarketing_snapchat_status') && $this->config->get('remarketing_snapchat_pixel_status')) {
					$snapchat_data = [
						'currency' => $snapchat_currency,
						'item_ids' => $snapchat_ids,
						'number_items' => count($snapchat_ids),
						'price' => $snapchat_total 
					];
					$output .= "<script>" . "\n";
					$output .= "if (typeof snaptr != 'undefined') {" . "\n";
					$output .= "snaptr('track','START_CHECKOUT', " . json_encode($snapchat_data) . ");" . "\n";
					$output .= "}" . "\n";
					$output .= "</script>" . "\n";
				}		
				
				if ($this->config->get('remarketing_uet_status')) {
					$uet_ids = [];
					$uet_products = [];
					foreach ($products as $product) {
						$uet_ids[] = $product['product_id'];
						$uet_products[] = [
								'id' => $product['product_id'], 'quantity' => $product['quantity'], 'price' => $this->currency->format($product['price'], $ecommerce_currency, '', false)
							];
					}
					$uet_data = [
						'ecomm_prodid' => $uet_ids,
						'ecomm_pagetype' => 'cart',
						'ecomm_totalvalue' => $ecommerce_total,
						'revenue_value' => $ecommerce_total,
						'currency' => $ecommerce_currency,
						'items' => $uet_products
					];
					$output .= "<script>window.uetq = window.uetq || [];window.uetq.push('event', '', " . json_encode($uet_data) . ");</script>" . "\n";
				}				
				
				break;	
			case 'checkout/success':
			case 'extension/ocdevwizard/smart_order_success_page_pro': 
			case 'extension/ocdevwizard/order_success_page_pro': 
			case 'extension/ocdevwizard/order_success_page': 
			case 'oneclick/success': 
				$google_page = 'purchase';
				$facebook_page = 'purchase';
				$tiktok_page = 'purchase';
				if (!empty($this->request->cookie['remarketing_order_id']) || !empty($this->session->data['order_id']) || !empty($this->session->data['remarketing_order_id'])) {
					if (!empty($this->request->cookie['remarketing_order_id'])) $remarketing_order_id = $this->request->cookie['remarketing_order_id'];
					if (!empty($this->session->data['order_id'])) $remarketing_order_id = $this->session->data['order_id'];
					if (!empty($this->session->data['remarketing_order_id'])) $remarketing_order_id = $this->session->data['remarketing_order_id'];
					$order_info = $this->getOrderRemarketing($remarketing_order_id);
					if ($order_info) {
						if ($order_info['products']) {
							foreach ($order_info['products'] as $product) {
								$google_ids[] = $product[$google_id];
								$facebook_ids[] = $product;
								$tiktok_ids[] = $product;
							}							
						} 
						$total_value = $this->currency->format($order_info['total'], $this->session->data['currency'], '', false);
						$google_total = $order_info['google_total'];  
						$facebook_total = $order_info['facebook_total']; 
						$ecommerce_total = $order_info['ecommerce_total'];
						$tiktok_total = $order_info['tiktok_total'];
						
						$google_reviews_page = true;
						$reviews_order_id = $order_info['order_id'];
						$reviews_order_email = $order_info['email'];
						$reviews_order_date = date('Y-m-d', time() + 3600 * 24 * (int)$this->config->get('remarketing_reviews_date'));
						if ($this->config->get('remarketing_events_purchase')) {
							$output .= "<script>\n";
							$remarketing_events_purchase = html_entity_decode($this->config->get('remarketing_events_purchase'));
							$remarketing_events_purchase = str_replace(['{order_id}', '{order_total}'], [$order_info['order_id'], $order_info['default_total']], $remarketing_events_purchase);
							$output .= $remarketing_events_purchase;
							$output .= "</script>\n";     
						}
						 
					    if ($this->config->get('remarketing_google_status') && $this->config->get('remarketing_google_identifier')) {
							$output .= '<script>var enhanced_conversion_data = {' . "\n";
							if ($order_info['order_info']['email']) {
								$output .= '"email": "' . $order_info['order_info']['email'] . '",' . "\n";
							}
							if ($order_info['order_info']['telephone']) {
								$output .= '"phone_number": "' . $order_info['telephone'] . '",' . "\n";
							}
							if ($order_info['order_info']['firstname']) {
								$output .= '"first_name": "' . $order_info['order_info']['firstname'] . '",' . "\n";
							}
							if ($order_info['order_info']['lastname']) {
								$output .= '"last_name": "' . $order_info['order_info']['lastname'] . '",' . "\n";
							}
							if ($order_info['order_info']['shipping_address_1']) {
								$output .= '"home_address": {';
								$output .= '"street": "' . $order_info['order_info']['shipping_address_1'] . '",' . "\n";
								$output .= '"city": "' . $order_info['order_info']['shipping_city'] . '",' . "\n";
								$output .= '"region": "' . $order_info['order_info']['shipping_zone'] . '",' . "\n";
								$output .= '"country": "' . $order_info['order_info']['shipping_country'] . '"' . "\n";
								$output .= '}';  
							}
							$output .= '}</script>' . "\n";
							$output .= "<script>if (typeof gtag != 'undefined') { gtag('set', 'user_data', {" . "\n";
							if ($order_info['order_info']['email']) {
								$output .= '"email": "' . $order_info['order_info']['email'] . '",' . "\n";
							}
							if ($order_info['order_info']['telephone']) {
								$output .= '"phone_number": "' . $order_info['telephone'] . '",' . "\n";
							}
							if ($order_info['order_info']['firstname']) {
								$output .= '"first_name": "' . $order_info['order_info']['firstname'] . '",' . "\n";
							}
							if ($order_info['order_info']['lastname']) {
								$output .= '"last_name": "' . $order_info['order_info']['lastname'] . '",' . "\n";
							}
							if ($order_info['order_info']['shipping_address_1']) {
								$output .= '"home_address": {';
								$output .= '"street": "' . $order_info['order_info']['shipping_address_1'] . '",' . "\n";
								$output .= '"city": "' . $order_info['order_info']['shipping_city'] . '",' . "\n";
								$output .= '"region": "' . $order_info['order_info']['shipping_zone'] . '",' . "\n";
								$output .= '"country": "' . $order_info['order_info']['shipping_country'] . '"' . "\n";
								$output .= '}';  
							}
							$output .= '})}</script>' . "\n";
						}
						
						if ($this->config->get('remarketing_google_ads_identifier')) {
							$output .= '<script>' . "\n";
							$output .= "if (typeof gtag != 'undefined') {" . "\n";
							$output .= 'gtag("event", "conversion", {' . "\n";
							$output .= "'send_to': '" . $this->config->get('remarketing_google_ads_identifier') . "'," . "\n";
							$output .= "'value': " . $order_info['google_total'] . ",\n";
							$output .= "'currency': '" . $google_currency . "',\n";
							$output .= "'transaction_id': '" . $order_info['order_id'] . "'\n";
							$output .= '})};' . "\n</script>\n";
						}
						
						if ($this->config->get('remarketing_ecommerce_status') && !$this->config->get('remarketing_ga4_only_purchase')) {
							$output .= '<script>' . "\n";
							$output .= 'window.dataLayer = window.dataLayer || [];' . "\n";
							$output .= 'dataLayer.push({ ecommerce: null });' . "\n";
							$output .= 'dataLayer.push(' . json_encode($order_info['ga4_datalayer']) . ');' . "\n";
							$output .= '</script>' . "\n";  
						} 
						
						if ($this->config->get('remarketing_ecommerce_ga4_status') && !$this->config->get('remarketing_ga4_only_purchase')) {
							$output .= '<script>' . "\n";
							$output .= "if (typeof gtag != 'undefined') {" . "\n"; 
							$output .= 'gtag("event", "purchase", ' . json_encode($order_info['ga4_event']) . ');' . "\n";
							$output .= '}' . "\n";
							$output .= '</script>' . "\n";
						}
						
						if ($this->config->get('remarketing_snapchat_status') && $this->config->get('remarketing_snapchat_pixel_status')) {
							$output .= "<script>" . "\n";
							$output .= "if (typeof snaptr != 'undefined') {" . "\n";
							$output .= "snaptr('track','PURCHASE', " . json_encode($order_info['snapchat_data']) . ");" . "\n";
							$output .= "}" . "\n";
							$output .= "</script>" . "\n";
						}	
						
						if ($this->config->get('remarketing_uet_status')) { 
							$output .= "<script>window.uetq = window.uetq || [];window.uetq.push('event', 'purchase', " . json_encode($order_info['uet_data']) . ");</script>" . "\n";
						}				

						if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier') && isset($this->session->data['remarketing_esputnik_cart_id'])) {
							$sputnik_products = [];
							foreach ($order_info['products'] as $product) {
								$sputnik_products[] = [
									'productKey'    => $product['product_id'],
									'price'   => $product['ecommerce_price'],
									'quantity'   => $product['quantity'],
									'currency' => $ecommerce_currency
								];
							} 
							$output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'PurchasedItems', {'OrderNumber': '" . $order_info['order_id'] . "','PurchasedItems': " . json_encode($sputnik_products) . ",'GUID': '" . $this->session->data['remarketing_esputnik_cart_id']. "'," . $esputnik_general_info . "})};</script>\n\n";  
						}  
						$output .= "<script>console.log ('%c%s', 'color: #ff007f', 'order_sent');</script>";
					} 
					
					$this->setSuccessPage($remarketing_order_id);
					
				} else {
					$google_page = false;
					$facebook_page = false;
				}
				break;	 
			case 'error/not_found': 
				$output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'NotFound', {" . $esputnik_general_info . "});}</script>\n\n";
				break;	
			default:
				$google_page = false;
				$facebook_page = false;
				break;
		}
		
		if ($this->config->get('remarketing_google_status') && $this->config->get('remarketing_google_identifier')) {
			if ($google_page) {
				$google_products = [];
				foreach($google_ids as $google_id) {
					$google_products[] = [
						'id' => $google_id,
						'google_business_vertical' => 'retail'
					];
				}
				$google_data = [
					'send_to' => $this->config->get('remarketing_google_identifier'),
					'value'   => !empty($google_total) ? $google_total : $total_value,
					'items'   => $google_products
				];
				
				$output .= '<script>' . "\n";
				$output .= "if (typeof gtag != 'undefined') {" . "\n";
				$output .= 'gtag("event", "' . $google_page . '", ' . json_encode($google_data) .  ");\n";
				$output .= '}</script>' . "\n"; 
			}
		}
		
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_identifier') && $this->config->get('remarketing_facebook_pixel_status')) {
			
			// disable purchase if capi enabled and status not in
			$send_fb_purchase = true;
			$send_fb_lead = true;
			
			if ($this->config->get('remarketing_facebook_server_side') && $facebook_page == 'purchase' && !empty($order_info)) {
				$facebook_send_status = $this->config->get('remarketing_facebook_send_status');
				if (is_array($facebook_send_status) && !in_array($order_info['order_status_id'], $facebook_send_status)) {
					$send_fb_purchase = false;
				}
				$facebook_lead_send_status = $this->config->get('remarketing_facebook_lead_send_status');
				if (is_array($facebook_lead_send_status) && !in_array($order_info['order_status_id'], $facebook_lead_send_status)) {
					$send_fb_lead = false;
				}
			}
			
			if ($facebook_page == 'purchase' || $facebook_page == 'initiate') {
				if (!empty($facebook_ids)) {
					if ($send_fb_purchase || $facebook_page == 'initiate') { 
					$output .= '<script>' . "\n";
					$output .= "$(document).ready(function() {" . "\n";
					$output .= "if (typeof fbq != 'undefined') {" . "\n";
					if ($facebook_page == 'purchase') {
						$output .= "fbq('track', 'Purchase', {" . "\n";
					} else {
						$output .= "fbq('track', 'InitiateCheckout', {" . "\n";	
					}
					$output .= "content_type: 'product'," . "\n";
					
					$num_items = 0;
					foreach ($facebook_ids as $product) {
						$num_items += $product['quantity'];
					}

					$output .= "num_items: " . $num_items . "," . "\n";
					if (count($facebook_ids) == 1) {
						$output .= "content_ids: ['" . $facebook_ids[0][$facebook_id] . "']," . "\n";
						$output .= "content_name: '" . addslashes($facebook_ids[0]['name']) . "'," . "\n";
						if (!empty($facebook_ids[0]['category'])) $output .= "content_category: '" . $facebook_ids[0]['category'] . "'," . "\n";
					} else {  
						$output .= "contents: [" . "\n";
						foreach ($facebook_ids as $product) {
							$output .= "{" . "'id': '" . $product[$facebook_id] . "', 'price': " . $this->currency->format($product['price'], $facebook_currency, '', false) . ", 'quantity': " . $product['quantity'] . "},";
						}
						$output = rtrim($output, ',');
						$output .= "],\n";
					}
					$output .= 'value: ' . $facebook_total . ',' . "\n";
					$output .= "currency: '" .  $facebook_currency . "'" . "\n";
					if ($facebook_page == 'purchase') {
						$fb_event_id = $order_info['sent_data']['fb_event_id'];
					}
					$output .= '}, {eventID: "' . $fb_event_id . '"})}});' . "\n</script>\n";
					}
					 
					if ($this->config->get('remarketing_facebook_lead') && $facebook_page == 'purchase' && $send_fb_lead) {
						$output .= '<script>' . "\n";
						$output .= "$(document).ready(function() {" . "\n";
						$output .= "if (typeof fbq != 'undefined') {" . "\n";
						$output .= "fbq('track', 'Lead', {" . "\n";
						$output .= 'value: ' . $facebook_total . ',' . "\n";
						$output .= "currency: '" .  $facebook_currency . "'" . "\n";
						$fb_event_id = $order_info['sent_data']['fb_lead_event_id'];
						$output .= '}, {eventID: "' . $fb_event_id . '"})}});' . "\n</script>\n";
					}
				}
			}
		}
		
		if ($this->config->get('remarketing_tiktok_status')) {
			
			// disable purchase if api enabled and status not in
			$send_tt_purchase = true;
			
			if ($this->config->get('remarketing_tiktok_server_side') && $tiktok_page == 'purchase' && !empty($order_info)) {
				$tiktok_send_status = $this->config->get('remarketing_tiktok_send_status');
				if (is_array($tiktok_send_status) && !in_array($order_info['order_status_id'], $tiktok_send_status)) {
					$send_tt_purchase = false;
				}
			}
			
			if ($tiktok_page == 'purchase' || $tiktok_page == 'initiate') {
				if (!empty($tiktok_ids)) {
					if ($send_tt_purchase || $tiktok_page == 'initiate') { 
					$output .= '<script>' . "\n";
					$output .= "$(document).ready(function() {" . "\n";
					$output .= "if (typeof ttq != 'undefined') {" . "\n";
					if ($tiktok_page == 'purchase') {
						$output .= "ttq.track('CompletePayment', {" . "\n";
					} else {
						$output .= "ttq.track('InitiateCheckout', {" . "\n";	
					}
					$output .= "content_type: 'product'," . "\n";
					
					if (count($tiktok_ids) == 1) {
						$output .= "content_id: '" . $tiktok_ids[0][$tiktok_id] . "'," . "\n";
						$output .= "content_name: '" . addslashes($tiktok_ids[0]['name']) . "'," . "\n";
						if (!empty($tiktok_ids[0]['category'])) $output .= "content_category: '" . $tiktok_ids[0]['category'] . "'," . "\n";
					} else {  
						$output .= "contents: [" . "\n";
						foreach ($tiktok_ids as $product) {
							$output .= "{" . "'content_id': '" . $product[$tiktok_id] . "', 'price': " . $this->currency->format($product['price'], $tiktok_currency, '', false) . ", 'quantity': " . $product['quantity'] . ", 'content_name': '" . $product['name'] . "', 'content_type': 'product'},";
						}
						$output = rtrim($output, ',');
						$output .= "],\n";
					}
					$output .= 'value: ' . $tiktok_total . ',' . "\n";
					$output .= "currency: '" .  $tiktok_currency . "'" . "\n";
					if ($tiktok_page == 'purchase') {
						$tt_event_id = $order_info['sent_data']['tt_event_id'];
					}
					$output .= '}, {eventID: "' . $tt_event_id . '"})}});' . "\n</script>\n";
					}
				}
			}
		}
		
		if ($google_reviews_page && $this->config->get('remarketing_reviews_status') && $this->config->get('remarketing_google_merchant_identifier')  && strpos($reviews_order_email, 'localhost') === false) {			
			$output .= '<script src="https://apis.google.com/js/platform.js?onload=renderOptIn"  async defer></script>' . "\n";
			$output .= "<script>\n";     
			$output .= "window.renderOptIn = function() {\n";  
			$output .= "window.gapi.load('surveyoptin', function() {\n"; 
			$output .= "window.gapi.surveyoptin.render({\n"; 
			$output .= '"merchant_id": ' . $this->config->get('remarketing_google_merchant_identifier') . ",\n"; 
			$output .= '"order_id": "' . $reviews_order_id . "\",\n"; 
			$output .= '"email": "' . $reviews_order_email . "\",\n"; 
			$output .= '"delivery_country": "' . $this->config->get('remarketing_reviews_country') . "\",\n"; 
			$output .= '"estimated_delivery_date": "' . $reviews_order_date . "\",\n"; 
			$output .= '"opt_in_style": "CENTER_DIALOG"'; 
			$items = [];
			if ($this->config->get('remarketing_reviews_feed_gtin')) {
				foreach ($order_info['products'] as $product) {
					if (!empty($product['product_info'][$this->config->get('remarketing_reviews_feed_gtin')])) {
						$items[] = ['gtin' => $product['product_info'][$this->config->get('remarketing_reviews_feed_gtin')]];	
					}
				}
			}
			if (!empty($items)) {
				$output .= ",\n";
				$output .= '"products": ' . json_encode($items);
			}
			
			$output .=  "});});}\n"; 
			$output .=  "</script>"; 
		}
		
		if ($this->config->get('remarketing_counter3') && $this->config->get('remarketing_counter3')) {
			$output .=  html_entity_decode($this->config->get('remarketing_counter3'));
		}
		
		if ($this->config->get('remarketing_events_cart_add')) {
			$output .= "<script>\n";
			$output .= "function events_cart_add() {\n";
			$output .= html_entity_decode($this->config->get('remarketing_events_cart_add')) . "\n";
			$output .= "}\n";     
			$output .= "</script>\n";     
		}
		
		if ($this->config->get('remarketing_events_wishlist')) {
			$output .= "<script>\n";
			$output .= "function events_wishlist() {\n";
			$output .= html_entity_decode($this->config->get('remarketing_events_wishlist')) . "\n";
			$output .= "}\n";     
			$output .= "</script>\n";     
		}
		
		if ($this->config->get('remarketing_events_quick_purchase')) {
			$output .= "<script>\n";
			$output .= "function quickPurchase(order_id = false, order_total = false) {\n";
			$remarketing_events_quick_purchase = html_entity_decode($this->config->get('remarketing_events_quick_purchase'));
			$remarketing_events_quick_purchase = str_replace(['{order_id}', '{order_total}'], ['order_id', 'order_total'], $remarketing_events_quick_purchase);
			$output .= html_entity_decode($remarketing_events_quick_purchase);
			$output .= "\n}\n";     
			$output .= "</script>\n";     
		}
		
		if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier')) {
			$show_customer_data = false;
			if (!empty($order_info)) {
				$esputnik_info = '"CustomerData": {
				"externalCustomerId": "' . $order_info['email'] . '", 
				"user_email": "' . $order_info['email'] . '",
				"user_name": "' . $order_info['firstname'] . ' ' . $order_info['lastname']  . '",
				"user_phone": "' . preg_replace("/[^0-9]/", '', $order_info['telephone']) . '"}';
				$show_customer_data = true;
			} else if ($this->customer->isLogged()) {
				$esputnik_info = '"CustomerData": {
				"externalCustomerId": "' . $this->customer->getEmail() . '", 
				"user_email": "' . $this->customer->getEmail() . '",
				"user_name": "' . $this->customer->getFirstName() . ' ' . $this->customer->getLastName()  . '",
				"user_phone": "' . preg_replace("/[^0-9]/", '', $this->customer->getTelephone()) . '"}';
				$show_customer_data = true;
			}
			if ($show_customer_data) {
				$output .= "<script>if (typeof eS != 'undefined') { eS('sendEvent', 'CustomerData', {" . $esputnik_info . "});}</script>\n\n";
			}
		}
		
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_pixel_status') && $this->config->get('remarketing_facebook_depth') && $this->config->get('remarketing_facebook_depth_params')) {
			$output .= '<script>' . "\n";
			$output .= 'function getCurrentPosition() {' . "\n";
			$output .= '	return window.pageYOffset ||' . "\n";
			$output .= '		(document.documentElement || document.body.parentNode || document.body).scrollTop;' . "\n";
			$output .= '}' . "\n";
			$output .= '' . "\n";
			$output .= 'function getScrollableHeight() {' . "\n";
			$output .= '	var d = Math.max(' . "\n";
			$output .= '		document.body.scrollHeight, document.documentElement.scrollHeight,' . "\n";
			$output .= '		document.body.offsetHeight, document.documentElement.offsetHeight,' . "\n";
			$output .= '		document.body.clientHeight, document.documentElement.clientHeight' . "\n";
			$output .= '	)' . "\n";
			$output .= '	var w = window.innerHeight ||' . "\n";
			$output .= '		(document.documentElement || document.body).clientHeight;' . "\n";
			$output .= '	if (d > w) {' . "\n";
			$output .= '		return d - w;' . "\n";
			$output .= '	}' . "\n";
			$output .= '	return 0;' . "\n";
			$output .= '}' . "\n";
			$output .= 'var checkPoints = [' . $this->config->get('remarketing_facebook_depth_params') . '];' . "\n";
			$output .= 'var reached = 0;' . "\n";
			$output .= 'var scrollableHeight = getScrollableHeight();' . "\n";
			$output .= "window.addEventListener('resize', function () {" . "\n";
			$output .= '	scrollableHeight = getScrollableHeight();' . "\n";
			$output .= '});' . "\n";
			$output .= "window.addEventListener('scroll', function () {" . "\n";
			$output .= '	var current;' . "\n";
			$output .= '	if (scrollableHeight == 0) {' . "\n";
			$output .= '		current = 100;' . "\n";
			$output .= '	} else {' . "\n";
			$output .= '		var current = getCurrentPosition() / scrollableHeight * 100;' . "\n";
			$output .= '	}' . "\n";
			$output .= '	if (current > reached) {' . "\n";
			$output .= '		reached = current;' . "\n";
			$output .= '		// checkpoint and send events' . "\n";
			$output .= '		while (checkPoints.length > 0) {' . "\n";
			$output .= '			var c = checkPoints[0];' . "\n";
			$output .= '			if (c <= reached) {' . "\n";
			$output .= '				checkPoints.shift();' . "\n";
			$output .= "				if (typeof fbq != 'undefined') {" . "\n";
			$output .= "					fbq('trackCustom', 'ViewContentCheckPoint', {" . "\n";
			$output .= '						depth: c,' . "\n";
			$output .= '					});' . "\n";
			$output .= '				}' . "\n";
			$output .= '			} else {' . "\n";
			$output .= '				break;' . "\n";
			$output .= '			}' . "\n";
			$output .= '		}' . "\n";
			$output .= '	}' . "\n";
			$output .= '}, false);  ' . "\n";
			$output .= '</script>' . "\n";
		} 
		
		if ($this->config->get('remarketing_ecommerce_ga4_status') && $this->config->get('remarketing_ecommerce_ga4_selector')) {
			$output .= "<script>$(document).on('click touchstart', '" . $this->config->get('remarketing_ecommerce_ga4_selector') . ", .fm-module-item, .rm-module-item, .sc-module-item, .us-module-item', (e) => {" . "\n";
			/* big thanks to @soor ) */
			$output .= "item_id = $(this).find('.remarketing_cart_button').attr('data-product_id');" . "\n";
			$output .= "const index = $(e.target).index('*');" . "\n"; 
			$output .= "const header = $($('h1, h2, h3, .sc-module-header, .title-module > span, .rm-column-title, .fm-column-title, .us-module-column-box .panel-heading').get().reverse()).filter((i, el) => ($(el).index('*') < index)).first();" . "\n";
			$output .= "localStorage.setItem('remarketing_product_id', item_id);" . "\n";
			$output .= "localStorage.setItem('remarketing_heading', header.text().trim());" . "\n";
			$output .= '})</script>' . "\n"; 
		}
		 
		return $output; 
	}
	
	public function sendEsputnik($esputnik_data, $event_url = 'https://esputnik.com/api/v1/event') {
		if ($this->config->get('remarketing_esputnik_api_status') && !$this->isBot() && $this->config->get('remarketing_esputnik_login') && $this->config->get('remarketing_esputnik_password')) {
			
			$user = $this->config->get('remarketing_esputnik_login');
			$password = $this->config->get('remarketing_esputnik_password');
			 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($esputnik_data));
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/json;charset=UTF-8']);
			curl_setopt($ch, CURLOPT_URL, $event_url);
			curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $password);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
			$output = curl_exec($ch);
			curl_close($ch);
		}
	}
	
	public function sendEsputnikCartUpdated() {
		$event = new stdClass();
		$event->eventTypeKey = 'cartUpdated';
		$event->keyValue = $this->session->data['esputnik_email'];
		$event->params = [];
		if (isset($this->session->data['esputnik_telephone'])) {
			$event->params[] = ['name' => 'phone', 'value' => $this->session->data['esputnik_telephone']];
		}
		$event->params[] = ['name' => 'email', 'value' => $this->session->data['esputnik_email']];
		
		$event->params[] = ['name' => 'currencyCode', 'value' => $this->config->get('remarketing_ecommerce_currency')];
		
		if ($this->customer->isLogged()) {
			$event->params[] = ['name' => 'externalCustomerId', 'value' => $this->customer->getEmail()];
		
			if ($this->customer->getFirstName()) {
				$event->params[] = ['name' => 'firstName', 'value' => $this->customer->getFirstName()];
			}
		
			if ($this->customer->getLastName()) {
				$event->params[] = ['name' => 'lastName', 'value' => $this->customer->getLastName()];
			}
		}
		$items = [];
		
		$this->load->model('tool/image');
		$products = $this->cart->getProducts();
		foreach ($products as $product) {
			$items[] = [
				'productId' => $product['product_id'],
				'name'      => $product['name'],
				'quantity'  => $product['quantity'],
				'price'     => $product['price'],
			];
		}
		if (!isset($this->session->data['esputnik_uniq'])) {
			$this->session->data['esputnik_uniq'] = uniqid();
		}
		$event->params[] = ['name' => 'recycleStateId', 'value' => $this->session->data['esputnik_uniq']];
		$event->params[] = ['name' => 'products', 'value' => json_encode($items)];
		
		$this->sendEsputnik($event);
	}
	
	public function sendGa4($ecommerce_data) {
		if (!$this->isBot() && $this->config->get('remarketing_ecommerce_ga4_analytics_id') && $this->config->get('remarketing_ecommerce_ga4_measurement_api_secret') && !empty($this->session->data['uuid'])) {
			
			$ecommerce_data['client_id'] = $this->session->data['uuid'];
 			
			if (empty($ecommerce_data['events'][0]['params']['session_id'])) {
				$ecommerce_data['events'][0]['params']['session_id'] = $this->session->data['ga4_uuid'];
			}
			
			$url = 'https://www.google-analytics.com/mp/collect?measurement_id=' . $this->config->get('remarketing_ecommerce_ga4_analytics_id') . '&api_secret=' . $this->config->get('remarketing_ecommerce_ga4_measurement_api_secret');
			$ecommerce_data_send = [];
			$ecommerce_data_send = json_encode($ecommerce_data); 
			$content = $ecommerce_data_send;
			
			$this->writeLog('ecommerce_measurement_ga4', $ecommerce_data);
	
			$ch = curl_init();
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				curl_setopt($ch, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
			}
	
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Content-Length: ' . mb_strlen($content)]);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, true); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch);
			curl_close($ch); 
		}
	}

	public function sendFacebook($facebook_data, $order_info = false) {
		if (!$this->isBot()) {
			$data = [];
			
			$data['event_name'] = $facebook_data['event_name'];
			$data['event_time'] = $data['event_id'] = time();
			
			$data['event_source_url'] = rtrim(HTTPS_SERVER, '/') . $this->request->server['REQUEST_URI'];
			
			if (isset($facebook_data['url'])) {
				$data['event_source_url'] = $facebook_data['url'];		
			}
			
			$data['custom_data'] = $facebook_data['custom_data'];
			
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
			
			if (isset($this->session->data['fbc'])) {
				$data['user_data']['fbc'] = $this->session->data['fbc'];
			}
			
			if (isset($this->session->data['fbp'])) {
				$data['user_data']['fbp'] = $this->session->data['fbp'];
			}
		
			if ($this->customer->isLogged()) {
				if ($this->customer->getEmail()) {
					$data['user_data']['em'] = hash('sha256', $this->customer->getEmail());
				}
				if ($this->customer->getFirstName()) {
					$data['user_data']['fn'] = hash('sha256', mb_strtolower($this->customer->getFirstName()));
				}
				if ($this->customer->getLastName()) {
					$data['user_data']['ln'] = hash('sha256', mb_strtolower($this->customer->getLastName()));
				}
				if ($this->customer->getTelephone()) {
					$data['user_data']['ph'] = hash('sha256', preg_replace("/[^0-9]/", '', $this->customer->getTelephone()));
				}
			
				$data['user_data']['external_id'] = hash('sha256', $this->customer->getEmail());
			}
		
			if ($order_info) {
				if (!empty($order_info['email'])) {
					$data['user_data']['em'] = hash('sha256', $order_info['email']);
				}
				if (!empty($order_info['firstname'])) {
					$data['user_data']['fn'] = hash('sha256', mb_strtolower($order_info['firstname']));
				}
				if (!empty($order_info['lastname'])) {
					$data['user_data']['ln'] = hash('sha256', mb_strtolower($order_info['lastname']));
				}
				if (!empty($order_info['telephone'])) {
					$data['user_data']['ph'] = hash('sha256', preg_replace("/[^0-9]/", '', $order_info['telephone']));
				}
				if (!empty($order_info['order_info']['shipping_city'])) {
					$data['user_data']['ct'] = hash('sha256', $order_info['order_info']['shipping_city']);
				}
			}
		
			if (!empty($facebook_data['time'])) {
				$data['event_time'] = $data['event_id'] = $facebook_data['time'];
			}
			
			if (!empty($facebook_data['event_id'])) {
				$data['event_id'] = $facebook_data['event_id'];
			}
			
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
			
			$this->writeLog('facebook', $fb_data);
	
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/x-www-form-urlencoded']);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fb_send_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch); 
			//var_dump($response);
			//var_dump($facebook_data); 
			curl_close($ch); 
		}
	}
	
	public function sendTiktok($tiktok_data, $order_info = false) {
		if (!$this->isBot()) {
			$data = [];
			
			$data['pixel_code'] = $this->config->get('remarketing_tiktok_identifier');
			$data['event'] = $tiktok_data['event_name'];
			$data['event_id'] = $tiktok_data['event_id'];
			$data['timestamp'] = date('c');
			
			$data['properties'] = $tiktok_data['properties'];
			
			
			if ($this->config->get('remarketing_tiktok_test_code') != '') {
				$data['test_event_code'] = $this->config->get('remarketing_tiktok_test_code');
			}
		
			$data['context'] = [];
			
			$data['context']['page']['url'] = rtrim(HTTPS_SERVER, '/') . $this->request->server['REQUEST_URI'];
			
			if (isset($tiktok_data['url'])) {
				$data['context']['page']['url'] = $tiktok_data['url'];		
			}
			
			if (!empty($this->session->data['ttclid'])) {
				$data['context']['ad']['callback'] = $this->session->data['ttclid'];
			}
			
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
			
			$data['context']['user'] = [];
			
			if ($this->customer->isLogged()) {
				if ($this->customer->getEmail()) {
					$data['context']['user']['email'] = hash('sha256', $this->customer->getEmail());
				}
				if ($this->customer->getTelephone()) {
					$data['context']['user']['phone_number'] = hash('sha256', preg_replace("/[^0-9]/", '', $this->customer->getTelephone()));
				}
				$data['context']['user']['external_id'] = hash('sha256', $this->customer->getEmail());
			}

			if (!empty($this->request->cookie['_ttp'])) {
				$data['context']['user']['ttp'] = $this->request->cookie['_ttp'];
			} 
			
			$data['context']['user_agent'] = $ua;
			$data['context']['ip'] = $ip;
				
			if ($order_info) {
				if (!empty($order_info['email'])) {
					$data['context']['user']['email'] = hash('sha256', $order_info['email']);
				}
				if (!empty($order_info['telephone'])) {
					$data['context']['user']['phone_number'] = hash('sha256', preg_replace("/[^0-9]/", '', $order_info['telephone']));
				}
			}
			
			if (!empty($tiktok_data['event_id'])) {
				$data['event_id'] = $tiktok_data['event_id'];
			}
			
			if ($this->config->get('remarketing_tiktok_test_code') != '') {
				$data['test_event_code'] = $this->config->get('remarketing_tiktok_test_code'); 
			}
			
			if (empty($data['context']['user'])) unset($data['context']['user']);
			
			$t_data = json_encode($data); 
	
			$url = 'https://business-api.tiktok.com/open_api/v' . $this->config->get('remarketing_tiktok_api_ver') . '/pixel/track/';
			
			$ch = curl_init();
			
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				curl_setopt($ch, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
			} 
			
			$this->writeLog('tiktok', $t_data);
	
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ['Access-Token: ' . $this->config->get('remarketing_tiktok_token'), 'Content-Type: application/json']);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $t_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch); 
			//var_dump($response);
			//var_dump($t_data);
			curl_close($ch); 
		}
	}
	
	public function sendTelegram($order_id) {
		$order_info = $this->getOrderRemarketing($order_id);
		if ($order_info) {
			$tg_url = 'https://api.telegram.org/bot';
    
			$tg_token = $this->config->get('remarketing_telegram_bot_id');
			$tg_link = $tg_url . $tg_token . '/sendMessage';
			$tg_users = $this->config->get('remarketing_telegram_send_to_id');
			$tg_user_id = explode(',', $tg_users);
			$tg_message = $this->config->get('remarketing_telegram_message');        
	
			$find = [
				'{order_id}',
				'{firstname}',
				'{lastname}',
				'{email}',
				'{telephone}',
				'{total}',
				'{shipping_method}',
				'{payment_method}',
				'{order_status}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			];
	
			$replace = [ 
				'order_id'        => $order_info['order_id'],
				'firstname'       => $order_info['firstname'],
				'lastname'        => $order_info['lastname'],
				'email'  	      => $order_info['order_info']['email'],
				'telephone'       => $order_info['order_info']['telephone'],
				'total'           => $order_info['default_total'],
				'shipping_method' => $order_info['order_info']['shipping_method'],
				'payment_method'  => $order_info['order_info']['payment_method'],
				'order_status'    => $order_info['order_info']['order_status'],
				'company'         => $order_info['order_info']['shipping_company'],
				'address_1'       => $order_info['order_info']['shipping_address_1'],
				'address_2'       => $order_info['order_info']['shipping_address_2'],
				'city'            => $order_info['order_info']['shipping_city'],
				'postcode'        => $order_info['order_info']['shipping_postcode'],
				'zone'            => $order_info['order_info']['shipping_zone'],
				'zone_code'       => $order_info['order_info']['shipping_zone_code'],
				'country'         => $order_info['order_info']['shipping_country']
			];
			
			$tg_message = str_replace($find, $replace, $tg_message);
			
			$products = '';
			foreach ($order_info['products'] as $product) {
				$products .= $product['name'] . ' - ' . $product['price'] . ' х ' . $product['quantity'] . "\n";
			}
			
			$tg_message = str_replace('{products}', $products, $tg_message);
			
			$tg_message = strip_tags($tg_message, '<a><b><i>');
			
			$tg_message = html_entity_decode($tg_message);
			 
			foreach ($tg_user_id as $user_id) {
				$tg_data = [
					'chat_id'    => $user_id,
					'text'       => $tg_message,
					'parse_mode' => 'html'
				];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $tg_link);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $tg_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				$response = curl_exec($ch); 
				curl_close($ch); 
			}
		}
	}
	
	public function sendTelegramMsg($message = '') {

		$tg_url = 'https://api.telegram.org/bot';
    
		$tg_token = $this->config->get('remarketing_telegram_bot_id');
		$tg_link = $tg_url . $tg_token . '/sendMessage';
		$tg_users = $this->config->get('remarketing_telegram_send_to_id');
		$tg_user_id = explode(',', $tg_users);
		$tg_message = '';    
		
		$tg_message = strip_tags($message, '<a><b><i>');
			
		$tg_message = html_entity_decode($tg_message);
		
		foreach ($tg_user_id as $user_id) {
			$tg_data = [
				'chat_id'    => $user_id,
				'text'       => $message,
				'parse_mode' => 'html'
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $tg_link);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $tg_data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$response = curl_exec($ch); 
			curl_close($ch); 
		}
	}
	
	public function remarketingAddToCart($product_info = [], $quantity = 1, $options = '') {
		$json_data = [];
		if ($product_info) {
			$categories = $this->getRemarketingCategories($product_info['product_id']);
			$categories = addslashes($categories);
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$facebook_product_id = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$tiktok_product_id = $this->config->get('remarketing_tiktok_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json_data['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
			$json_data['tiktok_pixel_status'] = $this->config->get('remarketing_tiktok_pixel_status');
			$json_data['snapchat_status'] = $this->config->get('remarketing_snapchat_status');
			$json_data['snapchat_pixel_status'] = $this->config->get('remarketing_snapchat_pixel_status');
			$json_data['esputnik_status'] = $this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier');
			$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$json_data['google_status'] = $this->config->get('remarketing_google_status');
			$json_data['google_ads_identifier_cart'] = $this->config->get('remarketing_google_ads_identifier_cart'); 
			$json_data['facebook_status'] = $this->config->get('remarketing_facebook_status');
			$json_data['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
			$json_data['uet_status'] = $this->config->get('remarketing_uet_status');
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$google_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_google_ads_ratio'), $this->config->get('remarketing_google_currency'), '', false);
			$facebook_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_facebook_ratio'), $this->config->get('remarketing_facebook_currency'), '', false);
			$ecommerce_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			$tiktok_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_tiktok_ratio'), $this->config->get('remarketing_tiktok_currency'), '', false);
			$name = addslashes($product_info['name']);
			$facebook_currency = $this->config->get('remarketing_facebook_currency');
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			$tiktok_currency = $this->config->get('remarketing_tiktok_currency');
			
			$json_data['google_remarketing_event'] = [
				'send_to' => $this->config->get('remarketing_google_identifier'),
				'value'   => $google_price,
				'items'   => [[
					'id' => $this->config->get('remarketing_google_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
					'google_business_vertical' => 'retail'
				]],
			];
			
			$json_data['google_ads_event'] = [
				'send_to' => $this->config->get('remarketing_google_ads_identifier_cart'),
				'value'   => $google_price,
				'currency'   => $this->config->get('remarketing_google_currency')
			];
			
			$json_data['facebook_pixel_event'] = [
				'content_name' => $name,
				'content_ids' => [$facebook_product_id],
				'content_type' => 'product',
				'content_category' => $categories,
				'value'   => $facebook_price,
				'currency'   => $facebook_currency
			];
			
			$json_data['tiktok_event'] = [
				'content_name' => $name,
				'content_id' => $tiktok_product_id,
				'content_type' => 'product',
				'content_category' => $categories,
				'value'   => $tiktok_price * $quantity,
				'price'   => $tiktok_price,
				'quantity'   => $quantity,
				'currency'   => $tiktok_currency
			];
			
			$json_data['snapchat_event'] = [
				'item_ids' => [$this->config->get('remarketing_snapchat_id') == 'id' ? $product_info['product_id'] : $product_info['model']],
				'item_category' => $categories,
				'price'   => $this->currency->format($current_price * (float)$this->config->get('remarketing_snapchat_ratio'), $this->config->get('remarketing_snapchat_currency'), '', false),
				'number_items'   => $quantity,
				'currency'   => $this->config->get('remarketing_snapchat_currency')
			];
			
			$json_data['uet_event'] = [
				'ecomm_prodid' => [$product_info['product_id']], 
				'ecomm_pagetype' => 'product',
				'ecomm_totalvalue' => $ecommerce_price * $quantity,
				'revenue_value' => $ecommerce_price * $quantity,
				'currency' => $ecommerce_currency,
				'items' => [
					['id' => $product_info['product_id'], 'quantity' => $quantity, 'price' => $ecommerce_price]
				]
			];
			
			$ecommerce_ga4_product = [
				'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
				'item_name' => $name, 
				'index' => 1,
				'price' => $ecommerce_price,
				'quantity' => $quantity
			];
			if (!empty($options)) $ecommerce_ga4_product['variant'] = addslashes($options);
			if (!empty($product_info['manufacturer'])) $ecommerce_ga4_product['item_brand'] = addslashes($product_info['manufacturer']);
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = addslashes($ga4_categories[0]);
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);
			
			$json_data['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $ecommerce_currency,
				'value' => $ecommerce_price * $quantity,
				'items' => [$ecommerce_ga4_product]
			];
			
			$json_data['ga4_datalayer'] = [
				'event' => 'ga4_add_to_cart',
				'ecommerce' => [
					'currency' => $ecommerce_currency,
					'items' => [$ecommerce_ga4_product]
				]
			]; 
			
			$fb_time = time();
			$fb_event_id = $tt_event_id = $this->genEventId();
			$json_data['rem_id'] = '7793892706020240358'; 
			$json_data['time'] = $fb_time;
			$json_data['event_id'] = $fb_event_id; 
		
			if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			
				$ecommerce_ga4_product['item_id'] = $this->config->get('remarketing_ecommerce_ga4_measurement_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
				$ecommerce_data = [
					'events' => [[
						'name' => 'add_to_cart',
						'params' => [
							'currency' => $ecommerce_currency,
							'items' => [$ecommerce_ga4_product], 
							'value' => $ecommerce_price
						]],
					],
				];
				
				$this->sendGa4($ecommerce_data);
			}
			
			if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'AddToCart';
				$facebook_data['custom_data'] = [
					'value' => $facebook_price,
					'currency' => $facebook_currency,
					'content_ids' => [
						$facebook_product_id
					],
					'content_name'     => $name,
					'content_category' => $categories,
					'content_type'     => 'product',
					'opt_out'          => false
				];
				$facebook_data['time'] = $fb_time;
				$facebook_data['event_id'] = $fb_event_id;
				$this->sendFacebook($facebook_data);
			}
			
			if ($this->config->get('remarketing_tiktok_status') && $this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token')) {
				$tiktok_data['event_name'] = 'AddToCart';
				$tiktok_data['url'] = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);
				$tiktok_data['properties'] = [
					'contents' => [[
						'content_type'    => 'product',
						'price'           => $tiktok_price,
						'quantity'        => $quantity,
						'content_id'      => $tiktok_product_id,
						'content_name'    => $name,
						'content_category'=> $categories
					]],
					'value'               => $tiktok_price * quantity,
					'currency'            => $tiktok_currency
				];
				$tiktok_data['time'] = date('c');
				$tiktok_data['event_id'] = $json_data['event_id'];
				$this->sendTiktok($tiktok_data);
			} 
			
			if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged() && isset($this->session->data['esputnik_email'])) {
				$this->sendEsputnikCartUpdated();
			}
			
			if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier')) {
			
				$this->session->data['remarketing_esputnik_cart_id'] = $this->genEventId();
			
				$cart_products = [];
				
				foreach ($this->cart->getProducts() as $cart_product) {
					$cart_products[] = [
						'productKey' => $cart_product['product_id'],
						'price' => $this->currency->format($cart_product['price'], $ecommerce_currency, '', false),
						'quantity' => $cart_product['quantity'],
						'currency' => $ecommerce_currency
					];
				}
				
				$json_data['esputnik_event'] = [
					'StatusCart' => $cart_products, 
					'GUID' => $this->session->data['remarketing_esputnik_cart_id']
				];
				
				if ($this->customer->isLogged()) {
				   $json_data['esputnik_event']['GeneralInfo'] = [
						'externalCustomerId' => $this->customer->getEmail(),
						'user_email' => $this->customer->getEmail(),
						'user_phone' => preg_replace("/[^0-9]/", '', $this->customer->getTelephone())
				   ];
				} 
			}
		}
		return $json_data;	 
	}
	
	public function remarketingRemoveFromCart($product_info = [], $quantity = 1) {
		$json_data = [];
		if ($product_info) {
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$json_data['esputnik_status'] = $this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier');
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$ecommerce_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			 
			$ecommerce_ga4_product = [ 
				'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
				'item_name' => addslashes($product_info['name']),
				'index' => 1,
				'price' => $ecommerce_price,
				'quantity' => $quantity
			];
			if (!empty($product_info['manufacturer'])) $ecommerce_ga4_product['item_brand'] = addslashes($product_info['manufacturer']);
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = addslashes($ga4_categories[0]);
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);

			$json_data['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $ecommerce_currency,
				'items' => [$ecommerce_ga4_product]
			]; 
			
			$json_data['ga4_datalayer'] = [
				'event' => 'ga4_remove_from_cart',
				'ecommerce' => [
					'currency' => $ecommerce_currency,
					'items' => [$ecommerce_ga4_product]
				] 
			]; 	
			
			if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
				$ecommerce_ga4_product['item_id'] = $this->config->get('remarketing_ecommerce_ga4_measurement_id') == 'id' ? $product_info['product_id'] : $product_info['model'];

				$ecommerce_data = [
					'events' => [[
						'name' => 'remove_from_cart',
						'params' => [ 
							'currency' => $ecommerce_currency,
							'items' => [$ecommerce_ga4_product],
							'value' => $ecommerce_price * $quantity
						]],
					],
				];
			
				$this->sendGa4($ecommerce_data);
			}
					
			if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged() && isset($this->session->data['esputnik_email'])) {
				$this->sendEsputnikCartUpdated();
			}
			
			if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier')) {
			
				$this->session->data['remarketing_esputnik_cart_id'] = $this->genEventId();
			
				$cart_products = [];
				
				foreach ($this->cart->getProducts() as $cart_product) {
					$cart_products[] = [
						'productKey' => $cart_product['product_id'],
						'price' => $this->currency->format($cart_product['price'], $this->config->get('remarketing_ecommerce_currency'), '', false),
						'quantity' => $cart_product['quantity'],
						'currency' => $ecommerce_currency
					];
				}
				$json_data['esputnik_event'] = [
					'StatusCart' => $cart_products, 
					'GUID' => $this->session->data['remarketing_esputnik_cart_id']
				];
				
				if ($this->customer->isLogged()) {
				$json_data['esputnik_event']['GeneralInfo'] = [
						'externalCustomerId' => $this->customer->getEmail(),
						'user_email' => $this->customer->getEmail(),
						'user_phone' => preg_replace("/[^0-9]/", '', $this->customer->getTelephone())
				];
				} 
			}
		}
		return $json_data;	
	}
	
	public function remarketingWishlist($product_info = []) {
		$json_data = [];
		if ($product_info) {
			$categories = $this->getRemarketingCategories($product_info['product_id']);
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$json_data = [];
			$facebook_product_id = $this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$tiktok_product_id = $this->config->get('remarketing_tiktok_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			$json_data['product_id'] = $product_info['product_id'];
			$json_data['facebook_status'] = $this->config->get('remarketing_facebook_status');
			$json_data['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
			$json_data['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
			$json_data['tiktok_pixel_status'] = $this->config->get('remarketing_tiktok_pixel_status');
			$json_data['snapchat_status'] = $this->config->get('remarketing_snapchat_status');
			$json_data['snapchat_pixel_status'] = $this->config->get('remarketing_snapchat_pixel_status');
			$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			$json_data['esputnik_status'] = $this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier');
			$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
			$facebook_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_facebook_ratio'), $this->config->get('remarketing_facebook_currency'), '', false);
			$ecommerce_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			$tiktok_price = $this->currency->format($current_price * (float)$this->config->get('remarketing_tiktok_ratio'), $this->config->get('remarketing_tiktok_currency'), '', false);
			$brand = addslashes($product_info['manufacturer']);
			$name = addslashes($product_info['name']);
			$json_data['category'] = addslashes($categories);
			$quantity = 1; 
			$facebook_currency = $this->config->get('remarketing_facebook_currency');
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			$tiktok_currency = $this->config->get('remarketing_tiktok_currency');
			$fb_time = time();
			$fb_event_id = $tt_event_id = $this->genEventId();
			$json_data['event_id'] = $fb_event_id;
			$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
			
			$json_data['facebook_pixel_event'] = [
				'content_name' => $name,
				'content_ids' => [$facebook_product_id],
				'content_type' => 'product',
				'content_category' => $json_data['category'],
				'value'   => $facebook_price,
				'currency'   => $facebook_currency
			];
			
			$json_data['tiktok_event'] = [
				'content_name' => $name,
				'content_id' => $tiktok_product_id,
				'content_type' => 'product',
				'content_category' => $json_data['category'],
				'value'   => $tiktok_price,
				'price'   => $tiktok_price,
				'quantity'   => $quantity,
				'currency'   => $tiktok_currency
			];
			
			$json_data['snapchat_event'] = [
				'item_ids' => [$this->config->get('remarketing_snapchat_id') == 'id' ? $product_info['product_id'] : $product_info['model']],
				'item_category' => $categories,
				'price'   => $this->currency->format($current_price * (float)$this->config->get('remarketing_snapchat_ratio'), $this->config->get('remarketing_snapchat_currency'), '', false),
				'number_items'   => $quantity, 
				'currency'   => $this->config->get('remarketing_snapchat_currency')
			];

			$ecommerce_ga4_product = [
				'item_id' => $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'],
				'item_name' => $name,
				'index' => 1,
				'price' => $ecommerce_price,
				'quantity' => $quantity
			];
			if (!empty($brand)) $ecommerce_ga4_product['item_brand'] = $brand;
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = addslashes($ga4_categories[0]);
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);

			$json_data['ecommerce_ga4_event'] = [
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $ecommerce_currency,
				'items' => [$ecommerce_ga4_product]
			];
			
			$json_data['ga4_datalayer'] = [
				'event' => 'ga4_add_to_wishlist',
				'ecommerce' => [
					'items' => [$ecommerce_ga4_product]
				]
			]; 
			
			$json_data['esputnik_event'] = [
				'AddToWishlist' => [
					'productKey' => $json_data['product_id'],
					'price' => $ecommerce_price,
					'isInStock' => ($product_info['quantity'] > 0 ? '1' : '0') 
				]
			];
			
			if ($this->customer->isLogged()) {
			   $json_data['esputnik_event']['GeneralInfo'] = [
					'externalCustomerId' => $this->customer->getEmail(),
					'user_email' => $this->customer->getEmail(),
					'user_phone' => preg_replace("/[^0-9]/", '', $this->customer->getTelephone())
			   ];
			}
			
			if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
				$facebook_data['event_name'] = 'AddToWishlist';
				$facebook_data['custom_data'] = [
					'value' => $facebook_price,
					'currency' => $facebook_currency,
					'content_ids' => [$facebook_product_id],
					'content_name' => $name,
					'content_category' => $categories,
					'content_type' => 'product',
					'opt_out' => false
				];
				$facebook_data['time'] = $fb_time;
				$facebook_data['event_id'] = $fb_event_id;
				
				$this->sendFacebook($facebook_data);
			}
			
			if ($this->config->get('remarketing_tiktok_status') && $this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token')) {
				$tiktok_data['event_name'] = 'AddToWishlist';
				$tiktok_data['url'] = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);
				$tiktok_data['properties'] = [
					'contents' => [[
						'content_type'    => 'product',
						'price'           => $tiktok_price,
						'quantity'        => $quantity,
						'content_id'      => $tiktok_product_id,
						'content_name'    => $name,
						'content_category'=> $categories
					]],
					'value' => $tiktok_price,
					'currency' => $tiktok_currency
				];
				$tiktok_data['time'] = date('c');  
				$tiktok_data['event_id'] = $json_data['event_id'];
				$this->sendTiktok($tiktok_data);
			}
			
			if ($this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
				$ecommerce_data = [
					'events' => [[
						'name' => 'add_to_wishlist',
						'params' => [
							'currency' => $ecommerce_currency,
							'items' => [$ecommerce_ga4_product],
							'value' => $ecommerce_price
						]],
					],
				]; 
				$this->sendGa4($ecommerce_data);
			}
		}
		return $json_data;	
	}
	
	public function remarketingCallback() {
		$json_data = [];
		$json_data['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
		$json_data['tiktok_pixel_status'] = $this->config->get('remarketing_tiktok_pixel_status');
		$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
		$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status');
		$json_data['facebook_status'] = $this->config->get('remarketing_facebook_status');
		$json_data['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
		$json_data['ecommerce_ga4_event'] = [
			'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier')
		];
		return $json_data;	 
	}
	
	public function remarketingFoundCheaper() {
		$json_data = [];
		$json_data['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
		$json_data['tiktok_pixel_status'] = $this->config->get('remarketing_tiktok_pixel_status');
		$json_data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
		$json_data['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status'); 
		$json_data['facebook_status'] = $this->config->get('remarketing_facebook_status');
		$json_data['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
		$json_data['ecommerce_ga4_event'] = [
			'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier')
		];
		return $json_data;	 
	}
	
	public function getQuickOrderOpen($product_info) {
		$json = [];
		if ($product_info && $this->config->get('remarketing_status') && !$this->isBot()) {
			$json['remarketing'] = $this->remarketingAddToCart($product_info, $quantity = 1);
		}
		return $json; 
    } 
	
	public function getQuickOrderSuccess($order_id, $send_history = false) {
		$json['remarketing'] = [];
		$order_info = $this->getOrderRemarketing($order_id);
		if ($order_info) {
			$json['remarketing'] = [];
			$google_products = [];
			$facebook_products = [];
			$tiktok_products = [];
			$reviews_products = [];
			$sputnik_products = []; 
			$google_currency = $this->config->get('remarketing_google_currency');
			$facebook_currency = $this->config->get('remarketing_facebook_currency');
			$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency');
			$tiktok_currency = $this->config->get('remarketing_tiktok_currency');
			$num_items = 0;
			$json['remarketing']['google_identifier'] = $this->config->get('remarketing_google_identifier');
			$json['remarketing']['google_ads_identifier'] = $this->config->get('remarketing_google_ads_identifier');
			$json['remarketing']['google_ads_identifier_cart'] = $this->config->get('remarketing_google_ads_identifier_cart');
			$json['remarketing']['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status') && !$this->config->get('remarketing_ga4_only_purchase');
			$json['remarketing']['ecommerce_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_status') && !$this->config->get('remarketing_ga4_only_purchase');
			$json['remarketing']['ecommerce_ga4_identifier'] = $this->config->get('remarketing_ecommerce_ga4_identifier');
			$json['remarketing']['google_status'] = $this->config->get('remarketing_google_status');
			$json['remarketing']['facebook_status'] = $this->config->get('remarketing_facebook_status');
			$json['remarketing']['tiktok_status'] = $this->config->get('remarketing_tiktok_status');
			$json['remarketing']['tiktok_pixel_status'] = $this->config->get('remarketing_tiktok_pixel_status');
			$json['remarketing']['snapchat_status'] = $this->config->get('remarketing_snapchat_status');
			$json['remarketing']['snapchat_pixel_status'] = $this->config->get('remarketing_snapchat_pixel_status');
			$json['remarketing']['uet_status'] = $this->config->get('remarketing_uet_status');
			$json['remarketing']['esputnik_status'] = $this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier');
			$json['remarketing']['facebook_pixel_status'] = $this->config->get('remarketing_facebook_pixel_status');
			$json['remarketing']['facebook_lead'] = $this->config->get('remarketing_facebook_lead');
			$json['remarketing']['reviews_status'] = $this->config->get('remarketing_reviews_status') && $this->config->get('remarketing_reviews_quick_order_status') && $order_info['email'] && strpos($order_info['email'], 'localhost') === false;
			$json['remarketing']['fb_event_id'] = $order_info['sent_data']['fb_event_id'];
			$json['remarketing']['fb_lead_event_id'] = $order_info['sent_data']['fb_lead_event_id'];
			$json['remarketing']['tt_event_id'] = $order_info['sent_data']['tt_event_id'];
			
			if ($order_info['products']) {
				$i = 1;
				foreach ($order_info['products'] as $product) {
					$google_products[] = [
						'id' => $this->config->get('remarketing_google_id') == 'id' ? $product['product_id'] : $product['model'],
						'google_business_vertical' => 'retail'
					];
					
					$facebook_products[] = [
						'id' => $this->config->get('remarketing_facebook_id') == 'id' ? $product['product_id'] : $product['model'],
						'price' => $product['facebook_price'],
						'quantity' => $product['quantity']
					];
					
					if (!empty($product['product_info'][$this->config->get('remarketing_reviews_feed_gtin')])) {
						$reviews_products[] = ['gtin' => $product['product_info'][$this->config->get('remarketing_reviews_feed_gtin')]];	
					}
					
					$tiktok_products[] = [
						'content_id' => $product['product_id'],
						'content_name' => $product['product_id'],
						'content_category' => $product['category'],
						'price' => $product['tiktok_price'],
						'quantity' => $product['quantity']
					];

					$sputnik_products[] = [
						'productKey'    => $product['product_id'],
						'price'   => $product['ecommerce_price'],
						'quantity'   => $product['quantity'],
						'currency' => $ecommerce_currency
					];

					$i++;
					$num_items += $product['quantity'];
				}
			}
			
			$json['remarketing']['ga4_datalayer'] = $order_info['ga4_datalayer'];
			 
			$json['remarketing']['ga4_event'] = $order_info['ga4_event']; 
			 
			$json['remarketing']['snapchat_event'] = $order_info['snapchat_data']; 
			
			$json['remarketing']['uet_event'] = $order_info['uet_data']; 
			 
			$json['remarketing']['ads_event'] = [
				'send_to' => $json['remarketing']['google_identifier'],
				'value' => $order_info['google_total'],
				'items' => $google_products
			];
			
			$json['remarketing']['ads_conversion_event'] = [ 
				'send_to' => $json['remarketing']['google_ads_identifier'],
				'value' => $order_info['google_total'],
				'currency' => $google_currency
			];
			
			$json['remarketing']['ads_user_data'] = [ 
				'email' => $order_info['email'],
				'phone_number' => $order_info['telephone']
			];
			
			if (empty($order_info['email']) || strpos($order_info['email'], 'localhost') === false) {
				unset($json['remarketing']['ads_user_data']['email']);
			}
			
			$json['remarketing']['facebook_event'] = [
				'contents' => $facebook_products,
				'content_type' => 'product',
				'num_items' => $num_items,
				'value' => $order_info['facebook_total'],
				'currency' => $facebook_currency
			];
			
			$json['remarketing']['facebook_lead_event'] = [
				'value' => $order_info['facebook_total'],
				'currency' => $facebook_currency
			];
			
			$facebook_send_status = $this->config->get('remarketing_facebook_send_status');
			$facebook_lead_send_status = $this->config->get('remarketing_facebook_lead_send_status');
			
			if ($this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token') && (is_array($facebook_send_status) && !in_array($order_info['order_status_id'], $facebook_send_status))) {
				$json['remarketing']['facebook_status'] = NULL; 
			} 
			
			if ($this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token') && (is_array($facebook_lead_send_status) && !in_array($order_info['order_status_id'], $facebook_lead_send_status))) {
				$json['remarketing']['facebook_lead'] = NULL;  
			} 
			
			$json['remarketing']['tt_event'] = [
				'contents' => $tiktok_products,
				'content_type' => 'product',
				'num_items' => $num_items,
				'value' => $order_info['tiktok_total'],
				'currency' => $tiktok_currency
			];
			
			$tiktok_send_status = $this->config->get('remarketing_tiktok_send_status');
			if (is_array($tiktok_send_status) && !in_array($order_info['order_status_id'], $tiktok_send_status)) {
				$json['remarketing']['tiktok_pixel_status']  = NULL; 
			}
				
			$json['remarketing']['reviews_event'] = [
				'merchant_id' => $this->config->get('remarketing_google_merchant_identifier'),
				'order_id' => $order_info['order_id'],
				'email' => $order_info['email'],
				'delivery_country' => $this->config->get('remarketing_reviews_country'),
				'estimated_delivery_date' => date('Y-m-d', time() + 3600 * 24 * (int)$this->config->get('remarketing_reviews_date')),
				'opt_in_style' => 'CENTER_DIALOG',
				'products' => $reviews_products
			];
 
			$json['remarketing']['esputnik_event'] = [
				'PurchasedItems' => $sputnik_products,  
				'OrderNumber' => $order_info['order_id'] 
			];

			if (!empty($order_info['email'])) {
				$json['remarketing']['esputnik_event']['GeneralInfo'] = [
					'externalCustomerId' => $order_info['email'],
					'user_email' => $order_info['email']
				];
			}
		    
			if (!empty($order_info['telephone'])) {
				$json['remarketing']['esputnik_event']['GeneralInfo'] = [
					'user_phone' => preg_replace("/[^0-9]/", '', $order_info['telephone'])	
				];
			}
						
			if ($send_history) {
				$this->load->model('checkout/order'); 				
				$this->model_checkout_order->addOrderHistory($order_id, $order_info['order_status_id'], 'remarketing_quick_order');
			}
		}
		
		return $json['remarketing'];
    }

	
	public function isBot() {
		if (!empty($this->request->server['HTTP_USER_AGENT']) && !$this->config->get('remarketing_bot_status')) {
			if (preg_match('/abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|speed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|Lighthouse|lighthouse|YandexMobileBot|yandex|Chrome-Lighthouse|yeti|Zeus/i', $this->request->server['HTTP_USER_AGENT'])) {
				return true; 
			}
		}
		if ($this->config->get('remarketing_admin_status') && (!empty($this->session->data['user_id']) || !empty($this->session->data['api_id']))) {
			return true; 
		}
		return false;
	}
	
	public function writeLog($source, $event) {
		if (!$this->config->get('remarketing_debug_mode')) return;
        if ($event) {
            $log = new Log($source . '-' . date('d-m-Y') . '.log');
            $log->write($event);
        }
    }
	
	public function setSuccessPage($order_id) {
        if (!empty($order_id)) { 
			unset($this->session->data['remarketing_esputnik_cart_id']); 
			unset($this->session->data['remarketing_order_id']); 
			unset($this->session->data['order_id']); 
			setcookie('remarketing_order_id', $order_id, time() - 3600, '/');
			$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `success_page` = NOW() WHERE order_id = '" . (int)$order_id . "'");
		}
    }
	
	public function setSend($order_id, $source) {
        if (!empty($order_id)) {
			$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `" . $this->db->escape($source) . "` = NOW() WHERE order_id = '" . (int)$order_id . "'");
		}
    }
	
	/**
     * Creates a new guid v4 - via https://stackoverflow.com/a/15875555
     * @return string A 36 character string containing dashes.
     */
    public function genEventId() {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
	
	public function getCid() {
		$cid = '';
        if (isset($this->request->cookie['_ga'])) {
			$cookie = explode('.', $this->request->cookie['_ga']);
			if (isset($cookie['2']) && isset($cookie['3'])) {
				$uuid = $cookie['2'] . '.' . $cookie['3'];
				$cid = $uuid;
			}
		} elseif (isset($this->request->cookie['__utma'])) {
			$cookie = explode('.', $this->request->cookie['__utma']);
			if (isset($cookie['1']) && isset($cookie['2'])) {
				$uuid = $cookie['1'] . '.' . $cookie['2'];
				$cid = $uuid;
			}
		} elseif (isset($this->request->cookie['remarketing_cid'])) {
			$cid = $this->request->cookie['remarketing_cid'];
		} else {
			$cid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',  mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),  mt_rand( 0, 0xffff ),  mt_rand( 0, 0x0fff ) | 0x4000,  mt_rand( 0, 0x3fff ) | 0x8000,  mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));		
			setcookie('remarketing_cid', $cid, time() + 24 * 3600 * 30, '/');
		} 
		
		$this->session->data['uuid'] = $cid;
		
		$ga4_session_id = ''; 
		$cookie_name = '_ga_' . str_replace('G-', '', $this->config->get('remarketing_ecommerce_ga4_analytics_id'));
        if (isset($this->request->cookie[$cookie_name])) {
			$parts = explode('.', $this->request->cookie[$cookie_name]);
			if (isset($parts['2'])) {
				$ga4_session_id = $parts['2'];
				$this->session->data['ga4_uuid'] = $ga4_session_id;
			}
			setcookie('remarketing_ga4_cid', $ga4_session_id, time() + 24 * 3600 * 30, '/');
		} elseif (isset($this->request->cookie['remarketing_ga4_cid'])) {
			$ga4_session_id = $this->request->cookie['remarketing_ga4_cid'];
			$this->session->data['ga4_uuid'] = $ga4_session_id;
		} else {
			$ga4_session_id = $this->session->data['uuid'];
			$this->session->data['ga4_uuid'] = $ga4_session_id;
		} 
		
    }
	
	public function trackUtm() {
		
		$get_params = [
			'gclid',
			'dclid',
			'utm_source',
			'utm_campaign',
			'utm_term',
			'utm_medium',
			'utm_content',
			'ttclid'
		];

		foreach ($get_params as $get_param) {
			if (isset($this->request->get[$get_param])) {
				$this->session->data[$get_param] = $this->request->get[$get_param];
			}
		}
		
		if (isset($this->request->cookie['_fbp'])) {
			$this->session->data['fbp'] = $this->request->cookie['_fbp'];
		}

		if (isset($this->request->cookie['_fbc'])) {
			$this->session->data['fbc'] = $this->request->cookie['_fbc'];
		}
		
		if (isset($this->request->get['fbclid'])) {
			$this->session->data['fbc'] = 'fb' . '.' . '1' . '.' . time() . '.' . $this->request->get['fbclid'];
		}
 
		if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
			if (empty($this->session->data['esputnik_email']) && $this->customer->getEmail()) {
				$this->session->data['esputnik_email'] = $this->customer->getEmail();
			}
			
			if (empty($this->session->data['esputnik_telephone']) && $this->customer->getTelephone()) {
				$this->session->data['esputnik_telephone'] = $this->customer->getTelephone();
			}
			
			if (empty($this->session->data['esputnik_uniq'])) {
				$this->session->data['esputnik_uniq'] = uniqid();
			}
		}

		if (!headers_sent()) {
			$last_referrer = 'Direct';
			if (!isset($this->request->cookie['first_referrer'])) {
				if (!empty($this->request->get['referrer'])) {
					$first_referrer = $this->request->get['referrer'];
				} elseif (!empty($this->request->server['HTTP_REFERER']) && strpos($this->request->server['HTTP_REFERER'], $this->request->server['SERVER_NAME']) == false) {
					$first_referrer = parse_url($this->request->server['HTTP_REFERER'], PHP_URL_HOST);
				} else {
					$first_referrer = 'Direct'; 
				}
				setcookie('first_referrer', $first_referrer, time() + 3600 * 24 * 365, '/');
				$this->session->data['first_referrer'] = $first_referrer;
			} else {
				$this->session->data['first_referrer'] = $this->request->cookie['first_referrer'];
			}

			if (!isset($this->request->cookie['last_referrer'])) {
				if (!empty($this->request->get['referrer'])) {
					$last_referrer = $this->request->get['referrer'];
				} elseif (!empty($this->request->server['HTTP_REFERER']) && strpos($this->request->server['HTTP_REFERER'], $this->request->server['SERVER_NAME']) == false) {
					$last_referrer = parse_url($this->request->server['HTTP_REFERER'], PHP_URL_HOST);
				} else {
					$last_referrer = 'Direct';
				}
				setcookie('last_referrer', $last_referrer, time() + 3600 * 24 * 365, '/');
				$this->session->data['last_referrer'] = $last_referrer;
			} else {  
				if (!empty($this->request->server['HTTP_REFERER']) && strpos($this->request->server['HTTP_REFERER'], $this->request->server['SERVER_NAME']) == false && parse_url($this->request->server['HTTP_REFERER'], PHP_URL_HOST) != $this->request->cookie['last_referrer']) {
					setcookie('last_referrer', parse_url($this->request->server['HTTP_REFERER'], PHP_URL_HOST), time() + 3600 * 24 * 365, '/');
					$this->session->data['last_referrer'] = parse_url($this->request->server['HTTP_REFERER'], PHP_URL_HOST);
				} else {
					$this->session->data['last_referrer'] = $this->request->cookie['last_referrer'];
				}
			}
		}
    }
	
	public function getRemarketingCategories($product_id) {
		$category_data = '';
		$category_query = $this->db->query("SELECT DISTINCT cd.name FROM `" . DB_PREFIX . "product_to_category` pc LEFT JOIN `" . DB_PREFIX . "category_description` cd ON pc.category_id = cd.category_id LEFT JOIN `" . DB_PREFIX . "category_path` cp ON pc.category_id = cp.category_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cp.level ASC LIMIT 5");
		foreach ($category_query->rows as $category) {
			$category_data .= $category['name'] . '/';
		}
		$category_data = rtrim($category_data, '/');
		return $category_data;
	}
	 
	public function getRemarketingCategoriesGa4($product_id) {
		$category_data = [];
		$category_query = $this->db->query("SELECT DISTINCT cd.name FROM `" . DB_PREFIX . "product_to_category` pc LEFT JOIN `" . DB_PREFIX . "category_description` cd ON pc.category_id = cd.category_id LEFT JOIN `" . DB_PREFIX . "category_path` cp ON pc.category_id = cp.category_id WHERE pc.product_id = '" . (int)$product_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cp.level ASC LIMIT 5");
		foreach ($category_query->rows as $category) {
			$category_data[] = $category['name'];
		}
		return $category_data; 
	}
	 
	public function makeRemarketingOrder($name = '', $telephone = '', $email = '', $comment = '', $product_id = '', $quantity = 1, $order_status_id = 0) {
		
		$json = [];
		
		if (empty($name) && empty($telephone) && empty($email)) return 'No Data';
			
		$order_data = [];
	
		$totals = [];
		
		$total = 0;
	
		$order_data['totals'] = [];
	
		$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
		$order_data['store_id'] = $this->config->get('config_store_id');
		$order_data['store_name'] = $this->config->get('config_name');
	
		if ($order_data['store_id']) {
			$order_data['store_url'] = $this->config->get('config_url');
		} else {
			$order_data['store_url'] = HTTPS_SERVER;
		}
	
		$order_firstname = '';
		$order_telephone = '';
		$order_comment = '';
		$order_email = 'noemail@' . $this->request->server['SERVER_NAME'];
		
		if (!empty($name)) {
			$order_firstname = $name;
		}
		
		if (!empty($telephone)) {
			$order_telephone = $telephone;
		}
	
		if (!empty($email)) {
			$order_email = $email;
		}
	
		if (!empty($comment)) {
			$order_comment = $comment;
		}
	
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');
	
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
	
			$order_data['customer_id'] = $this->customer->getId();
			$order_data['customer_group_id'] = $customer_info['customer_group_id'];
			$order_data['firstname'] = $order_firstname;
			$order_data['lastname'] = $customer_info['lastname'];
			$order_data['email'] = $order_email;
			$order_data['telephone'] = $order_telephone;
			$order_data['fax'] = '';
			$order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
		} else {
			$order_data['customer_id'] = 0;
			$order_data['customer_group_id'] = 0;
			$order_data['firstname'] = $order_firstname;
			$order_data['lastname'] = '';
			$order_data['email'] = $order_email;
			$order_data['telephone'] = $order_telephone;
			$order_data['fax'] = '';
			$order_data['custom_field'] = [];
		}
	
		$order_data['payment_firstname'] = $order_firstname;
		$order_data['payment_lastname'] = '';
		$order_data['payment_company'] = '';
		$order_data['payment_address_1'] = '';
		$order_data['payment_address_2'] = '';
		$order_data['payment_city'] = '';
		$order_data['payment_postcode'] = '';
		$order_data['payment_zone'] = '';
		$order_data['payment_zone_id'] = '';
		$order_data['payment_country'] = '';
		$order_data['payment_country_id'] = '';
		$order_data['payment_address_format'] = '';
		$order_data['payment_custom_field'] = [];
		$order_data['payment_method'] = '';
		$order_data['payment_code'] = '';
	
		$order_data['shipping_firstname'] = $order_firstname;
		$order_data['shipping_lastname'] = '';
		$order_data['shipping_company'] = '';
		$order_data['shipping_address_1'] = '';
		$order_data['shipping_address_2'] = '';
		$order_data['shipping_city'] = '';
		$order_data['shipping_postcode'] = '';
		$order_data['shipping_zone'] = '';
		$order_data['shipping_zone_id'] = '';
		$order_data['shipping_country'] = '';
		$order_data['shipping_country_id'] = '';
		$order_data['shipping_address_format'] = '';
		$order_data['shipping_custom_field'] = [];
		$order_data['shipping_method'] = '';
		$order_data['shipping_code'] = '';
	
		$order_data['products'] = [];
	
		if (!empty($product_id)) {
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				
				$price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
				
				$total = $price * $quantity;
				
				$option_data = [];

				$order_data['products'][] = [
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'option'     => $option_data,
					'download'   => '',
					'quantity'   => $quantity,
					'subtract'   => $product_info['subtract'],
					'price'      => $price * $quantity,
					'total'      => $price * $quantity,
					'tax'        => 0,
					'reward'     => $product_info['reward']
				];
			}
		}

		$order_data['vouchers'] = [];
	
		$order_data['comment'] = $order_comment;
		$order_data['total'] = $total;
	
		$order_data['affiliate_id'] = 0;
		$order_data['commission'] = 0;
		$order_data['marketing_id'] = 0;
		$order_data['tracking'] = '';
	
		$order_data['language_id'] = $this->config->get('config_language_id');
		$order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
		$order_data['currency_code'] = $this->session->data['currency'];
		$order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
		$order_data['ip'] = $this->request->server['REMOTE_ADDR']; 
	
		if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
			$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
			$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
		} else {
			$order_data['forwarded_ip'] = '';
		}
	
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
		} else {
			$order_data['user_agent'] = '';
		}
	
		if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
			$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
		} else {
			$order_data['accept_language'] = '';
		}
	
		$this->load->model('checkout/order');
	
		$this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);
		
		if ($order_status_id != 0) {
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $order_status_id); 
		}
		
		return $this->session->data['order_id'];
	}
	
	public function processCategory($category_info = [], $heading_title = '', $results = []) {

	  if (empty($results)) {
		  $data['remarketing_code'] = '';
		  return $data;
	  }
	
	  $products = [];
	  
	  foreach($results as $result) {
		  $products[] = [
			  'manufacturer'    => !empty($result['manufacturer']) ? $result['manufacturer'] : '',
			  'model'           => $result['model'],
			  'google_price'    => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_google_currency'), '', false),
			  'facebook_price'  => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_facebook_currency'), '', false),
			  'ecommerce_price' => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_ecommerce_currency'), '', false),
			  'tiktok_price'    => $this->currency->format($result['special'] ? $result['special'] : $result['price'], $this->config->get('remarketing_tiktok_currency'), '', false),
			  'product_id'      => $result['product_id'],
			  'name'            => $result['name'],
		  ];
	  }
	
      $search_page = (!empty($this->request->get['route']) && $this->request->get['route'] == 'product/search' && !empty($this->request->get['search'])) ? true : false;
	  $output = '';
	  $google_page = 'view_item_list';
	  $google_ids = [];
	  $facebook_ids = [];
	  $tiktok_ids = [];   
	  $uet_ids = [];   
	  $data = [];
	  
	  foreach($products as $product) {
		  $google_ids[] = $this->config->get('remarketing_google_id') == 'id' ? $product['product_id'] : $product['model'];
		  $facebook_ids[] = $this->config->get('remarketing_facebook_id') == 'id' ? $product['product_id'] : $product['model'];
	      $tiktok_ids[] = $this->config->get('remarketing_tiktok_id') == 'id' ? $product['product_id'] : $product['model'];
	      $uet_ids[] = $product['product_id'];
	  }
	  
	  if ($search_page) {
	      $google_page = 'view_search_results';
		  $data['view_search_results'] = true;
	  }
	  
	  if ($this->config->get('remarketing_google_status') && $this->config->get('remarketing_google_identifier')) {
		  $data['remarketing_google_json'] = [];
		  if ($google_page) {
			$items = [];
			if (isset($google_ids) && count($google_ids) > 0) {
				foreach ($google_ids as $item) {
					$items[] = [
						'id' => $item, 
						'google_business_vertical' => 'retail'
					];
				} 
			}
			$data['remarketing_google_json'] = [
				'event' => $google_page,
				'data'  => [
					'send_to' => $this->config->get('remarketing_google_identifier'),
					'items'   => $items
				]
			];
			}
	  }
	  
	  $fb_event_id = $this->genEventId();
	  $fb_time = time();
	   
	  if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_identifier') && $this->config->get('remarketing_facebook_pixel_status')) {
	  	  $data['facebook_remarketing_status'] = true;
	  	  $output .= '<script>' . "\n";
	  	  $output .= "$(document).ready(function() {" . "\n";
	  	  $output .= "if (typeof fbq != 'undefined') {" . "\n";
		  if (!$search_page) {
			  $output .= "fbq('trackCustom', 'ViewCategory', {" . "\n";
		  } else {
			  $output .= "fbq('track', 'Search', {" . "\n";
			  $output .= "search_string: '" . $this->request->get['search'] . "'," . "\n";
		  }
	  	  $output .= "content_name: '" . $heading_title . "'," . "\n";
	  	  if (!empty($facebook_ids)) {
			  $output .= "content_ids: ['" . implode('\',\'', $facebook_ids) . "']," . "\n";
	  	  }
	  	  $output .= "content_type: 'product'," . "\n";
	  	  $output .= "currency: '" . $this->config->get('remarketing_facebook_currency') . "'," . "\n";
	  	  $output .= "value: 0" . "\n";
	  	  $output .= '}, {eventID: "' . $fb_event_id . '"})}});' . "\n</script>\n";
	  }
	  if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
		  $data['facebook_remarketing_status'] = true;
		  $content_ids = [];
		  if (isset($facebook_ids) && count($facebook_ids) > 0) {
			 foreach ($facebook_ids as $id) {
				$content_ids[] = $id;
			 }
	  	  }
		  if (!$search_page) {
		  	  $data['facebook_data_json_category']['products'] = [
		  	  	  'value'            => 0,
		  	  	  'currency'         => $this->config->get('remarketing_facebook_currency'),
		  	  	  'content_ids'      => $content_ids,
		  	  	  'content_type'     => 'product',
		  	  	  'content_name'     => addslashes($heading_title),
		  	  	  'content_category' => !empty($category_info['name']) ? addslashes($category_info['name']) : '',
		  	  	  'opt_out'          => false
		  	  ];
		  } else {
		  	  $data['facebook_data_json_category']['products'] = [
		  	  	  'value'            => 0,
		  	  	  'currency'         => $this->config->get('remarketing_facebook_currency'),
		  	  	  'content_ids'      => $content_ids,
		  	  	  'content_type'     => 'product',
		  	  	  'content_name'     => addslashes($heading_title),
		  	  	  'search_string'    => addslashes($this->request->get['search']),
		  	  	  'content_category' => !empty($category_info['name']) ? addslashes($category_info['name']) : '',
		  	  	  'opt_out'          => false
		  	  ];
		  }
		  $data['facebook_data_json_category']['time'] = $fb_time;
		  $data['facebook_data_json_category']['event_id'] = $fb_event_id;
	  }
	  
	  if ($this->config->get('remarketing_tiktok_status')) { 
		  if ($this->config->get('remarketing_tiktok_pixel_status') && $search_page) {
		  	  $tt_ids = [];
		  	  if (count($tiktok_ids) > 0) {
		  	  	  foreach ($tiktok_ids as $tt_id) {
		  	  	  	  $tt_ids[] = [
		  	  	  	  	  'content_type' => 'product',
		  	  	  	  	  'content_id' => $tt_id,
		  	  	  	  	  'quantity' => 1
		  	  	  	  ];
		  	  	  }
		  	  	  $tt_event_id = $this->genEventId();
		  	  	  $output .= '<script>' . "\n";
		  	  	  $output .= "$(document).ready(function() {" . "\n";
		  	  	  $output .= "if (typeof ttq != 'undefined') {" . "\n";
		  	  	  $output .= "ttq.track('Search', {" . "\n"; 
		  	  	  $output .= "content_type: 'product_group'," . "\n";
		  	  	  $output .= "contents: " . json_encode($tt_ids) . "," . "\n";
		  	  	  $output .= "query: '" . addslashes($this->request->get['search']) . "'," . "\n";
		  	  	  $output .= "value: '0'," . "\n";
		  	  	  $output .= "currency: '" . $this->config->get('remarketing_tiktok_currency') . "'" . "\n";
		  	  	  $output .= '}, {eventID: "' . $tt_event_id . '"})}});' . "\n</script>\n"; 	
		  	    }
		    }
	    }

		if ($this->config->get('remarketing_ecommerce_status')) {
			$data['ecommerce_status'] = $this->config->get('remarketing_ecommerce_status');
			$data['ga4_datalayer'] = [];
			$data['measurement_status'] = $this->config->get('remarketing_ecommerce_measurement_status');
			$currency = $this->config->get('remarketing_ecommerce_currency');
			
			$ecommerce_ga4_products = [];
			
			$i = 0;
			foreach ($products as $remarketing_product) {
				$ecommerce_ga4_products[$i] = [];
				$ecommerce_ga4_products[$i]['item_name'] = addslashes($remarketing_product['name']);
				$ecommerce_ga4_products[$i]['item_id'] = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $remarketing_product['product_id'] : $remarketing_product['model']);
				$ecommerce_ga4_products[$i]['price'] = $remarketing_product['ecommerce_price'];
				if (!empty($remarketing_product['manufacturer'])) $ecommerce_ga4_products[$i]['item_brand'] = addslashes($remarketing_product['manufacturer']);
				$ecommerce_ga4_products[$i]['item_list_name'] = addslashes($heading_title);
				$ecommerce_ga4_products[$i]['item_category'] = addslashes($heading_title);
				$ecommerce_ga4_products[$i]['index'] = $i+1;
				$ecommerce_ga4_products[$i]['quantity'] = 1; 
				$i++;
			}
			
			$data['ga4_datalayer'] = [
				'event' => 'ga4_view_item_list',
				'ecommerce' => [ 
					'currency' => $currency,
					'items' => $ecommerce_ga4_products
				]
			]; 
		}
		 
		if ($this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			$data['ecommerce_ga4_status'] = true;
			$data['ga4_json'] = [];
			$data['measurement_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_measurement_status');
			
			$currency = $this->config->get('remarketing_ecommerce_currency');
			$i = 0;
			foreach ($products as $remarketing_product) {
				$data['ga4_json'][$i] = [];
				$data['ga4_json'][$i]['item_name'] = addslashes($remarketing_product['name']);
				$data['ga4_json'][$i]['item_id'] = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $remarketing_product['product_id'] : $remarketing_product['model']);
				$data['ga4_json'][$i]['price'] = $remarketing_product['ecommerce_price'];
				if (!empty($remarketing_product['manufacturer'])) $data['ga4_json'][$i]['item_brand'] = addslashes($remarketing_product['manufacturer']);
				$data['ga4_json'][$i]['item_list_name'] = addslashes($heading_title);
				$data['ga4_json'][$i]['item_category'] = addslashes($heading_title);
				$data['ga4_json'][$i]['index'] = $i+1;
				$data['ga4_json'][$i]['quantity'] = 1;
				$i++;
			}

			$data['remarketing_ecommerce_ga4_selector'] = $this->config->get('remarketing_ecommerce_ga4_selector');
		}
		
		if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
			$data['esputnik_remarketing_status'] = true;
			$data['esputnik_data_category_json'] = [
				'productCategoryId' => addslashes($heading_title)
			];
		} 
		
		if ($this->config->get('remarketing_esputnik_status') && $this->config->get('remarketing_esputnik_webtracking_status') && $this->config->get('remarketing_esputnik_webtracking_identifier') && $search_page) {
			$esputnik_general_info = '';
			if ($this->customer->isLogged()) {
				$esputnik_general_info = '"GeneralInfo": {
					"externalCustomerId": "' . $this->customer->getEmail() . '",
					"user_email": "' . $this->customer->getEmail() . '",
					"user_phone": "' . preg_replace("/[^0-9]/", '', $this->customer->getTelephone()) . '"}';
			}
			$output .= "<script>$(window).ready(function(){ if (typeof eS != 'undefined') { eS('sendEvent', 'SearchRequest', {'SearchRequest': {'search': '" . addslashes($this->request->get['search']) . "', 'isFound': '" . (count($products) > 0 ? '1' : '0') . "'}}, {" . $esputnik_general_info . "});}})</script>\n\n";
		}  
		
		if ($this->config->get('remarketing_snapchat_status') && $this->config->get('remarketing_snapchat_pixel_status')) {
			$snapchat_ids = [];
			$snapchat_brands = [];
			foreach ($products as $remarketing_product) {
				$snapchat_ids[] = $this->config->get('remarketing_snapchat_id') == 'id' ? $remarketing_product['product_id'] : $remarketing_product['model'];
				$snapchat_brands[] = $remarketing_product['manufacturer'];
			}
			
			$snapchat_data = [
				'currency' => $this->config->get('remarketing_snapchat_currency'),
				'item_ids' => $snapchat_ids,
				'number_items' => count($snapchat_ids),
				'item_category' => !empty($category_info['name']) ? $category_info['name'] : $heading_title
			];
			if (!empty($snapchat_brands)) {
				$snapchat_data['brands'] = array_unique($snapchat_brands);
			}
			
			if ($search_page) {
				$snapchat_data['search_string'] = $this->request->get['search'];
			}
			$output .= "<script>" . "\n";
			$output .= "if (typeof snaptr != 'undefined') {" . "\n";
			$output .= "snaptr('track','" . ($search_page ? 'SEARCH' : 'VIEW_CONTENT') . "', " . json_encode($snapchat_data) . ");" . "\n";
			$output .= "}" . "\n";
			$output .= "</script>" . "\n";
		}	
		
		if ($this->config->get('remarketing_uet_status')) {
			$uet_data = [
				'ecomm_pagetype' => $search_page ? 'searchresults' : 'category',
				'ecomm_prodid' => $uet_ids
			];
			if ($search_page) {
				$uet_data['ecomm_query'] = $this->request->get['search'];
			} else {
				$uet_data['ecomm_category'] = !empty($category_info['category_id']) ? $category_info['category_id'] : '0';
			}
			$output .= "<script>window.uetq = window.uetq || [];window.uetq.push('event', '', " . json_encode($uet_data) . ");</script>" . "\n";
		}	
		
		$data['remarketing_code'] = $this->load->view('extension/module/remarketing', $data);
		if (!empty($output)) { 
			$data['remarketing_code'] .= $output;
		}
		 
		return $data;
	}	
		
	public function processProduct($product_info = [], $category_info = []) {
		if (empty($product_info)) return [];
		$data = [];
		$output = '';
		$data['facebook_remarketing_status'] = false;
		$data['google_remarketing_status'] = false; 
		$current_price = $product_info['special'] ? $product_info['special'] : $product_info['price'];
		$product_price = $this->currency->format($current_price, $this->session->data['currency'], '', false);
		$google_price = $this->currency->format($current_price, $this->config->get('remarketing_google_currency'), '', false);
		$facebook_price = $this->currency->format($current_price, $this->config->get('remarketing_facebook_currency'), '', false);
		$tiktok_price = $this->currency->format($current_price, $this->config->get('remarketing_tiktok_currency'), '', false);
		$snapchat_price = $this->currency->format($current_price, $this->config->get('remarketing_snapchat_currency'), '', false);
		$ecommerce_price = $this->currency->format($current_price, $this->config->get('remarketing_ecommerce_currency'), '', false);
		$ecommerce_product_id = ($this->config->get('remarketing_ecommerce_ga4_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
		$snapchat_id = ($this->config->get('remarketing_snapchat_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
		$remarketing_product_id = ($this->config->get('remarketing_google_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
		$snapchat_currency = $this->config->get('remarketing_snapchat_currency');
		$fb_time = time();
		$fb_event_id = $tt_event_id = $this->genEventId();
		
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_identifier') && $this->config->get('remarketing_facebook_pixel_status')) {
			$data['facebook_remarketing_status'] = true;
			$output .= '<script>' . "\n";
			$output .= "$(document).ready(function() {" . "\n";
			$output .= "if (typeof fbq != 'undefined') {" . "\n";
			$output .= "fbq('track', 'ViewContent', {" . "\n";
			$output .= "content_name: '" . addslashes($product_info['name']) . "'," . "\n";
			if (!empty($category_info['name'])) $output .= "content_category: '" . addslashes($category_info['name']) . "'," . "\n";
			$output .= "content_ids: ['" . ($this->config->get('remarketing_facebook_id') == 'id' ? $product_info['product_id'] : $product_info['model']) . "']," . "\n";
			$output .= "content_type: 'product'," . "\n";
			$output .= 'value: ' . $facebook_price . ',' . "\n";
			$output .= "currency: '" . $this->config->get('remarketing_facebook_currency') . "'" . "\n";
			$output .= '}, {eventID: "' . $fb_event_id . '"})}});' . "\n</script>\n";	
		}
		
		if ($this->config->get('remarketing_tiktok_status')) { 
			$data['tiktok_id'] = ($this->config->get('remarketing_tiktok_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
			$data['tiktok_remarketing_status'] = true;
			if ($this->config->get('remarketing_tiktok_pixel_status')) {
				$output .= '<script>' . "\n";
				$output .= "$(document).ready(function() {" . "\n";
				$output .= "if (typeof ttq != 'undefined') {" . "\n";
				$output .= "ttq.track('ViewContent', {" . "\n"; 
				$output .= "content_name: '" . addslashes($product_info['name']) . "'," . "\n";
				if (!empty($category_info['name'])) $output .= "content_category: '" . addslashes($category_info['name']) . "'," . "\n";
				$output .= "content_id: '" . $data['tiktok_id'] . "'," . "\n";
				$output .= "price: '" . $tiktok_price . "'," . "\n";
				$output .= "content_type: 'product'," . "\n";
				$output .= 'value: ' . $tiktok_price . ',' . "\n";
				$output .= "currency: '" . $this->config->get('remarketing_tiktok_currency') . "'" . "\n";
				$output .= '}, {eventID: "' . $tt_event_id . '"})}});' . "\n</script>\n"; 	
			}
			if ($this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token')) {
				$data['tiktok_remarketing_status'] = true; 
				$data['tiktok_data_json']['properties'] = [
					'contents' => [[
						'price' => $tiktok_price,
						'content_type'     => 'product',
						'content_name'     => addslashes($product_info['name']),
						'content_category' => !empty($category_info['name']) ? addslashes($category_info['name']) : '',
						'content_id'       => $data['tiktok_id']
					]],
					'value'            => $tiktok_price,
					'currency'         => $this->config->get('remarketing_tiktok_currency')
				];
				$data['tiktok_data_json']['event_id'] = $tt_event_id;
			}
		}
		
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token')) {
			$data['facebook_remarketing_status'] = true; 
			$data['facebook_id'] = ($this->config->get('remarketing_facebook_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
			$data['facebook_data_json']['products'] = [
				'value'            => $facebook_price,
				'currency'         => $this->config->get('remarketing_facebook_currency'),
				'content_ids'      => [$data['facebook_id']],
				'content_type'     => 'product',
				'content_name'     => addslashes($product_info['name']),
				'content_category' => !empty($category_info['name']) ? addslashes($category_info['name']) : '',
				'opt_out'          => false
			];
	
			$data['facebook_data_json']['time'] = $fb_time;
			$data['facebook_data_json']['event_id'] = $fb_event_id;
		}
		
		if ($this->config->get('remarketing_google_status') && $this->config->get('remarketing_google_identifier')) {
			$data['google_remarketing_status'] = true;
			$data['google_price'] = $google_price;
			$data['google_code'] = $this->config->get('remarketing_google_identifier');
			$data['google_id'] = ($this->config->get('remarketing_google_id') == 'id') ? $product_info['product_id'] : $product_info['model'];
		}	
		
		if ($this->config->get('remarketing_ecommerce_status') || $this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			$ga4_categories = $this->getRemarketingCategoriesGa4($product_info['product_id']);
			$ecommerce_ga4_product = [
				'item_id' => $ecommerce_product_id,
				'item_name' => $product_info['name'], 
				'index' => 1, 
				'price' => $this->currency->format($product_info['special'] ? $product_info['special'] : $product_info['price'], $this->config->get('remarketing_ecommerce_currency'), '', false),
				'quantity' => 1
			];
			if (!empty($product_info['manufacturer'])) $ecommerce_ga4_product['item_brand'] = $product_info['manufacturer'];
			if (!empty($ga4_categories[0])) $ecommerce_ga4_product['item_category'] = $ecommerce_ga4_product['item_list_name'] = (!empty($category_info['name']) ? $category_info['name'] : addslashes($ga4_categories[0]));
			if (!empty($ga4_categories[1])) $ecommerce_ga4_product['item_category2'] = addslashes($ga4_categories[1]);
			if (!empty($ga4_categories[2])) $ecommerce_ga4_product['item_category3'] = addslashes($ga4_categories[2]);
			if (!empty($ga4_categories[3])) $ecommerce_ga4_product['item_category4'] = addslashes($ga4_categories[3]);
		}
		
		if ($this->config->get('remarketing_ecommerce_status')) {
			$data['ecommerce_product_json'] = [];
			$data['measurement_status'] = false;
			$data['ecommerce_status'] = true;  
			
			$data['ga4_datalayer'] = [ 
				'event' => 'ga4_view_item',
				'ecommerce' => [ 
					'currency' => $this->config->get('remarketing_ecommerce_currency'),
					'items' => [$ecommerce_ga4_product]
				]
			]; 
			
			$data['ga4_click_datalayer'] = [ 
				'event' => 'ga4_select_item',
				'ecommerce' => [ 
					'currency' => $this->config->get('remarketing_ecommerce_currency'),
					'items' => [$ecommerce_ga4_product]
				]
			]; 
		}
 
		if ($this->config->get('remarketing_ecommerce_ga4_status') || $this->config->get('remarketing_ecommerce_ga4_measurement_status')) {
			$data['ga4_product'] = []; 
			$data['ecommerce_ga4_status'] = true;
			$data['measurement_ga4_status'] = $this->config->get('remarketing_ecommerce_ga4_measurement_status');
			$ecommerce_ga4_product['item_id'] = $this->config->get('remarketing_ecommerce_ga4_id') == 'id' ? $product_info['product_id'] : $product_info['model'];
			 
			$data['ga4_product'] = [ 
				'send_to' => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'currency' => $this->config->get('remarketing_ecommerce_currency'),
				'items' => [$ecommerce_ga4_product], 
			];
		}
		
		if ($this->config->get('remarketing_esputnik_status') && $this->customer->isLogged()) {
			$data['esputnik_remarketing_status'] = true;
			$data['esputnik_data_json'] = [
				'productId' => addslashes($product_info['name']),
				'quantity' => $product_info['quantity'],
				'price' => $product_price,
				'isInStock' => $product_info['quantity'] > 0 ? '1' : '0'
			];
		} 
		
		if ($this->config->get('remarketing_snapchat_status') && $this->config->get('remarketing_snapchat_pixel_status')) {
			$snapchat_data = [
				'currency' => $snapchat_currency,
				'item_ids' => [$snapchat_id],
				'number_items' => '1',
				'item_category' => !empty($category_info['name']) ? $category_info['name'] : $product_info['name'],
				'price' => $this->currency->format($product_price, $snapchat_currency, '', false) 
			];
			if ($product_info['manufacturer']) {
				$snapchat_data['brands'][0] = $product_info['manufacturer'];
			}
			$output .= "<script>" . "\n";
			$output .= "if (typeof snaptr != 'undefined') {" . "\n";
			$output .= "snaptr('track','VIEW_CONTENT', " . json_encode($snapchat_data) . ");" . "\n";
			$output .= "}" . "\n";
			$output .= "</script>" . "\n";
		}	
		
		if ($this->config->get('remarketing_uet_status')) {
			$uet_data = [
				'ecomm_pagetype' => 'product',
				'ecomm_prodid' =>[$product_info['product_id']]
			];
			$output .= "<script>window.uetq = window.uetq || [];window.uetq.push('event', '', " . json_encode($uet_data) . ");</script>" . "\n";
		}	
		
		$data['remarketing_code'] = $this->load->view('extension/module/remarketing', $data);
		if (!empty($output)) { 
			$data['remarketing_code'] .= $output;
		}
 
		return $data;	
	}
	
	public function processOrder($order_id = 0, $order_status_id = 0, $order_info = []) {
		$ecommerce_currency = $this->config->get('remarketing_ecommerce_currency'); 
		$facebook_currency = $this->config->get('remarketing_facebook_currency'); 
		$tiktok_currency = $this->config->get('remarketing_tiktok_currency'); 
		$ecommerce_info = $this->getOrderRemarketing($order_id);
		$fb_time = time(); 
		 
		if ($this->config->get('remarketing_ecommerce_ga4_measurement_status') || $this->config->get('remarketing_ga4_only_purchase')) {
			$ga4_send_status = $this->config->get('remarketing_ecommerce_ga4_send_status');
			$ga4_refund_status = $this->config->get('remarketing_ecommerce_ga4_refund_status');
		 
			$event_name = false;
			
			if (is_array($ga4_send_status) && in_array($order_status_id, $ga4_send_status) && $ecommerce_info['sent_data']['ecommerce_ga4'] == '0000-00-00 00:00:00' || ($this->config->get('remarketing_ecommerce_ga4_resend_status') != '0' && $this->config->get('remarketing_ecommerce_ga4_resend_status') == $order_status_id)) {
				$event_name = 'purchase'; 
			}
			
			if (is_array($ga4_refund_status) && in_array($order_status_id, $ga4_refund_status)) {
				$event_name = 'refund';
			}
			
			if ($event_name) { 
				
				$params = [];
				$params['affiliation'] = addslashes($ecommerce_info['store_name']);
				if ($ecommerce_info['coupon']) {
					$params['coupon'] = $ecommerce_info['coupon'];
				}
				$params['currency'] = $ecommerce_currency;
				$params['items'] = $ecommerce_info['ga4_products'];
				$params['transaction_id'] = $ecommerce_info['order_id'];
				
				if ($ecommerce_info['shipping']) {
					$params['shipping'] = $ecommerce_info['shipping'];
				}
				
				if ($ecommerce_info['tax']) {
					$params['tax'] = $ecommerce_info['tax'];
				}
				
				$params['value'] = $ecommerce_info['ecommerce_total'];
				
				$ecommerce_data = [
					'events' => [[
						'name' => $event_name,
						'params' => $params
					]]
				];
				
				$this->sendGa4($ecommerce_data);
				$this->setSend($order_id, 'ecommerce_ga4');
			}
		}

		$facebook_send_status = $this->config->get('remarketing_facebook_send_status');
		  
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token') && (($this->config->get('remarketing_facebook_resend_status') != '0' && $this->config->get('remarketing_facebook_resend_status') == $order_status_id) || ((is_array($facebook_send_status) && in_array($order_status_id, $facebook_send_status) && $ecommerce_info['sent_data']['facebook'] == '0000-00-00 00:00:00')))) {
			$facebook_data['event_name'] = 'Purchase';
			$fb_products = [];
			$num_items = 0;
            
			foreach ($ecommerce_info['products'] as $product) {
				$fb_products[] = [
					'id'         => ($this->config->get('remarketing_facebook_id') == 'id' ? $product['product_id'] : $product['model']),
					'quantity'   => $product['quantity'],
					'item_price' => $product['facebook_price']
				];
				$num_items += $product['quantity'];
			}
			$facebook_data['custom_data'] = [
				'value'        => $ecommerce_info['facebook_total'],
				'currency'     => $facebook_currency,
				'contents'     => $fb_products,
				'num_items'    => $num_items,
				'content_type' => 'product',
				'opt_out'      => false
			];
			
			$facebook_data['time'] = $fb_time;
			$facebook_data['event_id'] = $ecommerce_info['sent_data']['fb_event_id'];
			
			$this->sendFacebook($facebook_data, $ecommerce_info);
			
			$this->setSend($order_id, 'facebook');
		} 
		
		$facebook_lead_send_status = $this->config->get('remarketing_facebook_lead_send_status');
		  
		if ($this->config->get('remarketing_facebook_status') && $this->config->get('remarketing_facebook_server_side') && $this->config->get('remarketing_facebook_token') && ((is_array($facebook_lead_send_status) && in_array($order_status_id, $facebook_lead_send_status) && $ecommerce_info['sent_data']['facebook_lead'] == '0000-00-00 00:00:00'))) {
			$facebook_data = [];	
			$facebook_data['event_name'] = 'Lead';
			$facebook_data['custom_data'] = [ 
				'value'        => $ecommerce_info['facebook_total'],
				'currency'     => $facebook_currency, 
				'opt_out'      => false
			];
			
			$facebook_data['time'] = $fb_time;
			$facebook_data['event_id'] = $ecommerce_info['sent_data']['fb_lead_event_id'];
			$this->sendFacebook($facebook_data, $ecommerce_info);
			$this->setSend($order_id, 'facebook_lead');
		} 
		
		$tiktok_send_status = $this->config->get('remarketing_tiktok_send_status');
		  
		if ($this->config->get('remarketing_tiktok_status') && $this->config->get('remarketing_tiktok_server_side') && $this->config->get('remarketing_tiktok_token') && (($this->config->get('remarketing_tiktok_resend_status') != '0' && $this->config->get('remarketing_tiktok_resend_status') == $order_status_id) || ((is_array($tiktok_send_status) && in_array($order_status_id, $tiktok_send_status) && $ecommerce_info['sent_data']['tiktok'] == '0000-00-00 00:00:00')))) {
			$tiktok_data['event_name'] = 'CompletePayment';
			$tt_products = []; 
             
			foreach ($ecommerce_info['products'] as $product) {
				$tt_products[] = [
					'content_type'     => 'product',
					'content_id'       => ($this->config->get('remarketing_tiktok_id')== 'id' ? $product['product_id'] : $product['model']),
					'quantity'         => $product['quantity'],
					'price'            => $product['tiktok_price'],
					'content_name'     => $product['name'],
					'content_category' => $product['category']
				];
			}
			
			$tiktok_data['properties'] = [
				'contents' => $tt_products,
				'value' => $ecommerce_info['tiktok_total'],
				'currency' => $tiktok_currency
			];
			
			$tiktok_data['event_id'] = $ecommerce_info['sent_data']['tt_event_id'];
			$tiktok_data['url'] = $this->url->link('common/home');
			
			$this->sendTiktok($tiktok_data, $ecommerce_info);
			$this->setSend($order_id, 'tiktok');
		} 
		
		if ($this->config->get('remarketing_telegram_status')) {
			$tg_send_status = $this->config->get('remarketing_telegram_send_status');
			if (is_array($tg_send_status) && in_array($order_status_id, $tg_send_status) && $ecommerce_info['sent_data']['telegram'] == '0000-00-00 00:00:00') {
				$this->sendTelegram($order_id);
				$this->setSend($order_id, 'telegram');
			}
		}
		
		if ($this->config->get('remarketing_esputnik_status')) {
			$event_type = false;
			$esputnik_status = false;
			$initialized_status = $this->config->get('remarketing_esputnik_initialized_status');
			if (is_array($initialized_status) && in_array($order_status_id, $initialized_status) && $ecommerce_info['sent_data']['esputnik'] == '0000-00-00 00:00:00') {
				$event_type = 'orderCreated';
				$esputnik_status = 'INITIALIZED';
			}
			
			$in_progress_status = $this->config->get('remarketing_esputnik_inprogress_status');
			if (is_array($in_progress_status) && in_array($order_status_id, $in_progress_status)) {
				$event_type = 'orderUpdated';
				$esputnik_status = 'IN_PROGRESS';
			}
			
			$delivered_status = $this->config->get('remarketing_esputnik_delivered_status');
			if (is_array($delivered_status) && in_array($order_status_id, $delivered_status)) {
				$event_type = 'orderDelivered';
				$esputnik_status = 'DELIVERED';
			}
			
			$cancelled_status = $this->config->get('remarketing_esputnik_cancelled_status');
			if (is_array($cancelled_status) && in_array($order_status_id, $cancelled_status)) {
				$event_type = 'orderCancelled';
				$esputnik_status = 'CANCELLED';
			}

			if ($event_type && $esputnik_status && !empty($ecommerce_info['email'])) {
				$event = new stdClass();
				$event->eventTypeKey = $event_type;
				$event->keyValue = $ecommerce_info['email'];
				$event->params = []; 
				$event->params[] = ['name' => 'phone', 'value' => $ecommerce_info['telephone']];
				$event->params[] = ['name' => 'externalOrderId', 'value' => $ecommerce_info['order_id']];
				$event->params[] = ['name' => 'externalCustomerId', 'value' => $ecommerce_info['email']];
				$event->params[] = ['name' => 'totalCost', 'value' => $ecommerce_info['default_total']];
				$event->params[] = ['name' => 'status', 'value' => $esputnik_status];
				$event->params[] = ['name' => 'date', 'value' => date('Y-m-d\TH:i:s') . '+02:00'];
				if (!empty($ecommerce_info['firstname'])) {
					$event->params[] = ['name' => 'firstName', 'value' => $ecommerce_info['firstname']];
				}
				if (!empty($ecommerce_info['lastname'])) {
					$event->params[] = ['name' => 'lastName', 'value' => $ecommerce_info['lastname']];
				}
				if (!empty($ecommerce_info['order_info'][$this->config->get('remarketing_esputnik_ttn_field')])) {
					$event->params[] = ['name' => 'ttn', 'value' => $ecommerce_info['order_info'][$this->config->get('remarketing_esputnik_ttn_field')]];
				}
				$event->params[] = ['name' => 'currency', 'value' => $this->session->data['currency']];
				if ($ecommerce_info['shipping']) {
					$event->params[] = ['name' => 'shipping', 'value' => $ecommerce_info['shipping']];
				}
				$event->params[] = ['name' => 'deliveryMethod', 'value' => $order_info['shipping_method']];
				$event->params[] = ['name' => 'paymentMethod', 'value' => $order_info['payment_method']];
				
				$format = $this->config->get('remarketing_esputnik_address_format');
				
				$find = [
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
				];
	
				$replace = [ 
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
				];
	
				$esputnik_address = str_replace(["\r\n", "\r", "\n"], '<br />', preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], '<br />', trim(str_replace($find, $replace, $format))));
				$event->params[] = ['name' => 'deliveryAddress', 'value' => $esputnik_address];
				$items = [];
				
				$this->load->model('tool/image');
				foreach ($ecommerce_info['products'] as $product) {
					if ($product['product_info']['image']) {
						$product_image = $this->model_tool_image->resize($product['product_info']['image'], 200, 200);
					} else {
						$product_image = $this->model_tool_image->resize('no_image.jpg', 200, 200);
					}
					$items[] = [
						'externalItemId' => $product['product_id'],
						'name'           => $product['name'],
						'category'       => $product['category'],
						'quantity'       => $product['quantity'],
						'cost'           => $product['price'],
						'url'            => $this->url->link('product/product', 'product_id=' . $product['product_id']),
						'imageUrl'       => $product_image
					];
				}
				
				if (!isset($this->session->data['esputnik_uniq'])) {
					$this->session->data['esputnik_uniq'] = uniqid();
				}
				
				$products_array = ['array' => $items];
				
				$event->params[] = ['name' => 'recycleStateId', 'value' => $this->session->data['esputnik_uniq']];
				$event->params[] = ['name' => 'items', 'value' => json_encode($items)];
				$event->params[] = ['name' => 'products', 'value' => json_encode($products_array)];  
				$this->sendEsputnik($event);
				if ($esputnik_status == 'INITIALIZED') {
					$this->setSend($order_id, 'esputnik');
				}
			}
		}
	}
	
	public function getOrderRemarketing($order_id) {
		
		$this->load->model('catalog/product'); 
		$this->load->model('checkout/order'); 

        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");
        if ($order_query->num_rows) {
			$products = [];
			$ga4_products = [];
			$snapchat_products = [];
			$uet_ids = [];
			$uet_products = [];
            $language_id = $order_query->row['language_id'];
            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
			$i = 1;
            foreach ($order_product_query->rows as $product) {
                $option_data = '';
                $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
                foreach ($order_option_query->rows as $option) {
                    if ($option['type'] != 'file') {
                        $option_data .= $option['name'] . ':' . $option['value'] . ';';
                    }
                }
                $option_data = rtrim($option_data, ';');
				
                if ($option_data) {
                    $variant = str_replace("\n", " ", addslashes($option_data));
                } else {
                    $variant = '';
                }

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);
				
				$ga4_categories = $this->getRemarketingCategoriesGa4($product['product_id']);
				
				if (count($order_product_query->rows) > 4) {
					$ga4_categories = [];		 		
				}
				
                $products[] = [
                    'name'            => $product['name'],
                    'product_id'      => $product['product_id'],
                    'product_info'    => $product_info,
                    'sku'             => $product_info['sku'],
                    'model'           => $product['model'],
                    'category'        => $this->getRemarketingCategories($product['product_id']),
                    'variant'         => $variant,
                    'price'           => $this->currency->format($product['price'], $this->session->data['currency'], '', false),
                    'google_price'    => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_google_ratio'), $this->config->get('remarketing_google_currency'), '', false),
                    'facebook_price'  => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_facebook_ratio'), $this->config->get('remarketing_facebook_currency'), '', false),
                    'tiktok_price'    => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_tiktok_ratio'), $this->config->get('remarketing_tiktok_currency'), '', false),
                    'ecommerce_price' => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false),
                    'quantity'        => $product['quantity']
                ];
				
				$ga4_products[] = [
					'item_id'        => $this->config->get('remarketing_ecommerce_ga4_id')== 'id' ? $product['product_id'] : $product['model'],
					'item_name'      => addslashes($product['name']),
					'item_brand'     => !empty($product_info['manufacturer']) ? addslashes($product_info['manufacturer']) : '',
					'item_category'  => !empty($ga4_categories[0]) ? addslashes($ga4_categories[0]) : '',
					'item_category2' => !empty($ga4_categories[1]) ? addslashes($ga4_categories[1]) : '',
					'item_category3' => !empty($ga4_categories[2]) ? addslashes($ga4_categories[2]) : '',
					'item_category4' => !empty($ga4_categories[3]) ? addslashes($ga4_categories[3]) : '', 
					'item_variant'   => $variant, 
					'index'          => $i, 
					'quantity'       => $product['quantity'], 
					'price'          => $this->currency->format($product['price'] * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false)
				];
				
				$uet_products[] = [
					'id'       => $product['product_id'],
                    'quantity' => $product['quantity'], 
                    'price'    => $this->currency->format($product['price'], $this->config->get('remarketing_ecommerce_currency'), '', false)
				];
				
				$snapchat_products[] = $this->config->get('remarketing_snapchat_id') == 'id' ? $product['product_id'] : $product['model'];
				$uet_ids[] = $product['product_id'];
				
				$i++; 
            }
			
			$shipping_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'shipping'");
			if ($shipping_query->rows) {
				$shipping = $shipping_query->row['value'];
			} else {
				$shipping = 0;
			}

			$tax_query = $this->db->query("SELECT value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'tax'");
			if ($tax_query->rows) {
				$tax = $tax_query->row['value'];
			} else {
				$tax = 0;
			}

			if ($this->config->get('remarketing_no_shipping')) {
				$order_query->row['total'] -= $shipping;
			}
			
			$coupon_query = $this->db->query("SELECT title FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'coupon'");
			if ($coupon_query->rows) {
				$coupon = $coupon_query->row['title'];
			} else {
				$coupon = false;
			}
			
			$order_info = $this->model_checkout_order->getOrder($order_query->row['order_id']);
			
			$ecommerce_total = $this->currency->format($order_query->row['total'] * (float)$this->config->get('remarketing_ecommerce_ratio'), $this->config->get('remarketing_ecommerce_currency'), '', false);
			
			$ads_event = [];
			$ga4_datalayer = [];
			$ga4_event = []; 
			
			$ga4_event = [
				'send_to'        => $this->config->get('remarketing_ecommerce_ga4_identifier'),
				'transaction_id' => $order_info['order_id'],
				'value'          => $ecommerce_total,
				'currency'       => $this->config->get('remarketing_ecommerce_currency'),
				'affiliation'    => addslashes($order_info['store_name']),
				'shipping'       => $this->currency->format($shipping, $this->config->get('remarketing_ecommerce_currency'), '', false),
				'tax'            => $this->currency->format($tax, $this->config->get('remarketing_ecommerce_currency'), '', false),
				'items'          => $ga4_products
			];
 			if ($coupon) $ga4_event['coupon'] = $coupon;
			
			$ga4_datalayer = [
				'event'     => 'ga4_purchase',
				'ecommerce' => $ga4_event
			]; 
			
			if ($order_info['shipping_method']) $ga4_datalayer['shipping_tier'] = $order_info['shipping_method'];
			if ($order_info['payment_method'])  $ga4_datalayer['payment_type'] = $order_info['payment_method'];
			unset($ga4_datalayer['ecommerce']['send_to']);
			
			$snapchat_data = [
				'transaction_id'  => $order_info['order_id'],
				'currency'        => $this->config->get('remarketing_snapchat_currency'),
				'item_ids'        => $snapchat_products,
				'number_items'    => count($snapchat_products),
				'price'           => $this->currency->format($order_query->row['total'] * (float)$this->config->get('remarketing_snapchat_ratio'), $this->config->get('remarketing_snapchat_currency'), '', false),
				'customer_status' => $order_info['customer_id'] > 0 ? 'returning' :  'new',
				'success'         => '1'
			]; 
			
			$uet_data = [
				'transaction_id'   => $order_info['order_id'],
				'ecomm_prodid'     => $uet_ids,
				'ecomm_pagetype'   => 'purchase',
				'ecomm_totalvalue' => $ecommerce_total,
				'revenue_value'    => $ecommerce_total,
				'currency'         => $this->config->get('remarketing_ecommerce_currency'),
				'items'            => $uet_products
			];	 
			
			$order_data = [
                'order_id'        => $order_query->row['order_id'],
                'store_name'      => addslashes($order_query->row['store_name']),
                'email'           => $order_query->row['email'],
                'telephone'       => $this->phoneClear($order_query->row['telephone']),
                'firstname'       => $order_query->row['firstname'],
                'lastname'        => $order_query->row['lastname'],
                'products'        => $products,
                'ga4_products'    => $ga4_products, 
                'order_info'      => $order_info,
                'total'           => $order_query->row['total'], 
                'default_total'   => $this->currency->format($order_query->row['total'], $this->session->data['currency'], '', false),
                'google_total'    => $this->currency->format($order_query->row['total'] * (float)$this->config->get('remarketing_google_ads_ratio'), $this->config->get('remarketing_google_currency'), '', false),
                'facebook_total'  => $this->currency->format($order_query->row['total'] * (float)$this->config->get('remarketing_facebook_ratio'), $this->config->get('remarketing_facebook_currency'), '', false),
                'ecommerce_total' => $ecommerce_total,
                'tiktok_total'    => $this->currency->format($order_query->row['total'] * (float)$this->config->get('remarketing_tiktok_ratio'), $this->config->get('remarketing_tiktok_currency'), '', false),
				'shipping'        => $this->currency->format($shipping, $this->config->get('remarketing_ecommerce_currency'), '', false), 
				'tax'             => $this->currency->format($tax, $this->config->get('remarketing_ecommerce_currency'), '', false), 
				'coupon'          => $coupon, 
                'order_status_id' => $order_query->row['order_status_id'],
                'currency_code'   => $order_query->row['currency_code'],
                'ga4_event'       => $ga4_event,
                'ga4_datalayer'   => $ga4_datalayer,
                'snapchat_data'   => $snapchat_data,
                'uet_data'        => $uet_data
            ];
			 
			$remarketing_check_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "remarketing_orders` WHERE order_id = '" . (int)$order_id . "'");
			$parameters = [
				'uuid', 'ga4_uuid', 'fbclid', 'fbc', 'fbp', 'gclid', 'dclid', 'utm_source', 'utm_campaign', 'utm_medium', 'utm_term', 'utm_content', 'ttclid', 'first_referrer', 'last_referrer' 
			]; 
			if (!$remarketing_check_query->num_rows) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "remarketing_orders` SET `order_id` = '" . (int)$order_id . "', `order_data` = '" . $this->db->escape(!$this->config->get('remarketing_debug_mode') ? '' : print_r($order_data, true)) . "', `date_added` = NOW()");
				
				foreach ($parameters as $parameter) {
					if (!empty($this->session->data[$parameter])) {
						$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `" . $parameter . "` = '" . $this->db->escape($this->session->data[$parameter]) . "' WHERE order_id = '" . (int)$order_id . "'");
					}
				}
				$event_id = $this->genEventId(); 
				$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `fb_event_id` = '" . $this->db->escape($event_id) . "' WHERE order_id = '" . (int)$order_id . "'");
				$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `tt_event_id` = '" . $this->db->escape($event_id) . "' WHERE order_id = '" . (int)$order_id . "'");
				$this->db->query("UPDATE `" . DB_PREFIX . "remarketing_orders` SET `fb_lead_event_id` = '" . $this->db->escape($this->genEventId()) . "' WHERE order_id = '" . (int)$order_id . "'");
			}
			
			$remarketing_orders_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "remarketing_orders` WHERE `order_id` = '" . (int)$order_id . "'");
			
			$order_data['sent_data'] = []; 
			
			if ($remarketing_orders_query->rows) {
				$order_data['sent_data'] = $remarketing_orders_query->row;
			}
			
			foreach($order_data['sent_data'] as $key => $val) {
				if (!empty($order_data['sent_data'][$key]) && in_array($key, $parameters)) {
					$this->session->data[$key] = $val; 
				}
			}
			
			if (empty($this->session->data['uuid'])) {
				$this->getCid();	 	
			} 

			if ($this->config->get('remarketing_autoclear_mode')) {
				$this->db->query("DELETE FROM `" . DB_PREFIX . "remarketing_orders` WHERE `date_added` < DATE_SUB(NOW(), INTERVAL 3 MONTH)");	
			}

			return $order_data;
        } else {
            return false; 
        }  
    } 
	
	public function phoneClear($telephone) {
		$telephone = str_replace([' ', '-', '(', ')'], '', $telephone);
		return $telephone;
	}
	
	public function sendFacebookManual($post = []) {
		if (empty($post)) return; 
		$total = (int)$post['manual_facebook_total'];
		$fb_time = time();
		$facebook_data = [];
		$facebook_data['event_name'] = 'Purchase';
		$fb_products = [];
		$num_items = 0;
		if (!empty($post['manual_facebook_products'])) {
			foreach ($post['manual_facebook_products'] as $manual_facebook_product) {
				$fb_products[] = [
					'id'         => $manual_facebook_product['product_id'],
					'quantity'   => $manual_facebook_product['quantity'],
					'item_price' => $this->currency->format($manual_facebook_product['price'], $this->config->get('remarketing_facebook_currency'), '', false)
				];
				$num_items += $manual_facebook_product['quantity'];
			}
		}
		$facebook_data['custom_data'] = [
			'value'        => $this->currency->format($total, $this->config->get('remarketing_facebook_currency'), '', false),
			'currency'     => $this->config->get('remarketing_facebook_currency'),
			'contents'     => $fb_products,
			'num_items'    => $num_items,
			'content_type' => 'product',
			'opt_out'      => false
		];
		
		$facebook_data['time'] = $fb_time;
		 
		$this->sendFacebook($facebook_data, false);
	}

}
