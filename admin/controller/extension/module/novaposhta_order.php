<?php
class ControllerExtensionModuleNovaposhtaOrder extends Controller {
    public function index() {
        $data = array();
        
        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
            
            $this->load->model('sale/order');
            $this->load->model('extension/shipping/novaposhta');
            
            $order_info = $this->model_sale_order->getOrder($order_id);
            $data['order_id'] = $order_id;

            // получаем название и ref отделения и города
            if (isset($order_info['novaposhta_cn_ref'])){
                $data['novaposhta_cn_ref'] = $order_info['novaposhta_cn_ref'];
                $warehouse = $this->model_extension_shipping_novaposhta->getWarehouseByRef($order_info['novaposhta_cn_ref']);
                
                if($warehouse){
                    $data['warehouse_name'] = $warehouse['Description'];
                    $data['city_ref'] = $warehouse['CityRef'];
                    $city = $this->model_extension_shipping_novaposhta->getCityByRef($warehouse['CityRef']);
                    if ($city){
                        $data['city_name'] = $city['description'];
                    }
                }

            } else {
                $data['novaposhta_cn_ref'] = '';
            }
            
            // Данные получателя из заказа
            $data['customer_name'] = trim($order_info['lastname']) . ' ' . trim($order_info['firstname']);
            $data['customer_phone'] = $order_info['telephone'];
            
            // Существующие ТТН
            $data['ttns'] = $this->model_extension_shipping_novaposhta->getTtns($order_id);
            
            // Города и отделения из базы данных
            $data['cities'] = $this->model_extension_shipping_novaposhta->getCitiesList();
            
            $data['user_token'] = $this->session->data['user_token'];

            if (isset($this->request->get['cost'])) {
                $data['cost'] = (float)$this->request->get['cost'];
            } else{
                $data['cost'] = (float)$order_info['total'];
            }

            if (isset($this->request->get['seats_amount'])) {
				$data['seats_amount'] =  $this->request->get['seats_amount'];
			} else {
                $data['seats_amount'] = 1;
            } 
            
            $code_nal = $this->config->get('shipping_novaposhta_payment_nalogka_code');
            $payment_code_nalogka = isset($code_nal) ? $code_nal : null;

            if (isset($this->request->get['cash_on_delivery'])) {
				$data['secash_on_delivery'] =  $this->request->get['cash_on_delivery'];
			} else {
                if ($order_info['payment_code'] == $payment_code_nalogka) { // если метод оплаты = наложка
                    $data['cash_on_delivery'] = (float)$order_info['total'];
                } else {    
                    $data['cash_on_delivery'] = '';
                }    
            }

            // if (isset($this->request->get['warehouse_search'])) {
			// 	$data['warehouse_search'] =  $this->request->get['warehouse_search'];
			// } else {
            //     $data['warehouse_search'] = 1;
            // }

            return $this->load->view('extension/module/novaposhta_order', $data);
        }
    }
    
    public function getWarehouses() {
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
    
    public function searchCities() {
        $json = array();
        
        if (isset($this->request->get['search'])) {
            $this->load->model('extension/shipping/novaposhta');
            
            $cities = $this->model_extension_shipping_novaposhta->searchCities($this->request->get['search']);
            
            foreach ($cities as $city) {
                $name = !empty($city['description_ru']) ? $city['description_ru'] : $city['description'];
                
                // Добавляем область для уточнения
                if (!empty($city['AreaDescriptionRu'])) {
                    $name .= ' (' . $city['AreaDescriptionRu'] . ')';
                } elseif (!empty($city['AreaDescription'])) {
                    $name .= ' (' . $city['AreaDescription'] . ')';
                }
                
                $json[] = array(
                    'name' => $name,
                    'ref' => $city['ref']
                );
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json, JSON_UNESCAPED_UNICODE));
    }
    
    public function createTtn() {
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/shipping/novaposhta');
            
            $order_id = $this->request->post['order_id'];
            
            try {
                // Подключаем autoload
                require_once dirname(DIR_SYSTEM) . '/vendor/autoload.php';
                
                $api_key = $this->config->get('shipping_novaposhta_api_key');
                
                if (empty($api_key)) {
                    throw new Exception('API ключ Новой Почты не настроен');
                }
                
                // Создаем SDK
                $sdk = new \AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK($api_key);
                
                // Получаем данные отправителя из настроек
                $sender_city_ref = $this->config->get('shipping_novaposhta_sender_city_ref');
                $sender_warehouse_ref = $this->config->get('shipping_novaposhta_sender_warehouse_ref');
                $sender_phone = $this->config->get('shipping_novaposhta_sender_phone');
                
                // Используем Ref отправителя из настроек или захардкоженный
                $sender_counterparty_ref = $this->config->get('shipping_novaposhta_sender_counterparty_ref');
                if (empty($sender_counterparty_ref)) {
                    $sender_counterparty_ref = '7100d21a-1d7e-11ef-bcd0-48df37b921da';
                }
                
                // Форматируем телефоны
                $sender_phone_clean = preg_replace('/[^0-9]/', '', $sender_phone);
                $recipient_phone_clean = preg_replace('/[^0-9]/', '', $this->request->post['recipient_phone']);
                
                // Получаем контактное лицо отправителя
                $sender_contact_ref = null;
                
                // Пробуем получить контактные лица отправителя
                try {
                    $sender_contacts = $sdk->counterparty()->getCounterpartyContactPersons(
                        $sender_counterparty_ref,
                        'Sender'
                    );
                    
                    // ПРАВИЛЬНЫЙ ФОРМАТ: [0]['Ref']
                    if (isset($sender_contacts[0]['Ref'])) {
                        $sender_contact_ref = $sender_contacts[0]['Ref'];
                    }
                } catch (Exception $e) {
                    // Игнорируем
                }
                
                // Если контакт не найден, используем известный Ref
                if (empty($sender_contact_ref)) {
                    $sender_contact_ref = '65c1ccac-1d96-11ef-bcd0-48df37b921da';
                }
                
                // Шаг 2: Создаем получателя
                $recipient_name = trim($this->request->post['recipient_name']);
                $recipient_name = preg_replace('/\s+/', ' ', $recipient_name);
                
                if (empty($recipient_name)) {
                    throw new Exception('Имя получателя не указано');
                }
                
                $name_parts = explode(' ', $recipient_name);
                
                if (count($name_parts) >= 2) {
                    $last_name = $name_parts[0];
                    $first_name = $name_parts[1];
                    $middle_name = isset($name_parts[2]) ? $name_parts[2] : '';
                }
                
                $recipient_result = $sdk->counterparty()->save(
                    'PrivatePerson',
                    $first_name,
                    $last_name,
                    $middle_name,
                    $recipient_phone_clean
                );
                
                $recipient_counterparty_ref = null;
                $recipient_contact_ref = null;
                
                // Проверяем разные форматы ответа
                if (isset($recipient_result[0]['Ref'])) {
                    $recipient_counterparty_ref = $recipient_result[0]['Ref'];
                    
                    if (isset($recipient_result[0]['ContactPerson']['data'][0]['Ref'])) {
                        $recipient_contact_ref = $recipient_result[0]['ContactPerson']['data'][0]['Ref'];
                    }
                } elseif (isset($recipient_result['data'][0]['Ref'])) {
                    $recipient_counterparty_ref = $recipient_result['data'][0]['Ref'];
                    
                    if (isset($recipient_result['data'][0]['ContactPerson']['data'][0]['Ref'])) {
                        $recipient_contact_ref = $recipient_result['data'][0]['ContactPerson']['data'][0]['Ref'];
                    }
                }
                
                if (empty($recipient_counterparty_ref) || empty($recipient_contact_ref)) {
                    throw new Exception('Не удалось создать получателя');
                }
                
                // Шаг 3: Создаем ТТН
                date_default_timezone_set('Europe/Kiev');
                $date_time = date('d.m.Y', time() + 3600);

                // Получаем данные заказа
                //$this->load->model('sale/order');
                //$order_info = $this->model_sale_order->getOrder($order_id);

                if (isset($this->request->post['cost']) && $this->request->post['cost'] !== '') {
                    // Если стоимость указана вручную
                    $cost = (float)$this->request->post['cost'];
                } //elseif ($order_info && isset($order_info['total'])) {
                    // Автоматически используем сумму заказа
                    //$cost = (float)$order_info['total'];
                //}

                $cashOnDelivery = isset($this->request->post['cash_on_delivery']) ? (float)$this->request->post['cash_on_delivery'] : 0;

                if (isset($this->request->post['volume']) && $this->request->post['volume'] !== '') {
                    $volumeGeneral = number_format($this->request->post['volume'] / 250, 3, '.', '');
                } else {
                    $volumeGeneral = '0.008';
                }
                
                $ttn_data = [
                    'Sender' => $sender_counterparty_ref,
                    'CitySender' => $sender_city_ref,
                    'SenderAddress' => $sender_warehouse_ref,
                    'ContactSender' => $sender_contact_ref,
                    'SendersPhone' => $sender_phone_clean,
                    
                    'Recipient' => $recipient_counterparty_ref,
                    'CityRecipient' => $this->request->post['city_ref'],
                    'RecipientAddress' => $this->request->post['warehouse_ref'],
                    'ContactRecipient' => $recipient_contact_ref,
                    'RecipientsPhone' => $recipient_phone_clean,
                    
                    'CargoType' => 'Cargo',
                    'Weight' => $this->request->post['weight'],
                    'SeatsAmount' => $this->request->post['seats_amount'],
                    'Cost' => $cost,
                    'Description' => $this->request->post['description'],
                    
                    'ServiceType' => $this->request->post['service_type'],
                    'PayerType' => $this->request->post['payer_type'],
                    'PaymentMethod' => $this->request->post['payment_method'],

                    //'VolumeGeneral' => $volumeGeneral, //'0.008',
                    'OptionsSeat' =>    [
                        [
                            'volumetricVolume' => $volumeGeneral, 
                            'volumetricWidth' => $this->request->post['width'] ?? '20',
                            'volumetricHeight' => $this->request->post['height'] ?? '20',
                            'volumetricLength' => $this->request->post['length'] ?? '20',
                            'weight' => $this->request->post['weight'],
                        ]
                    ],
                    'DateTime' => $date_time
                ];

                // Если сумма наложенного платежа больше нуля — добавляем блок обратной доставки
                if ($cashOnDelivery > 0) {
                    $ttn_data['AfterpaymentOnGoodsCost'] = (string)$cashOnDelivery;
                }
                
                $response = $sdk->document()->save($ttn_data);
                
                $ttn_number = '';
                $success = false;
                $ref = '';
                
                // Проверяем разные форматы ответа
                // if (isset($ttn_result['data'][0]['IntDocNumber'])) {
                //     $success = true;
                //     $ttn_number = $ttn_result['data'][0]['IntDocNumber'];
                // } elseif (isset($ttn_result['data'][0]['Ref'])) {
                //     $success = true;
                //     $ttn_number = $ttn_result['data'][0]['Ref'];
                // } elseif (isset($ttn_result[0]['IntDocNumber'])) {
                //     $success = true;
                //     $ttn_number = $ttn_result[0]['IntDocNumber'];
                // } elseif (isset($ttn_result[0]['Ref'])) {
                //     $success = true;
                //     $ttn_number = $ttn_result[0]['Ref'];
                // }
                
                if (isset($response[0]['IntDocNumber'])) {
                    $success = true;
                    $ref =  $response[0]['Ref'];
                    $ttn_number = $response[0]['IntDocNumber'];
                } 
                
                if ($success && $ttn_number) {
                    // Сохраняем ТТН в базу
                    $data = array(
                        'ref' => $ref,
                        'ttn' => $ttn_number,
                        'city_ref' => $this->request->post['city_ref'],
                        'city_name' => $this->request->post['city_name'],
                        'warehouse_ref' => $this->request->post['warehouse_ref'],
                        'warehouse_name' => $this->request->post['warehouse_name'],
                        'service_type' => $this->request->post['service_type'],
                        'payer_type' => $this->request->post['payer_type'],
                        'payment_method' => $this->request->post['payment_method'],
                        'cargo_type' => $this->request->post['cargo_type'],
                        'volume_general' => '0.01',
                        'weight' => $this->request->post['weight'],
                        'cost' => $cost,
                        'seats_amount' => $this->request->post['seats_amount'],
                        'description' => $this->request->post['description'],
                        'recipient_name' => $recipient_name,
                        'recipient_phone' => $this->request->post['recipient_phone']
                    );
                    
                    $ttn_id = $this->model_extension_shipping_novaposhta->addTtn($order_id, $data);
                    
                    $json['success'] = 'ТТН успешно создана: ' . $ttn_number;
                    $json['ttn'] = $ttn_number;
                    
                    // Добавляем в историю заказа
                    //$this->load->model('sale/order');
                    //$order_info = $this->model_sale_order->getOrder($order_id);
                    //$this->model_sale_order->addOrderHistory($order_id, $order_info['order_status_id'], 'Создана ТТН Новой Почты: ' . $ttn_number, true);
                } else {
                    $json['error'] = 'Ошибка создания ТТН';
                    if (isset($response['errors'])) {
                        $json['error'] .= ': ' . implode(', ', $response['errors']);
                    }
                    $json['debug'] = array(
                        'sender_ref' => $sender_counterparty_ref,
                        'sender_contact_ref' => $sender_contact_ref,
                        'recipient_ref' => $recipient_counterparty_ref,
                        'recipient_contact_ref' => $recipient_contact_ref,
                        'date_time' => $date_time,
                        'response' => $response
                    );
                }
                
            } catch (Exception $e) {
                $json['error'] = 'Ошибка: ' . $e->getMessage();
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json, JSON_UNESCAPED_UNICODE));
    }
    
    public function saveManualTtn() {
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/shipping/novaposhta');
            
            $order_id = $this->request->post['order_id'];
            
            $data = array(
                'ttn' => $this->request->post['ttn'],
                'city_ref' => $this->request->post['city_ref'],
                'city_name' => $this->request->post['city_name'],
                'warehouse_ref' => $this->request->post['warehouse_ref'],
                'warehouse_name' => $this->request->post['warehouse_name'],
                'service_type' => $this->request->post['service_type'],
                'payer_type' => $this->request->post['payer_type'],
                'payment_method' => $this->request->post['payment_method'],
                'cargo_type' => $this->request->post['cargo_type'],
                'volume_general' => '0.01',
                'weight' => $this->request->post['weight'],
                'cost' => $this->request->post['cost'],
                'seats_amount' => $this->request->post['seats_amount'],
                'description' => $this->request->post['description'],
                'recipient_name' => $this->request->post['recipient_name'],
                'recipient_phone' => $this->request->post['recipient_phone']
            );
            
            $ttn_id = $this->model_extension_shipping_novaposhta->addTtn($order_id, $data);
            
            $json['success'] = 'ТТН сохранена';
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    
    public function deleteTtn() {
        $json = array();
        
        if (isset($this->request->post['ttn_id'])) {
            $this->load->model('extension/shipping/novaposhta');
            
            
            $ttn =  $this->model_extension_shipping_novaposhta->getRefTtn($this->request->post['ttn_id']);
            
            $ref ='';

            if (isset($ttn['ref'])){
                $ref = $ttn['ref'];
                // Удаляем ТТН в системе Новой почты
                try {
                    // Подключаем autoload
                    require_once dirname(DIR_SYSTEM) . '/vendor/autoload.php';
                
                    $api_key = $this->config->get('shipping_novaposhta_api_key');
                
                    if (empty($api_key)) {
                        throw new Exception('API ключ Новой Почты не настроен');
                    }
                
                    // Создаем SDK
                    $sdk = new \AUnhurian\NovaPoshta\SDK\NovaPoshtaSDK($api_key);
                    $response = $sdk->document()->delete($ref);
                    //var_dump($response);
                    if (isset($response[0]['Ref'])){
                        $json['success'] = 'ТТН удалена';
                    }

                } catch (Exception $e) {
                    $json['error'] = 'Ошибка: ' . $e->getMessage();
                }
            }

            //Удаляем у себя в базе
            $this->model_extension_shipping_novaposhta->deleteTtn($this->request->post['ttn_id']);
            
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function searchWarehouses() {
        $json = array();
        
        if (isset($this->request->get['city_ref']) && isset($this->request->get['search'])) {
            $this->load->model('extension/shipping/novaposhta');
            
            $warehouses = $this->model_extension_shipping_novaposhta->searchWarehouses(
                $this->request->get['city_ref'],
                $this->request->get['search']
            );
            
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
}