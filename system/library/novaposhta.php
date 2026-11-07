<?php

class Novaposhta {
    private $config;
    private $log;
    private $prefix;
    private $api_key;
    private $api_url = 'https://api.novaposhta.ua/v2.0/json/';

    public function __construct($registry)
    {
        $this->config = $registry->get('config');
        $this->log = $registry->get('log');
        $this->prefix = (version_compare(VERSION, '3.0', '>=')) ? 'shipping_' : '';
        $this->api_key = $this->config->get($this->prefix . 'novaposhta_api_key');
    }

    public function getCitiesChunked($callback, $filter = array(), $page_size = 5000) {
        $page = 1;
        $total_processed = 0;
        $has_more_data = true;

        while ($has_more_data) {
            // API Nova Poshta требует Page как строку для getCities
            $filter_with_pagination = array_merge($filter, array(
                'Page' => (string)$page,
                'Limit' => $page_size
            ));
            
            $result = $this->makeApiRequest('getCities', $filter_with_pagination);
            
            if (!isset($result['success']) || !$result['success']) {
                if ($this->log) {
                    $this->log->write("[CITIES] API Error on page $page");
                }
                $has_more_data = false;
                break;
            }
            
            if (!isset($result['data']) || !is_array($result['data'])) {
                $has_more_data = false;
                break;
            }

            $current_count = count($result['data']);

            if ($current_count === 0) {
                $has_more_data = false;
                break;
            }

            // Обрабатываем текущую страницу батчами
            $chunks = array_chunk($result['data'], 5000);
            foreach ($chunks as $chunk) {
                $processed = call_user_func($callback, $chunk);
                $total_processed += $processed;
            }

            // Если получили меньше чем запросили - это последняя страница
            if ($current_count < $page_size) {
                $has_more_data = false;
            }

            $page++;
            
            // Задержка между запросами для предотвращения rate limiting
            usleep(200000); // 0.2 сек

            // Защита от бесконечного цикла
            if ($page > 50) {
                $has_more_data = false;
            }

            unset($result);
        }

        return $total_processed;
    }

    public function getDepartmentsChunked($callback, $filter = array(), $page_size = 5000) {
        $page = 1;
        $total_processed = 0;
        $has_more_data = true;

        while ($has_more_data) {
            // API Nova Poshта может требовать Page как строку для getWarehouses
            $filter_with_pagination = array_merge($filter, array(
                'Page' => (string)$page,
                'Limit' => $page_size
            ));
            
            $result = $this->makeApiRequest('getWarehouses', $filter_with_pagination);
            
            if (!isset($result['success']) || !$result['success']) {
                if ($this->log) {
                    $this->log->write("[DEPARTMENTS] API Error on page $page");
                }
                $has_more_data = false;
                break;
            }
            
            if (!isset($result['data']) || !is_array($result['data'])) {
                $has_more_data = false;
                break;
            }

            $current_count = count($result['data']);

            if ($current_count === 0) {
                $has_more_data = false;
                break;
            }

            // Обрабатываем текущую страницу батчами
            $chunks = array_chunk($result['data'], 5000);
            foreach ($chunks as $chunk) {
                $processed = call_user_func($callback, $chunk);
                $total_processed += $processed;
            }

            // Если получили меньше чем запросили - это последняя страница
            if ($current_count < $page_size) {
                $has_more_data = false;
            }

            $page++;
            
            // Задержка между запросами для предотвращения rate limiting
            usleep(300000); // 0.3 сек

            // Защита от бесконечного цикла
            if ($page > 100) {
                $has_more_data = false;
            }

            unset($result);
        }

        return $total_processed;
    }

    public function getRegionsChunked($callback, $filter = array(), $page_size = 500) {
        // Для getAreas пагінація не підтримується згідно з API документацією
        // Завантажуємо всі області одним запитом
        $result = $this->makeApiRequest('getAreas', $filter);
        
        if (!isset($result['success']) || !$result['success'] || 
            !isset($result['data']) || !is_array($result['data']) || empty($result['data'])) {
            return 0;
        }

        $total_count = count($result['data']);

        // Розбиваємо на батчі вручну для обробки
        $total_processed = 0;
        $data_chunks = array_chunk($result['data'], $page_size);
        
        foreach ($data_chunks as $chunk) {
            $processed = call_user_func($callback, $chunk);
            $total_processed += $processed;
            unset($chunk);
        }

        return $total_processed;
    }

