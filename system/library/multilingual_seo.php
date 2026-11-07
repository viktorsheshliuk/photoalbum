<?php
/************************************
 - Sirius SEO Package - multilingual handler -
*************************************

 contact : sirius_box-dev@yahoo.fr
 
************************************/

final class multilingual_seo extends Controller {

	public function detect() {
    $url_alias = version_compare(VERSION, '3', '>=') ? 'seo_url' : 'url_alias';
    
    // prefix mode
    if ($this->config->get('mlseo_store_mode')) {
      $lang_to_store = $this->config->get('mlseo_lang_to_store');
      
      foreach ($lang_to_store as $lang => $store) {
        if (isset($this->session->data['language']) && isset($store['config_url']) && strpos($store['config_url'], $this->request->server['HTTP_HOST']) !== false) {
          $this->session->data['language'] = $lang;
        }
      }
    
    // suffix mode
    } else if ($this->config->get('mlseo_flag')) {
      if (empty($this->request->get['_route_'])) {
        if (empty($this->request->get['route'])) {
          if (!$this->config->get('mlseo_flag_detect')) {
            // redirect if detected language (session, cookie, or browser detect) is not equal to default language
            $detect = $this->detectLanguage();
            if ($detect != $this->config->get('mlseo_default_lang')) {
              if ($this->config->get('mlseo_flag_short')) {
                $detect = substr($detect, 0, 2);
              }
              header('Location: '.$this->config->get('config_url') . $detect);
            }
          } else if (false) {
            // detect but don't do anything
            return;
          } else {
            // force default language if no tag
            $this->session->data['language'] = $this->config->get('mlseo_default_lang');
          }
        }
        return;
      }
      
      $parts = explode('/', $this->request->get['_route_']);
      $lgCode = array_shift($parts);
      $lgCodes = (array) $this->config->get('mlseo_lang_codes');
      
      $customSeoFlag = $this->config->get('mlseo_flag_custom');
      if (is_array($customSeoFlag)) {
        $customSeoFlag = array_flip($customSeoFlag);
      }
      
      if (!empty($customSeoFlag[$lgCode])) {
        $this->session->data['language'] = $customSeoFlag[$lgCode];
        $this->request->get['_route_'] = implode('/', $parts);
      } else {
        if ($this->config->get('mlseo_flag_short')) {
          $lgSearch = array_map(array($this, 'langCode'), $lgCodes);
        } else {
          $lgSearch = array_map(array($this, 'lowercaseCode'), $lgCodes);
        }
        
        if ($lgKey = array_search(strtolower($lgCode), $lgSearch)) {
          $this->session->data['language'] = $lgCodes[$lgKey];
          $this->request->get['_route_'] = implode('/', $parts);
        } else {
          if ($this->config->get('mlseo_flag_detect')) {
            $this->session->data['language'] = $this->config->get('mlseo_default_lang');
          }
        }
			}
    // multilingual
    } else if($this->config->get('mlseo_ml_mode')) {
			$get = array();
			
			if (isset($this->request->get['_route_'])) {
				$parts = explode('/', $this->request->get['_route_']);
				
				foreach ($parts as $part) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $url_alias . " WHERE keyword = '" . $this->db->escape($part) . "'");
					
					if ($query->num_rows) {
						$url = explode('=', $query->row['query']);
						
						if ($url[0] == 'product_id') {
							$get['product_id'] = $url[1];
						}
						
						if ($url[0] == 'category_id') {
							if (!isset($this->request->get['path'])) {
								$get['path'] = $url[1];
							} else {
								$get['path'] .= '_' . $url[1];
							}
						}	
						
						if ($url[0] == 'manufacturer_id') {
							$get['manufacturer_id'] = $url[1];
						}
						
						if ($url[0] == 'information_id') {
							$get['information_id'] = $url[1];
						}	
					} else {
						$get['route'] = 'error/not_found';	
					}
				}
				if (isset($get['product_id'])) {
					$get['route'] = 'product/product';
				} elseif (isset($get['path'])) {
					$get['route'] = 'product/category';
				} elseif (isset($get['manufacturer_id'])) {
					$get['route'] = 'product/manufacturer/product';
				} elseif (isset($get['information_id'])) {
					$get['route'] = 'information/information';
				}
				
				if (isset($get['route'])) {
					if (isset($query->row['language_id']) && ($query->row['language_id'] != 0) && (count($query->rows) === 1)) {
						$lgCodes = (array) $this->config->get('mlseo_lang_codes');
            
            if (isset($lgCodes[$query->row['language_id']])) {
							$this->session->data['language'] = $lgCodes[$query->row['language_id']];
            }
          }
        }
      }
    }
  }
  
  private function detectLanguage() {
    $code = '';
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		if (isset($this->session->data['language'])) {
			$code = $this->session->data['language'];
		}
    
		if (isset($this->request->cookie['language']) && !array_key_exists($code, $languages)) {
			$code = $this->request->cookie['language'];
		}
		
		// Language Detection
		if (!empty($this->request->server['HTTP_ACCEPT_LANGUAGE']) && !array_key_exists($code, $languages)) {
			$detect = '';
			
			$browser_languages = explode(',', $this->request->server['HTTP_ACCEPT_LANGUAGE']);
			
			// Try using local to detect the language
			foreach ($browser_languages as $browser_language) {
				foreach ($languages as $key => $value) {
					if ($value['status']) {
						$locale = explode(',', $value['locale']);
						
						if (in_array($browser_language, $locale)) {
							$detect = $key;
							break 2;
						}
					}
				}	
			}			
			
			if (!$detect) { 
				// Try using language folder to detect the language
				foreach ($browser_languages as $browser_language) {
					if (array_key_exists(strtolower($browser_language), $languages)) {
						$detect = strtolower($browser_language);
						
						break;
					}
				}
			}
			
			$code = $detect ? $detect : '';
		}
		
		if (!array_key_exists($code, $languages)) {
			$code = $this->config->get('config_language');
		}
    
    return $code;
  }
  
  private function langCode($code) {
    $code = substr($code, 0, 2);
    
    return strtolower($code);
  }
  
  private function lowercaseCode($code) {
    return strtolower($code);
  }
}