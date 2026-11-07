<?php
class ControllerExtensionModuleUniTool extends Controller {
	private $error = []; 
	
	public function index() {   
		$this->load->language('extension/module/uni_tool');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$this->load->model('setting/module');
		$this->load->model('setting/setting');
		$this->load->model('setting/store');

		if (!$this->validate()) {
			$data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
		}
		
  		$data['breadcrumbs'] = [];

   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], 'SSL'),
   		];

   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('text_module'),
			'href' 		=> $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
   		];
		
   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/uni_tool', 'user_token=' . $this->session->data['user_token'], 'SSL'),
   		];
		
		$data['stores'][] = [
			'store_id' => 0, 
			'name' => $this->config->get('config_name')
		];
		
		$stores = $this->model_setting_store->getStores();
		
		if($stores) {
			foreach ($stores as $store) {
				$data['stores'][] = [
					'store_id' 	=> $store['store_id'], 
					'name' 		=> html_entity_decode($store['name'], ENT_QUOTES, 'UTF-8')
				];
			}
		}
		
		$data['multistore'] = count($data['stores']) > 1 ? true : false;
		
		$data['token'] = $this->session->data['user_token'];
		
		$data['action_export'] = $this->url->link('extension/module/uni_tool/exportSettings', 'user_token=' . $this->session->data['user_token'], true);
		
		$data['text_note_restore'] = sprintf($this->language->get('text_note_restore'), $this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true));
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_tool', $data));
	}
	
	public function restoreSettings() {
		$this->load->language('extension/module/uni_tool');

		$json = [];
		
		if (!$this->validate()) {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$type = isset($this->request->post['type']) ? $this->request->post['type'] : (isset($this->request->get['type']) ? $this->request->get['type'] : '');
		
		$type_arr = ['full', 'set', 'set_green', 'set_black', 'set_new1', 'set_new2'];
		
		if(!$json && $type && in_array($type, $type_arr)) {
			
			$filename = DIR_CONFIG . 'unishop2/' . $type . '.cfg';
			
			if(file_exists($filename)) {
				
				$position = isset($this->request->get['position']) ? (int)$this->request->get['position'] : 0;
				
				$i = 0;
				$start = false;
			
				$handle = fopen($filename, 'r');

				fseek($handle, $position, SEEK_SET);
			
				while (!feof($handle) && ($i < 10000)) {
					$position = ftell($handle);

					$line = fgets($handle, 1000000);
				
					if (substr($line, 0, 20) == 'DROP TABLE IF EXISTS' || substr($line, 0, 12) == 'CREATE TABLE' || substr($line, 0, 14) == 'TRUNCATE TABLE' || substr($line, 0, 11) == 'INSERT INTO') {
						$sql = '';
						
						if (DB_PREFIX != 'oc_') {
							$line = str_replace('`oc_', '`'.DB_PREFIX, $line);
						}
					
						$start = true;
					}

					if ($i > 0 && (substr($line, 0, 24) == 'TRUNCATE TABLE `oc_user`' || substr($line, 0, 30) == 'TRUNCATE TABLE `oc_user_group`')) {
						fseek($handle, $position, SEEK_SET);

						break;
					}

					if ($start) {
						$sql .= $line;
					}
				
					if ($start && substr($line, -2) == ";\n") {
						$this->db->query(substr($sql, 0, strlen($sql) -2));
					
						$start = false;
					}
					
					$i++;
				}

				$position = ftell($handle);

				$size = filesize($filename);

				$json['total'] = round(($position / $size) * 100);

				if ($position && !feof($handle)) {
					$json['next'] = str_replace('&amp;', '&', $this->url->link('extension/module/uni_tool/restoreSettings', 'user_token=' . $this->session->data['user_token'] . '&type=' . $type . '&position=' . $position, true));
			
					fclose($handle);
				} else {
					fclose($handle);

					$this->cache->delete('unishop');
				
					$json['success'] = $this->language->get('text_success_restore');
					
					if(isset($this->request->post['redirect'])) {
						$json['redirect'] = 'index.php?route=extension/module/uni_settings&user_token=' . $this->session->data['user_token'] . '&store_id=0';
					}
				}
			} else {
				$json['error'] = $this->language->get('error_file');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	
	public function copySettings() {
		$this->load->language('extension/module/uni_tool');
		$this->load->model('setting/store');
		
		$json = [];
		
		if (!$this->validate()) {
			$json['error'] = $this->language->get('error_permission');
		}
		
		$from = isset($this->request->post['from']) ? $this->request->post['from'] : '';
		
		$to = isset($this->request->post['to']) ? $this->request->post['to'] : '';
		
		$stores_arr = [0];
		
		$stores = $this->model_setting_store->getStores();
		
		if($stores) {
			$stores_arr = array_merge($stores_arr, array_column($stores, 'store_id'));
		}

		if(!$json && in_array($from, $stores_arr) && in_array($to, $stores_arr)) {
			
			$query = $this->db->query("SELECT data FROM `" . DB_PREFIX . "uni_setting` WHERE store_id = " . (int)$from . "");
			
			$data = $query->row['data'];
			
			$this->db->query("DELETE FROM `" . DB_PREFIX . "uni_setting` WHERE store_id = '" . (int)$to . "'");
			$this->db->query("INSERT INTO `" . DB_PREFIX . "uni_setting` SET store_id = '" . (int)$to . "', data = '" . $this->db->escape($data) . "'");
			
			$this->cache->delete('unishop');
			
			$json['success'] = $this->language->get('text_success_copy');
			
			if(isset($this->request->post['redirect'])) {
				$json['redirect'] = 'index.php?route=extension/module/uni_settings&user_token=' . $this->session->data['user_token'] . '&store_id=' . (int)$to;
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	
	public function exportSettings() {
		$this->load->language('extension/module/uni_tool');
		$this->load->model('setting/store');
		
		$from = isset($this->request->post['from']) ? (int)$this->request->post['from'] : 0;
		
		$stores_arr = [0];
		
		$stores = $this->model_setting_store->getStores();
		
		if($stores) {
			$stores_arr = array_merge($stores_arr, array_column($stores, 'store_id'));
		}
		
		if($this->validate() && in_array($from, $stores_arr)) {
			
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename="unishop2_setting_store_id_' . $from . '_' . date('d-m-Y__H-i-s', time()) . '_backup.sql"');
			$this->response->addheader('Content-Transfer-Encoding: binary');
			
			$query = $this->db->query("SELECT data FROM `" . DB_PREFIX . "uni_setting` WHERE store_id = " . (int)$from . "");
			
			$data = $query->row['data'];
			
			$output = '';

			if ($data) {
				
				$table = DB_PREFIX . 'uni_setting';
				
				$output = '-- Use phpmyadmin, adminer, etc. Date: ' . date('Y-m-d H-i-s', time()). "\n\n";
				
				//$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";
				$output .= 'DELETE FROM `' . $table . '` WHERE store_id = '. (int)$from . ';' . "\n\n";
				
				$data = str_replace('"', '\"',	$data);
				$data = str_replace("'", "\'",	$data);
				$data = str_replace('u0', '\u0', $data);
				$data = str_replace('\/', '\\\/', $data);
				$data = str_replace('\n', '\\\n',	$data);
				$data = str_replace('\r', '\\\r',	$data);
				$data = str_replace('\t', '\\\t',	$data);

				$output .= 'INSERT INTO `' . $table . '` (`store_id`, `data`) VALUES (' . $from . ', \'' . $data . '\');' . "\n\n\n";

				$this->response->setOutput($output);
			}
		} else {
			echo $this->language->get('error_permission');
		}
	}
	
	private function validate() {		
		if (!$this->user->hasPermission('modify', 'extension/module/uni_tool')) {
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