    // Залишаємо старі методи для зворотної сумісності
    public function getCities($filter = array()) {
        //error_log("[LIBRARY] getCities() called");
        //error_log("[LIBRARY] API Key check: " . (empty($this->api_key) ? "EMPTY!" : "Present"));
        
        //error_log("[LIBRARY] Calling makeApiRequest('getCities')");
        $start_time = microtime(true);
        $result = $this->makeApiRequest('getCities', $filter);
        $elapsed = round((microtime(true) - $start_time) * 1000, 2);
        
        //error_log("[LIBRARY] makeApiRequest completed in {$elapsed}ms");
        //error_log("[LIBRARY] Result: " . json_encode($result));

        if (isset($result['data']) && is_array($result['data'])) {
            //error_log("[LIBRARY] Returning " . count($result['data']) . " cities");
            return $result['data'];
        }

        //error_log("[LIBRARY] No data in result");
        return array();
    }

    public function getDepartments($filter = array()) {
        //error_log("[LIBRARY] getDepartments() called");
        //error_log("[LIBRARY] API Key check: " . (empty($this->api_key) ? "EMPTY!" : "Present"));
        
        //error_log("[LIBRARY] Calling makeApiRequest('getWarehouses')");
        $start_time = microtime(true);
        $result = $this->makeApiRequest('getWarehouses', $filter);
        $elapsed = round((microtime(true) - $start_time) * 1000, 2);
        
        //error_log("[LIBRARY] makeApiRequest completed in {$elapsed}ms");
        //error_log("[LIBRARY] Result: " . json_encode($result));

        if (isset($result['data']) && is_array($result['data'])) {
            //error_log("[LIBRARY] Returning " . count($result['data']) . " departments");
            return $result['data'];
        }

        //error_log("[LIBRARY] No data in result");
        return array();
    }

    public function getRegions($filter = array()) {
        //error_log("[LIBRARY] getRegions() called");
        //error_log("[LIBRARY] API Key check: " . (empty($this->api_key) ? "EMPTY!" : "Present"));
        
        //error_log("[LIBRARY] Calling makeApiRequest('getAreas')");
        $start_time = microtime(true);
        $result = $this->makeApiRequest('getAreas', $filter);
        $elapsed = round((microtime(true) - $start_time) * 1000, 2);
        
        //error_log("[LIBRARY] makeApiRequest completed in {$elapsed}ms");
        //error_log("[LIBRARY] Result: " . json_encode($result));

        if (isset($result['data']) && is_array($result['data'])) {
            //error_log("[LIBRARY] Returning " . count($result['data']) . " regions");
            return $result['data'];
        }

        //error_log("[LIBRARY] No data in result");
        return array();
    }

    /**
     * Синхронізація статусів замовлень зі статусами Нової Пошти
     *
     * @param array    $orders   [['order_id' => int, 'order_status_id' => int, 'ttn' => string], ...]
     * @param array    $status_map  карта відповідності: [StatusCode Нової Пошти => order_status_id магазину]
     * @param callable $status_change_callback  function($order_id, $order_status_id)
     *
     * @return array ['processed' => int, 'updated' => int, 'skipped' => int, 'errors' => array]
     */
    public function syncOrderStatuses($orders, $status_map, $status_change_callback) {
        $result = array(
            'processed' => 0,
            'updated'   => 0,
            'skipped'   => 0,
            'errors'    => array()
        );

        if (!$orders) {
            $result['errors'][] = 'Немає замовлень для відслідковування';

            return $result;
        }

        if (!$status_map || !is_array($status_map)) {
            $result['errors'][] = 'Не налаштовано відповідність статусів';

            return $result;
        }

        if (empty($this->api_key)) {
            $result['errors'][] = 'API ключ Нової Пошти не налаштований';

            return $result;
        }

        $documents = array();

        foreach ($orders as $order) {
            if (!empty($order['ttn'])) {
                $documents[] = array(
                    'DocumentNumber' => $order['ttn']
                );
            }
        }

        if (!$documents) {
            $result['errors'][] = 'Немає накладних для відслідковування';

            return $result;
        }

        require_once dirname(DIR_SYSTEM) . '/vendor/autoload.php';

        if (!class_exists('\AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK')) {
            $result['errors'][] = 'Не знайдено SDK Нової Пошти';

            return $result;
        }

        $result['processed'] = count($documents);

        try {
            $sdk = new \AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK($this->api_key);

            $documents_statuses = $sdk->tracking()->getStatusDocumentsBatch($documents);
        } catch (Exception $e) {
            $result['errors'][] = $e->getMessage();

            return $result;
        }

        $statuses = array();

        if (is_array($documents_statuses)) {
            foreach ($documents_statuses as $document_status) {
                if (empty($document_status['Number'])) {
                    continue;
                }

                $statuses[$document_status['Number']] = $document_status;
            }
        }

        foreach ($orders as $order) {
            if (empty($order['ttn']) || !isset($statuses[$order['ttn']])) {
                $result['skipped']++;

                continue;
            }

            $document_status = $statuses[$order['ttn']];

            $status_code = isset($document_status['StatusCode']) ? (int)$document_status['StatusCode'] : 0;

            if (!$status_code || !isset($status_map[$status_code])) {
                $result['skipped']++;

                continue;
            }

            $order_status_id = (int)$status_map[$status_code];

            // Статус вже такий самий - нічого не змінюємо
            if ((int)$order['order_status_id'] == $order_status_id) {
                $result['skipped']++;

                continue;
            }

            call_user_func($status_change_callback, $order['order_id'], $order_status_id);

            $result['updated']++;
        }

        return $result;
    }

