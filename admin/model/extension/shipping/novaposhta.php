<?php
class ModelExtensionShippingNovaposhta extends Model {
    private $error = array();

    public function getQuote($address) {
        $this->load->language('extension/shipping/novaposhta');

        $method_data = array();
        $quote_data = array();

        $language_id = $this->config->get('config_language_id');
        $subtotal = $this->cart->getSubTotal();

        // Получаем группу текущего пользователя
        $customer_group_id = 0;
        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        // Доставка до відділення
        if ($this->config->get('shipping_novaposhta_department_status')) {
            $status = $this->checkGeoZoneStatus(
                $this->config->get('shipping_novaposhta_department_geo_zone_id'),
                $address
            );

            if ($status) {
                $settings = $this->getShippingSettings('department', $customer_group_id);

                $status = $this->checkOrderLimits(
                    $subtotal,
                    $settings['min_sum'],
                    $settings['max_sum']
                );
            }

            if ($status && $settings['status']) {
                $title = $this->config->get('shipping_novaposhta_department_title');
                $description = $this->config->get('shipping_novaposhta_department_description');

                $text = $this->getShippingText(
                    $settings['cost'],
                    $subtotal,
                    $settings['free_sum'],
                    $this->config->get('shipping_novaposhta_department_free_text'),
                    $language_id,
                    $this->config->get('shipping_novaposhta_department_tax_class_id'),
                    $settings['discount_percent']
                );

                $quote_data['department'] = array(
                    'code' => 'novaposhta.department',
                    'title' => isset($title[$language_id]) ? $title[$language_id] : $this->language->get('text_department_title'),
                    'description' => isset($description[$language_id]) ? html_entity_decode($description[$language_id]) : '',
                    'cost' => $settings['cost'],
                    'tax_class_id' => $this->config->get('shipping_novaposhta_department_tax_class_id'),
                    'text' => $text
                );
            }
        }

        // Доставка кур'єром
        if ($this->config->get('shipping_novaposhta_courier_status')) {
            $status = $this->checkGeoZoneStatus(
                $this->config->get('shipping_novaposhta_courier_geo_zone_id'),
                $address
            );

            if ($status) {
                $settings = $this->getShippingSettings('courier', $customer_group_id);

                $status = $this->checkOrderLimits(
                    $subtotal,
                    $settings['min_sum'],
                    $settings['max_sum']
                );
            }

            if ($status && $settings['status']) {
                $title = $this->config->get('shipping_novaposhta_courier_title');
                $description = $this->config->get('shipping_novaposhta_courier_description');

                $text = $this->getShippingText(
                    $settings['cost'],
                    $subtotal,
                    $settings['free_sum'],
                    $this->config->get('shipping_novaposhta_courier_free_text'),
                    $language_id,
                    $this->config->get('shipping_novaposhta_courier_tax_class_id'),
                    $settings['discount_percent']
                );

                $quote_data['courier'] = array(
                    'code' => 'novaposhta.courier',
                    'title' => isset($title[$language_id]) ? $title[$language_id] : $this->language->get('text_courier_title'),
                    'description' => isset($description[$language_id]) ? html_entity_decode($description[$language_id]) : '',
                    'cost' => $settings['cost'],
                    'tax_class_id' => $this->config->get('shipping_novaposhta_courier_tax_class_id'),
                    'text' => $text
                );
            }
        }

        // Доставка в почтомат
        if ($this->config->get('shipping_novaposhta_parcelbox_status')) {
            $status = $this->checkGeoZoneStatus(
                $this->config->get('shipping_novaposhta_parcelbox_geo_zone_id'),
                $address
            );

            if ($status) {
                $settings = $this->getShippingSettings('parcelbox', $customer_group_id);

                $status = $this->checkOrderLimits(
                    $subtotal,
                    $settings['min_sum'],
                    $settings['max_sum']
                );
            }

            if ($status && $settings['status']) {
                $title = $this->config->get('shipping_novaposhta_parcelbox_title');
                $description = $this->config->get('shipping_novaposhta_parcelbox_description');

                $text = $this->getShippingText(
                    $settings['cost'],
                    $subtotal,
                    $settings['free_sum'],
                    $this->config->get('shipping_novaposhta_parcelbox_free_text'),
                    $language_id,
                    $this->config->get('shipping_novaposhta_parcelbox_tax_class_id'),
                    $settings['discount_percent']
                );

                $quote_data['parcelbox'] = array(
                    'code' => 'novaposhta.parcelbox',
                    'title' => isset($title[$language_id]) ? $title[$language_id] : 'Доставка в почтомат',
                    'description' => isset($description[$language_id]) ? html_entity_decode($description[$language_id]) : '',
                    'cost' => $settings['cost'],
                    'tax_class_id' => $this->config->get('shipping_novaposhta_parcelbox_tax_class_id'),
                    'text' => $text
                );
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
     * Получить настройки доставки для конкретной группы пользователей
     */
    private function getShippingSettings($type, $customer_group_id) {
        $settings = array();

        // Получаем базовые настройки
        $settings['status'] = $this->config->get('shipping_novaposhta_' . $type . '_status');
        $settings['cost'] = (float) $this->config->get('shipping_novaposhta_' . $type . '_cost');
        $settings['min_sum'] = (float) $this->config->get('shipping_novaposhta_' . $type . '_min_sum');
        $settings['max_sum'] = (float) $this->config->get('shipping_novaposhta_' . $type . '_max_sum');
        $settings['free_sum'] = (float) $this->config->get('shipping_novaposhta_' . $type . '_free_sum');
        $settings['discount_percent'] = 0;

        // Проверяем, есть ли специальные настройки для группы
        $group_status = $this->config->get('shipping_novaposhta_' . $type . '_group_' . $customer_group_id . '_status');

        if ($group_status !== null && $group_status != '') {
            // Применяем настройки для группы
            $settings['status'] = $group_status;

            $group_cost = $this->config->get('shipping_novaposhta_' . $type . '_group_' . $customer_group_id . '_cost');
            if ($group_cost !== null && $group_cost != '') {
                $settings['cost'] = (float) $group_cost;
            }

            $group_min_sum = $this->config->get('shipping_novaposhta_' . $type . '_group_' . $customer_group_id . '_min_sum');
            if ($group_min_sum !== null && $group_min_sum != '') {
                $settings['min_sum'] = (float) $group_min_sum;
            }

            $group_max_sum = $this->config->get('shipping_novaposhta_' . $type . '_group_' . $customer_group_id . '_max_sum');
            if ($group_max_sum !== null && $group_max_sum != '') {
                $settings['max_sum'] = (float) $group_max_sum;
            }

            $group_free_sum = $this->config->get('shipping_novaposhta_' . $type . '_group_' . $customer_group_id . '_free_sum');
            if ($group_free_sum !== null && $group_free_sum != '') {
                $settings['free_sum'] = (float) $group_free_sum;
            }

            $group_discount = $this->config->get('shipping_novaposhta_' . $type . '_group_' . $customer_group_id . '_discount_percent');
            if ($group_discount !== null && $group_discount != '') {
                $settings['discount_percent'] = (float) $group_discount;
            }
        }

        return $settings;
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

    private function getShippingText($cost, $subtotal, $free_sum, $free_text, $language_id, $tax_class_id, $discount_percent = 0) {
        // Применяем скидку по группе
        if ($discount_percent > 0) {
            $cost = $cost * (1 - $discount_percent / 100);
        }

        if ($cost > 0) {
            if ($free_sum && $subtotal >= $free_sum) {
                $cost = 0;
                if (isset($free_text[$language_id])) {
                    return $free_text[$language_id];
                } else {
                    return $this->language->get('text_free');
                }
            } else {
                $formatted_cost = $this->currency->format(
                    $this->tax->calculate($cost, $tax_class_id, $this->config->get('config_tax')),
                    $this->session->data['currency']
                );

                // Добавляем информацию о скидке, если она есть
                if ($discount_percent > 0) {
                    $original_cost = $this->currency->format(
                        $this->tax->calculate($cost / (1 - $discount_percent / 100), $tax_class_id, $this->config->get('config_tax')),
                        $this->session->data['currency']
                    );
                    return $formatted_cost . ' <small class="text-muted"><s>' . $original_cost . '</s> (-' . $discount_percent . '%)</small>';
                }

                return $formatted_cost;
            }
        } else {
            return $this->language->get('text_cost');
        }
    }

    /**
     * Получить общее количество регионов
     */
    public function getRegionsTotal() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "novaposhta_regions");
        return $query->row['total'];
    }

    /**
     * Получить общее количество городов
     */
    public function getCitiesTotal() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "novaposhta_cities");
        return $query->row['total'];
    }

