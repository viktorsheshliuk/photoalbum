<?php
require_once(DIR_SYSTEM . 'novaPoshta/NovaPoshtaApi2.php');
require_once(DIR_SYSTEM . 'novaPoshta/NovaPoshtaApi2Areas.php');

class ControllerExtensionModuleNovaPoshta extends Controller {
		
	public function search() {
		$np = new \LisDev\Delivery\NovaPoshtaApi2('47db93c355e486f7ea3a3f79494d7a06',	'ru', FALSE, 'curl');		
		$cities = $np->getAllCities(999, $this->request->post['search']);
		$json = $cities['data'][0]['Addresses'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
 
	public function warehouses() {
		$np = new \LisDev\Delivery\NovaPoshtaApi2('47db93c355e486f7ea3a3f79494d7a06',	'ru', FALSE, 'curl');
		if (!isset($this->request->post['ref'])){
			$this->request->post['ref'] ='';
		}
		$ware = $np->getWarehouses($this->request->post['ref']);
		$json = $ware['data'];
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>
