<?php
/**
 * Local Nova Poshta cities / warehouses search for the Simple checkout autocomplete
 */
class ControllerExtensionModuleShippingdata extends Controller {
	public function getShippingData() {
		$this->load->model('extension/module/shippingdata');
		$this->language->load('extension/module/shippingdata');

		$action = isset($this->request->get['action']) ? (string)$this->request->get['action'] : '';
		$region_suffix = $this->language->get('text_region_suffix');

		$results = array();

		if ($action == 'cities') {
			$search  = isset($this->request->get['q']) ? (string)$this->request->get['q'] : '';
			$zone_id = isset($this->request->get['zone_id']) ? (int)$this->request->get['zone_id'] : 0;

			foreach ($this->model_extension_module_shippingdata->getCities($search, $zone_id) as $city) {
				$results[] = array(
					'id'     => $city['Ref'],
					'text'   => $this->model_extension_module_shippingdata->getCityLabel($city),
					'hint'   => $this->model_extension_module_shippingdata->getCityHint($city, $region_suffix),
					'area'   => $city['AreaDescription'],
					'type'   => $city['SettlementTypeDescription']
				);
			}
		} elseif ($action == 'warehouses') {
			$city_ref = isset($this->request->get['city_ref']) ? (string)$this->request->get['city_ref'] : '';
			$type     = isset($this->request->get['type']) ? (string)$this->request->get['type'] : 'branch';
			$search   = isset($this->request->get['q']) ? (string)$this->request->get['q'] : '';

			$type = ($type == 'postomat') ? 'postomat' : 'branch';

			foreach ($this->model_extension_module_shippingdata->getWarehouses($city_ref, $type, $search) as $warehouse) {
				$results[] = array(
					'id'       => $warehouse['Ref'],
					'text'     => $warehouse['Description'],
					'number'   => $warehouse['Number'],
					'category' => $warehouse['CategoryOfWarehouse'],
					'address'  => $warehouse['ShortAddress']
				);
			}
		} elseif ($action == 'resolve') {
			$name    = isset($this->request->get['city']) ? (string)$this->request->get['city'] : '';
			$zone_id = isset($this->request->get['zone_id']) ? (int)$this->request->get['zone_id'] : 0;

			foreach ($this->model_extension_module_shippingdata->getCityByName($name, $zone_id) as $city) {
				$results[] = array(
					'id'   => $city['Ref'],
					'text' => $this->model_extension_module_shippingdata->getCityLabel($city),
					'hint' => $this->model_extension_module_shippingdata->getCityHint($city, $region_suffix),
					'area' => $city['AreaDescription'],
					'type' => $city['SettlementTypeDescription']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json; charset=utf-8');
		$this->response->setOutput(json_encode(array('results' => $results), JSON_UNESCAPED_UNICODE));
	}
}
