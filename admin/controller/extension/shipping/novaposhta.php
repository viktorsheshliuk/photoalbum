<?php
class ControllerExtensionShippingNovaposhta extends Controller {
    const DEFAULT_CRON_KEY = '77777';

    private $error = array();

    public function index() {
        $this->load->language('extension/shipping/novaposhta');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            //$this->model_setting_setting->editSetting('shipping_novaposhta', $this->request->post);
            $setting_data = $this->request->post;

            // Відповідність статусів Нової Пошти статусам замовлень (вкладка Cron)
            if (isset($this->request->post['shipping_novaposhta_status_map'])) {
                $setting_data['shipping_novaposhta_status_map'] = $this->normalizeStatusMap($this->request->post['shipping_novaposhta_status_map']);
            } elseif (isset($this->request->post['np_status_map_present'])) {
                $setting_data['shipping_novaposhta_status_map'] = array();
            }

            // Статуси замовлень, які відслідковуються (вкладка Cron)
            if (!isset($this->request->post['shipping_novaposhta_tracking_statuses']) && isset($this->request->post['np_tracking_statuses_present'])) {
                $setting_data['shipping_novaposhta_tracking_statuses'] = array();
            }

            if (isset($setting_data['shipping_novaposhta_tracking_statuses']) && is_array($setting_data['shipping_novaposhta_tracking_statuses'])) {
                $setting_data['shipping_novaposhta_tracking_statuses'] = array_values(array_filter(array_unique(array_map('intval', $setting_data['shipping_novaposhta_tracking_statuses']))));
            }

            if (isset($this->request->post['shipping_novaposhta_api_key'])) {
                $setting_data['shipping_novaposhta'] = [
                    'key_api' => $this->request->post['shipping_novaposhta_api_key']
                ];
            }

            $this->model_setting_setting->editSetting('shipping_novaposhta', $setting_data);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['api_key'])) {
            $data['error_api_key'] = $this->error['api_key'];
        } else {
            $data['error_api_key'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/shipping/novaposhta', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/shipping/novaposhta', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

        // ГЛОБАЛЬНІ налаштування (статус модуля, API ключ, загальний порядок сортування)
        if (isset($this->request->post['shipping_novaposhta_api_key'])) {
            $data['shipping_novaposhta_api_key'] = $this->request->post['shipping_novaposhta_api_key'];
        } else {
            $data['shipping_novaposhta_api_key'] = $this->config->get('shipping_novaposhta_api_key');
        }

        if (isset($this->request->post['shipping_novaposhta_status'])) {
            $data['shipping_novaposhta_status'] = $this->request->post['shipping_novaposhta_status'];
        } else {
            $data['shipping_novaposhta_status'] = $this->config->get('shipping_novaposhta_status');
        }

        if (isset($this->request->post['shipping_novaposhta_sort_order'])) {
            $data['shipping_novaposhta_sort_order'] = $this->request->post['shipping_novaposhta_sort_order'];
        } else {
            $data['shipping_novaposhta_sort_order'] = $this->config->get('shipping_novaposhta_sort_order');
        }

        // НАЛАШТУВАННЯ ДЛЯ ГРУП КОРИСТУВАЧІВ
        if (isset($this->request->post['shipping_novaposhta_customer_group_settings'])) {
            $data['shipping_novaposhta_customer_group_settings'] = $this->request->post['shipping_novaposhta_customer_group_settings'];
        } else {
            $data['shipping_novaposhta_customer_group_settings'] = $this->config->get('shipping_novaposhta_customer_group_settings');
        }

        // Для зворотної сумісності - всі старі поля для всіх методів
        $methods = ['courier', 'department', 'parcelbox'];

        foreach ($methods as $method) {
            $legacy_fields = [
                "shipping_novaposhta_{$method}_status",
                "shipping_novaposhta_{$method}_title",
                "shipping_novaposhta_{$method}_description",
                "shipping_novaposhta_{$method}_cost",
                "shipping_novaposhta_{$method}_min_sum",
                "shipping_novaposhta_{$method}_max_sum",
                "shipping_novaposhta_{$method}_free_sum",
                "shipping_novaposhta_{$method}_free_text",
                "shipping_novaposhta_{$method}_tax_class_id",
                "shipping_novaposhta_{$method}_geo_zone_id",
                "shipping_novaposhta_{$method}_sort_order"
            ];

            foreach ($legacy_fields as $field) {
                if (isset($this->request->post[$field])) {
                    $data[$field] = $this->request->post[$field];
                } else {
                    $data[$field] = $this->config->get($field);
                }
            }
        }

        // Завантаження моделей для дропдаунів
        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();

        $this->load->model('localisation/tax_class');
        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        // ДОДАЄМО ГРУПИ КОРИСТУВАЧІВ
        $this->load->model('customer/customer_group');
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        // API дані
        $this->load->model('extension/shipping/novaposhta');
        $data['regions_total'] = $this->model_extension_shipping_novaposhta->getRegionsTotal();
        $data['cities_total'] = $this->model_extension_shipping_novaposhta->getCitiesTotal();
        $data['departments_total'] = $this->model_extension_shipping_novaposhta->getDepartmentsTotal();

        // Данные отправителя
        $sender_fields = [
            'shipping_novaposhta_sender_name',
            'shipping_novaposhta_sender_phone',
            'shipping_novaposhta_sender_city_ref',
            'shipping_novaposhta_sender_city_name',
            'shipping_novaposhta_sender_warehouse_ref',
            'shipping_novaposhta_sender_warehouse_name',
            'shipping_novaposhta_sender_counterparty_ref',  
            'shipping_novaposhta_sender_contact_ref',
            'shipping_novaposhta_payment_nalogka_code'
        ];

        foreach ($sender_fields as $field) {
            if (isset($this->request->post[$field])) {
                $data[$field] = $this->request->post[$field];
            } else {
                $data[$field] = $this->config->get($field);
            }
        }

        // Загружаем статусы заказов
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('setting/extension');
        $installed = $this->model_setting_extension->getInstalled('payment');

        $method_data = array();

        // 1. Сначала обычные методы оплаты
        foreach ($installed as $code) {
            if ($this->config->get('payment_' . $code . '_status')) {
                $this->load->language('extension/payment/' . $code);
                $method_data[$code] = array(
                    'code'       => $code,
                    'title'      => $this->language->get('heading_title'),
                    'sort_order' => $this->config->get('payment_' . $code . '_sort_order') ?? 0
                );
            }
        }

        // 2. Добавляем методы из Filterit
        $language = $this->config->get('config_admin_language');
        $filterit = $this->config->get('filterit_payment'); // ← вот тут всё хранится

        if (!empty($filterit['created'])) {
            foreach ($filterit['created'] as $module_code => $module_info) {
                $method_data[$module_code] = array(
                    'code'       => $module_code,
                    'title'      => !empty($module_info['title'][$language])
                                    ? $module_info['title'][$language]
                                    : $module_code,
                    'sort_order' => $module_info['sort_order'] ?? 0
                );
            }
        }

        // Сортировка
        $sort_order = array();
        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }
        array_multisort($sort_order, SORT_ASC, $method_data);

        $data['payment_methods'] = $method_data;

        // Налаштування відслідковування статусів (вкладка Cron)
        $data['novaposhta_statuses'] = $this->model_extension_shipping_novaposhta->getNovaposhtaStatuses();

        if (isset($this->request->post['shipping_novaposhta_tracking_enabled'])) {
            $data['shipping_novaposhta_tracking_enabled'] = $this->request->post['shipping_novaposhta_tracking_enabled'];
        } else {
            $data['shipping_novaposhta_tracking_enabled'] = $this->config->get('shipping_novaposhta_tracking_enabled');
        }

        if (isset($this->request->post['shipping_novaposhta_tracking_statuses'])) {
            $data['shipping_novaposhta_tracking_statuses'] = array_values(array_map('intval', (array)$this->request->post['shipping_novaposhta_tracking_statuses']));
        } else {
            $tracking_statuses = $this->config->get('shipping_novaposhta_tracking_statuses');

            // Значення за замовчуванням (як у попередній версії модуля)
            if (!is_array($tracking_statuses)) {
                $tracking_statuses = array(12, 9, 1, 6, 11, 2);
            }

            $data['shipping_novaposhta_tracking_statuses'] = array_values(array_map('intval', $tracking_statuses));
        }

        if (isset($this->request->post['shipping_novaposhta_cron_key'])) {
            $data['shipping_novaposhta_cron_key'] = $this->request->post['shipping_novaposhta_cron_key'];
        } else {
            $data['shipping_novaposhta_cron_key'] = $this->config->get('shipping_novaposhta_cron_key');
        }

        if (!$data['shipping_novaposhta_cron_key']) {
            $data['shipping_novaposhta_cron_key'] = self::DEFAULT_CRON_KEY;
        }

        if (isset($this->request->post['shipping_novaposhta_status_map'])) {
            $data['shipping_novaposhta_status_map'] = $this->normalizeStatusMap($this->request->post['shipping_novaposhta_status_map']);
        } else {
            $data['shipping_novaposhta_status_map'] = $this->normalizeStatusMap($this->config->get('shipping_novaposhta_status_map'));
        }

        $data['cron_url'] = HTTP_CATALOG . 'index.php?route=api/novaposhta/tracking&api_key=' . urlencode($data['shipping_novaposhta_cron_key']);

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/shipping/novaposhta', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/shipping/novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['shipping_novaposhta_api_key'])) {
            $this->error['api_key'] = $this->language->get('error_api_key');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    // Метод для поиска городов отправителя
    public function searchSenderCities() {
        $json = array();
        
        if (isset($this->request->get['search'])) {
            $this->load->model('extension/shipping/novaposhta');
            
            $cities = $this->model_extension_shipping_novaposhta->searchCities($this->request->get['search']);
            
            foreach ($cities as $city) {
                $json[] = array(
                    'name' => !empty($city['description_ru']) ? $city['description_ru'] : $city['description'],
                    'ref' => $city['ref']
                );
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json, JSON_UNESCAPED_UNICODE));
    }
    
    // Метод для получения отделений отправителя
    public function getSenderWarehouses() {
        $json = array();
        
        if (isset($this->request->get['city_ref'])) {
            $this->load->model('extension/shipping/novaposhta');
            
            $warehouses = $this->model_extension_shipping_novaposhta->getWarehousesByCityRef($this->request->get['city_ref']);
            
            foreach ($warehouses as $warehouse) {
                $json[] = array(
                    'name' => !empty($warehouse['description_ru']) ? $warehouse['description_ru'] : $warehouse['description'],
                    'ref' => $warehouse['ref']
                );
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json, JSON_UNESCAPED_UNICODE));
    }

    // API методи для оновлення довідників
    public function updateDepartments() {
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

    public function updateCities() {
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

    public function updateRegions() {
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
    /**
     * Нормалізація карти відповідності статусів
     * (прибирає порожні рядки та дублікати кодів Нової Пошти)
     */
    protected function normalizeStatusMap($status_map) {
        $result = array();

        if (!is_array($status_map)) {
            return $result;
        }

        $used_codes = array();

        foreach ($status_map as $row) {
            if (!is_array($row) || empty($row['order_status_id'])) {
                continue;
            }

            $statuses = array();

            if (isset($row['statuses']) && is_array($row['statuses'])) {
                foreach ($row['statuses'] as $status_code) {
                    $status_code = (int)$status_code;

                    if ($status_code && !isset($used_codes[$status_code])) {
                        $used_codes[$status_code] = true;
                        $statuses[] = $status_code;
                    }
                }
            }

            if (!$statuses) {
                continue;
            }

            $result[] = array(
                'statuses'        => $statuses,
                'order_status_id' => (int)$row['order_status_id']
            );
        }

        return $result;
    }

    /**
     * Ручний запуск оновлення статусів замовлень (кнопка "Оновити статуси зараз")
     */
    public function runTracking() {
        $this->load->language('extension/shipping/novaposhta');
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
                throw new Exception($this->language->get('error_np_tracking_disabled'));
            }

            $orders = $this->model_extension_shipping_novaposhta->getOrdersForTracking();

            if (!$orders) {
                throw new Exception($this->language->get('error_np_no_orders'));
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