    /**
     * Получить общее количество отделений
     */
    public function getDepartmentsTotal() {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "novaposhta_departments");
        return $query->row['total'];
    }

    /**
     * Обновить регионы
     */
    public function truncateRegionsTable() {
        //error_log("[MODEL] Truncating regions table");
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_regions");
    }

    /**
     * Добавить батч регионов (без очистки таблицы)
     */
    public function addRegionsBatch($regions) {
        //error_log("[MODEL] addRegionsBatch() started. Processing " . count($regions) . " regions");
        
        $inserted = 0;
        foreach ($regions as $region) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "novaposhta_regions SET 
                Ref = '" . $this->db->escape($region['Ref']) . "',
                AreasCenter = '" . $this->db->escape($region['AreasCenter']) . "',
                DescriptionRu = '" . $this->db->escape($region['DescriptionRu']) . "',
                Description = '" . $this->db->escape($region['Description']) . "'");
            $inserted++;
        }
        
        //error_log("[MODEL] addRegionsBatch() completed. Inserted $inserted regions");
        return $inserted;
    }

    /**
     * Обновить регионы (старый метод для обратной совместимости)

    /**
     * Обновить города
     */
    public function truncateCitiesTable() {
        //error_log("[MODEL] Truncating cities table");
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_cities");
    }

    /**
     * Добавить батч городов (без очистки таблицы)
     */
    public function addCitiesBatch($cities) {
        //error_log("[MODEL] addCitiesBatch() started. Processing " . count($cities) . " cities");
        
        $inserted = 0;
        foreach ($cities as $city) {
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
        }
        
       // error_log("[MODEL] addCitiesBatch() completed. Inserted $inserted cities");
        return $inserted;
    }

    /**
     * Обновить города (старый метод для обратной совместимости)

    /**
     * Обновить отделения
     */
    public function truncateDepartmentsTable() {
        //error_log("[MODEL] Truncating departments table");
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_departments");
    }

    /**
     * Добавить батч отделений (без очистки таблицы)
     */
    public function addDepartmentsBatch($departments) {
        $inserted = 0;
        $failed = 0;
        
        foreach ($departments as $department) {
            try {
                $fields = array();
                $values = array();
                
                // Маппируем все поля из API в таблицу
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
                    // Если значение массив - конвертируем в JSON
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
                $failed++;
            }
        }
        
        return $inserted;
    }

    /**
     * Обновить отделения (старый метод для обратной совместимости)
     */
    public function updateDepartments($departments) {
        //error_log("[MODEL] updateDepartments() started. Processing " . count($departments) . " departments");
        
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "novaposhta_departments");
        //error_log("[MODEL] Table truncated");

        $inserted = 0;
        $failed = 0;
        
        foreach ($departments as $department) {
            try {
                $fields = array();
                $values = array();
                
                // Маппируем все поля из API в таблицу
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
                    $fields[] = $field;
                    $values[] = "'" . $this->db->escape($value) . "'";
                }
                
                $sql = "INSERT INTO " . DB_PREFIX . "novaposhta_departments SET " . 
                       implode(', ', array_map(function($f, $v) { return "$f = $v"; }, $fields, $values));
                
                $this->db->query($sql);
                $inserted++;
                
            } catch (Exception $e) {
                //error_log("[MODEL] Error inserting department " . (isset($department['Ref']) ? $department['Ref'] : 'UNKNOWN') . ": " . $e->getMessage());
                $failed++;
            }
        }
        
        error_log("[MODEL] updateDepartments() completed. Inserted: $inserted, Failed: $failed");
    }

    public function addTtn($order_id, $data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "novaposhta_ttn SET 
            ref = '" . $this->db->escape($data['ref']) . "',
            order_id = '" . (int)$order_id . "',
            ttn = '" . $this->db->escape($data['ttn']) . "',
            city_ref = '" . $this->db->escape($data['city_ref']) . "',
            city_name = '" . $this->db->escape($data['city_name']) . "',
            warehouse_ref = '" . $this->db->escape($data['warehouse_ref']) . "',
            warehouse_name = '" . $this->db->escape($data['warehouse_name']) . "',
            service_type = '" . $this->db->escape($data['service_type']) . "',
            payer_type = '" . $this->db->escape($data['payer_type']) . "',
            payment_method = '" . $this->db->escape($data['payment_method']) . "',
            cargo_type = '" . $this->db->escape($data['cargo_type']) . "',
            volume_general = '" . $this->db->escape($data['volume_general']) . "',
            weight = '" . $this->db->escape($data['weight']) . "',
            cost = '" . (float)$data['cost'] . "',
            seats_amount = '" . (int)$data['seats_amount'] . "',
            description = '" . $this->db->escape($data['description']) . "',
            recipient_name = '" . $this->db->escape($data['recipient_name']) . "',
            recipient_phone = '" . $this->db->escape($data['recipient_phone']) . "',
            date_added = NOW()");
        
        return $this->db->getLastId();
    }

    public function getTtn($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "novaposhta_ttn WHERE order_id = '" . (int)$order_id . "'");
        
        return $query->row;
    }
    
    public function getTtns($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "novaposhta_ttn WHERE order_id = '" . (int)$order_id . "' ORDER BY date_added DESC");
        
        return $query->rows;
    }

    public function updateTtn($ttn_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "novaposhta_ttn SET 
            ttn = '" . $this->db->escape($data['ttn']) . "',
            city_ref = '" . $this->db->escape($data['city_ref']) . "',
            city_name = '" . $this->db->escape($data['city_name']) . "',
            warehouse_ref = '" . $this->db->escape($data['warehouse_ref']) . "',
            warehouse_name = '" . $this->db->escape($data['warehouse_name']) . "',
            service_type = '" . $this->db->escape($data['service_type']) . "',
            payer_type = '" . $this->db->escape($data['payer_type']) . "',
            payment_method = '" . $this->db->escape($data['payment_method']) . "',
            cargo_type = '" . $this->db->escape($data['cargo_type']) . "',
            volume_general = '" . $this->db->escape($data['volume_general']) . "',
            weight = '" . $this->db->escape($data['weight']) . "',
            cost = '" . (float)$data['cost'] . "',
            seats_amount = '" . (int)$data['seats_amount'] . "',
            description = '" . $this->db->escape($data['description']) . "',
            recipient_name = '" . $this->db->escape($data['recipient_name']) . "',
            recipient_phone = '" . $this->db->escape($data['recipient_phone']) . "',
            date_modified = NOW() 
            WHERE ttn_id = '" . (int)$ttn_id . "'");
    }

    public function deleteTtn($ttn_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "novaposhta_ttn WHERE ttn_id = '" . (int)$ttn_id . "'");
    }

    public function install() {
        // Создание таблицы для ТТН
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "novaposhta_ttn` (
            `ttn_id` INT(11) NOT NULL AUTO_INCREMENT,
            `order_id` INT(11) NOT NULL,
            `ref` VARCHAR(255) NOT NULL,
            `ttn` VARCHAR(255) NOT NULL,
            `city_ref` VARCHAR(255) NOT NULL,
            `city_name` VARCHAR(255) NOT NULL,
            `warehouse_ref` VARCHAR(255) NOT NULL,
            `warehouse_name` VARCHAR(255) NOT NULL,
            `service_type` VARCHAR(50) DEFAULT 'WarehouseWarehouse',
            `payer_type` VARCHAR(50) DEFAULT 'Recipient',
            `payment_method` VARCHAR(50) DEFAULT 'Cash',
            `cargo_type` VARCHAR(50) DEFAULT 'Cargo',
            `volume_general` VARCHAR(20) DEFAULT '0.01',
            `weight` VARCHAR(20) DEFAULT '1',
            `cost` DECIMAL(15,2) DEFAULT '0.00',
            `seats_amount` INT(5) DEFAULT '1',
            `description` TEXT,
            `recipient_name` VARCHAR(255),
            `recipient_phone` VARCHAR(50),
            `date_added` DATETIME NOT NULL,
            `date_modified` DATETIME DEFAULT NULL,
            PRIMARY KEY (`ttn_id`),
            KEY `order_id` (`order_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "novaposhta_ttn`");
    }

        /**
     * Получить список городов из базы данных
     */
    public function getCitiesList() {
        $query = $this->db->query("SELECT Ref as ref, DescriptionRu as description_ru, Description as description 
                                   FROM " . DB_PREFIX . "novaposhta_cities 
                                   ORDER BY DescriptionRu ASC");
        
        return $query->rows;
    }

    /**
     * Поиск городов по названию
     */
    public function searchCities($search, $limit = 20) {
        $search = $this->db->escape($search);
        
        // Сначала ищем крупные города (областные центры)
        $sql = "SELECT 
                    c.Ref as ref, 
                    c.DescriptionRu as description_ru, 
                    c.Description as description,
                    c.SettlementType,
                    c.AreaDescription,
                    c.AreaDescriptionRu,
                    CASE 
                        WHEN c.DescriptionRu = '" . $search . "' THEN 1
                        WHEN c.Description = '" . $search . "' THEN 2
                        WHEN c.DescriptionRu LIKE '" . $search . "%' THEN 3
                        WHEN c.Description LIKE '" . $search . "%' THEN 4
                        WHEN c.DescriptionRu LIKE '%" . $search . "%' THEN 5
                        WHEN c.Description LIKE '%" . $search . "%' THEN 6
                        ELSE 7
                    END as sort_order
                FROM " . DB_PREFIX . "novaposhta_cities c
                WHERE c.DescriptionRu LIKE '%" . $search . "%' 
                OR c.Description LIKE '%" . $search . "%'
                ORDER BY sort_order ASC, 
                        c.SettlementType ASC,  -- Города раньше сел
                        c.DescriptionRu ASC 
                LIMIT " . (int)$limit;
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }

 

    /**
     * Получить город по Ref
     */
    public function getCityByRef($city_ref) {
        $query = $this->db->query("SELECT Ref as ref, DescriptionRu as description_ru, Description as description 
                                   FROM " . DB_PREFIX . "novaposhta_cities 
                                   WHERE Ref = '" . $this->db->escape($city_ref) . "' 
                                   LIMIT 1");
        
        return $query->row;
    }

    /**
     * Получить отделение по Ref
     */
    public function getWarehousesByCityRef($city_ref, $limit = 50) {
        $query = $this->db->query("SELECT Ref as ref, DescriptionRu as description_ru, Description as description, Number 
                                FROM " . DB_PREFIX . "novaposhta_departments 
                                WHERE CityRef = '" . $this->db->escape($city_ref) . "' 
                                ORDER BY CAST(Number AS UNSIGNED) ASC, Number ASC 
                                LIMIT " . (int)$limit);
        
        return $query->rows;
    }

    public function searchWarehouses($city_ref, $search) {
        $search = trim($search);
        $search_escaped = $this->db->escape($search);
        
        // Разбиваем поисковый запрос на слова
        $words = explode(' ', $search);
        $conditions = array();
        
        foreach ($words as $word) {
            $word = $this->db->escape($word);
            $conditions[] = "(Number LIKE '%" . $word . "%' 
                            OR DescriptionRu LIKE '%" . $word . "%' 
                            OR Description LIKE '%" . $word . "%'
                            OR ShortAddressRu LIKE '%" . $word . "%'
                            OR ShortAddress LIKE '%" . $word . "%')";
        }
        
        $where = implode(' AND ', $conditions);
        
        $sql = "SELECT 
                    Ref as ref, 
                    DescriptionRu as description_ru, 
                    Description as description,
                    Number,
                    ShortAddressRu,
                    ShortAddress,
                    CASE 
                        WHEN Number = '" . $search_escaped . "' THEN 1
                        WHEN Number LIKE '" . $search_escaped . "%' THEN 2
                        WHEN DescriptionRu LIKE '%" . $search_escaped . "%' THEN 3
                        WHEN Description LIKE '%" . $search_escaped . "%' THEN 4
                        WHEN ShortAddressRu LIKE '%" . $search_escaped . "%' THEN 5
                        WHEN ShortAddress LIKE '%" . $search_escaped . "%' THEN 6
                        ELSE 7
                    END as sort_order
                FROM " . DB_PREFIX . "novaposhta_departments 
                WHERE CityRef = '" . $this->db->escape($city_ref) . "' 
                AND (" . $where . ")
                ORDER BY sort_order ASC, CAST(Number AS UNSIGNED) ASC 
                LIMIT 20";
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }

    public function getRefTtn($ttn_id){
        $query = $this->db->query("SELECT ref FROM " . DB_PREFIX . "novaposhta_ttn WHERE ttn_id = '" . (int)$ttn_id . "'");
        return $query->row;
    }

    public function getWarehouseByRef($ref){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "novaposhta_departments WHERE Ref = '" . $this->db->escape($ref) . "'");
        return $query->row;
    }

    // public function getCityByRef($ref){
    //     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "novaposhta_cities WHERE Ref = '" . $this->db->escape($ref) . "'");
    //     return $query->row;
    // }

    /**
     * Довідник статусів Нової Пошти (код => назва)
     */
    public function getNovaposhtaStatuses() {
        return array(
            1   => 'Відправник самостійно створив цю накладну, але ще не надав до відправки',
            2   => 'Видалено',
            3   => 'Номер не знайдено',
            4   => 'Відправлення у місті ХХXХ (статус для міжобласних відправлень)',
            41  => 'Відправлення у місті ХХXХ (статус для послуг «Локал стандарт» і «Локал експрес» - доставка в межах міста)',
            5   => 'Відправлення прямує до міста YYYY',
            6   => 'Відправлення у місті YYYY, орієнтовна доставка до ВІДДІЛЕННЯ-XXX dd-mm. Очікуйте додаткове повідомлення про прибуття',
            7   => 'Прибув на відділення',
            8   => 'Прибув на відділення (завантажено в Поштомат)',
            9   => 'Відправлення отримано',
            10  => 'Відправлення отримано %DateReceived%. Протягом доби ви одержите SMS-повідомлення про надходження грошового переказу та зможете отримати його в касі відділення «Нова пошта»',
            11  => 'Відправлення отримано %DateReceived%. Грошовий переказ видано одержувачу',
            12  => 'Нова пошта комплектує ваше відправлення',
            15  => 'Відправлення вже в дорозі до України',
            101 => 'На шляху до одержувача',
            102 => 'Відмова від отримання (відправником створено замовлення на повернення)',
            103 => 'Відмова від отримання',
            104 => 'Змінено адресу',
            105 => 'Припинено зберігання',
            106 => 'Одержано і створено ЕН зворотної доставки',
            107 => 'Відправлення переміщено з пункту видачі замовлень (PUDO) до основного відділення, яке його обслуговує',
            111 => 'Невдала спроба доставки через відсутність одержувача на адресі або зв\'язку з ним',
            112 => 'Дата доставки перенесена одержувачем',
            124 => 'Знищено внаслідок ворожої атаки'
        );
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

        // за указаными статусами и за последние 50 дней
        $query = $this->db->query("
            SELECT nttn.ttn AS ttn, o.order_status_id AS order_status_id, nttn.order_id AS order_id
            FROM `" . DB_PREFIX . "novaposhta_ttn` nttn
            LEFT JOIN `" . DB_PREFIX . "order` o ON (nttn.order_id = o.order_id)
            WHERE o.order_status_id IN (" . implode(',', $statuses) . ")
            AND nttn.ttn != ''
            AND o.shipping_code IN ('novaposhta.department', 'novaposhta.parcelbox' , 'novaposhta.courier', 'filterit0.filterit0')
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