<?php
class ModelExtensionShippingNovaposhta extends Model {
    private $error = array();

    public function getQuote($address) {
        $this->load->language('extension/shipping/novaposhta');

        $method_data = array();
        $quote_data = array();

        if (!$this->config->get('shipping_novaposhta_status')) {
            return $method_data;
        }

        $language_id = $this->config->get('config_language_id');
        $subtotal = $this->cart->getSubTotal();

        // Визначаємо групу клієнта
        $customer_group_id = 0;
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        // Перевіряємо методи доставки для групи
        $shipping_methods = ['department', 'courier', 'parcelbox'];

        foreach ($shipping_methods as $method) {
            $quote = $this->getShippingMethodQuote($method, $address, $subtotal, $language_id, $customer_group_id);
            if ($quote) {
                $quote_data[$method] = $quote;
            }
        }

        if ($quote_data) {
            $method_data = array(
                'code' => 'novaposhta',
                'title' => $this->language->get('text_title'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get('shipping_novaposhta_sort_order'),
                'error' => false
            );
        }

        return $method_data;
    }

    /**
     * Отримує котировку для конкретного методу доставки
     */
    private function getShippingMethodQuote($method, $address, $subtotal, $language_id, $customer_group_id) {
        $settings = $this->getShippingMethodSettings($method, $customer_group_id);

        if (!$settings || !$settings['status']) {
            return null;
        }

        // Перевіряємо географічну зону
        $status = $this->checkGeoZoneStatus($settings['geo_zone_id'], $address);
        if (!$status) {
            return null;
        }

        // Перевіряємо ліміти замовлення
        $status = $this->checkOrderLimits($subtotal, $settings['min_sum'], $settings['max_sum']);
        if (!$status) {
            return null;
        }

        $cost = (int) $settings['cost'];

        $text = $this->getShippingText(
            $cost,
            $subtotal,
            $settings['free_sum'],
            $settings['free_text'],
            $language_id,
            $settings['tax_class_id']
        );

        if ($settings['free_sum'] && $subtotal >= $settings['free_sum']) {
            $cost = 0;
        }

        // Визначаємо заголовки по умолчанню
        $default_titles = [
            'department' => 'Доставка до відділення',
            'courier' => 'Доставка кур\'єром',
            'parcelbox' => 'Доставка в почтомат'
        ];

        $title = isset($settings['title'][$language_id]) ?
            $settings['title'][$language_id] :
            $default_titles[$method];

        $description = isset($settings['description'][$language_id]) ?
            html_entity_decode($settings['description'][$language_id]) :
            '';

        return array(
            'code' => "novaposhta.{$method}",
            'title' => $title,
            'description' => $description,
            'cost' => $cost,
            'tax_class_id' => $settings['tax_class_id'],
            'text' => $text,
            'sort_order' => isset($settings['sort_order']) ? $settings['sort_order'] : 0
        );
    }

    /**
     * Отримує налаштування для конкретного методу доставки та групи клієнта
     */
    private function getShippingMethodSettings($method, $customer_group_id) {
        $customer_group_settings = $this->config->get('shipping_novaposhta_customer_group_settings');

        // Спочатку пробуємо отримати налаштування для конкретної групи клієнта
        if (isset($customer_group_settings[$customer_group_id][$method])) {
            $settings = $customer_group_settings[$customer_group_id][$method];

            // Перевіряємо, чи активний метод для цієї групи
            if (isset($settings['status']) && $settings['status']) {
                return $settings;
            }
        }

        // Якщо налаштувань для групи немає або метод неактивний, використовуємо стандартні налаштування
        $default_settings = array(
            'status' => false,
        );

        return $default_settings['status'] ? $default_settings : null;
    }

    private function checkGeoZoneStatus($geo_zone_id, $address) {
        if (!$geo_zone_id) {
            return true;
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $geo_zone_id . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");

        return $query->num_rows > 0;
    }

    private function checkOrderLimits($subtotal, $min_sum, $max_sum) {
        if ($min_sum && $subtotal < $min_sum) {
            return false;
        }

        if ($max_sum && $subtotal > $max_sum) {
            return false;
        }

        return true;
    }

    private function getShippingText($cost, $subtotal, $free_sum, $free_text, $language_id, $tax_class_id) {
        if ($cost > 0) {
            if ($free_sum && $subtotal >= $free_sum) {
                if (isset($free_text[$language_id])) {
                    return $free_text[$language_id];
                } else {
                    return $this->language->get('text_free');
                }
            } else {
                return $this->currency->format(
                    $this->tax->calculate($cost, $tax_class_id, $this->config->get('config_tax')),
                    $this->session->data['currency']
                );
            }
        } else {
            return $this->language->get('text_cost');
        }
    }

    /**
     * API методи для обновления справочников
     */
    public function getRegionsTotal() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "novaposhta_regions");
        return $query->row['total'];
    }

