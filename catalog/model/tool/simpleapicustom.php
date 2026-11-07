<?php
/*
@author Dmitriy Kubarev
@link   http://www.simpleopencart.com
*/

class ModelToolSimpleApiCustom extends Model {
    public function example($filterFieldValue) {
        $values = array();

        $values[] = array(
            'id'   => 'my_id',
            'text' => 'my_text'
        );

        return $values;
    }

    public function checkCaptcha($value, $filter) {
        if (isset($this->session->data['captcha']) && $this->session->data['captcha'] != $value) {
            return false;
        }

        return true;
    }

    public function getYesNo($filter = '') {
        return array(
            array(
                'id'   => '1',
                'text' => $this->language->get('text_yes')
            ),
            array(
                'id'   => '0',
                'text' => $this->language->get('text_no')
            )
        );
    }


    public function MygetShippingCities($ab) {

        require_once(DIR_SYSTEM . 'novaPoshta/NovaPoshtaApi2.php');
        require_once(DIR_SYSTEM . 'novaPoshta/NovaPoshtaApi2Areas.php');

         $values = array(
             array(
                'id'   => $AreaRef,
                'text' => $this->language->get('text_select')
                )
        );

        $np = new \LisDev\Delivery\NovaPoshtaApi2('6676d1d486cca2b1db759d79d42d1252',   'ru', FALSE, 'curl');       
$areaRef = 'dcaadf02-4b33-11e4-ab6d-005056801329';
   echo "<script>console.log('$ab')</script>";     
        $query = $np->getAllCities2($ab);
        $all_cities = $query['data'];

        
        //$results = $areas['data'];

        //$this->load->model('extension/module/shippingdata');

        //$zone_info = $this->model_extension_module_shippingdata->getZone($zone_id);

       
          
        //require_once(DIR_SYSTEM . 'helper/novaposhta.php');

        // $novaposhta = new NovaPoshta($this->registry);

        // if ($zone_info) {
        //     $filter = $novaposhta->getAreaRef($zone_info['name']);
        // } else {
        //     $filter = '';
        // }

       // $results = '';//$this->model_extension_module_shippingdata->getNovaPoshtaCities($filter);

        // if (!$all_cities) {
        //     $values[] = array(
        //         'id'   => 0,
        //         'text' => 'нет'//$this->language->get('text_none')
        //     );
        // } else {
            foreach ($all_cities as $result) {
                $values[] = array(
                    'id'   => trim($result['Ref']),
                    'text' => trim($result['Description'])
                );
            }
        //}
                        
        return $values;
    }


}