    private function makeApiRequest($method, $properties = array()) {
        $max_retries = 3;
        $retry_count = 0;
        $retry_delay = 1000; // мс
        
        while ($retry_count <= $max_retries) {
            $data = array(
                'apiKey' => $this->api_key,
                'modelName' => 'Address',
                'calledMethod' => $method
            );

            if (!empty($properties)) {
                $data['methodProperties'] = $properties;
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            $curlErrno = curl_errno($ch);
            curl_close($ch);

            // Ошибка подключения
            if ($curlError) {
                if ($this->log) {
                    $this->log->write("[API_REQUEST] cURL Error (retry $retry_count): ($curlErrno) $curlError");
                }
                $retry_count++;
                if ($retry_count <= $max_retries) {
                    usleep($retry_delay * 1000);
                    $retry_delay *= 2;
                }
                continue;
            }

            // HTTP ошибка
            if ($response === false || $httpCode !== 200) {
                if ($this->log) {
                    $this->log->write("[API_REQUEST] HTTP Error $httpCode (retry $retry_count)");
                }
                $retry_count++;
                if ($retry_count <= $max_retries) {
                    usleep($retry_delay * 1000);
                    $retry_delay *= 2;
                }
                continue;
            }

            // JSON парсинг
            $result = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                if ($this->log) {
                    $this->log->write("[API_REQUEST] JSON decode error: " . json_last_error_msg());
                }
                $retry_count++;
                if ($retry_count <= $max_retries) {
                    usleep($retry_delay * 1000);
                    $retry_delay *= 2;
                }
                continue;
            }

            // Проверяем ошибку "Too many requests" от Nova Poshta
            if (isset($result['errorCodes']) && in_array('20000401501', $result['errorCodes'])) {
                if ($this->log) {
                    $info_msg = isset($result['info'][0]) ? $result['info'][0] : 'Too many requests';
                    $this->log->write("[API_REQUEST] Rate limit hit (retry $retry_count): $info_msg");
                }
                
                // Парсим рекомендуемую задержку из сообщения API
                $recommended_delay = 500;
                if (isset($result['info']) && is_array($result['info'])) {
                    foreach ($result['info'] as $info) {
                        if (preg_match('/after ([\d.]+)\s*seconds?/i', $info, $matches)) {
                            $recommended_delay = (int)($matches[1] * 1000);
                            break;
                        }
                    }
                }
                
                $retry_count++;
                if ($retry_count <= $max_retries) {
                    if ($this->log) {
                        $this->log->write("[API_REQUEST] Waiting " . ($recommended_delay / 1000) . " seconds before retry...");
                    }
                    usleep($recommended_delay * 1000);
                    continue;
                }
            }

            // Успешный ответ - выходим из цикла
            // if ($this->log) {
            //     $this->log->write("[API_REQUEST] Success for $method");
            // }
            return $result;
        }

        // Все повторы исчерпаны
        if ($this->log) {
            $this->log->write("[API_REQUEST] Failed after $max_retries retries for $method");
        }
        return array('success' => false, 'data' => array(), 'errors' => array('Max retries exceeded'));
    }
}