    public function getCitiesTotal() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "novaposhta_cities");
        return $query->row['total'];
    }

    public function getDepartmentsTotal() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "novaposhta_departments");
        return $query->row['total'];
    }

    public function truncateRegionsTable() {
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_regions");
    }

    public function truncateCitiesTable() {
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_cities");
    }

    public function truncateDepartmentsTable() {
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_departments");
    }

    public function addRegionsBatch($regions) {
        $inserted = 0;
        
        foreach ($regions as $region) {
            try {
                $this->db->query("INSERT INTO " . DB_PREFIX . "novaposhta_regions SET 
                    Ref = '" . $this->db->escape($region['Ref']) . "',
                    AreasCenter = '" . $this->db->escape($region['AreasCenter']) . "',
                    DescriptionRu = '" . $this->db->escape($region['DescriptionRu']) . "',
                    Description = '" . $this->db->escape($region['Description']) . "'");
                $inserted++;
            } catch (Exception $e) {
                // Ошибка при вставке
            }
        }
        
        return $inserted;
    }

    public function addCitiesBatch($cities) {
        $inserted = 0;
        
        foreach ($cities as $city) {
            try {
                $this->db->query("INSERT INTO " . DB_PREFIX . "novaposhta_cities SET 
                    DescriptionRu = '" . $this->db->escape($city['DescriptionRu']) . "',
                    Description = '" . $this->db->escape($city['Description']) . "',
                    Ref = '" . $this->db->escape($city['Ref']) . "',
                    Delivery1 = '" . $this->db->escape($city['Delivery1']) . "',
                    Delivery2 = '" . $this->db->escape($city['Delivery2']) . "',
                    Delivery3 = '" . $this->db->escape($city['Delivery3']) . "',
                    Delivery4 = '" . $this->db->escape($city['Delivery4']) . "',
                    Delivery5 = '" . $this->db->escape($city['Delivery5']) . "',
                    Delivery6 = '" . $this->db->escape($city['Delivery6']) . "',
                    Delivery7 = '" . $this->db->escape($city['Delivery7']) . "',
                    SettlementType = '" . $this->db->escape($city['SettlementType']) . "',
                    IsBranch = '" . $this->db->escape($city['IsBranch']) . "',
                    PreventEntryNewStreetsUser = '" . $this->db->escape($city['PreventEntryNewStreetsUser']) . "',
                    CityID = '" . $this->db->escape($city['CityID']) . "',
                    SettlementTypeDescription = '" . $this->db->escape($city['SettlementTypeDescription']) . "',
                    SettlementTypeDescriptionRu = '" . $this->db->escape($city['SettlementTypeDescriptionRu']) . "',
                    SpecialCashCheck = '" . $this->db->escape($city['SpecialCashCheck']) . "',
                    AreaDescription = '" . $this->db->escape($city['AreaDescription']) . "',
                    AreaDescriptionRu = '" . $this->db->escape($city['AreaDescriptionRu']) . "',
                    Area = '" . $this->db->escape($city['Area']) . "'");
                $inserted++;
            } catch (Exception $e) {
                // Ошибка при вставке
            }
        }
        
        return $inserted;
    }

    public function addDepartmentsBatch($departments) {
        $inserted = 0;
        
        foreach ($departments as $department) {
            try {
                $fields = array();
                $values = array();
                
                $field_mapping = array(
                    'Ref', 'TypeOfWarehouse', 'CityRef', 'SiteKey', 'Description', 'DescriptionRu',
                    'ShortAddress', 'ShortAddressRu', 'Phone', 'Number', 'CityDescription', 'CityDescriptionRu',
                    'SettlementRef', 'SettlementDescription', 'SettlementAreaDescription', 'SettlementRegionsDescription',
                    'SettlementTypeDescription', 'SettlementTypeDescriptionRu', 'Longitude', 'Latitude',
                    'PostFinance', 'BicycleParking', 'PaymentAccess', 'POSTerminal', 'InternationalShipping',
                    'SelfServiceWorkplacesCount', 'TotalMaxWeightAllowed', 'PlaceMaxWeightAllowed',
                    'SendingLimitationsOnDimensions', 'ReceivingLimitationsOnDimensions', 'Reception', 'Delivery',
                    'Schedule', 'DistrictCode', 'WarehouseStatus', 'WarehouseStatusDate', 'WarehouseIllusha',
                    'CategoryOfWarehouse', 'Direct', 'RegionCity', 'WarehouseForAgent', 'GeneratorEnabled',
                    'MaxDeclaredCost', 'WorkInMobileAwis', 'DenyToSelect', 'CanGetMoneyTransfer', 'HasMirror',
                    'HasFittingRoom', 'OnlyReceivingParcel', 'PostMachineType', 'PostalCodeUA', 'WarehouseIndex',
                    'BeaconCode', 'PostomatFor', 'Location'
                );
                
                foreach ($field_mapping as $field) {
                    $value = isset($department[$field]) ? $department[$field] : '';
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    $fields[] = $field;
                    $values[] = "'" . $this->db->escape($value) . "'";
                }
                
                $sql = "INSERT INTO " . DB_PREFIX . "novaposhta_departments SET " . 
                       implode(', ', array_map(function($f, $v) { return "$f = $v"; }, $fields, $values));
                
                $this->db->query($sql);
                $inserted++;
            } catch (Exception $e) {
                // Ошибка при вставке
            }
        }
        
        return $inserted;
    }

    /**
     * Замовлення, які потрібно відслідковувати (за налаштованими статусами)
     */
    public function getOrdersForTracking() {
        $statuses = $this->config->get('shipping_novaposhta_tracking_statuses');

        if (!is_array($statuses) || !$statuses) {
            return array();
        }

        $statuses = array_filter(array_map('intval', $statuses));

        if (!$statuses) {
            return array();
        }

        $query = $this->db->query("
            SELECT nttn.ttn AS ttn, o.order_status_id AS order_status_id, nttn.order_id AS order_id
            FROM `" . DB_PREFIX . "novaposhta_ttn` nttn
            LEFT JOIN `" . DB_PREFIX . "order` o ON (nttn.order_id = o.order_id)
            WHERE o.order_status_id IN (" . implode(',', $statuses) . ")
            AND o.shipping_code IN ('novaposhta.department', 'novaposhta.parcelbox' , 'novaposhta.courier', 'filterit0.filterit0')
            AND nttn.ttn != ''
            AND o.date_added >= NOW() - INTERVAL 50 DAY
        ");

        return $query->rows;
    }

    /**
     * Карта відповідності: код статусу Нової Пошти => order_status_id магазину
     */
    public function getOrderStatusMap() {
        $status_map = $this->config->get('shipping_novaposhta_status_map');
        $result = array();

        if (!is_array($status_map)) {
            return $result;
        }

        foreach ($status_map as $row) {
            if (empty($row['order_status_id']) || empty($row['statuses']) || !is_array($row['statuses'])) {
                continue;
            }

            foreach ($row['statuses'] as $status_code) {
                $status_code = (int)$status_code;

                // Перший рядок має пріоритет
                if ($status_code && !isset($result[$status_code])) {
                    $result[$status_code] = (int)$row['order_status_id'];
                }
            }
        }

        return $result;
    }

    /**
     * Зміна статусу замовлення без сповіщень та коментарів
     */
    public function setOrderStatus($order_id, $order_status_id) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_history` SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '0', comment = 'Автоматическое обновление', date_added = NOW()");
    }
}