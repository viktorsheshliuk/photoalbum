<?php
//контроллер для крона, который будет обновлять данные по регионам, городам и отделениям Новой Почты через API и трекать ТТН
class ControllerApiNovaposhta extends Controller {
    const DEFAULT_CRON_KEY = '77777';

    private function getCronKey() {
        $cron_key = $this->config->get('shipping_novaposhta_cron_key');

        if (!$cron_key) {
            $cron_key = self::DEFAULT_CRON_KEY;
        }

        return (string)$cron_key;
    }

    private function validateApiKey() {
        $api_key = isset($this->request->get['api_key']) ? (string)$this->request->get['api_key'] : '';

        if (!hash_equals($this->getCronKey(), $api_key)) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode(['error' => 'Invalid API key']));
            return false;
        }
        return true;
    }

    public function updateRegions() {
        if (!$this->validateApiKey()) {
            return;
        }

        $this->load->language('extension/shipping/novaposhta');
        $this->load->model('extension/shipping/novaposhta');
        $this->load->library('novaposhta');

        $json = ['old_total' => 0, 'new_total' => 0];

        try {
            $json['old_total'] = $this->model_extension_shipping_novaposhta->getRegionsTotal();

            $total_processed = 0;
            $first_batch_loaded = false;
            
            // Загружаем и вставляем батчами
            $callback = function($chunk) use (&$total_processed, &$first_batch_loaded) {
                // Если первый батч успешно загружен - очищаем таблицу
                if (!$first_batch_loaded) {
                    $this->model_extension_shipping_novaposhta->truncateRegionsTable();
                    $first_batch_loaded = true;
                }
                
                // Вставляем батч
                $processed = $this->model_extension_shipping_novaposhta->addRegionsBatch($chunk);
                $total_processed += $processed;
                return $processed;
            };
            
            $total_from_api = $this->novaposhta->getRegionsChunked($callback);
            
            // Проверяем что загрузилось
            if ($total_processed === 0) {
                throw new Exception("Failed to retrieve regions from API - no data received");
            }
            
            $json['api_returned'] = $total_from_api;
            $json['new_total'] = $total_processed;
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function updateCities() {
        if (!$this->validateApiKey()) {
            return;
        }

        $this->load->language('extension/shipping/novaposhta');
        $this->load->model('extension/shipping/novaposhta');
        $this->load->library('novaposhta');

        $json = ['old_total' => 0, 'new_total' => 0];

        try {
            $json['old_total'] = $this->model_extension_shipping_novaposhta->getCitiesTotal();

            $total_processed = 0;
            $first_batch_loaded = false;
            
            // Загружаем и вставляем батчами
            $callback = function($chunk) use (&$total_processed, &$first_batch_loaded) {
                // Если первый батч успешно загружен - очищаем таблицу
                if (!$first_batch_loaded) {
                    $this->model_extension_shipping_novaposhta->truncateCitiesTable();
                    $first_batch_loaded = true;
                }
                
                // Вставляем батч
                $processed = $this->model_extension_shipping_novaposhta->addCitiesBatch($chunk);
                $total_processed += $processed;
                return $processed;
            };
            
            $total_from_api = $this->novaposhta->getCitiesChunked($callback);
            
            // Проверяем что загрузилось
            if ($total_processed === 0) {
                throw new Exception("Failed to retrieve cities from API - no data received");
            }
            
            $json['api_returned'] = $total_from_api;
            $json['new_total'] = $total_processed;
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function updateDepartments() {
        if (!$this->validateApiKey()) {
            return;
        }

        $this->load->language('extension/shipping/novaposhta');
        $this->load->model('extension/shipping/novaposhta');
        $this->load->library('novaposhta');

        $json = ['old_total' => 0, 'new_total' => 0];

        try {
            $json['old_total'] = $this->model_extension_shipping_novaposhta->getDepartmentsTotal();

            $total_processed = 0;
            $first_batch_loaded = false;
            
            // Загружаем и вставляем батчами
            $callback = function($chunk) use (&$total_processed, &$first_batch_loaded) {
                // Если первый батч успешно загружен - очищаем таблицу
                if (!$first_batch_loaded) {
                    $this->model_extension_shipping_novaposhta->truncateDepartmentsTable();
                    $first_batch_loaded = true;
                }
                
                // Вставляем батч
                $processed = $this->model_extension_shipping_novaposhta->addDepartmentsBatch($chunk);
                $total_processed += $processed;
                return $processed;
            };
            
            $total_from_api = $this->novaposhta->getDepartmentsChunked($callback);
            
            // Проверяем что загрузилось
            if ($total_processed === 0) {
                throw new Exception("Failed to retrieve departments from API - no data received");
            }
            
            $json['api_returned'] = $total_from_api;
            $json['new_total'] = $total_processed;
        } catch (Exception $e) {
            $json['error'] = $e->getMessage();
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function tracking() {
        if (!$this->validateApiKey()) {
            return;
        }

        $this->load->model('extension/shipping/novaposhta');
        $this->load->library('novaposhta');

        $json = array(
            'processed' => 0,
            'updated'   => 0,
            'skipped'   => 0,
            'errors'    => array()
        );

        try {
            if (!$this->config->get('shipping_novaposhta_tracking_enabled')) {
                throw new Exception('Tracking is disabled');
            }

            $orders = $this->model_extension_shipping_novaposhta->getOrdersForTracking();

            if (!$orders) {
                throw new Exception('No orders for tracking');
            }

            $status_map = $this->model_extension_shipping_novaposhta->getOrderStatusMap();

            $json = $this->novaposhta->syncOrderStatuses($orders, $status_map, function ($order_id, $order_status_id) {
                $this->model_extension_shipping_novaposhta->setOrderStatus($order_id, $order_status_id);
            });
        } catch (Exception $e) {
            $json['errors'][] = $e->getMessage();
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json, JSON_UNESCAPED_UNICODE));
    }
}
