<?php
class ControllerExtensionModuleNpApiCheck extends Controller {
    
    const RECOMMENDED_CURL_CONNECTTIMEOUT = 10;
    const RECOMMENDED_CURL_TIMEOUT = 300;
    const RECOMMENDED_MAX_EXECUTION_TIME = 600;
    
    const MIN_CURL_CONNECTTIMEOUT = 5;
    const MIN_CURL_TIMEOUT = 60;
    const MIN_MAX_EXECUTION_TIME = 300;
    
    public function index() {
        $refresh = isset($this->request->get['refresh']) ? (int)$this->request->get['refresh'] : 0;
        $cache_key = 'novaposhta.api_status_check';

        if (!$refresh) {
            $cached_data = $this->cache->get($cache_key);
            if ($cached_data) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($cached_data));
                return;
            }
        }

        $json = array(
            'valid'              => false,
            'status_type'        => 'error',
            'count_mismatch'     => false,
            'db_cities'          => 0,
            'api_cities'         => 0,
            'db_warehouses'      => 0,
            'api_warehouses'     => 0,
            'expire'             => '',
            'last_update'        => '',
            'warnings'           => array(),
            'timeout_settings'   => array(
                'curl_connecttimeout' => null,
                'curl_timeout'        => null,
                'max_execution_time'  => null
            )
        );

        $settings = $this->config->get('novaposhta');
        
        $npSettings = $this->config->get('shipping_novaposhta');
        if (!$npSettings) {
            $npSettings = $settings;
        }
        
        $apiKey = '';
        if (is_array($npSettings) && isset($npSettings['key_api'])) {
            $apiKey = $npSettings['key_api'];
        } elseif (is_array($settings) && isset($settings['key_api'])) {
            $apiKey = $settings['key_api'];
        }

        if (!$apiKey) {
            $json['warnings'][] = array(
                'type'    => 'error',
                'message' => 'API ключ не встановлено'
            );
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
            return;
        }

        $this->checkTimeoutSettings($json, $npSettings);
        
        $this->checkMaxExecutionTime($json);

        $keyCheck = $this->makeApiRequest($apiKey, 'Common', 'getApiKeysList', new stdClass());
        
        if (isset($keyCheck['success']) && $keyCheck['success'] && !empty($keyCheck['data'])) {
            $foundKey = null;
            foreach ($keyCheck['data'] as $k) {
                if ($k['ApiKey'] == $apiKey) { $foundKey = $k; break; }
            }

            if ($foundKey) {
                $json['valid'] = true;
                $json['expire'] = !empty($foundKey['ExpireDate']) ? $foundKey['ExpireDate'] : '';
                $json['last_update'] = date('d.m.Y H:i:s');
                
                $json['db_cities'] = $this->getDbCount(DB_PREFIX . "novaposhta_cities");
                $json['db_warehouses'] = $this->getDbCount(DB_PREFIX . "novaposhta_departments");

                $apiCities = $this->makeApiRequest($apiKey, 'Address', 'getCities', array('Page' => '1', 'Limit' => '500'));
                $apiWarehouses = $this->makeApiRequest($apiKey, 'Address', 'getWarehouses', array('WarehouseStatus' => 'Working', 'Limit' => '500'));

                $json['api_cities'] = isset($apiCities['info']['totalCount']) ? (int)$apiCities['info']['totalCount'] : 0;
                $json['api_warehouses'] = isset($apiWarehouses['info']['totalCount']) ? (int)$apiWarehouses['info']['totalCount'] : 0;

                $citiesMatch = ($json['db_cities'] == $json['api_cities']);
                $warehousesMatch = ($json['db_warehouses'] == $json['api_warehouses']);

                if (!$citiesMatch || !$warehousesMatch) {
                    $json['count_mismatch'] = true;
                    
                    if ($json['db_cities'] < $json['api_cities']) {
                        $json['cities_status'] = 'less';
                    } elseif ($json['db_cities'] > $json['api_cities']) {
                        $json['cities_status'] = 'more';
                    } else {
                        $json['cities_status'] = 'ok';
                    }
                    
                    if ($json['db_warehouses'] < $json['api_warehouses']) {
                        $json['warehouses_status'] = 'less';
                    } elseif ($json['db_warehouses'] > $json['api_warehouses']) {
                        $json['warehouses_status'] = 'more';
                    } else {
                        $json['warehouses_status'] = 'ok';
                    }
                    
                    $json['status_type'] = 'warning';
                } else {
                    $json['cities_status'] = 'ok';
                    $json['warehouses_status'] = 'ok';
                    $json['status_type'] = 'success';
                }
                
                if (!empty($json['warnings']) && $json['status_type'] == 'success') {
                    $json['status_type'] = 'warning';
                }
                
                $this->cache->set($cache_key, $json, 3600);
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    private function checkTimeoutSettings(&$json, $settings) {
        $curlConnectTimeout = isset($settings['curl_connecttimeout']) && $settings['curl_connecttimeout'] !== '' 
            ? (int)$settings['curl_connecttimeout'] 
            : null;
        $curlTimeout = isset($settings['curl_timeout']) && $settings['curl_timeout'] !== '' 
            ? (int)$settings['curl_timeout'] 
            : null;
        
        $json['timeout_settings']['curl_connecttimeout'] = $curlConnectTimeout;
        $json['timeout_settings']['curl_timeout'] = $curlTimeout;
        
        if ($curlConnectTimeout !== null && $curlConnectTimeout < self::MIN_CURL_CONNECTTIMEOUT) {
            $json['warnings'][] = array(
                'type'    => 'warning',
                'code'    => 'curl_connecttimeout_low',
                'message' => sprintf(
                    'CURL Connect Timeout (%d сек) занадто низький. Рекомендовано: %d сек або більше',
                    $curlConnectTimeout,
                    self::RECOMMENDED_CURL_CONNECTTIMEOUT
                )
            );
        }
        
        if ($curlTimeout !== null && $curlTimeout < self::MIN_CURL_TIMEOUT) {
            $json['warnings'][] = array(
                'type'    => 'warning',
                'code'    => 'curl_timeout_low',
                'message' => sprintf(
                    'CURL Timeout (%d сек) занадто низький для завантаження великих обсягів даних. Рекомендовано: %d сек або більше',
                    $curlTimeout,
                    self::RECOMMENDED_CURL_TIMEOUT
                )
            );
        }
    }
    
    private function checkMaxExecutionTime(&$json) {
        return;
        $maxExecutionTime = (int)ini_get('max_execution_time');
        $json['timeout_settings']['max_execution_time'] = $maxExecutionTime;
        
        if ($maxExecutionTime === 0) {
            return;
        }
        
        if ($maxExecutionTime < self::MIN_MAX_EXECUTION_TIME) {
            $json['warnings'][] = array(
                'type'    => 'warning',
                'code'    => 'max_execution_time_low',
                'message' => sprintf(
                    'PHP max_execution_time (%d сек) може бути недостатнім для оновлення великих обсягів даних НП. Рекомендовано: %d сек або більше',
                    $maxExecutionTime,
                    self::RECOMMENDED_MAX_EXECUTION_TIME
                )
            );
        }
    }

    private function getDbCount($table) {
        $query = $this->db->query("SHOW TABLES LIKE '" . $table . "'");
        if ($query->num_rows) {
            $res = $this->db->query("SELECT COUNT(*) AS total FROM `" . $table . "`")->row;
            return (int)$res['total'];
        }
        return 0;
    }

    private function makeApiRequest($apiKey, $model, $method, $properties) {
        $data = array('apiKey' => $apiKey, 'modelName' => $model, 'calledMethod' => $method, 'methodProperties' => $properties);
        $ch = curl_init('https://api.novaposhta.ua/v2.0/json/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}
