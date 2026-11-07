<?php
if (!defined('_JEXEC')) {
  register_shutdown_function('gkd_fatal_handler');
  set_error_handler('var_dump', 0);
}

function gkd_fatal_handler() {
  $error = error_get_last();
  
  if (!empty($error['type']) && $error['type'] == '1') {
    ob_end_clean();
    if ($error !== NULL) {
      echo 'Error: ' . $error['message'] . ' in ' . $error['file'] . ' on line '  . $error['line'];
    } else {
      echo 'Unknown fatal error';
    }
    
    if (!empty($_SESSION['seopackage_lastItem'])) {
      echo "\n".'Last item id: '.$_SESSION['seopackage_lastItem'];
    }
  }
}

class ControllerModuleCompleteSeo extends Controller {
  const MODULE = 'complete_seo';
  const PREFIX = 'mlseo';
  const MOD_FILE = 'seo_package';
  const LINK = 'module/complete_seo';
  const OCID = 9486;
  
  private $error = array();
  private $OC_VERSION;
  private $OC_V2;
  private $OC_V21X;
  private $OC_V22X;
  private $OC_V23X;
  private $EXT_23X = '';
  private $OC_V151;
  private $ml_mode = false;
  private $multistore_mode = false;
  private $start;
  private $token;
  private $url_alias;
  private $front_url;
  private $total_items;
  private $store;
  private $limit = 500;
  private $edit_action = 'edit';
  
  public function __construct($registry) {
    ini_set('memory_limit', -1);
      $this->OC_VERSION = (int) str_replace('.', '', substr(VERSION, 0, 5));
      $this->OC_V2 = version_compare(VERSION, '2', '>=');
      $this->OC_V151 = (substr(VERSION, 0, 5) == '1.5.1');
      $this->OC_V21X = version_compare(VERSION, '2.1', '>=');
      $this->OC_V22X = version_compare(VERSION, '2.2', '>=');
      $this->OC_V23X = version_compare(VERSION, '2.3', '>=');
      
      if ($this->OC_V23X) {
        $this->EXT_23X = 'extension/';
      }
      
      if (!version_compare(VERSION, '2', '>=')) {
        $this->edit_action = 'update';
      }
      
    parent::__construct($registry);
    
      if (!defined('SEO_PACKAGE_CLI')) {
        $this->token = isset($this->session->data['user_token']) ? 'user_token='.$this->session->data['user_token'] : 'token='.$this->session->data['token'];
      }
      
      if (version_compare(VERSION, '3', '>=')) {
        $this->load->language('extension/module/complete_seo');
        $this->url_alias = 'seo_url';
      } else {
        $this->load->language('module/complete_seo');
        $this->url_alias = 'url_alias';
      }
    
    if ($this->config->get('mlseo_ml_mode')) {
      $this->ml_mode = true;
    }
    
    if ($this->config->get('mlseo_multistore')) {
      $this->multistore_mode = true;
    }
    
    // front url handler
    $this->front_url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
    
    if ($this->config->get('config_seo_url')) {
      if ($this->OC_V22X) {
        $seourl_file = DIR_SYSTEM.'../catalog/controller/startup/seo_url.php';
      } else {
        $seourl_file = DIR_SYSTEM.'../catalog/controller/common/seo_url.php';
      }
      
      if (isset($vqmod)) {
        require_once($vqmod->modCheck($seourl_file));
      } else if (class_exists('VQMod') && function_exists('modification')) {
        require_once(VQMod::modCheck(modification($seourl_file), $seourl_file));
      } else if (function_exists('modification')) {
        require_once(modification($seourl_file));
      } else if (class_exists('VQMod')) {
        require_once(VQMod::modCheck($seourl_file));
      } else {
        require_once($seourl_file);
      }
      
      if ($this->OC_V22X) {
        $rewriter = new ControllerStartupSeoUrl($this->registry);
      } else {
        $rewriter = new ControllerCommonSeoUrl($this->registry);
      }
      
      $this->front_url->addRewrite($rewriter);
    }
  }

  public function index() {
    /*
    $this->load->model('user/user_group');

    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'module/' . self::MODULE);
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'module/' . self::MODULE);
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'extension/module/' . self::MODULE);
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'extension/module/' . self::MODULE);
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'feed/advanced_sitemap');
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'module/advanced_sitemap');
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'extension/module/advanced_sitemap');
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'extension/module/advanced_sitemap');
    */
    if (!empty($this->request->get['clear_cli_logs']) && file_exists(DIR_LOGS.'seo_package_cli.log')) {
      unlink(DIR_LOGS.'seo_package_cli.log');
      
      if (version_compare(VERSION, '2', '>=')) {
        $this->response->redirect($this->url->link('module/complete_seo', $this->token, 'SSL'));
      } else {
        $this->redirect($this->url->link('module/complete_seo', $this->token, 'SSL'));
      }
    }
    
    $data['token'] = $this->token;
    $data['_language'] = &$this->language;
    $data['_config'] = &$this->config;
    $data['_url'] = &$this->url;
    $data['OC_VERSION'] = $this->OC_VERSION;
    $data['OC_V2'] = version_compare(VERSION, '2', '>=');
    $data['OC_V151'] = $this->OC_V151;
    $data['OCID'] = self::OCID;
    $data['module'] = self::MODULE;
    
    $asset_path = 'view/seo_package/';
    
    $this->document->addStyle($asset_path . 'prettyCheckable.css');
		$this->document->addScript($asset_path . 'prettyCheckable.js');
    $this->document->addScript($asset_path . 'itoggle.js');
    $this->document->addScript($asset_path . 'jquery-editable.min.js');
    $this->document->addScript($asset_path . 'select2.min.js');
    $this->document->addScript($asset_path . 'toggler.js');
    $this->document->addScript($asset_path . 'jquery.dataTables.min.js');
    $this->document->addStyle($asset_path . 'jquery.dataTables.min.css');
    $this->document->addStyle($asset_path . 'select2.min.css');
    //$this->document->addScript($asset_path . 'gkd-script.js');
    
    $data['style_radial_meter'] = file_get_contents($asset_path . 'radial-meter.css');
    
    if (version_compare(VERSION, '2', '<')) {
      $this->document->addScript($asset_path . 'jquery-migrate.js');
      $this->document->addStyle($asset_path . 'awesome/css/font-awesome.min.css');
      $data['style_scoped'] = file_get_contents($asset_path . 'bootstrap.min.css');
			$data['style_scoped'] .= str_replace('img/', $asset_path . 'img/', file_get_contents($asset_path . 'jquery-editable.css'));
			$data['style_scoped'] .= str_replace('img/', $asset_path . 'img/', file_get_contents($asset_path . 'gkd-theme.css'));
			$data['style_scoped'] .= str_replace('img/', $asset_path . 'img/', file_get_contents($asset_path . 'style.css'));
			$this->document->addScript($asset_path . 'bootstrap.min.js');
    } else {
      $this->document->addStyle($asset_path . 'jquery-editable.css');
      $this->document->addStyle($asset_path . 'gkd-theme.css');
      $this->document->addStyle($asset_path . 'style.css');
    }
    
    $this->document->setTitle(strip_tags($this->language->get('heading_title')));
    $this->load->model('setting/setting');
    
    // get languages 
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    $current_lang_codes = array();
    
    foreach ($languages as $k => $language) {
      if ($this->OC_V22X) {
        $languages[$k]['image'] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $languages[$k]['image'] = 'view/image/flags/'. $language['image'];
      }
      
      if ($language['status']) {
        $current_lang_codes[$language['language_id']] = $language['code'];
      }
    }
    
    $data['languages'] = $languages;
    
    /*
    $langCodeToId = $langIdToCode = array();
    
    foreach ($languages as $lang) {
      $langCodeToId[$lang['code']] = $lang['language_id'];
      $langIdToCode[$lang['language_id']] = $lang['code'];
    }
    */
    
    if (!empty($this->request->get['tab'])) {
      $this->session->data['currentTab'] = $this->request->get['tab'];
    }
    
    $data['currentTab'] = 'tab-dashboard';
    
    if (!empty($this->session->data['currentTab'])) {
      $data['currentTab'] = $this->session->data['currentTab'];
    }
    
    // Store SEO tab
    $this->load->model('setting/store');
    
    $data['stores'] = array();
    $data['stores'][] = array(
      'store_id' => 0,
      'name'     => $this->config->get('config_name')
    );

    $stores = $this->model_setting_store->getStores();

    foreach ($stores as $store) {
      $action = array();

      $data['stores'][] = array(
        'store_id' => $store['store_id'],
        'name'     => $store['name']
      );
    }
    
    $data['store_id'] = $store_id = 0;
    
    // Overwrite store settings
		if (isset($this->request->get['store_id']) && $this->request->get['store_id']) {
			$data['store_id'] = $store_id = (int) $this->request->get['store_id'];
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '".$store_id."'");
			
			foreach ($query->rows as $setting) {
				if (!$setting['serialized']) {
					$this->config->set($setting['key'], $setting['value']);
        } else if ($this->OC_V21X) {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
				} else {
					$this->config->set($setting['key'], unserialize($setting['value']));
				}
			}
		}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    
    $redirect_store = '';
    
    if ($store_id) {
      $redirect_store = '&store_id=' . $store_id;
    }
    
    // delete extension/module folder on OC 1.5
    if (version_compare(VERSION, '2', '<') && is_dir(DIR_APPLICATION.'controller/extension/module')) {
      //@rename(DIR_APPLICATION.'controller/extension/module', DIR_APPLICATION.'controller/extension/.seo_package');
      if (version_compare(VERSION, '2', '<') && is_dir(DIR_APPLICATION.'controller/extension/module')) {
        $this->session->data['error'] = 'OC v1.5 - Please delete the folder ' . DIR_APPLICATION.'controller/extension/module';
      }
    }
    
    // prepare store binding for use with store rewriting
    $lang_to_store = array();
    
    foreach ($data['stores'] as $store) {
      $store_info = $this->model_setting_setting->getSetting('config', $store['store_id']);
      
      if (!empty($store_info['config_language'])) {
        $lang_to_store[$store_info['config_language']] = array(
          'config_url' => !empty($store_info['config_url']) ? rtrim($store_info['config_url'], '/') : rtrim(HTTP_CATALOG, '/'),
          'config_ssl' => !empty($store_info['config_ssl']) ? rtrim($store_info['config_ssl'], '/') : rtrim(HTTPS_CATALOG, '/'),
        );
      }
    }
    
    $data['lang_to_store'] = $lang_to_store;
    
    $data['journal_active'] = is_dir(DIR_APPLICATION . 'model/journal2') || is_dir(DIR_APPLICATION . 'model/journal3');
    $data['journal2_active'] = is_dir(DIR_APPLICATION . 'model/journal2');
    $data['journal3_active'] = is_dir(DIR_APPLICATION . 'model/journal3');
    
    // module installation check
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      $data['info'] = 'Demonstration mode is read only, no change will be saved.';
    }
    
    if (strpos(strtolower($_SERVER["SERVER_SOFTWARE"]), 'apache') !== false && !is_file(DIR_CATALOG.'../.htaccess')) {
      $this->session->data['error'] = 'htaccess file not found : Please rename <b>.htaccess.txt</b> to <b>.htaccess</b> in order to enable url rewriting';
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    
    if (is_file(DIR_CATALOG.'../vqmod/xml/multilingual_seo.xml')) {
      $this->session->data['error'] = 'Old version of the module detected, please remove this file :<b>/vqmod/xml/multilingual_seo.xml</b>';
    }

    if (!function_exists('mb_strtolower')) {
      $this->error['warning'] = 'The php extension mb_string is not installed, the module can work without it but you may experience some incorrect values when generating seo values, it is recommended to enable this extension in php.ini';
    }
    
    /* not necessary anymore
    if ($this->config->get('mlseo_flag') || (isset($this->request->post['mlseo_flag']) && $this->request->post['mlseo_flag'])) {
      $htaccess = file_get_contents(DIR_CATALOG.'../.htaccess');
      if (strpos($htaccess, 'index.php?_route_=$2&site_language=$1') === false) {
        if (is_writable(DIR_CATALOG.'../.htaccess')) {
          $htaccess = str_replace('RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]', '#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]'."\n".'RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]', $htaccess);
          file_put_contents(DIR_CATALOG.'../.htaccess', $htaccess);
        } else {
          $this->session->data['error'] = 'htaccess file not writable : Please do the following procedure in order to use language prefix mode: <br/>- Open <b>.htaccess.txt</b><br/>- Find the line : <b>RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]</b> <br/>- add a "#" before this provious line, like this : <b>#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]</b><br/>- And add this code just below the previous line : <b>RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]</b>';
        }
      }
    }
    */
    
    if (!$this->OC_V22X) {
      $index = file_get_contents(DIR_CATALOG.'../index.php');
        if (strpos($index, 'new multilingual_seo') === false) {
        $this->session->data['error'] = 'Install not complete : multilingual_seo class declaration not found in index.php, maybe the file was not writeable, manual procedure : <br/>- open index.php<br />- find the text (without outter quotes): $languages = array();<br/>- add just below the previous line this text: $multilingual = new multilingual_seo($registry); $multilingual->detect();';
      }
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    
    // restore default htaccess
    if ($this->config->get('mlseo_flag') || (isset($this->request->post['mlseo_flag']) && $this->request->post['mlseo_flag'])) {
      $htaccess = @file_get_contents(DIR_CATALOG.'../.htaccess');
      if (strpos($htaccess, 'index.php?_route_=$2&site_language=$1') !== false) {
        if (is_writable(DIR_CATALOG.'../.htaccess')) {
          $htaccess = str_replace('#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]', 'RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]', $htaccess);
          $htaccess = str_replace('RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]', '', $htaccess);
          file_put_contents(DIR_CATALOG.'../.htaccess', $htaccess);
        } else {
          $this->session->data['error'] = 'Upgrade from old version, please edit your htaccess file like this :<br/>Remove the entire line: <b>RewriteRule ^(?:(?:(\\w{2})(?:/|\\z))?(?:/|\\z)?)?(?:([^?]*))? index.php?_route_=$2&site_language=$1 [L,QSA]</b><br/>Remove the # before the line: <b>#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]</b>';
        }
      }
    }
    
    // handle form submit
    if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
      // define multilingual handler
      $this->request->post['mlseo_ml_mode'] = (count($languages) > 1);
      $this->request->post['mlseo_lang_codes'] = $current_lang_codes;
      
      // save store bindings
      $this->request->post['mlseo_lang_to_store'] = $lang_to_store;
      
      unset($this->request->post['langs'], $this->request->post['simulate'], $this->request->post['empty_only'], $this->request->post['redirect_mode']);
      /*<complete*/
      /* now included in main xml
      // full product path 
      if (isset($this->request->post['full_product_path']) && is_file(DIR_CATALOG.'../vqmod/xml/full_product_path.xml.disabled')) {
        if (!rename(DIR_CATALOG.'../vqmod/xml/full_product_path.xml.disabled', DIR_CATALOG.'../vqmod/xml/full_product_path.xml'))
          $this->session->data['error'] = 'Error: /vqmod/xml/ is not writeable.';
      }
      elseif (!isset($this->request->post['full_product_path']) && is_file(DIR_CATALOG.'../vqmod/xml/full_product_path.xml')) {
        if (!rename(DIR_CATALOG.'../vqmod/xml/full_product_path.xml', DIR_CATALOG.'../vqmod/xml/full_product_path.xml.disabled'))
          $this->session->data['error'] = 'Error: /vqmod/xml/ is not writeable.';
      }
      */
      
      // urls management
      foreach($data['languages'] as $lang)
      {
        if (isset($this->request->post['mlseo_urls_'.$lang['code']]))
        $this->request->post['mlseo_urls_'.$lang['code']] =  array_combine($this->request->post['mlseo_urls_'.$lang['code']]['keys'], $this->request->post['mlseo_urls_'.$lang['code']]['values']);
      }
      
      /*complete>*/
      // $this->request->post['mlseo_default_lang'] = (!empty($this->request->post['mlseo_flag_short'])) ? substr($this->config->get('config_language'), 0, 2) : $this->config->get('config_language'); // do not use short code here !
      //$this->request->post['mlseo_default_lang'] = $this->config->get('config_language');
      $this->model_setting_setting->editSetting('mlseo', $this->request->post, $store_id);    
      $this->session->data['success'] = $this->language->get('text_success');
      
      if (version_compare(VERSION, '2', '>=')) {
        $this->response->redirect($this->url->link('module/complete_seo', $this->token . $redirect_store, 'SSL'));
      } else {
        $this->redirect($this->url->link('module/complete_seo', $this->token . $redirect_store, 'SSL'));
      }
    }
    
    // check tables
    if (version_compare(VERSION, '2.3', '>=') && !$this->config->has('mlseo_default_lang')) {
      $this->install('redir');
    } else {
      $this->db_tables();
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    
    // module checks
    if (!extension_loaded('mbstring')) {
      $this->session->data['error'] = 'Warning : PHP extension <b>mbstring</b> not loaded, make sure to enable this extension in order to use correctly the module.';
    }
    
    if (!$store_id) { // do not check in store mode
      if (file_exists(DIR_APPLICATION . 'controller/feed/seopackage_sitemap.php')) {
        @rename(DIR_APPLICATION . 'controller/feed/seopackage_sitemap.php', DIR_APPLICATION . 'controller/feed/seopackage_sitemap.php_disabled');
      }
      
      if ($current_lang_codes !== $this->config->get('mlseo_lang_codes')) {
        $this->session->data['error'] = 'It seems you have modified your languages configuration, please save module options to activate multilingual handling';
      }
      
      if (false && $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'language_id'")->row) {
        $has_incorrect_assign = $this->db->query("SELECT ".$this->url_alias."_id FROM " . DB_PREFIX . $this->url_alias . " WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'information_id=%' OR query LIKE 'route=%') AND language_id=0 LIMIT 1")->row;
        if (!empty($has_incorrect_assign[$this->url_alias.'_id'])) {
          $this->session->data['error'] = 'There is some urls which have incorrect language assignation, please go in Mass Update and do a "Clean up"';
        }
      }
      
      if ($this->config->get('config_seo_url_type') == 'seo_pro') {
        $this->session->data['error'] = 'On ocStore you must select Default SEO Url engine in System > Settings > Server in order to Complete SEO to work';
      }
      
      if (!$this->config->get('mlseo_ml_mode') && (count($languages) > 1)) {
        $this->session->data['error'] = 'It seems you have installed another language, please save module options to activate multilingual handling';
      }
      
      if ($this->config->get('mlseo_redirect_canonical') && !$this->config->get('mlseo_fpp_bypasscat')) {
        $this->session->data['error'] = 'You have enabled redirect to canonical, you should enable the option Path manager > "Rewrite product path in categories" in order to have the product urls to be always the canonical ones, else it will generate a redirection on each product clicked in categories';
      }
      
      if ($this->config->get('mlseo_absolute') && ($this->config->get('mlseo_fpp_directcat') || !$this->config->get('mlseo_fpp_cat_canonical'))) {
        $this->session->data['error'] = 'You have enabled <b>Absolute category path</b>, in this configuration it is necessary to set <b>Category path mode</b> and <b>Category canonical</b> to <b>Full path</b> else it will not be possible to find the corresponding category.<br/>It is also recommended to have <b>Product path mode</b> to <b>Largest path.</b>';
      }
      
      if (!$this->config->get('mlseo_enabled')) {
        $this->session->data['error'] = $this->language->get('error_module_disabled');
      }
    }
    //$data['products'] = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE language_id=" . $this->config->get('config_language_id') . " ORDER BY name")->rows;
    
    $this->load->model('setting/friendlyurls');
    $data['friendly_urls_langs'] = $this->model_setting_friendlyurls->getAvailableLangs();
    
    // version check
    foreach (array(self::MOD_FILE, 'a_'.self::MOD_FILE, 'z_'.self::MOD_FILE) as $mod_file) {
      if (is_file(DIR_SYSTEM.'../vqmod/xml/'.$mod_file.'.xml')) {
        $data['module_version'] = @simplexml_load_file(DIR_SYSTEM.'../vqmod/xml/'.$mod_file.'.xml')->version;
        $data['module_type'] = 'vqmod';
        break;
      } else if (is_file(DIR_SYSTEM.'../system/'.$mod_file.'.ocmod.xml')) {
        $data['module_version'] = @simplexml_load_file(DIR_SYSTEM.'../system/'.$mod_file.'.ocmod.xml')->version;
        $data['module_type'] = 'ocmod';
        break;
      } else {
        $data['module_version'] = 'not found';
        $data['module_type'] = '';
 		  }
		}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    
    $modification_active = false;
    
    if (!$modification_active) {
      if ($data['module_type'] == 'ocmod') {
        $this->session->data['error'] = 'Module modification are not applied<br/>You have installed <b>ocmod</b> version, go to extensions > <a href="'.$this->url->link('extension/modification', $this->token).'">modifications</a> and push refresh button';
      } else if ($data['module_type'] == 'vqmod') {
        $this->session->data['error'] = 'Module modification are not applied<br/>You have installed <b>vqmod</b> version, make sure vqmod is correctly installed and working.
        <br/><br/>If vqmod is correctly installed, please try the following:
        <br/>- delete all files into <b>/vqmod/vqcache/</b> folder
        <br/>- delete the files <b>checked.cache</b> and <b>mods.cache</b> in <b>/vqmod/</b> folder
        <br/>- reload this page
        <br/><br/>If you have opencart v2.x and don\'t know what is vqmod or ocmod, then install ocmod version instead';
      } else {
        $this->session->data['error'] = 'Module modification are not applied<br/>No modification file have been found, there should be the file either in /system/'.self::MOD_FILE.'.ocmod.xml for ocmod version, or in /vqmod/xml/'.self::MOD_FILE.'.xml for vqmod version, please upload the file from module package if it is not yet.';
      }
    }
    
    if (is_file(DIR_SYSTEM.'../vqmod/xml/'.self::MOD_FILE.'.xml') && is_file(DIR_SYSTEM.'../system/'.self::MOD_FILE.'.ocmod.xml')) {
      $this->error['warning'] = 'Warning : both vqmod and ocmod version are installed<br/>- delete /vqmod/xml/'.self::MOD_FILE.'.xml if you want to use ocmod version<br/>- or delete /system/'.self::MOD_FILE.'.ocmod.xml if you want to use vqmod version';
    }
    
    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    } else $data['success'] = '';
    
    if (isset($this->session->data['error'])) {
      $data['error'] = $this->session->data['error'];
      unset($this->session->data['error']);
    } elseif (!empty($this->error['error'])) {
      $data['error'] = $this->error['error'];
    } else {
      $data['error'] = '';
    }
    
    if (version_compare(VERSION, '2.1', '>=')) {
      $this->load->model('customer/customer_group');
      $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
    } else {
      $this->load->model('sale/customer_group');
      $data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
    }
    
    $this->load->model('localisation/stock_status');
		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
    
    $seo_score = array();
    $seo_score[] = $this->config->get('mlseo_enabled');
    
    $total_score = count($seo_score);
    
    $data['seo_score'] = round(count(array_filter($seo_score)) * 100 / $total_score);
    
    $data['heading_title'] = $this->language->get('module_title');
    
    $data['button_save'] = $this->language->get('button_save');
    $data['button_cancel'] = $this->language->get('button_cancel');
    $data['button_add_module'] = $this->language->get('button_add_module');
    $data['button_remove'] = $this->language->get('button_remove');
    
    
    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', $this->token, 'SSL'),
      'separator' => false
    );

    if (version_compare(VERSION, '3', '>=')) {
      $extension_link = $this->url->link('marketplace/extension', 'type=module&' . $this->token, 'SSL');
    } else if (version_compare(VERSION, '2.3', '>=')) {
      $extension_link = $this->url->link('extension/extension', 'type=module&' . $this->token, 'SSL');
    } else {
      $extension_link = $this->url->link('extension/module', $this->token, 'SSL');
    }
    
    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_module'),
      'href'      => $extension_link,
      'separator' => ' :: '
    );

    $data['breadcrumbs'][] = array(
      'text'      => strip_tags($this->language->get('heading_title')),
      'href'      => $this->url->link('module/complete_seo', $this->token, 'SSL'),
      'separator' => ' :: '
    );
    
    // is feed installed ?
    if (version_compare(VERSION, '3', '>=')) {
      $this->load->model('setting/extension');
      $installed_feeds = $this->model_setting_extension->getInstalled('feed');
    } else if (version_compare(VERSION, '2', '>=')) {
      $this->load->model('extension/extension');
      $installed_feeds = $this->model_extension_extension->getInstalled('feed');
    } else {
      $this->load->model('setting/extension');
      $installed_feeds = $this->model_setting_extension->getInstalled('feed');
    }
    
    if (in_array('advanced_sitemap', $installed_feeds)) {
      $data['link_sitemap'] = $this->url->link('feed/advanced_sitemap', $this->token, 'SSL');
    } else {
      if (version_compare(VERSION, '3', '>=')) {
        $data['link_sitemap'] = $this->url->link('marketplace/extension', 'type=feed&' . $this->token, 'SSL');
      } else if (version_compare(VERSION, '2.3', '>=')) {
        $data['link_sitemap'] = $this->url->link('extension/extension', 'type=feed&' . $this->token, 'SSL');
      } else {
        $data['link_sitemap'] = $this->url->link('feed/advanced_sitemap', $this->token, 'SSL');
      }
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    
    $data['action'] = $this->url->link('module/complete_seo', $this->token . $redirect_store, 'SSL');
    $data['upgrade_url'] = $this->url->link('module/complete_seo/upgrade', $this->token, 'SSL');
    
    $data['cancel'] = $extension_link;
    
    /*complete>*/

    /*<complete*/
    
    // CLI logs
    $data['cli_log'] = $data['cli_log_link'] = '';
    
    $file = DIR_LOGS.'seo_package_cli.log';
    
		if (file_exists($file)) {
      $data['cli_log_link'] = $this->url->link('module/complete_seo/save_cli_log', $this->token, 'SSL');
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$data['cli_log'] = sprintf($this->language->get('text_cli_log_too_big'), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['cli_log'] = file_get_contents($file);
			}
		}
    
    $prefix = 'mlseo_';
    
    $params_array = array(
      // main options
      'mlseo_enabled',
      'mlseo_url_absolute',
      'mlseo_friendly',
      'mlseo_multistore',
      'mlseo_backup',
      'mlseo_404',
      'mlseo_redirect',
      'mlseo_autolink',
      'mlseo_absolute',
      'mlseo_redirect_dynamic',
      'mlseo_redirect_http',
      'mlseo_redirect_canonical',
      'mlseo_cat_slash',
      'mlseo_redir_reviews',
      'mlseo_cache',
      'mlseo_banners',
      'mlseo_special_group',
      'mlseo_format_tag',
      'mlseo_fix_search',
      'mlseo_fix_cart',
      'mlseo_editor',
      'mlseo_shortcut',
      'mlseo_headings',
      
      // 404 manager
      'mlseo_404_log',
      'mlseo_404_filter',
      'mlseo_404_filter_ext',
      'mlseo_404_redir',
      
      // language prefix
      'mlseo_flag_mode',
      'mlseo_store_mode',
      'mlseo_flag',
      'mlseo_flag_detect',
      'mlseo_flag_short',
      'mlseo_flag_upper',
      'mlseo_flag_default',
      'mlseo_flag_custom',
      
      // sort & pagination
      'mlseo_tag',
      'mlseo_sort',
      'mlseo_search',
      'mlseo_pagination',
      'mlseo_pagination_fix',
      'mlseo_pagination_canonical',
      'mlseo_disable_other_store_links',
      
      // reviews
      'mlseo_reviews',
      
      // canonical
      'mlseo_canonical',
      
      // hreflang
      'mlseo_hreflang',
      
      // meta robots
      'mlseo_robots',
      'mlseo_meta_robots',
      
      // store seo
      'mlseo_store',
      'mlseo_title_prefix',
      'mlseo_title_suffix',
      
      // store seo
      'mlseo_header_lm_product',
      'mlseo_header_lm_category',
      'mlseo_header_lm_information',
      'mlseo_header_lm_manufacturer',
      
      // Keyword options
      'mlseo_whitespace',
      'mlseo_extension',
      'mlseo_extension_mode',
      'mlseo_safe_url',
      'mlseo_lowercase',
      'mlseo_duplicate',
      
      // auto-update
      'mlseo_insertautotitle',
      'mlseo_editautotitle',
      'mlseo_insertautourl',
      'mlseo_editautourl',
      'mlseo_insertautoseotitle',
      'mlseo_editautoseotitle',
      'mlseo_insertautometakeyword',
      'mlseo_editautometakeyword',
      'mlseo_insertautometadesc',
      'mlseo_editautometadesc',
      'mlseo_insertautodesc',
      'mlseo_editautodesc',
      'mlseo_insertautoh1',
      'mlseo_editautoh1',
      'mlseo_insertautoh2',
      'mlseo_editautoh2',
      'mlseo_insertautoh3',
      'mlseo_editautoh3',
      'mlseo_insertautoimgtitle',
      'mlseo_editautoimgtitle',
      'mlseo_insertautoimgalt',
      'mlseo_editautoimgalt',
      'mlseo_insertautoimgname',
      'mlseo_editautoimgname',
      'mlseo_insertautotags',
      'mlseo_editautotags',
      'mlseo_insertautorelated',
      'mlseo_editautorelated',
      
      // mass update
      'mlseo_product_url_pattern',
      'mlseo_product_title_pattern',
      'mlseo_product_h1_pattern',
      'mlseo_product_h2_pattern',
      'mlseo_product_h3_pattern',
      'mlseo_product_keyword_pattern',
      'mlseo_product_description_pattern',
      'mlseo_product_full_desc_pattern',
      'mlseo_product_image_name_pattern',
      'mlseo_product_image_alt_pattern',
      'mlseo_product_image_title_pattern',
      'mlseo_product_tag_pattern',
      'mlseo_product_related_no',
      'mlseo_product_related_relevance',
      'mlseo_product_related_samecat',
      'mlseo_category_url_pattern',
      'mlseo_category_h1_pattern',
      'mlseo_category_h2_pattern',
      'mlseo_category_h3_pattern',
      'mlseo_category_title_pattern',
      'mlseo_category_keyword_pattern',
      'mlseo_category_description_pattern',
      'mlseo_category_full_desc_pattern',
      'mlseo_information_url_pattern',
      'mlseo_information_h1_pattern',
      'mlseo_information_h2_pattern',
      'mlseo_information_h3_pattern',
      'mlseo_information_title_pattern',
      'mlseo_information_keyword_pattern',
      'mlseo_information_description_pattern',
      'mlseo_information_full_desc_pattern',
      'mlseo_manufacturer_url_pattern',
      'mlseo_manufacturer_h1_pattern',
      'mlseo_manufacturer_h2_pattern',
      'mlseo_manufacturer_h3_pattern',
      'mlseo_manufacturer_title_pattern',
      'mlseo_manufacturer_keyword_pattern',
      'mlseo_manufacturer_description_pattern',
      'mlseo_manufacturer_full_desc_pattern',
      
      // rich snippets
      'mlseo_microdata',
      'mlseo_microdata_data',
      'mlseo_opengraph',
      'mlseo_opengraph_data',
      'mlseo_fb_pixel',
      'mlseo_tcard',
      'mlseo_tcard_data',
      'mlseo_gpublisher',
      'mlseo_gpublisher_data',
      
      // cron
      'mlseo_cron',
      'mlseo_cron_log',
    );
    
    // ML params
    // foreach ($languages as $language) {}
    
    // $data['full_product_path'] = (is_file(DIR_CATALOG.'../vqmod/xml/full_product_path.xml'));
      
    // full product path - start
    $pm_prefix = 'mlseo_fpp_';
    
    $params_array[] = $pm_prefix . 'mode';
    $params_array[] = $pm_prefix . 'depth';
    $params_array[] = $pm_prefix . 'breadcrumbs';
    $params_array[] = $pm_prefix . 'noprodbreadcrumb';
    $params_array[] = $pm_prefix . 'cat_canonical';
    $params_array[] = $pm_prefix . 'bc_mode';
    $params_array[] = $pm_prefix . 'bypasscat';
    $params_array[] = $pm_prefix . 'directcat';
    $params_array[] = $pm_prefix . 'homelink';
    $params_array[] = $pm_prefix . 'brand_parent';
    $params_array[] = $pm_prefix . 'remove_search';
    $params_array[] = $pm_prefix . 'remove_tag';
    $params_array[] = $pm_prefix . 'categories';
    $params_array[] = $pm_prefix . 'slash';
    
    // ML params
    foreach ($languages as $language) {
      $params_array[] = $prefix . 'remove_' . $language['language_id'];
      $params_array[] = $prefix . 'replace_' . $language['language_id'];
      $params_array[] = $prefix . 'pagination_' . $language['language_id'];
      $params_array[] = $prefix . 'sort_' . $language['language_id'];
      $params_array[] = $prefix . 'limit_' . $language['language_id'];
      $params_array[] = $prefix . 'order_' . $language['language_id'];
      $params_array[] = $prefix . 'sortname_' . $language['language_id'];
      $params_array[] = $prefix . 'pagination_name_' . $language['language_id'];
      $params_array[] = $pm_prefix . 'tag_' . $language['language_id'];
      $params_array[] = $pm_prefix . 'search_' . $language['language_id'];
    }
    
    // categories management
    $this->load->model('catalog/category');
    $data['categories'] = $this->model_catalog_category->getCategories(0);
    
    usort($data['categories'], array($this, 'sortByName'));
    
    // full product path - end
    
    /*complete>*/
    
    foreach ($params_array as $param_name) {
      if (isset($this->request->post[$param_name])) {
        $data[$param_name] = $this->request->post[$param_name];
      } else {
        $data[$param_name] = is_null($this->config->get($param_name)) ? '' : $this->config->get($param_name);
      }
    }
    
    if (version_compare(VERSION, '2', '>=')) {
      $data['header'] = $this->load->controller('common/header');
      $data['column_left'] = $this->load->controller('common/column_left');
      $data['footer'] = $this->load->controller('common/footer');
      
      if (version_compare(VERSION, '3', '>=')) {
        $this->config->set('template_engine', 'template');
        // use echo instead of setOutput() if there is blank page on some opencart versions
        // echo $this->load->view('module/complete_seo', $data);
        $this->response->setOutput($this->load->view('module/complete_seo', $data));
      } else {
        $this->response->setOutput($this->load->view('module/complete_seo.tpl', $data));
      }
    } else {
      $data['column_left'] = '';
      $this->data = &$data;
      $this->template = 'module/complete_seo.tpl';
      $this->children = array(
        'common/header',
        'common/footer'
      );

      // fix OC 1.5
      $this->response->setOutput(str_replace(array('view/javascript/jquery/jquery-1.6.1.min.js', 'view/javascript/jquery/jquery-1.7.1.min.js', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'), $asset_path . 'jquery.min.js', $this->render()));
    }
  }
  
  public function save_cli_log() {
    $file = DIR_LOGS.'seo_package_cli.log';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=seo_package_cron.log');
    header('Content-Type: text/plain');
    header('Cache-Control: must-revalidate');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
  }
  
  public function generator_related_product($mode, $simulate, $empty_only, $redirect) {
    $this->load->model('tool/seo_package');
    
    $values = $data = array();
    $data['langs'][0]['lang_img'] = '';
      
    if (isset($this->request->post['mlseo_product_related_samecat'])) {
      $same_cat = $this->request->post['mlseo_product_related_samecat'];
    } else if ($this->config->get('mlseo_product_related_samecat')) {
      $same_cat = $this->config->get('mlseo_product_related_samecat');
    } else {
      $same_cat = false;
    }
    
    $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE language_id=".$this->config->get('config_language_id')." ORDER BY pd.product_id,pd.language_id")->row;
    $this->total_items = $total['total'];
      
    if ($same_cat) {
      $rows = $this->db->query("SELECT pd.*, p.*, (SELECT cp.category_id FROM " . DB_PREFIX . "product_to_category pc LEFT JOIN " . DB_PREFIX . "category_path cp on cp.category_id = pc.category_id WHERE pc.product_id = pd.product_id ORDER BY cp.level DESC LIMIT 1) as category_id FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE language_id=" . $this->config->get('config_language_id') . " ORDER BY pd.product_id,pd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
    } else {
      $rows = $this->db->query("SELECT pd.*, p.* FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id WHERE language_id=" . $this->config->get('config_language_id') . " GROUP BY pd.product_id ORDER BY pd.product_id,pd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
      //$rows = $this->db->query("SELECT pd.*, p.*, pc.category_id FROM " . DB_PREFIX . "product_description pd LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pd.product_id LEFT JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id WHERE language_id=" . $this->config->get('config_language_id') . " GROUP BY pd.product_id ORDER BY pd.product_id,pd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
    }
    
    foreach ($rows as $row) {
      $this->session->data['seopackage_processed']++;
      
      if (empty($row['product_id'])) continue;
      
      //$rel_count = $this->db->query("SELECT COUNT(*) AS count FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $row['product_id'] . "'")->row;
      
      $related = $this->db->query("SELECT pr.related_id, pd.name FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = pr.related_id AND pd.language_id='" . (int) $this->config->get('config_language_id')."') WHERE pr.product_id='" . (int) $row['product_id'] . "'")->rows;
      
      $old_related = array();
      foreach ($related as $rel) {
        $old_related[] = '- ' . $rel['name'];
      }
      
      if ($empty_only) {
        if (count($related)) {
          continue;
        }
      } else {
        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $row['product_id'] . "'" );
        }
      }
      
      $prod_name = str_replace(array('%', '#', "'", '"'), '', $row['name']);
      $prod_tag = str_replace(array('%', '#', "'", '"'), '', $row['tag']);
      $prod_desc = str_replace(array('\n', '\r', '%', '#', "'", '"'), '', $row['description']);
      $prod_cat = '';
      
      if ($same_cat && !empty($row['category_id'])) {
        $prod_cat = " AND pc.category_id = '" .$row['category_id'] . "' ";
      }
      
      if (!empty($this->request->post['mlseo_product_related_relevance'])) {
        $relevance = $this->request->post['mlseo_product_related_relevance'];
      } else if ($this->config->get('mlseo_product_related_relevance')) {
        $relevance = $this->config->get('mlseo_product_related_relevance');
      } else {
        $relevance = 2;
      }
      
      if (!empty($this->request->post['mlseo_product_related_no'])) {
        $max_items = $this->request->post['mlseo_product_related_no'];
      } else if ($this->config->get('mlseo_product_related_no')) {
        $max_items = $this->config->get('mlseo_product_related_no');
      } else {
        $max_items = 5;
      }
      
      if (empty($row['category_id'])) {
        $row['category_id'] = 0;
      }
      
      if (true) { // related generator method
        $results = $this->db->query("SELECT DISTINCT p.product_id, pd.name,
          ROUND(MATCH (pd.name, pd.description) AGAINST ('" . $prod_name . " " . $prod_tag . " " . $prod_desc . "'), 0) / 5 as relevance
          FROM " . DB_PREFIX . "product_description pd
          LEFT JOIN " . DB_PREFIX . "product p on pd.product_id = p.product_id
          INNER JOIN " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
          WHERE p.product_id <> " . $row['product_id'] . $prod_cat . "
            AND p.status = 1 GROUP BY p.product_id
            HAVING relevance >= " . (int) $relevance . "
          ORDER BY relevance DESC
          LIMIT 0, " . (int) $max_items)->rows;
      } else { // method 2
        $results = $this->db->query("SELECT DISTINCT p.product_id, pd.name, 
          MAX(2 / (CASE p.price >= ". $this->db->escape($row['price']) ." WHEN 0 THEN (". $this->db->escape($row['price']) ." / p.price) ELSE (p.price / ". $this->db->escape($row['price']) .") END) * 
          (CASE category_id WHEN ". (int) $row['category_id'] ." THEN 2 ELSE 1 end) + (1 + rel.rlv))
          AS relevance FROM " . DB_PREFIX . "product p 
          INNER JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
          INNER JOIN " . DB_PREFIX . "product_to_category p2c ON p.product_id = p2c.product_id
          INNER JOIN (SELECT product_id, MATCH(name, description) AGAINST ('". strip_tags(trim($this->db->escape(htmlspecialchars_decode(str_replace(array('%', '_', '"', "'"), array('', ' ', ' ', ' '), $row['name']))))) . ' ' . strip_tags(trim($this->db->escape(htmlspecialchars_decode(str_replace(array('%', '_', '"', "'"), array('', ' ', ' ', ' '), $row['description']))))) ."') AS rlv FROM " . DB_PREFIX . "product_description) AS rel ON rel.product_id = p.product_id  
          GROUP BY p.product_id
          HAVING p.product_id <> ". (int) $row['product_id'] ." AND relevance >= ".(int) $relevance." AND p.product_id NOT IN (SELECT related_id FROM " . DB_PREFIX . "product_related WHERE product_id = ". (int) $row['product_id'] .")
          ORDER BY relevance DESC
          LIMIT 0, ". (int) $max_items)->rows;
      }
      
      $new_related = array();
      foreach ($results as $res) {
        if (!$simulate) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "product_related (product_id, related_id) VALUES (" . $row['product_id'] . ", " . $res['product_id'] . ")");
        }
        $new_item = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id=" . $res['product_id'] . " AND language_id=" . $this->config->get('config_language_id'))->row;
        $new_related[] = '- ' . $new_item['name'];
      }
      sort($old_related);
      sort($new_related);
      
      $changed = false;
      
      if (!empty($new_related) && $old_related != $new_related) {
        $changed = true;
        $this->session->data['seopackage_updated']++;
      }
      
      $values[] = array(
        'link' =>  $this->url->link('catalog/product/'.$this->edit_action, $this->token . '&product_id=' . $row['product_id'], 'SSL'),
        'name' =>  $row['name'],
        'old_value' =>  implode('<br/> ', $old_related),
        'value' =>  implode("<br/> ", $new_related),
        'changed' =>  $changed,
      );
      
      if (defined('SEO_PACKAGE_CLI')) {
        if ($changed) {
          $this->log('product.related: ' . $row['name'] . ' => ' . "\n\t\t" . implode("\n\t\t", $new_related));
        }
      }
    }
    
    $data['langs'][0]['rows'] = &$values;
    return $data;
  }
  
  public function generator_product($mode, $simulate, $empty_only, $redirect) {
    if ($mode == 'related') return $this->generator_related_product($mode, $simulate, $empty_only, $redirect);
    
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); die('No language selected');}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    $image_simulate = array();
    if ($mode == 'image_name' && count($this->request->post['langs']) > 1) {
      die($this->language->get('text_image_name_lang'));
      die('<div class="alert alert-warning"><i class="fa fa-warning"> ' . $this->language->get('text_image_name_lang') . '</i></div>');
    }
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
      case 'image_name': $field = 'image'; break;
      case 'image_title': $field = 'image_title'; break;
      case 'image_alt': $field = 'image_alt'; break;
      case 'tag': $field = 'tag'; break;
    }
      
    $values = $data = array();
    
    if ($mode == 'store_copy') {
      foreach($this->request->post['langs'] as $lang) {
        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "seo_product_description WHERE language_id = '".(int) $lang."' AND store_id = '".(int) $this->store."'");
          
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_product_description SELECT product_id, '".(int) $lang."', '".(int) $this->store."', name, description, meta_title, meta_description, meta_keyword, image_title, image_alt, seo_h1, seo_h2, seo_h3 FROM " . DB_PREFIX . "product_description d WHERE d.language_id = '".(int) $lang."'");
        }
        
        $data['langs'][$lang]['lang_img'] = $lang_img[$lang];
        $data['langs'][$lang]['rows'][] = array(
          'link' =>  '',
          'name' =>  'Product data copy to sub-store',
          'old_value' =>  '',
          'value' =>  'Done',
          'changed' =>  '',
        );
      }
      
      return $data;
    }
    
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_product_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_product_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_product_'.$mode.'_pattern');
      }
      
      //if ($this->store) {
      if ($this->multistore_mode) {
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store s ON (p.product_id = s.product_id) WHERE s.store_id = ".(int) $this->store)->row;
      } else {
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product p")->row;
      }
      
      $this->total_items = $total['total'];
      
      $special = '';
      if ($this->config->get('mlseo_special_group')) {
        $special = ", (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.customer_group_id = ".(int)$this->config->get('mlseo_special_group')." ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
      }
      
      $extra_select = '';
      
      if ($mode == 'url') {
       if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('product_id=', p.product_id) AND (u.language_id = d.language_id OR u.language_id = 0)  AND (u.store_id = ".(int) $this->store.") LIMIT 1), '') AS seo_keyword";
         //$extra_select .= ",IFNULL((SELECT meta_title FROM " . DB_PREFIX . "seo_product_description sd WHERE (sd.product_id = p.product_id) AND (sd.language_id = d.language_id)  AND (sd.store_id = ".(int) $this->store.") LIMIT 1), null) AS seo_table_exists";
       } else if ($this->multistore_mode) {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('product_id=', p.product_id) AND (u.store_id = ".(int) $this->store.") LIMIT 1), '') AS seo_keyword";
       } else if ($this->ml_mode) {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('product_id=', p.product_id) AND (u.language_id = d.language_id OR u.language_id = 0) LIMIT 1), '') AS seo_keyword";
       } else {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE query = CONCAT('product_id=', p.product_id) LIMIT 1), '') AS seo_keyword";
       }
      }

      if ($this->store) {
        $desc_table = 'seo_product_description';
        $extra_desc = "AND store_id = '" . (int)$this->store . "'";
        if (!empty($this->request->post['filter_category'])) {
          $rows = $this->db->query("SELECT sd.*, p.*, d.name as orig_name, d.description as orig_description ".$special.$extra_select." FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store s ON (p.product_id = s.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category c ON (p.product_id = c.product_id) LEFT JOIN " . DB_PREFIX . "seo_product_description sd ON (p.product_id = sd.product_id AND sd.language_id=".(int) $lang." AND sd.store_id = s.store_id) LEFT JOIN " . DB_PREFIX . "product_description d ON (p.product_id = d.product_id AND d.language_id = ".(int) $lang.") WHERE c.category_id = '".(int) $this->request->post['filter_category']."' AND s.store_id = ".(int) $this->store." ORDER BY d.product_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        } else {
          $rows = $this->db->query("SELECT sd.*, p.*, d.name as orig_name, d.description as orig_description ".$special.$extra_select." FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store s ON (p.product_id = s.product_id) LEFT JOIN " . DB_PREFIX . "seo_product_description sd ON (p.product_id = sd.product_id AND sd.language_id=".(int) $lang." AND sd.store_id = s.store_id) LEFT JOIN " . DB_PREFIX . "product_description d ON (p.product_id = d.product_id AND d.language_id = ".(int) $lang.") WHERE s.store_id = ".(int) $this->store." ORDER BY sd.product_id,sd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        }
      } else {
        $desc_table = 'product_description';
        $extra_desc = '';
        if (!empty($this->request->post['filter_category'])) {
          if ($this->multistore_mode) {
            $rows = $this->db->query("SELECT d.*, p.*".$special.$extra_select." FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description d ON p.product_id = d.product_id LEFT JOIN " . DB_PREFIX . "product_to_store s ON (p.product_id = s.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category c ON (p.product_id = c.product_id) WHERE c.category_id = '".(int) $this->request->post['filter_category']."' AND s.store_id = ".(int) $this->store." AND d.language_id=".(int) $lang." ORDER BY d.product_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
          } else {
            $rows = $this->db->query("SELECT d.*, p.*".$special.$extra_select." FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description d ON p.product_id = d.product_id LEFT JOIN " . DB_PREFIX . "product_to_category c ON (p.product_id = c.product_id) WHERE c.category_id = '".(int) $this->request->post['filter_category']."' AND d.language_id=".(int) $lang." ORDER BY d.product_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
          }
        } else {
          if ($this->multistore_mode) {
            $rows = $this->db->query("SELECT d.*, p.*".$special.$extra_select." FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description d ON p.product_id = d.product_id LEFT JOIN " . DB_PREFIX . "product_to_store s ON (p.product_id = s.product_id) WHERE s.store_id = ".(int) $this->store." AND d.language_id=".(int) $lang." ORDER BY d.product_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
          } else {
            $rows = $this->db->query("SELECT d.*, p.*".$special.$extra_select." FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description d ON p.product_id = d.product_id WHERE d.language_id=".(int) $lang." ORDER BY d.product_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
          }
        }
      }
      
      foreach ($rows as $row) {
        $this->session->data['seopackage_processed']++;
        
        $_SESSION['seopackage_lastItem'] = $row['product_id'];
        
        if (empty($row['name']) && isset($row['orig_name'])) {
          $row['name'] = $row['orig_name'];
        }
        
        if (empty($row['description']) && isset($row['orig_description'])) {
          $row['description'] = $row['orig_description'];
        }
        
        if (!array_key_exists($field, $row)) continue;
        
        $value = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformProduct($value, $lang, $row, $this->store);
        
        if ($mode != 'url' && $this->multistore_mode && $this->store && !$simulate && !array_key_exists('meta_title', $row)) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_product_description SET product_id = '" . (int)$row['product_id'] . "', store_id = '" . (int)$this->store . "', language_id = '" . (int)$lang . "'");
        }
        
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'product_id=" . $row['product_id'] . "' AND store_id = " . (int)$this->store . " AND language_id IN (".(int) $lang.", 0)");
            } else if ($this->multistore_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'product_id=" . $row['product_id'] . "' AND store_id = " . (int)$this->store);
            } else if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'product_id=" . $row['product_id'] . "' AND language_id IN (".(int) $lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'product_id=" . $row['product_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'product', $row['product_id'], $lang, $simulate);
          
          if (!$simulate) {
            if ($this->config->get('mlseo_backup')) {
              if ($row['seo_keyword'] && $row['seo_keyword'] != $value) {
                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($row['seo_keyword']) . "', redirect = 'product/product&product_id=" . (int) $row['product_id'] . "', language_id = '" . (int) $lang . "'");
              }
            }
            
            //$this->db->query("UPDATE " . DB_PREFIX . "product_description SET seo_keyword = '". $this->db->escape($value) ."' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'product_id=" . $row['product_id'] . "', language_id = '" . (int) $lang . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->multistore_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'product_id=" . $row['product_id'] . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'product_id=" . $row['product_id'] . "', language_id = '" . (int) $lang . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'product_id=" . $row['product_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          //$field = 'seo_keyword';
        }
        // Meta title
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h1 = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h2 = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h2';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h3 = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h3';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_title = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          if (function_exists('mb_strtolower')) {
            $value = mb_strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          } else {
            $value = strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          }
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_keyword = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_description = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && trim(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')))) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET description = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'description';
        }
        // image name
        if ($mode == 'image_name')
        {
          if (!$row['image']) continue;
          
          $img_count = $this->db->query("SELECT COUNT(image) as count FROM " . DB_PREFIX . "product WHERE image='" . $this->db->escape($row['image']) . "'")->row;
          if ($img_count['count'] > 1) continue;
          
          $path = pathinfo($row['image']);
          
          // skip if no extension
          if (empty($path['extension'])) {
            continue;
          }
          
          $filename = $this->model_tool_seo_package->filter_seo($value, 'image', '', $lang, false, true);
          $value = $path['dirname'] . '/' . $filename . '.' . $path['extension'];
          
          if ($row['image'] != $value) {
            $x = 1;
            
            if ($simulate) {
              while (file_exists(DIR_IMAGE . $value) || in_array(DIR_IMAGE . $value, $image_simulate)) {
                $value = $path['dirname'] . '/' . $filename . '-' . $x . '.' . $path['extension'];
                $x++;
              }
              $image_simulate[] = DIR_IMAGE . $value;
            } else {
              while (file_exists(DIR_IMAGE . $value)) {
                $value = $path['dirname'] . '/' . $filename . '-' . $x . '.' . $path['extension'];
                $x++;
              }
              if (@rename(DIR_IMAGE . $row['image'], DIR_IMAGE . $value)) {
                //$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '". $this->db->escape($value) ."' WHERE product_id = '" . $row['product_id'] . "'");

                // replace all images with such value
                $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '". $this->db->escape($value) ."' WHERE image = '" . $this->db->escape($row['image']) . "'");
                $this->db->query("UPDATE " . DB_PREFIX . "product_image SET image = '". $this->db->escape($value) ."' WHERE image = '" . $this->db->escape($row['image']) . "'");
              } else {
                continue;
              }
            }
          }
          // $field = 'image';
        }
         // Image title
        elseif ($mode == 'image_title')
        {
          if ($empty_only && $row['image_title']) continue;
          
          $value = str_replace(array('"', "'"), '', $value);
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET image_title = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'image_title';
        }
         // Image alt
        elseif ($mode == 'image_alt')
        {
          if ($empty_only && $row['image_alt']) continue;
          
          $value = str_replace(array('"', "'"), '', $value);
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET image_alt = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'image_alt';
        }
        // Tags
        elseif ($mode == 'tag')
        {
          if ($empty_only && $row['tag']) continue;
          
          if ($lang) {
            $remove = $this->config->get('mlseo_remove_'.$lang);
          } else {
            $remove = $this->config->get('mlseo_remove_'.$this->config->get('config_language_id'));
          }
          
          $value = str_replace('"', '', $value);
          
          if (!empty($remove)) {
            $beforeWord = "(\\s|\\.|\\,|\\!|\\?|\\(|\\)|\\'|\\\"|^)";
            $afterWord =  "(\\s|\\.|\\,|\\!|\\?|\\(|\\)|\\'|\\\"|$)";
            $removeArray = array();
            
            foreach (explode(',', $remove) as $rem) {
              $removeArray[] = '`'.$beforeWord.preg_quote(trim($rem), '`').$afterWord.'`';
            }
            
            if ($removeArray) {
              $value = preg_replace($removeArray, '$1$2', $value);
            }
          }
          
          if ($this->config->get('mlseo_format_tag')) {
            $value = str_replace('.', ',', $value);
            $value = str_replace(array('  ',' '), ', ', $value);
            
            if (function_exists('mb_strtolower')) {
              $value = trim(mb_strtolower($value), ', ');
            } else {
              $value = trim(strtolower($value), ', ');
            }
          }
          
          $value = trim(preg_replace('/(?:,\s*)+/', ',', $value), ', ');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . "product_description SET tag = '" . $this->db->escape($value) . "' WHERE product_id = '" . $row['product_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'tag';
        }
        
        if (!$simulate) {
          $this->db->query("UPDATE " . DB_PREFIX . "product SET date_modified = NOW() WHERE product_id = '".(int)$row['product_id']."'");
        }
        
        if (array_key_exists($field, $row)) {
          $changed = !($value === $row[$field]);
        } else {
          $changed = false;
        }
        
        if (!defined('SEO_PACKAGE_CLI')) {
          if ($row[$field] && $changed && $mode == 'url' && $this->config->get('mlseo_backup')) {
            $values[$lang]['rows'][] = array(
              'link' =>  $this->url->link('catalog/product/'.$this->edit_action, $this->token . '&product_id=' . $row['product_id'], 'SSL'),
              'name' =>  $row['name'],
              'old_value' =>  (string) $row[$field],
              'value' =>  '[backup url to redirect to new one]',
              'changed' =>  false,
            );
          }
          
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/product/'.$this->edit_action, $this->token . '&product_id=' . $row['product_id'], 'SSL'),
            'name' =>  $row['name'],
            'old_value' =>  (string) $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('product.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['name'] . ' => ' . $value);
          }
          
          $change_count++;
          $this->session->data['seopackage_updated']++;
          //Powercache::remove('seo_rewrite', 'product_id=' . $row['product_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    return $data;
  }
  
  public function getChildCategories($cat_id) {
    $parentsArray = array($cat_id);
    
    if ($cat_id) {
      $catQuery = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '".(int) $cat_id."'")->rows;
      
      if (!empty($catQuery)) {
        foreach ($catQuery as $cat) {
          $parentsArray[] = $cat['category_id'];
          $parentsArray = array_unique(array_merge($parentsArray, $this->getChildCategories($cat['category_id'])));
        }
      }
    }
    
    return $parentsArray;
  }
  
  public function generator_category($mode, $simulate, $empty_only, $redirect) {
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); return;}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
    }
    
    $values = $data = array();
    
    if ($mode == 'store_copy') {
      foreach($this->request->post['langs'] as $lang) {
        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "seo_category_description WHERE language_id = '".(int) $lang."' AND store_id = '".(int) $this->store."'");
          
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_category_description SELECT category_id, '".(int) $lang."', '".(int) $this->store."', name, description, meta_title, meta_description, meta_keyword, seo_h1, seo_h2, seo_h3 FROM " . DB_PREFIX . "category_description d WHERE d.language_id = '".(int) $lang."'");
        }
        
        $data['langs'][$lang]['lang_img'] = $lang_img[$lang];
        $data['langs'][$lang]['rows'][] = array(
          'link' =>  '',
          'name' =>  'Category data copy to sub-store',
          'old_value' =>  '',
          'value' =>  'Done',
          'changed' =>  '',
        );
      }
      
      return $data;
    }
    
    $filterCats = '';
    
    if (!empty($this->request->post['filter_cat_category'])) {
      $parentsArray = array();
      $cat_id = $this->request->post['filter_cat_category'];
      
      $parentsArray = $this->getChildCategories($cat_id);
      
      if (!empty($parentsArray)) {
        $filterCats = " AND c.category_id IN (".implode(',', $parentsArray).")";
      }
    }
    
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_category_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_category_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_category_'.$mode.'_pattern');
      }
      
      if ($this->multistore_mode) {
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store s ON (c.category_id = s.category_id) WHERE s.store_id = ".(int) $this->store . $filterCats)->row;
      } else {
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "category c WHERE 1" . $filterCats)->row;
      }
      
      $this->total_items = $total['total'];
      
      $extra_select = '';
      
      if ($mode == 'url') {
       if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('category_id=', d.category_id) AND (u.language_id = d.language_id OR u.language_id = 0) AND (u.store_id = ".(int) $this->store.") LIMIT 1), '') AS seo_keyword";
       } else if ($this->multistore_mode) {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('category_id=', d.category_id) AND (u.store_id = s.store_id) LIMIT 1), '') AS seo_keyword";
       } else if ($this->ml_mode) {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('category_id=', d.category_id) AND (u.language_id = d.language_id OR u.language_id = 0) LIMIT 1), '') AS seo_keyword";
       } else {
         $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE query = CONCAT('category_id=', d.category_id) LIMIT 1), '') AS seo_keyword";
       }
      }

      if ($this->store) {
        $desc_table = 'seo_category_description';
        $extra_desc = "AND store_id = '" . (int)$this->store . "'";
        $rows = $this->db->query("SELECT sd.*, c.*, d.name as orig_name, d.description as orig_description ".$extra_select." FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store s ON (c.category_id = s.category_id) LEFT JOIN " . DB_PREFIX . "seo_category_description sd ON (c.category_id = sd.category_id AND sd.language_id=".(int) $lang." AND sd.store_id = s.store_id) LEFT JOIN " . DB_PREFIX . "category_description d ON (c.category_id = d.category_id AND d.language_id=".(int) $lang.") WHERE s.store_id = ".(int) $this->store." ORDER BY sd.category_id,sd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
      } else {
        $desc_table = 'category_description';
        $extra_desc = '';
        if ($this->multistore_mode) {
          $rows = $this->db->query("SELECT d.*, c.*".$extra_select." FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description d ON c.category_id = d.category_id LEFT JOIN " . DB_PREFIX . "category_to_store s ON (c.category_id = s.category_id) WHERE s.store_id = ".(int) $this->store." AND d.language_id=".(int) $lang . $filterCats . " ORDER BY d.category_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        } else {
          $rows = $this->db->query("SELECT d.*, c.*".$extra_select." FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description d ON c.category_id = d.category_id WHERE d.language_id=".(int) $lang . $filterCats . " ORDER BY d.category_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        }
      }
      
      foreach ($rows as $row) {
        $this->session->data['seopackage_processed']++;
        
        if (empty($row['name']) && isset($row['orig_name'])) {
          $row['name'] = $row['orig_name'];
        }
        
        if (empty($row['description']) && isset($row['orig_description'])) {
          $row['description'] = $row['orig_description'];
        }
        
        $value = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformCategory($value, $lang, $row, $this->store);
        
        if ($mode != 'url' && $this->multistore_mode && $this->store && !$simulate && !array_key_exists('meta_title', $row)) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_category_description SET category_id = '" . (int)$row['category_id'] . "', store_id = '" . (int)$this->store . "', language_id = '" . (int)$lang . "'");
        }
        
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'category_id=" . $row['category_id'] . "' AND store_id = " . (int)$this->store . " AND language_id IN (".(int) $lang.", 0)");
            } else if ($this->multistore_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'category_id=" . $row['category_id'] . "' AND store_id = " . (int)$this->store);
            } else if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'category_id=" . $row['category_id'] . "' AND language_id IN (".(int) $lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'category_id=" . $row['category_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'category', $row['category_id'], $lang, $simulate);
          
          if (!$simulate) {
            if ($this->config->get('mlseo_backup')) {
              if ($row['seo_keyword'] && $row['seo_keyword'] != $value) {
                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($row['seo_keyword']) . "', redirect = 'product/category&category_id=" . (int) $row['category_id'] . "', language_id = '" . (int) $lang . "'");
              }
            }
            
            //$this->db->query("UPDATE " . DB_PREFIX . "category_description SET seo_keyword = '". $this->db->escape($value) ."' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'category_id=" . $row['category_id'] . "', language_id = '" . $lang . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->multistore_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'category_id=" . $row['category_id'] . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'category_id=" . $row['category_id'] . "', language_id = '" . $lang . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'category_id=" . $row['category_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          // $field = 'seo_keyword';
        }
        // Meta title
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h1 = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h2 = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h3 = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_title = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          if (function_exists('mb_strtolower')) {
            $value = mb_strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          } else {
            $value = strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          }
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_keyword = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_description = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && trim(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')))) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET description = '" . $this->db->escape($value) . "' WHERE category_id = '" . $row['category_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'description';
        }
        
        if (!$simulate) {
          $this->db->query("UPDATE " . DB_PREFIX . "category SET date_modified = NOW() WHERE category_id = '".(int)$row['category_id']."'");
        }
        
        if (array_key_exists($field, $row)) {
          $changed = !($value === $row[$field]);
        } else {
          $changed = false;
        }
        
        if (!defined('SEO_PACKAGE_CLI')) {
          if ($row[$field] && $changed && $mode == 'url' && $this->config->get('mlseo_backup')) {
            $values[$lang]['rows'][] = array(
              'link' =>  $this->url->link('catalog/category/'.$this->edit_action, $this->token . '&category_id=' . $row['category_id'], 'SSL'),
              'name' =>  $row['name'],
              'old_value' =>  (string) $row[$field],
              'value' =>  '[backup url to redirect to new one]',
              'changed' =>  false,
            );
          }
          
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/category/'.$this->edit_action, $this->token . '&category_id=' . $row['category_id'], 'SSL'),
            'name' =>  $row['name'],
            'old_value' =>  (string) $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('category.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['name'] . ' => ' . $value);
          }
          
          $this->session->data['seopackage_updated']++;
          $change_count++;
          //Powercache::remove('seo_rewrite', 'path=', $row['category_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    return $data;
  }
  
  public function generator_information($mode, $simulate, $empty_only, $redirect) {
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); return;}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
    }
    
    $values = $data = array();
    
    if ($mode == 'store_copy') {
      foreach($this->request->post['langs'] as $lang) {
        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "seo_information_description WHERE language_id = '".(int) $lang."' AND store_id = '".(int) $this->store."'");
          
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_information_description SELECT information_id, '".(int) $lang."', '".(int) $this->store."', title, description, meta_title, meta_description, meta_keyword, seo_h1, seo_h2, seo_h3 FROM " . DB_PREFIX . "information_description d WHERE d.language_id = '".(int) $lang."'");
        }
        
        $data['langs'][$lang]['lang_img'] = $lang_img[$lang];
        $data['langs'][$lang]['rows'][] = array(
          'link' =>  '',
          'name' =>  'Information data copy to sub-store',
          'old_value' =>  '',
          'value' =>  'Done',
          'changed' =>  '',
        );
      }
      
      return $data;
    }
    
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_information_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_information_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_information_'.$mode.'_pattern');
      }
      
      if ($this->multistore_mode) {
        $total = $this->db->query("SELECT COUNT(*) as total  FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_to_store s ON (i.information_id = s.information_id) WHERE s.store_id = ".(int) $this->store)->row;
      } else {
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "information")->row;
      }
      
      $this->total_items = $total['total'];
      
      $extra_select = '';
      
      if ($mode == 'url') {
        if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('information_id=', d.information_id) AND (u.language_id = d.language_id OR u.language_id = 0) AND (u.store_id = ".(int) $this->store.") LIMIT 1), '') AS seo_keyword";
        } else if ($this->multistore_mode) {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('information_id=', d.information_id) AND (u.store_id = s.store_id) LIMIT 1), '') AS seo_keyword";
        } else if ($this->ml_mode) {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('information_id=', d.information_id) AND (u.language_id = d.language_id OR u.language_id = 0) LIMIT 1), '') AS seo_keyword";
        } else {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE query = CONCAT('information_id=', d.information_id) LIMIT 1), '') AS seo_keyword";
        }
      }
      
      if ($this->store) {
        $desc_table = 'seo_information_description';
        $extra_desc = "AND store_id = '" . (int)$this->store . "'";
        $rows = $this->db->query("SELECT sd.*, i.*, sd.name as title, d.title as orig_title, d.description as orig_description ".$extra_select." FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_to_store s ON (i.information_id = s.information_id) LEFT JOIN " . DB_PREFIX . "seo_information_description sd ON (i.information_id = sd.information_id AND sd.language_id=".(int) $lang." AND sd.store_id = s.store_id) LEFT JOIN " . DB_PREFIX . "information_description d ON (i.information_id = d.information_id AND d.language_id=".(int) $lang.") WHERE s.store_id = ".(int) $this->store." ORDER BY i.information_id,sd.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        //$rows = $this->db->query("SELECT d.*, i.*, cd.title, cd.description ".$extra_select." FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "seo_information_description d ON i.information_id = d.information_id /*LEFT JOIN " . DB_PREFIX . "information_description id ON i.information_id = cd.information_id*/ LEFT JOIN " . DB_PREFIX . "information_to_store s ON (i.information_id = s.information_id) WHERE s.store_id = ".(int) $this->store." AND d.language_id=".(int) $lang." AND cd.language_id=".(int) $lang." ORDER BY d.information_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
      } else {
        $desc_table = 'information_description';
        $extra_desc = '';
        if ($this->multistore_mode) {
          $rows = $this->db->query("SELECT d.*, i.*".$extra_select." FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description d ON i.information_id = d.information_id LEFT JOIN " . DB_PREFIX . "information_to_store s ON (i.information_id = s.information_id) WHERE s.store_id = ".(int) $this->store." AND d.language_id=".(int) $lang." ORDER BY d.information_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        } else {
          $rows = $this->db->query("SELECT d.*, i.*".$extra_select." FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description d ON i.information_id = d.information_id WHERE d.language_id=".(int) $lang." ORDER BY d.information_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
        }
      }
      
      //$rows = $this->db->query("SELECT *".$extra_select." FROM " . DB_PREFIX . "information_description d WHERE d.language_id=".(int) $lang." ORDER BY d.information_id LIMIT ".$this->start.",".$this->limit)->rows;
      
      foreach ($rows as $row) {
        $this->session->data['seopackage_processed']++;
        
        if (empty($row['title']) && isset($row['orig_title'])) {
          $row['title'] = $row['orig_title'];
        }
        
        if (empty($row['description']) && isset($row['orig_description'])) {
          $row['description'] = $row['orig_description'];
        }
        
        $value = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformInformation($value, $lang, $row, $this->store);
        
        if ($mode != 'url' && $this->multistore_mode && $this->store && !$simulate && !array_key_exists('meta_title', $row)) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_information_description SET information_id = '" . (int)$row['information_id'] . "', store_id = '" . (int)$this->store . "', language_id = '" . (int)$lang . "'");
        }
        
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'information_id=" . $row['information_id'] . "' AND store_id = " . (int)$this->store . " AND language_id IN (".(int) $lang.", 0)");
            } else if ($this->multistore_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'information_id=" . $row['information_id'] . "' AND store_id = " . (int)$this->store);
            } else if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'information_id=" . $row['information_id'] . "' AND language_id IN (".(int) $lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'information_id=" . $row['information_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'information', $row['information_id'], $lang, $simulate);
          
          if (!$simulate) {
            if ($this->config->get('mlseo_backup')) {
              if ($row['seo_keyword'] && $row['seo_keyword'] != $value) {
                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($row['seo_keyword']) . "', redirect = 'information/information&information_id=" . (int) $row['information_id'] . "', language_id = '" . (int) $lang . "'");
              }
            }
            
            //$this->db->query("UPDATE " . DB_PREFIX . "information_description SET seo_keyword = '". $this->db->escape($value) ."' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . $row['language_id'] . "' ");
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'information_id=" . $row['information_id'] . "', language_id = '" . (int) $lang . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->multistore_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'information_id=" . $row['information_id'] . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'information_id=" . $row['information_id'] . "', language_id = '" . (int) $lang . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'information_id=" . $row['information_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          // $field = 'seo_keyword';
        }
        // h1
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h1 = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h2 = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h3 = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_title = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          if (function_exists('mb_strtolower')) {
            $value = mb_strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          } else {
            $value = strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          }
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_keyword = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_description = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && trim(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')))) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET description = '" . $this->db->escape($value) . "' WHERE information_id = '" . $row['information_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'description';
        }
        
        if (array_key_exists($field, $row)) {
          $changed = !($value === $row[$field]);
        } else {
          $changed = false;
        }
        
        if (!defined('SEO_PACKAGE_CLI')) {
          if ($row[$field] && $changed && $mode == 'url' && $this->config->get('mlseo_backup')) {
            $values[$lang]['rows'][] = array(
              'link' =>  $this->url->link('catalog/information/'.$this->edit_action, $this->token . '&information_id=' . $row['information_id'], 'SSL'),
              'name' =>  $row['title'],
              'old_value' =>  (string) $row[$field],
              'value' =>  '[backup url to redirect to new one]',
              'changed' =>  false,
            );
          }
          
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/information/'.$this->edit_action, $this->token . '&information_id=' . $row['information_id'], 'SSL'),
            'name' =>  $row['title'],
            'old_value' =>  (string) $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('information.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['title'] . ' => ' . $value);
          }
          
          $this->session->data['seopackage_updated']++;
          $change_count++;
          //Powercache::remove('seo_rewrite', 'information_id=' . $row['information_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    
    return $data;
  }
  
  public function generator_manufacturer($mode, $simulate, $empty_only, $redirect) {
    if (version_compare(VERSION, '3', '<')) {
      //return $this->generator_manufacturer_old($mode, $simulate, $empty_only, $redirect);
    }
    
    if (!isset($this->request->post['langs'])) { $data['langs'] = array(); return;}
    
    // get languages 
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    unset($languages);
    
    switch ($mode) {
      case 'url': $field = 'seo_keyword'; break;
      case 'h1': $field = 'seo_h1'; break;
      case 'h2': $field = 'seo_h2'; break;
      case 'h3': $field = 'seo_h3'; break;
      case 'title': $field = 'meta_title'; break;
      case 'keyword': $field = 'meta_keyword'; break;
      case 'description': $field = 'meta_description'; break;
      case 'full_desc': $field = 'description'; break;
    }
    
    $values = $data = array();
    
    if ($mode == 'store_copy') {
      foreach($this->request->post['langs'] as $lang) {
        if (!$simulate) {
          $this->db->query("DELETE FROM " . DB_PREFIX . "seo_manufacturer_description WHERE language_id = '".(int) $lang."' AND store_id = '".(int) $this->store."'");
          
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_manufacturer_description SELECT manufacturer_id, '".(int) $lang."', '".(int) $this->store."', title, description, meta_title, meta_description, meta_keyword, seo_h1, seo_h2, seo_h3 FROM " . DB_PREFIX . "seo_manufacturer_description d WHERE d.language_id = '".(int) $lang."' AND d.store_id = '0'");
        }
        
        $data['langs'][$lang]['lang_img'] = $lang_img[$lang];
        $data['langs'][$lang]['rows'][] = array(
          'link' =>  '',
          'name' =>  'manufacturer data copy to sub-store',
          'old_value' =>  '',
          'value' =>  'Done',
          'changed' =>  '',
        );
      }
      
      return $data;
    }
    
    foreach($this->request->post['langs'] as $lang)
    {
      $this->config->set('mlseo_current_lang', $lang_code[$lang]);
      $values[$lang]['lang_img'] = $lang_img[$lang];
      $values[$lang]['rows'] = array();
      $change_count = 0;
      
      if (isset($this->request->post['mlseo_manufacturer_'.$mode.'_pattern'])) {
        $pattern = $this->request->post['mlseo_manufacturer_'.$mode.'_pattern'];
      } else {
        $pattern = $this->config->get('mlseo_manufacturer_'.$mode.'_pattern');
      }
    
      if ($this->multistore_mode) {
        $total = $this->db->query("SELECT COUNT(*) as total  FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store s ON (m.manufacturer_id = s.manufacturer_id) WHERE s.store_id = ".(int) $this->store)->row;
      } else {
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "manufacturer")->row;
      }
      
      $this->total_items = $total['total'];
      
      $extra_select = '';
      
      if ($mode == 'url') {
        if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) AND (u.language_id = ".(int) $lang." OR u.language_id = 0) AND (u.store_id = ".(int) $this->store.") LIMIT 1), '') AS seo_keyword";
        } else if ($this->multistore_mode) {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) AND (u.store_id = s.store_id) LIMIT 1), '') AS seo_keyword";
        } else if ($this->ml_mode) {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " u WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) AND (u.language_id = ".(int) $lang." OR u.language_id = 0) LIMIT 1), '') AS seo_keyword";
        } else {
          $extra_select = ",IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE query = CONCAT('manufacturer_id=', m.manufacturer_id) LIMIT 1), '') AS seo_keyword";
        }
      }
      
      $desc_table = 'seo_manufacturer_description';
      $extra_desc = "AND store_id = '" . (int)$this->store . "'";

      $rows = $this->db->query("SELECT d.*, m.*, d.name as title, m.name as orig_name ".$extra_select." FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store s ON (m.manufacturer_id = s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "seo_manufacturer_description d ON (m.manufacturer_id = d.manufacturer_id AND d.language_id=".(int) $lang." AND d.store_id = s.store_id) WHERE s.store_id = ".(int) $this->store." ORDER BY m.manufacturer_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;

      /* manufacturers always need the store id
      if ($this->multistore_mode) {
        $rows = $this->db->query("SELECT d.*, m.*, d.name as title, m.name as orig_name ".$extra_select." FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store s ON (m.manufacturer_id = s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "seo_manufacturer_description d ON (m.manufacturer_id = d.manufacturer_id AND d.language_id=".(int) $lang." AND d.store_id = s.store_id) WHERE s.store_id = ".(int) $this->store." ORDER BY m.manufacturer_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
      } else {
        $rows = $this->db->query("SELECT d.*, m.*, d.name as title, m.name as orig_name ".$extra_select." FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store s ON (m.manufacturer_id = s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "seo_manufacturer_description d ON (m.manufacturer_id = d.manufacturer_id AND d.language_id=".(int) $lang." AND d.store_id = s.store_id) ORDER BY m.manufacturer_id,d.language_id LIMIT ".$this->start.",".$this->limit)->rows;
      }*/
      
      foreach ($rows as $row) {
        $this->session->data['seopackage_processed']++;
        
        if (empty($row['name']) && isset($row['orig_name'])) {
          $row['name'] = $row['orig_name'];
        }
        
        $value = str_replace('[current]', $row[$field], $pattern);
        $value = $this->model_tool_seo_package->transformManufacturer($value, $lang, $row, $this->store);
        
        if (!$simulate && !array_key_exists('meta_title', $row)) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "seo_manufacturer_description SET manufacturer_id = '" . (int)$row['manufacturer_id'] . "', store_id = '" . (int)$this->store . "', language_id = '" . (int)$lang . "'");
        }
        
        // urls
        if ($mode == 'url')
        {
          if ($empty_only && $row['seo_keyword']) continue;
          
          if (!$simulate) {
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'manufacturer_id=" . $row['manufacturer_id'] . "' AND store_id = " . (int)$this->store . " AND language_id IN (".(int) $lang.", 0)");
            } else if ($this->multistore_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'manufacturer_id=" . $row['manufacturer_id'] . "' AND store_id = " . (int)$this->store);
            } else if ($this->ml_mode) {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'manufacturer_id=" . $row['manufacturer_id'] . "' AND language_id IN (".(int) $lang.", 0)");
            } else {
              $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'manufacturer_id=" . $row['manufacturer_id'] . "'");
            }
          }
          
          $value = $this->model_tool_seo_package->filter_seo($value, 'manufacturer', $row['manufacturer_id'], $lang, $simulate);
          
          if (!$simulate) {
            if ($this->config->get('mlseo_backup')) {
              if ($row['seo_keyword'] && $row['seo_keyword'] != $value) {
                $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($row['seo_keyword']) . "', redirect = 'product/manufacturer&manufacturer_id=" . (int) $row['manufacturer_id'] . "', language_id = '" . (int) $lang . "'");
              }
            }
            
            if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', language_id = '" . (int) $lang . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->multistore_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$this->store . "'");
            } else if ($this->ml_mode) {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', language_id = '" . (int) $lang . "', keyword = '" . $this->db->escape($value) . "'");
            } else {
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', keyword = '" . $this->db->escape($value) . "'");
            }
          }
          // $field = 'seo_keyword';
        }
        // h1
        elseif ($mode == 'h1')
        {
          if ($empty_only && $row['seo_h1']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h1 = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h2')
        {
          if ($empty_only && $row['seo_h2']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h2 = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        elseif ($mode == 'h3')
        {
          if ($empty_only && $row['seo_h3']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET seo_h3 = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'seo_h1';
        }
        // Meta title
        elseif ($mode == 'title')
        {
          if ($empty_only && $row['meta_title']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_title = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_title';
        }
        // Meta keywords
        elseif ($mode == 'keyword')
        {
          if ($empty_only && $row['meta_keyword']) continue;
          
          if (function_exists('mb_strtolower')) {
            $value = mb_strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          } else {
            $value = strtolower(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));
          }
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_keyword = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_keyword';
        }
        // Meta description
        elseif ($mode == 'description')
        {
          if ($empty_only && $row['meta_description']) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET meta_description = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'meta_description';
        }
        // Description
        elseif ($mode == 'full_desc')
        {
          if ($empty_only && trim(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')))) continue;
          
          $value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
          
          if (!$simulate) {
            $this->db->query("UPDATE " . DB_PREFIX . $desc_table . " SET description = '" . $this->db->escape($value) . "' WHERE manufacturer_id = '" . $row['manufacturer_id'] . "' AND language_id = '" . (int) $lang . "' " . $extra_desc);
          }
          // $field = 'description';
        }
        
        if (array_key_exists($field, $row)) {
          $changed = !($value === $row[$field]);
        } else {
          $changed = false;
        }
        
        if (!defined('SEO_PACKAGE_CLI')) {
          if ($row[$field] && $changed && $mode == 'url' && $this->config->get('mlseo_backup')) {
            $values[$lang]['rows'][] = array(
              'link' =>  $this->url->link('catalog/manufacturer/'.$this->edit_action, $this->token . '&manufacturer_id=' . $row['manufacturer_id'], 'SSL'),
              'name' =>  $row['name'],
              'old_value' =>  (string) $row[$field],
              'value' =>  '[backup url to redirect to new one]',
              'changed' =>  false,
            );
          }
          
          $values[$lang]['rows'][] = array(
            'link' =>  $this->url->link('catalog/manufacturer/'.$this->edit_action, $this->token . '&manufacturer_id=' . $row['manufacturer_id'], 'SSL'),
            'name' =>  $row['name'],
            'old_value' =>  (string) $row[$field],
            'value' =>  $value,
            'changed' =>  $changed,
          );
        }
        
        if ($changed) {
          if (defined('SEO_PACKAGE_CLI')) {
            $this->log('manufacturer.' . $mode . ': [' . $lang_code[$lang] . '] ' . $row['name'] . ' => ' . $value);
          }
          
          $this->session->data['seopackage_updated']++;
          $change_count++;
          //Powercache::remove('seo_rewrite', 'manufacturer_id=' . $row['manufacturer_id']);
        }
      } // end foreach $rows
      $values[$lang]['count'] = $change_count;
    }
    $data['langs'] = &$values;
    
    return $data;
  }
  
  public function generator_manufacturer_old($mode, $simulate, $empty_only, $redirect) {
    $this->load->model('tool/seo_package');
    
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['rows'] = array();
    
    if (isset($this->request->post['mlseo_manufacturer_'.$mode.'_pattern'])) {
      $pattern = $this->request->post['mlseo_manufacturer_'.$mode.'_pattern'];
    } else {
      $pattern = $this->config->get('mlseo_manufacturer_'.$mode.'_pattern');
    }
    
    $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "manufacturer")->row;
    $this->total_items = $total['total'];
    
    $rows = $this->db->query("SELECT name, manufacturer_id, IFNULL((SELECT keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE query = CONCAT('manufacturer_id=',manufacturer_id) LIMIT 1), '') AS seo_keyword FROM " . DB_PREFIX . "manufacturer ORDER BY manufacturer_id LIMIT ".$this->start.",".$this->limit)->rows;
    
    foreach ($rows as $row)
    {
      //Powercache::remove('seo_rewrite', 'manufacturer_id=' . $row['manufacturer_id']);
      $value = str_replace('[current]', $row['seo_keyword'], $pattern);
      $value = $this->model_tool_seo_package->transformManufacturer($value, false, $row, $this->store);
      
      if ($mode == 'url')
      {
        if ($empty_only && $row['seo_keyword']) continue;
        
        $value = $this->model_tool_seo_package->filter_seo($value, 'manufacturer', $row['manufacturer_id'], '', $simulate);

        if (!$simulate) {
          if (version_compare(VERSION, '3', '>=')) {
            $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'manufacturer_id=" . $row['manufacturer_id'] . "' AND store_id = " . (int)$this->store . " AND language_id IN (".(int) $lang.", 0)");
          } else {
            $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = 'manufacturer_id=" . $row['manufacturer_id'] . "'");
          }
          
          if ($this->ml_mode) {
            $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', language_id = 0, keyword = '" . $this->db->escape($value) . "'");
          } else {
            $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'manufacturer_id=" . $row['manufacturer_id'] . "', keyword = '" . $this->db->escape($value) . "'");
          }
        }
      }
      
      if (!defined('SEO_PACKAGE_CLI')) {
        $values['rows'][] = array(
          'link' =>  $this->url->link('catalog/manufacturer/'.$this->edit_action, $this->token . '&manufacturer_id=' . $row['manufacturer_id'], 'SSL'),
          'name' =>  $row['name'],
          'old_value' =>  $row['seo_keyword'],
          'value' =>  $value,
          'changed' =>  $row['seo_keyword'] != $value,
        );
      }
      
      if (defined('SEO_PACKAGE_CLI')) {
        $this->log('manufacturer.' . $mode . ': ' . $row['name'] . ' => ' . $value);
      }
    }
    $data['langs'][0] = &$values;
    
    return $data;
    }
  
  public function generator_redirect($mode, $simulate, $empty_only, $redirect) {
    $data = array();
    
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    
    // define('FRONT_MODEL_LOADER', true);
    
    // require_once(VQMod::modCheck(DIR_CATALOG . 'controller/common/seo_url.php')); 
    // $this->seo_url = new ControllerCommonSeoUrl($this->registry);
    //$this->seo_url->index();
    
    foreach($this->request->post['langs'] as $lang)
    {
      $values = array();
      $values['lang_img'] = $lang_img[$lang];
      $values['no_old'] = true;
      $values['rows'] = array();
      
      $this->config->set('mlseo_cache', false);
      
      $this->config->set('config_language_id', (int) $lang);
      $this->config->set('config_language', $lang_code[$lang]);
      $this->session->data['language'] = $lang_code[$lang];
      
      $type = $mode;
      
      switch($type) {
        case 'information':
          $route = 'information/information';
          $field = $param = 'information_id';
          break;
        case 'product':
          $route = 'product/product';
          $field = $param = 'product_id';
          break;
        case 'category':
          $route = 'product/category';
          $field = 'category_id';
          $param = 'path';
          break;
        case 'manufacturer':
          $route = 'product/manufacturer/info';
          $field = $param = 'manufacturer_id';
          break;
      }
      
      $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . $type)->row;
      $this->total_items = $total['total'];
      
      if ($type == 'category') {
        $rows = $this->getCategories(0, '', " LIMIT " . $this->start . "," . $this->limit);
      } else {
        $rows = $this->db->query("SELECT " . $field . " FROM " . DB_PREFIX . $type . " ORDER BY " . $field . " LIMIT " . $this->start . "," . $this->limit)->rows;
      }
      
      foreach ($rows as $row) {
        $this->session->data['seopackage_processed']++;
        
        $this->config->set('config_store_id', $this->store);
        
        $url = $this->front_url->link($route, $param . '=' . $row[$param]);
        
        // get relative url
        $rel_url = str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url);
         
        $redir = $route . '&' . $param . '=' . $row[$param];
        
        // do not redirect default links
        if (strpos($url, 'index.php?route=') !== false) continue;
        
        //if ($empty_only && $row['seo_keyword']) continue;
        
        $count = $this->db->query("SELECT COUNT(*) as count FROM " . DB_PREFIX . "url_redirect WHERE query = '" . $this->db->escape($rel_url) . "' AND redirect = '" . $this->db->escape($redir) . "' AND language_id = '" . (int) $lang . "'")->row;
        
        if ($count['count']) {
          $changed = 0;
        } else {
          if (!$simulate) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_redirect SET query = '" . $this->db->escape($rel_url) . "', redirect = '" . $this->db->escape($redir) . "', language_id = '" . (int) $lang . "'");
          }
          
          $changed = 1;
          $this->session->data['seopackage_updated']++;
        }
        
        if (!defined('SEO_PACKAGE_CLI')) {
        $values['rows'][] = array(
          'link' =>  str_replace(HTTP_SERVER, '../', $url),
          'name' =>  str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url),
          'old_value' =>  '',
          'value' => $redir,
          'changed' =>  $changed,
        );
        }
      
        if (defined('SEO_PACKAGE_CLI')) {
          if ($changed) {
            $this->log('redirect.' . $mode . ': ' . $rel_url . ' => ' . str_replace(HTTP_SERVER, '../', $url));
          }
        }
      }
      
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
      
      if ($type == 'manufacturer') {
        $data['langs'][$lang]['lang_img'] = false;
        break;
      }
    }
    
    return $data;
  }
  
  public function generator_report($mode, $simulate, $empty_only, $redirect) {
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['rows'] = array();
    $data['nohidecol'] = true;
    $data['hidesim'] = true;
    $data['col1'] = $this->language->get('text_query');
    $data['col2'] = $this->language->get('text_keyword');
    $data['col3'] = $this->language->get('text_status');
    
    $urls = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE keyword = ''")->rows;
    
    foreach($urls as $url) {
      $values['rows'][] = array(
        'name' =>  $url['query'],
        'old_value' =>  $url['keyword'],
        'value' =>  '<span style="color:#C94644">'.$this->language->get('text_empty').'</span>',
        'changed' =>  0,
      );
    }
    
    if (version_compare(VERSION, '3', '>=') || $this->multistore_mode) {
      $where = " WHERE store_id = ".(int) $this->store." ";
    } else {
      $where = '';
    }

    //$urls = $this->db->query("SELECT count(*) AS count, query, keyword FROM " . DB_PREFIX . $this->url_alias . " GROUP BY keyword")->rows;
    if ($this->ml_mode && $this->config->get('mlseo_duplicate')) {
      $urls = $this->db->query("SELECT count(*) AS count, query, keyword, language_id  FROM " . DB_PREFIX . $this->url_alias . $where . " GROUP BY query, keyword, language_id")->rows;
    } else {
      $urls = $this->db->query("SELECT count(*) AS count, query, keyword  FROM " . DB_PREFIX . $this->url_alias . $where . " GROUP BY query, keyword")->rows;
    }
    
    foreach($urls as $url) {
      if ($url['keyword'] && $url['count']> 1) {
        $duplicates = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE keyword = '".$url['keyword']."'")->rows;
        foreach($duplicates as $duplicate) {
          $values['rows'][] = array(
            'name' =>  $duplicate['query'],
            'old_value' =>  $duplicate['keyword'],
            'value' =>  '<span style="color:#82669B">'.$this->language->get('text_duplicate').'</span>',
            'changed' =>  0,
          );
        }
      }
    }
    
    $data['langs'][0] = &$values;
    //$data['langs'][0]['count'] = count($urls);
    
    return $data;
  }
  
  public function generator_links($mode, $simulate, $empty_only, $redirect) {
    $data = array();
    
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    
    // define('FRONT_MODEL_LOADER', true);
    
    // require_once(VQMod::modCheck(DIR_CATALOG . 'controller/common/seo_url.php')); 
    // $this->seo_url = new ControllerCommonSeoUrl($this->registry);
    //$this->seo_url->index();
    
    $mode = 'product';
    
    foreach($this->request->post['langs'] as $lang)
    {
      $values = array();
      $values['lang_img'] = $lang_img[$lang];
      $values['no_old'] = true;
      $values['rows'] = array();
      
      $this->config->set('mlseo_cache', false);
      
      $this->config->set('config_language_id', (int) $lang);
      $this->config->set('config_language', $lang_code[$lang]);
      $this->session->data['language'] = $lang_code[$lang];
      
      $type = $mode;
      
      switch($type) {
        case 'information':
          $route = 'information/information';
          $field = $param = 'information_id';
          break;
        case 'product':
          $route = 'product/product';
          $field = $param = 'name';
          break;
        case 'category':
          $route = 'product/category';
          $field = 'category_id';
          $param = 'path';
          break;
        case 'manufacturer':
          $route = 'product/manufacturer/info';
          $field = $param = 'manufacturer_id';
          break;
      }
      
      $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . $type)->row;
      $this->total_items = $total['total'];
      
      if ($type == 'category') {
        $rows = $this->getCategories(0, '', " LIMIT " . $this->start . "," . $this->limit);
      } else {
        $rows = $this->db->query("SELECT * FROM " . DB_PREFIX . $type . "_description ORDER BY " . $field . " LIMIT " . $this->start . "," . $this->limit)->rows;
      }
      
      foreach ($rows as $row) {
        $this->session->data['seopackage_processed']++;
        
        $this->config->set('config_store_id', $this->store);
        
        $url = $this->front_url->link($route, $type . '_id=' . $row[$type.'_id']);
        
        // get relative url
        $rel_url = str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url);
         
        //$redir = $route . '&' . $param . '=' . $row[$param];
        
        // do not redirect default links
        //if (strpos($url, 'index.php?route=') !== false) continue;
        
        //if ($empty_only && $row['seo_keyword']) continue;
        
        if (empty($row[$field])) continue;
        
        $changed = 0;
        
        $insertedInto = $insertedIntoHref = array();
        $searchLinks = $this->db->query("SELECT * FROM " . DB_PREFIX . $type . "_description WHERE description LIKE '%" . $this->db->escape($row[$field]) . "%' AND language_id = '" . (int) $lang . "'")->rows;
        
        foreach ($searchLinks as $res) {
          $orig_desc = $res['description'];
          
          preg_match_all('/(?:&lt;a.+?&gt;)?\b'.preg_quote($row[$field], '/').'\b(?:&lt;\/a&gt;)?/', $orig_desc, $matches);
          
          if (empty($matches)) continue;
          
          foreach ($matches as $match) {
            $new_desc = str_replace($match[0], '&lt;a href="'.$url.'"&gt;'.$row[$field].'&lt;/a&gt;', $orig_desc);
          }
          
          $insertedInto[] = $res[$type.'_id'];
          $insertedIntoHref[] = '<a href="'.$this->url->link('catalog/'.$type.'/edit', $type.'_id='.$res[$type.'_id'].'&'.$this->token).'">'.$res[$type.'_id'].'</a>';
          
          
          if ($orig_desc != $new_desc) {
            if (!$simulate) {
              $this->db->query("UPDATE " . DB_PREFIX . $type . "_description SET description = '" . $this->db->escape($new_desc) . "' WHERE " . $type . "_id = '" . (int) $res[$type . '_id'] . "' AND language_id = '" . (int) $lang . "'");
            }
            
            $changed = 1;
          }
        }
        
        if (empty($insertedInto)) continue;
        
        if ($changed) $this->session->data['seopackage_updated']++;
        
        if (!defined('SEO_PACKAGE_CLI')) {
          $values['rows'][] = array(
            'link' =>  $this->url->link('catalog/'.$type.'/edit', $type.'_id='.$row[$type.'_id'].'&'.$this->token),
            'name' =>  $row['name'],
            'old_value' =>  $url,
            'value' => ($changed ? 'Added link into: ' : 'Link exists into: ') . implode(', ', $insertedIntoHref),
            'changed' => $changed,
          );
        }
      
        if (defined('SEO_PACKAGE_CLI')) {
          if ($changed) {
            $this->log('internal_links: ' . $url . ' => ' . implode(', ', $insertedInto));
          }
        }
      }
      
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
      
      if ($type == 'manufacturer') {
        $data['langs'][$lang]['lang_img'] = false;
        break;
      }
    }
    
    return $data;
  }
  
  public function generator_robots($mode, $simulate, $empty_only, $redirect) {
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['no_main'] = true;
    $values['rows'] = array();
    $data['nohidecol'] = true;
    $data['hidesim'] = true;
    $data['col1'] = $this->language->get('text_query');
    $data['col2'] = $this->language->get('text_keyword');
    $data['col3'] = $this->language->get('text_status');
    
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    
    if (!$simulate) {
      $fh = fopen(DIR_CATALOG.'../robots.txt', 'w') or die('robots.txt can not be written, please check rights');
    }
    
    $robots = 'User-agent: *
Disallow: /*?route=checkout/
Disallow: /*?route=account/
Disallow: /*?route=affiliate/
Disallow: /*?route=product/search
Disallow: /*&limit
Disallow: /*?limit
Disallow: /*?sort
Disallow: /*&sort
Disallow: /*?order
Disallow: /*&order
Disallow: /*?price
Disallow: /*&price
Disallow: /*?mode
Disallow: /*&mode
Disallow: /*?cat
Disallow: /*&cat
Disallow: /*?dir
Disallow: /*&dir
Disallow: /*?color
Disallow: /*&color
Disallow: /*?product_id
Disallow: /*&product_id
Disallow: /*?minprice
Disallow: /*&minprice
Disallow: /*?maxprice
Disallow: /*&maxprice
Disallow: /*?page=1
Disallow: /*&create=1
Disallow: /*?keyword
Disallow: /*?av

Sitemap: '.HTTP_CATALOG.'sitemap.xml';

    if (!$simulate) {
      fwrite($fh, $robots);
    }
    
    $values['rows'][] = array(
          'name' =>  '',
          'old_value' =>  '',
          'value' => nl2br($robots),
          'changed' =>  0,
        );
    
    $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE meta_robots IN ('noindex', 'none')")->rows;
    
    foreach ($query as $product) {
      foreach ($this->request->post['langs'] as $lang) {
        $this->config->set('config_language_id', (int) $lang);
        $this->config->set('config_language', $lang_code[$lang]);
        $this->session->data['language'] = $lang_code[$lang];

        $this->session->data['seopackage_processed']++;
        
        $this->config->set('config_store_id', $this->store);
        
        $url = str_replace(array(HTTP_CATALOG, HTTPS_CATALOG), '/', $this->front_url->link('product/product', 'product_id=' . $product['product_id']));
        
        fwrite($fh, "\n" . 'Disallow: ' . $url);
      
        $values['rows'][] = array(
          'name' =>  '',
          'old_value' =>  '',
          'value' => 'Disallow: ' . $url,
          'changed' =>  0,
        );
      }
    }
    
    if (!$simulate) {
      fclose($fh);
    }
    
    $data['langs'][0] = &$values;
    
    return $data;
  }
  
  protected function getCategories($parent_id, $current_path = '', $limits = '') {
    $route = 'product/category';
    $field = 'category_id';
    $param = 'path';
    
    $categories = array();

    $results = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = " . (int) $parent_id . " ORDER BY " . $field . $limits)->rows;;
    
    foreach ($results as $result) {
      if (!$current_path) {
        $new_path = $result['category_id'];
      } else {
        $new_path = $current_path . '_' . $result['category_id'];
      }

      $categories[] = array(
        'category_id' => $result['category_id'],
        'path' => $new_path,
      );

      $categories = array_merge($categories, $this->getCategories($result['category_id'], $new_path));
    }

    return $categories;
  }
  
  public function generator_cache($mode, $simulate, $empty_only, $redirect) {
    $data = array();
    
    $this->load->model('tool/seo_package');
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    foreach ($languages as $language) {
      $lang_code[$language['language_id']] = $language['code'];
      if ($this->OC_V22X) {
        $lang_img[$language['language_id']] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $lang_img[$language['language_id']] = 'view/image/flags/'. $language['image'];
      }
    }
    
    if ($mode == 'delete') {
      $values = array();
      $values['lang_img'] = '';
      $values['no_old'] = true;
      $values['rows'] = array();
      foreach($this->request->post['langs'] as $lang)
      {
        $res = Powercache::delete('seo_rewrite.' . (int) $lang);
        if ($res) {
          $values['rows'][] = array(
            'link' =>  0,
            'name' =>  '/system/cache/pcache.seo_rewrite.'.$lang,
            'old_value' =>  '',
            'value' => $this->language->get('text_deleted'),
            'changed' =>  0,
          );
        }
      }
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
      return $data;
    }
    
    $data['simulate'] = false;

    //define('FRONT_MODEL_LOADER', true);
    
    //require_once(VQMod::modCheck(DIR_CATALOG . 'controller/common/seo_url.php')); 
    //$this->seo_url = new ControllerCommonSeoUrl($this->registry);

    foreach($this->request->post['langs'] as $lang)
    {
      $values = array();
      $values['lang_img'] = $lang_img[$lang];
      $values['no_old'] = true;
      $values['rows'] = array();
    
      Powercache::delete('seo_rewrite.' . (int) $lang);
      
      $this->config->set('config_language_id', (int) $lang);
      $this->config->set('config_language', $lang_code[$lang]);
      $this->session->data['language'] = $lang_code[$lang];
      
      $types = array('product', 'information');
      $this->total_items = 0;
      foreach ($types as $type)
      {
        switch($type) {
          case 'information':
            $route = 'information/information';
            $field = $param = 'information_id';
            break;
          case 'product':
            $route = 'product/product';
            $field = $param = 'product_id';
            break;
          case 'category':
            $route = 'product/category';
            $field = 'category_id';
            $param = 'path';
            break;
          }
        
        $total = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . $type."_description WHERE language_id=".(int)$lang)->row;
        $this->total_items += $total['total'];
        
        $rows = $this->db->query("SELECT ".$field.", seo_keyword, language_id FROM " . DB_PREFIX . $type."_description WHERE language_id=".(int)$lang . " ORDER BY ".$field." LIMIT ".$this->start.",".$this->limit)->rows;
        foreach ($rows as $row)
        {
          
          //$url = $this->front_link($route, $param . '=' . $row[$field]);
          $url = $this->front_url->link($route, $param . '=' . $row[$field]);
          
          $values['rows'][] = array(
            'link' =>  str_replace(HTTP_SERVER, '../', $url),
            'name' =>  'index.php?route=' . $route . '&' . $param . '=' . $row[$field],
            'old_value' =>  '',
            'value' =>  str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url),
            'changed' =>  0,
          );

          // product link from categories
          if ($type == 'product')
          {
            $paths = $this->model_tool_seo_package->getFullProductPaths($row['product_id']);
            foreach ($paths as $path)
            {
              //$url = $this->url->link('product/product', 'path=' . $path . '&product_id=' . $row['product_id']);
              $url = $this->front_url->link('product/product', 'path=' . $path . '&product_id=' . $row['product_id']);
              
              $values['rows'][] = array(
                'link' =>  str_replace(HTTP_SERVER, '../', $url),
                'name' =>  'index.php?route=product/product&path=' . $path . '&product_id=' . $row['product_id'],
                'old_value' =>  '',
                'value' =>  str_replace(array(HTTP_SERVER, HTTP_CATALOG), '/', $url),
                'changed' =>  0,
              );
            }
          }
          
          //Powercache::add('seo_rewrite', $row['language_id'] . '-route=product/product&product_id=' . $row['product_id'], $url);
          
        }
      }
      
      $data['langs'][$lang] = $values;
      $data['langs'][$lang]['count'] = count($values['rows']);
    }
    
    return $data;
  }
  
  public function generator_cleanup($mode, $simulate, $empty_only, $redirect) {
    $values = $data = array();
    $values['lang_img'] = '';
    $values['no_old'] = true;
    $values['rows'] = array();
    
    if ($mode == 'url') {
      if ($this->ml_mode) {
        $urls = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'information_id=%' OR query LIKE 'route=%') AND language_id=0")->rows;
      } else {
        //$urls = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%')")->rows;
        $urls = array();
      }
      
      foreach ($urls as $url)
      {
        $values['rows'][] = array(
          'name' =>  $url['query'] . ' ('.$url['keyword'].')',
          'old_value' =>  '',
          'value' => 'Fix assigned language ID',
          'changed' =>  0,
        );
      }
      
      if (!$simulate) {
        // Copy keyword values to item tables - Common to all modules - copy first without language id to be sure to have it in case of not defined
        $this->db->query("UPDATE `" . DB_PREFIX . "product_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'product_id=%' AND d.product_id = REPLACE(u.query, 'product_id=', '')");
        $this->db->query("UPDATE `" . DB_PREFIX . "category_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'category_id=%' AND d.category_id = REPLACE(u.query, 'category_id=', '')");
        $this->db->query("UPDATE `" . DB_PREFIX . "information_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'information_id=%' AND d.information_id = REPLACE(u.query, 'information_id=', '')");
        
        if ($this->ml_mode) {
          $this->db->query("UPDATE `" . DB_PREFIX . "product_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'product_id=%' AND d.product_id = REPLACE(u.query, 'product_id=', '') AND d.language_id = u.language_id");
          $this->db->query("UPDATE `" . DB_PREFIX . "category_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'category_id=%' AND d.category_id = REPLACE(u.query, 'category_id=', '') AND d.language_id = u.language_id");
          $this->db->query("UPDATE `" . DB_PREFIX . "information_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'information_id=%' AND d.information_id = REPLACE(u.query, 'information_id=', '') AND d.language_id = u.language_id");
        }
      }
      
      if (!$simulate) {
        if ($this->ml_mode) {
          $this->db->query("UPDATE " . DB_PREFIX . $this->url_alias . " SET language_id = ".(int) $this->config->get('config_language_id')." WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'information_id=%' OR query LIKE 'route=%') AND language_id=0");
          //$this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%') AND language_id=0");
        } else {
          //$this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'route=%')");
        }
      }
        
      $data['langs'][0] = &$values;
      $data['langs'][0]['count'] = count($urls);
    } else if ($mode == 'duplicate') {
      $data['nohidecol'] = true;
      $data['col1'] = $this->language->get('text_query');
      $data['col2'] = $this->language->get('text_keyword');
      $data['col3'] = $this->language->get('text_status');
    
      $deleted = 0;
      
      if (version_compare(VERSION, '3', '>=') || $this->multistore_mode) {
        $where = " WHERE store_id = ".(int) $this->store." ";
        $and_store = " AND store_id = ".(int) $this->store." ";
      } else {
        $where = '';
        $and_store = '';
      }
      
      if ($this->ml_mode) {
        $urls = $this->db->query("SELECT count(*) AS count, query, keyword, language_id  FROM " . DB_PREFIX . $this->url_alias . $where . " GROUP BY query, keyword, language_id")->rows;
      } else {
        $urls = $this->db->query("SELECT count(*) AS count, query, keyword  FROM " . DB_PREFIX . $this->url_alias . $where . " GROUP BY query, keyword")->rows;
      }
      
      foreach($urls as $url) {
        if ($url['count'] > 1) {
          if (!$simulate) {
            if ($this->ml_mode) {
              $total_deleted = $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '".$url['query']."' AND keyword = '".$url['keyword']."' AND language_id = '".$url['language_id']."' ".$and_store." LIMIT " . ($url['count']-1));
            } else {
              $total_deleted = $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '".$url['query']."' AND keyword = '".$url['keyword']."' ".$and_store." LIMIT " . ($url['count']-1));
            }
          }

          $values['rows'][] = array(
            'name' =>  $url['query'],
            'old_value' =>  $url['keyword'],
            'value' =>  $this->language->get('text_deleted'),
            'changed' =>  0,
          );
          $deleted++;
        }
      }
      
      $data['langs'][0] = &$values;
      $data['langs'][0]['count'] = $deleted;
    }
      
      return $data;
  }
  
  public function get_value() {
    $store = (int) $this->request->get['store'];
    $type = $this->request->get['type'];
    $fields = $this->request->get['field'];
    $lang = (int) $this->request->get['lang'];
    $item_id = (int) $this->request->get['id'];
    $store_id = isset($this->request->get['store']) ? (int) $this->request->get['store'] : 0;
    
    if ($store_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '".$store_id."'");
			
			foreach ($query->rows as $setting) {
				if (!$setting['serialized']) {
					$this->config->set($setting['key'], $setting['value']);
        } else if ($this->OC_V21X) {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
				} else {
					$this->config->set($setting['key'], unserialize($setting['value']));
				}
			}
		}
    
    $lgCodes = $this->config->get('mlseo_lang_codes');
      
    if (!empty($lgCodes[$lang])) {
      $this->config->set('mlseo_current_lang', $lgCodes[$lang]);
    }

    if (!in_array($type, array('product', 'category', 'information', 'manufacturer'))) {
      return '';
    }
    
    
    if ($fields == 'all') {
      if ($type == 'product') {
        $fields = array('seo_keyword', 'seo_h1', 'seo_h2', 'seo_h3', 'image_alt', 'image_title', 'meta_title', 'meta_keyword', 'meta_description', 'tag');
      } else {
        $fields = array('seo_keyword', 'seo_h1', 'seo_h2', 'seo_h3', 'meta_title', 'meta_keyword', 'meta_description');
      }
    }
    
    if (empty($fields)) {
      return '';
    }
    
    $values = array();
    
    foreach ((array) $fields as $field) {
      
      switch ($field) {
        case 'seo_keyword': $mode = 'url'; break;
        case 'seo_h1': $mode = 'h1'; break;
        case 'seo_h2': $mode = 'h2'; break;
        case 'seo_h3': $mode = 'h3'; break;
        case 'meta_title': $mode = 'title'; break;
        case 'meta_keyword': $mode = 'keyword'; break;
        case 'meta_description': $mode = 'description'; break;
        case 'description': $mode = 'full_desc'; break;
        case 'image': $mode = 'image_name'; break;
        case 'image_title': $mode = 'image_title'; break;
        case 'image_alt': $mode = 'image_alt'; break;
        case 'tag': $mode = 'tag'; break;
      }

      //$row = $this->db->query("SELECT * FROM " . DB_PREFIX . $type . "_description WHERE " . $type . "_id = " . (int) $item_id . " AND language_id=" . (int) $lang)->row;

      //$row = $this->request->post[$type.'_description'][$lang];
      $row = $this->request->post;
      $row[$type.'_id'] = $item_id;
      
      // set substore values
      if ($store_id && !empty($row['seo_'.$type.'_description'][$store_id])) {
        if (isset($row[$type.'_description'])) {
          foreach ($row[$type.'_description'] as $language_id => $desc) {
            $row[$type.'_description'][$language_id]['orig_name'] = $row[$type.'_description'][$language_id]['name'];
            $row[$type.'_description'][$language_id]['orig_description'] = $row[$type.'_description'][$language_id]['description'];
            $row[$type.'_description'][$language_id] = array_merge($row[$type.'_description'][$language_id], array_filter($row['seo_'.$type.'_description'][$store_id][$language_id]));
          }
        }
      }
      
      $pattern = $this->config->get('mlseo_'.$type.'_'.$mode.'_pattern');
      
      if ($type == 'manufacturer') {
        $pattern = str_replace('[current]', $row['seo_'.$type.'_description'][$store_id][$lang][$field], $pattern);
      } else {
        $pattern = str_replace('[current]', $row[$type.'_description'][$lang][$field], $pattern);
      }
      
      $this->load->model('tool/seo_package');
      
      $value = $this->model_tool_seo_package->{'transform'.ucfirst($type)}($pattern, $lang, $row, $store_id, true);
      
      if ($field == 'tag') {
        if ($lang) {
          $remove = $this->config->get('mlseo_remove_'.$lang);
        } else {
          $remove = $this->config->get('mlseo_remove_'.$this->config->get('config_language_id'));
        }
        
        $value = str_replace('"', '', $value);
        
        if (!empty($remove)) {
          $beforeWord = "(\\s|\\.|\\,|\\!|\\?|\\(|\\)|\\'|\\\"|^)";
          $afterWord =  "(\\s|\\.|\\,|\\!|\\?|\\(|\\)|\\'|\\\"|$)";
          $removeArray = array();
          
          foreach (explode(',', $remove) as $rem) {
            $removeArray[] = '`'.$beforeWord.preg_quote(trim($rem), '`').$afterWord.'`';
          }
          
          if ($removeArray) {
            $value = preg_replace($removeArray, '$1$2', $value);
          }
        }
        
        if ($this->config->get('mlseo_format_tag')) {
          $value = str_replace('.', ',', $value);
          $value = str_replace(array('  ',' '), ', ', $value);
          $value = trim(mb_strtolower($value), ', ');
        }
        
        $value = trim(preg_replace('/(?:,\s*)+/', ',', $value), ', ');
      }
      
      if ($field == 'seo_keyword') {
        $value = $this->model_tool_seo_package->filter_seo($value, $type, $row[$type.'_id'], $lang);
      }
      
      if ($mode == 'full_desc') {
        $value = nl2br($value);
      }
      
      if ($mode == 'keyword') {
        if (function_exists('mb_strtolower')) {
          $value = mb_strtolower($value);
        } else {
          $value = strtolower($value);
        }
      }
      
      if ($store || $type == 'manufacturer') {
        $values['seo_'.$type.'_description['.$store.']['.$lang.']['.$field.']'] = $value;
      } else {
        $values[$type.'_description['.$lang.']['.$field.']'] = $value;
      }
    }
    
    header('Content-Type: application/json');
    echo json_encode($values);
    exit;
  }
  
  public function generator($type = '', $mode = '', $redirect = '') {
    //sleep (2);
    
    $this->session->data['seopackage_processed'] = 0;
    $this->session->data['seopackage_updated'] = 0;
    
    $benchmark = false;
    if ($benchmark) {
      ini_set('memory_limit', -1);
      set_time_limit(3600);
    }
    $this->start_time = microtime(true)*1000;
    
    $data['OC_V2'] = version_compare(VERSION, '2', '>=');
    
    $this->load->language('module/complete_seo');
    
    if (defined('SEO_PACKAGE_CLI')) {
      $this->start = 0;
      $this->limit = 9999999999;
    } else {
      $this->start = (int) $this->request->get['start'];
    }
      
    $this->store = isset($this->request->get['store']) ? $this->request->get['store'] : 0;
    
    if (!$this->start) unset($this->session->data['kwCountArray']);
    
    if (!$type && !isset($this->request->get['type'])) return;
    if (!$mode && !isset($this->request->get['mode'])) return;
    
    if (!$type) $type = $this->request->get['type'];
    if (!$mode) $mode = $this->request->get['mode'];
    if (!$redirect) $redirect = !empty($this->request->get['redirect']) ? $this->request->get['redirect'] : false;
    
    $data['type'] = $type;
    $data['mode'] = $mode;
    $data['simulate'] = $simulate = !empty($this->request->post['simulate']);
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      $data['simulate'] = $simulate = true;
    }
    $data['empty_only'] = $empty_only = !empty($this->request->post['empty_only']);
    
    if (!defined('SEO_PACKAGE_CLI') && $mode == 'related') {
      $this->limit = 100;
    }
      
    $res = $this->{'generator_'.$type}($mode, $simulate, $empty_only, $redirect);
    
    $data['_language'] = $this->language;
    $data['_config'] = $this->config;
    $data['_url'] = $this->url;
    $data['token'] = $this->token;
    
    if ($benchmark) {
      $end_time = microtime(true)*1000;
      var_dump('time: '. ((int)($end_time - $this->start_time) /1000). 's');
      var_dump('mem peak: ' . memory_get_peak_usage()/1000000);
      die;
    }
    
    $processed = $this->start + $this->limit;
    
    if ($processed > $this->total_items) {
      $processed = $this->total_items;
    }
    
    if (!$this->total_items) {
      $progress = 100;
    } else {
      $progress = round(($processed / $this->total_items) * 100);
    }
    
    header('Content-Type: application/json');
    
    echo json_encode(array(
      'success'=> 1,
      'processed' => $processed,
      'progress' => $progress,
      'finished' => $processed >= $this->total_items,
      'log' => $res,
    ));
    
    exit;
    /*
    if ($this->OC_V2) {
      $this->response->setOutput($this->load->view('module/seo_generator.tpl', $data));
    } else {
      $this->data = &$data;
      $this->template = 'module/seo_generator.tpl';
      echo $this->render();
    }
    */
  }
  
  /*<complete*/

  public function cli($params = '') {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    $start_time = time();
    
    foreach ($languages as $language) {
      $this->request->post['langs'][] = $language['language_id'];
    }

    $this->session->data['seopackage_processed'] = 0;
    $this->session->data['seopackage_updated'] = 0;
    
    $this->start = 0;
    $this->limit = 9999999999;
      
    $this->store = isset($this->request->get['store']) ? $this->request->get['store'] : 0;
    
    // overwrite store settings
    if ($this->store) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '".$this->store."'");
			
			foreach ($query->rows as $setting) {
				if (!$setting['serialized']) {
					$this->config->set($setting['key'], $setting['value']);
        } else if ($this->OC_V21X) {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
				} else {
					$this->config->set($setting['key'], unserialize($setting['value']));
				}
			}
		}
    
    $params = $this->config->get('mlseo_cron');
    
    if (isset($_GET['product']) || isset($_GET['category']) || isset($_GET['information']) || isset($_GET['manufacturer']) || isset($_GET['redirect'])) {
      $params = $_GET;
    } else {
      $params = $this->config->get('mlseo_cron');
      if (!is_array($params)) {
        echo 'No parameters found';
        return;
      }
    }
    
    $simulation = isset($params['simulation']) && $params['simulation'];
    $empty_only = isset($params['empty_only']) && $params['empty_only'];
    
    $simu = $simulation ? 'SIMULATION MODE - ' : '';
    $this->log(PHP_EOL . '----------------------------- CLI Request - ' . $simu . date('d/m/Y H:i:s') . ' - Store ' . $this->store . ' -----------------------------', 'report');
    
    foreach (array('product', 'category', 'information', 'manufacturer', 'redirect') as $mode) {
      if (!empty($_GET[$mode])) {
        $params['update'][$mode] = (array) $_GET[$mode];
      }
    }
    
    if (count($params['update'])) {
      foreach ($params['update'] as $type => $modes) {
        foreach ($modes as $mode) {
          $this->{'generator_'.$type}($mode, $simulation, $empty_only, '');
        }
      }
    }
    
    $total_time = time() - $start_time;
    $hours = floor($total_time/3600);
    $mins = floor(($total_time-($hours * 3600))/60);
    $secs = $total_time-($hours * 3600)-($mins * 60);
    $process_time = '';
    
    if ($hours) {
      $process_time = $hours . ' ' . $this->language->get('text_hours');
    }
    
    if ($hours || $mins) {
      $process_time .= ($hours ? ', ': '') . $mins . ' ' . $this->language->get('text_minutes');
    }
    
    if ($hours || $mins || $secs) {
      $process_time .= ($mins ? ' and ' : '') . $secs . ' ' . $this->language->get('text_seconds');
    } else if (!$process_time) {
      $process_time .= '1 ' . $this->language->get('text_seconds');
    }
    
    $this->log(PHP_EOL .  'Process terminated:', 'report');
    $this->log('- Total items: ' . $this->session->data['seopackage_processed'], 'report');
    $this->log('- Total updated: ' . $this->session->data['seopackage_updated'], 'report');
    $this->log('- Total process time: ' . $process_time, 'report');
    $this->log('-------------------------------------------------------------------------------------------------------' . PHP_EOL, 'report');
    
    echo 'Process terminated - Processed: ' . $this->session->data['seopackage_processed'] . ' - Updated: ' . $this->session->data['seopackage_updated'] . ' - Total time: '. $process_time;
  }
  
  public function editor_data() {
    // DataTables PHP library
    $this->load->model('tool/seo_package_editor');
    $this->load->model('tool/image');
    
    if (!isset($this->request->get['type'])) return;
    if (!isset($this->request->get['lang'])) return;
    
    $type = $this->request->get['type'];
    $lang = (int) $this->request->get['lang'];
    $store = (int) $this->request->get['store'];
    
    // php 5.2 doesn't support anonymous functions
    if (!function_exists('inlineeditor_image')) {
      function inlineeditor_image($d, $row, $type, $_this) { 
        if ($d && file_exists(DIR_IMAGE . $d)) {
            $img = $_this->model_tool_image->resize($d, 40, 40);
          } else {
          $no_image = (version_compare(VERSION, '2', '>=')) ? 'no_image.png' : 'no_image.jpg';
          $img = $_this->model_tool_image->resize($no_image, 40, 40);
        }
        return '<img src="' . $img . '" alt=""/>';
      }
    }
    if (!function_exists('inlineeditor_text')) {
      function inlineeditor_text($d, $row, $type) {
        if (version_compare(VERSION, '3', '>=') && $type == 'url_alias') {
          $type = 'seo_url';
        }
        return '<a data-type="text" data-pk="' . $row[$type.'_id'] . '">' . $d . '</a>';
      }
    }
    if (!function_exists('inlineeditor_keyword')) {
      function inlineeditor_keyword($d, $row, $type) {
        if (version_compare(VERSION, '3', '>=') && $type == 'url_alias') {
          $type = 'seo_url';
        }
        return '<a data-type="text" data-pk="' . $row[$type.'_id'] . '">' . str_replace('route=', '', $d) . '</a>';
      }
    }
    if (!function_exists('inlineeditor_image_name')) {
      function inlineeditor_image_name($d, $row, $type) {
        $file = pathinfo($d);
        return '<a data-type="text" data-pk="' . $row[$type.'_id'] . '">' . $file['basename'] . '</a>';
      }
    }
    if (!function_exists('inlineeditor_related')) {
      function inlineeditor_related($d, $row, $type) {
        $rel_names = array();
        
        $output = '<div class="select2-input"><div class="editable-input"><select multiple="multiple" data-pk="' . $row[$type.'_id'] . '" data-col="related">';
        
        foreach ($d['rows'] as $rel) {
          $rel_names[] = $rel['name'];
          $output .= '<option value="' . $rel['related_id'] . '" selected="selected">' . $rel['name'] . '</option>';
        }
  
        $output .= '</select></div>';
        $output .= '<div class="editable-buttons"><button type="submit" class="select2-submit"><i class="fa fa-check"></i></button></div></div>';
        $output .= '<a class="select2" pk="' . $row[$type.'_id'] . '">' . implode(', ', $rel_names) . '</a>';
        
        return $output;
      }
    }
    if (!function_exists('inlineeditor_textarea')) {
      function inlineeditor_textarea($d, $row, $type) {
        return '<a data-type="textarea" data-pk="' . $row[$type.'_id'] . '">' . $d . '</a>';
      }
    }
    if (!function_exists('editor_404actions')) {
      function editor_404actions($d, $row, $type) {
        $disabled = '';
        
        if ($row['has_redirect']) {
          $disabled = 'style="visibility:hidden"';
        }
        
        return '<button type="button" '.$disabled.' class="btn btn-success btn-xs" onclick="javascript:$(\'#newAliasModal input\').val(\'\');$(\'#newAliasModal input[name=query]\').val($(this).closest(\'tr\').find(\'td:first\').text());" data-toggle="modal" data-target="#newAliasModal" data-pk="' . $d . '" title="Add redirection to this url"><i class="fa fa-plus"></i></i></button>
        <button type="button" class="btn btn-danger btn-xs deleteAlias" data-pk="' . $d . '"><i class="fa fa-close"></i></i></button>';
      }
    }
    if (!function_exists('editor_404color')) {
      function editor_404color($d, $row, $type) {
        if ($row['has_redirect']) {
          //important strip tags prefent xss vulnerability
          return '<span class="text-success">'.strip_tags($row['query']).'</span>';
        } else {
          return strip_tags($row['query']);
        }
      }
    }
    if (!function_exists('editor_deletebtn')) {
      function editor_deletebtn($d, $row, $type) {
        return '<button type="button" class="btn btn-danger btn-xs deleteAlias" data-pk="' . $d . '"><i class="fa fa-close"></i></i></button>';
        //return '<i class="deleteAlias fa fa-minus-circle" data-pk="' . $d . '"></i>';
      }
    }
     
    $columns = array();
    // image column
    $dt = 0;
    if ($type == 'image') {
      $columns[] = array( 'db' => 'image',  'dt' => $dt++, 'formatter' => 'inlineeditor_image');
      $columns[] = array( 'db' => 'name', 'dt' => $dt++);
      $columns[] = array( 'db' => 'image', 'dt' => $dt++, 'formatter' => 'inlineeditor_image_name');
      $columns[] = array( 'db' => 'image_alt', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'image_title', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $type = 'product';
      $columns[] = array( 'db' => $type.'_id', 'dt' => $dt++, 'table_alias' => 'd');
    } else if ($type == 'absolute') {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'redirect', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'url_absolute_id', 'dt' => $dt++, 'formatter' => 'editor_deletebtn' );
    } else if (in_array($type, array('common', 'special'))) {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'inlineeditor_keyword');
      $columns[] = array( 'db' => 'keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => $this->url_alias.'_id', 'dt' => $dt++, 'formatter' => 'editor_deletebtn' );
    } else if ($type == 'redirect') {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'redirect', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'url_redirect_id', 'dt' => $dt++, 'formatter' => 'editor_deletebtn');
     } else if ($type == 'autolink') {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'redirect', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      $columns[] = array( 'db' => 'url_autolink_id', 'dt' => $dt++, 'formatter' => 'editor_deletebtn');
    } else if ($type == '404') {
      $columns[] = array( 'db' => 'query', 'dt' => $dt++, 'formatter' => 'editor_404color');
      $columns[] = array( 'db' => 'count', 'dt' => $dt++);
      $columns[] = array( 'db' => 'url_404_id', 'dt' => $dt++, 'formatter' => 'editor_404actions');
    } else {
      if (in_array($type, array('product', 'category', 'manufacturer'))) {
        $columns[] = array( 'db' => 'image',  'dt' => $dt++, 'formatter' => 'inlineeditor_image');
        $columns[] = array( 'db' => 'name', 'dt' => $dt++, 'formatter' => 'inlineeditor_text', 'table_alias' => 'd');
      }
      if (in_array($type, array('information'))) {
        if ($store) {
          $columns[] = array( 'db' => 'name', 'dt' => $dt++, 'formatter' => 'inlineeditor_text', 'table_alias' => 'd');
        } else {
          $columns[] = array( 'db' => 'title', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
        }
      }
      /*
      if (in_array($type, array('manufacturer'))) {
        $columns[] = array( 'db' => 'keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
      }
      */
      //if (!in_array($type, array('manufacturer'))) {
      if (true) {
        $columns[] = array( 'db' => 'seo_keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_text');
        $columns[] = array( 'db' => 'meta_title', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        $columns[] = array( 'db' => 'meta_keyword', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        $columns[] = array( 'db' => 'meta_description', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        if (in_array($type, array('product')) && version_compare(VERSION, '1.5.3', '>') && !$store) {
          $columns[] = array( 'db' => 'tag', 'dt' => $dt++, 'formatter' => 'inlineeditor_textarea');
        }
        if (in_array($type, array('product'))) {
          $columns[] = array( 'db' => 'related', 'dt' => $dt++, 'formatter' => 'inlineeditor_related');
        }
      }
      $columns[] = array( 'db' => $type.'_id', 'dt' => $dt++, 'table_alias' => 'i');
    }
    
    header('Content-Type: application/json');
    
    echo json_encode(
      $this->model_tool_seo_package_editor->simple( $_GET, $type, $lang, $store, $columns )
    );
    exit;
  }
  
  public function editor_update() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      header('Content-Type: application/json');
      echo json_encode(array('status' => 'error', 'msg' => $this->language->get('error_permission')));
      exit;
    }
    
    $pk = $this->request->post['pk'];
    
    if (isset($this->request->get['store'])) {
      $store_id = (int) $this->request->get['store'];
    } else if (isset($this->request->post['store'])) {
      $store_id = (int) $this->request->post['store'];
    } else {
      $store_id = 0;
    }
    
    if (is_string($this->request->post['value'])) {
      $value = html_entity_decode($this->request->post['value'], ENT_QUOTES, 'UTF-8');
    } else {
      $value = $this->request->post['value'];
    }
    
    $col = $this->request->post['col'];
    $type =  isset($this->request->post['type']) ? $this->request->post['type'] : '';
    $lang = isset($this->request->post['lang']) ? $this->request->post['lang'] : '';
    
    if ($type == 'image') {
      $type = 'product';
    }
    
    // return if something is empty
    if (empty($pk) || empty($col)) return;
    
    // allowed values
    if (!in_array($col, array('title', 'name', 'seo_keyword', 'seo_h1', 'meta_title', 'meta_keyword', 'meta_description', 'tag', 'query', 'keyword', 'redirect', 'related', 'image', 'image_alt', 'image_title'))) return;
    
    if ($col == 'image') {
      $this->load->model('tool/seo_package');
      
      $prod = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $pk . "'")->row;
      
      $path = pathinfo($prod['image']);
      $new_path = pathinfo($value);
      
      if (empty($prod['image']) || empty($new_path['filename'])) {
        header('Content-Type: application/json');
        echo json_encode(
          array('status' => 'error', 'pk' => $pk, 'msg' => 'Empty value not allowed')
        );
        exit;
      }
      
      $filename = $this->model_tool_seo_package->filter_seo($new_path['filename'], 'image', '');
      $value = $path['dirname'] . '/' . $filename . '.' . $path['extension'];
      
      $x = 1;
      
      while (file_exists(DIR_IMAGE . $value)) {
        $value = $path['dirname'] . '/' . $filename . '-' . $x . '.' . $path['extension'];
        $x++;
      }
      
      if (rename(DIR_IMAGE . $prod['image'], DIR_IMAGE . $value)) {
        //$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '". $this->db->escape($value) ."' WHERE product_id = '" . (int) $pk . "'");
        
        // replace all images with such value
        $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '". $this->db->escape($value) ."' WHERE image = '" . $this->db->escape($prod['image']) . "'");
        $this->db->query("UPDATE " . DB_PREFIX . "product_image SET image = '". $this->db->escape($value) ."' WHERE image = '" . $this->db->escape($prod['image']) . "'");
      }
      
      $value = pathinfo($value);
      
      header('Content-Type: application/json');
      
      echo json_encode(
        array('status' => 'success', 'pk' => $pk, 'msg' => $value['basename'])
      );
      
      exit;
    }
    
    if ($col == 'related') {
       $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $pk . "'" );
       $res_ids = $res_names = array();
       
       if (empty($value)) {
          $value = array();
       }
       
       foreach ($value as $rel_id) {
          $rel_id = (int) $rel_id;
          if ((int) $rel_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_related (product_id, related_id) VALUES (" . (int) $pk . ", " . (int) $rel_id . ")");
            $prod = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE language_id=" . $this->config->get('config_language_id') . " AND product_id = '" . (int) $rel_id . "'")->row;
            $res_ids[] = $prod['product_id'];
            $res_names[] = $prod['name'];
          }
      }
      
      header('Content-Type: application/json');
      
      echo json_encode(
        //array('status' => 'success-related', 'val' => implode(',', $res_ids), 'msg' => implode(', ', $res_names), 'pk' => $pk)
        array('status' => 'success', 'pk' => $pk, 'msg' => implode(', ', $res_names))
      );
      
      exit;
    }
    
    $primaryKey = $type . '_id';
    if (in_array($type, array('common', 'special'))) {
      $primaryKey = $this->url_alias.'_id';
    } else if ($type == 'redirect') {
      $primaryKey = 'url_redirect_id';
    } else if ($type == 'absolute') {
      $primaryKey = 'url_absolute_id';
    }
    
    // update products, categories or informations
    if (in_array($type, array('product', 'category', 'information', 'manufacturer', 'common', 'special', 'redirect', 'absolute'))) {
      if (in_array($type, array('common', 'special'))) {
        // delete route if set by user
        str_replace('route=', '', $value);
        // insert it if necessary
        $route = ($type == 'common' && $col == 'query') ? 'route=' : '';
        
        $this->db->query("UPDATE " . DB_PREFIX . $this->url_alias . " SET " . $col . " = '" . $this->db->escape($route.$value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "'");
      } else if ($type == 'redirect') {
        $this->db->query("UPDATE " . DB_PREFIX . "url_redirect SET " . $col . " = '" . $this->db->escape($value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "'");
      } else if ($type == 'absolute') {
        $value = ltrim($value, '/');
        $value = str_replace(array('route=', 'index.php?route='), '', $value);
        $this->db->query("UPDATE " . DB_PREFIX . "url_absolute SET " . $col . " = '" . $this->db->escape($value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "'");
      }
      
      if ($col == 'seo_keyword') {
        $this->load->model('tool/seo_package');
        $value = $this->model_tool_seo_package->filter_seo($value, $type, $pk, $lang);
        
        if ($this->config->get('mlseo_backup')) {
          $currentKeywordsQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '". $primaryKey . "=" . (int)$pk . "'")->rows;
          
          $currentKeywords = array();
          
          foreach ($currentKeywordsQuery as $curKeyword) {
            $currentKeywords[(isset($curKeyword['store_id']) ? $curKeyword['store_id'] : 0)][(isset($curKeyword['language_id']) ? $curKeyword['language_id'] : $this->config->get('config_language_id'))] = $curKeyword['keyword'];
          }
          
          $currentKeyword = isset($currentKeywords[$store_id][$lang]) ? $currentKeywords[$store_id][$lang] : '';
          
          if ($currentKeyword && $currentKeyword != $value) {
            if ($type == 'product') {
              $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($currentKeyword) . "', redirect = 'product/product&product_id=" . (int) $pk . "', language_id = '" . (int) $lang . "'");
            } else if ($type == 'category') {
              $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($currentKeyword) . "', redirect = 'product/category&category_id=" . (int) $pk . "', language_id = '" . (int) $lang . "'");
            } else if ($type == 'information') {
              $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($currentKeyword) . "', redirect = 'information/information&information_id=" . (int) $pk . "', language_id = '" . (int) $lang . "'");
            } else if ($type == 'manufacturer') {
              $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "url_redirect SET query = '/" . $this->db->escape($currentKeyword) . "', redirect = 'product/manufacturer&manufacturer_id=" . (int) $pk . "', language_id = '" . (int) $lang . "'");
            }
          }
        }
            
        // manufacturer has no multilingual keyword
        if (version_compare(VERSION, '3', '>=') || ($this->multistore_mode && $this->ml_mode)) {
          $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '". $primaryKey . "=" . (int)$pk . "' AND store_id = " . (int)$store_id . " AND language_id IN (".(int) $lang.", 0)");
          $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '". $primaryKey . "=" . (int)$pk . "', keyword = '" . $this->db->escape($value) . "', language_id = '" . (int)$lang . "', store_id = '" . (int)$store_id . "'");
        } else if ($this->multistore_mode) {
          $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '". $primaryKey . "=" . (int)$pk . "' AND store_id = " . (int)$store_id);
          $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '". $primaryKey . "=" . (int)$pk . "', keyword = '" . $this->db->escape($value) . "', store_id = '" . (int)$store_id . "'");
        } else if ($this->ml_mode) {
          $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '". $primaryKey . "=" . (int)$pk . "' AND language_id IN (".(int) $lang.", 0)");
          $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '". $primaryKey . "=" . (int)$pk . "', keyword = '" . $this->db->escape($value) . "', language_id = '" . (int)$lang . "'");
        } else {
          $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE query = '". $primaryKey . "=" . (int)$pk . "'");
          $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '". $primaryKey . "=" . (int)$pk . "', keyword = '" . $this->db->escape($value) . "'");
        }
      } else if (in_array($type, array('product', 'category', 'information', 'manufacturer'))) {
        $seoDesc = ($store_id || $type == 'manufacturer') ? 'seo_' : '';
        $extraWhere = $seoDesc ? " AND store_id = '" . (int)$store_id . "'" : '';
        
        // insert seo desc table if not exists
        if ($seoDesc) {
          $hasSeoDesc = $this->db->query("SELECT * FROM " . DB_PREFIX . $seoDesc . $type . "_description WHERE " . $primaryKey . " = '" . (int)$pk . "' AND language_id = '" . (int)$lang . "'" . $extraWhere)->row;
          
          if(!$hasSeoDesc) {
            $this->db->query("INSERT INTO " . DB_PREFIX . $seoDesc . $type . "_description SET " . $primaryKey . " = '" . (int)$pk . "', store_id = '" . (int)$store_id . "', language_id = '" . (int)$lang . "'");
          }
        }
        
        // update the value
        $this->db->query("UPDATE " . DB_PREFIX . $seoDesc . $type . "_description SET " . $col . " = '" . $this->db->escape($value) . "' WHERE " . $primaryKey . " = '" . (int)$pk . "' AND language_id = '" . (int)$lang . "'" . $extraWhere);
      }
      
      header('Content-Type: application/json');
      
      echo json_encode(
        array('status' => 'success', 'msg' => $value)
      );
      exit;
    }
  }
  
  public function editor_add_alias() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $type = $this->request->get['type'];
    $lang = (int) $this->request->get['lang'];
    $store = (int) $this->request->get['store'];
    $query = $_GET['query'];
    $keyword = $_GET['keyword'];
    
    $table = 'url_alias';
    
    if ($type == 'common') {
      $query = 'route=' . str_replace('route=', '', $query);
    } else if ($type == 'absolute') {
      $query = ltrim($query, '/');
      $query = str_replace(array('route=', 'index.php?route='), '', $query);
    }
    
    if ($type == 'redirect' || $type == '404') {
      $this->db->query("INSERT INTO " . DB_PREFIX . "url_redirect SET query = '" . $this->db->escape($query) . "', redirect = '" . $this->db->escape($keyword) . "', language_id = '" . (int) $lang . "'");
    } else if ($type == 'autolink') {
      $this->db->query("INSERT INTO " . DB_PREFIX . "url_autolink SET query = '" . $this->db->escape($query) . "', redirect = '" . $this->db->escape($keyword) . "', language_id = '" . (int) $lang . "'");
    } else if ($type == 'absolute') {
      $this->db->query("INSERT INTO " . DB_PREFIX . "url_absolute SET query = '" . $this->db->escape($query) . "', redirect = '" . $this->db->escape($keyword) . "', language_id = '" . (int) $lang . "'");
    } else {
      $storeData = '';
      
      if (version_compare(VERSION, '3', '>=') || $this->multistore_mode) {
        $storeData = ", store_id = '".(int) $store."'";
      }
      
      if ($this->ml_mode) {
        $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '" . $this->db->escape($query) . "', keyword = '" . $this->db->escape($keyword) . "', language_id = '" . (int) $lang . "'" . $storeData);
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '" . $this->db->escape($query) . "', keyword = '" . $this->db->escape($keyword) . "'" . $storeData);
      }
    }
    
  }
  
  public function editor_delete_alias() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $type = $this->request->get['type'];
    $alias_id = $this->request->get['pk'];
    
    $lang = (int) $this->request->get['lang'];
    $store = (int) $this->request->get['store'];
    
    if ($type == '404') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_404 WHERE url_404_id =  '". (int) $alias_id . "'");
    } else if ($type == 'redirect') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_redirect WHERE url_redirect_id =  '". (int) $alias_id . "'");
    } else if ($type == 'autolink') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_autolink WHERE url_autolink_id =  '". (int) $alias_id . "'");
    } else if ($type == 'absolute') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_absolute WHERE url_absolute_id =  '". (int) $alias_id . "'");
    } else {
      $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE ".$this->url_alias."_id =  '". (int) $alias_id . "'");
    }
  }
  
  public function editor_delete_aliases() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $type = $this->request->get['type'];
    $lang = (int) $this->request->get['lang'];
    $store = (int) $this->request->get['store'];
    
    if ($type == 'common') {
      $extra_where = "query LIKE 'route=%'";
    } elseif ($type == 'special') {
      $extra_where = "query NOT LIKE 'route=%'
                   AND query NOT LIKE 'product_id=%'
                   AND query NOT LIKE 'category_id=%'
                   AND query NOT LIKE 'information_id=%'
                   AND query NOT LIKE 'manufacturer_id=%'";
    }
    
    if ($type == '404') {
      if (!empty($this->request->get['redir_only'])) {
        $this->db->query("DELETE u FROM " . DB_PREFIX . "url_404 u LEFT JOIN " . DB_PREFIX . "url_redirect r ON (u.query = r.query OR REPLACE(u.query, '".HTTP_CATALOG."', '/') = r.query) WHERE r.query IS NOT NULL");
      } else {
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_404");
      }
    } else if ($type == 'redirect') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_redirect");
    } else if ($type == 'autolink') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_autolink");
    } else if ($type == 'absolute') {
      $this->db->query("DELETE FROM " . DB_PREFIX . "url_absolute");
    } else {
      if (version_compare(VERSION, '3', '>=') || $this->multistore_mode) {
        $extra_where .= " AND store_id = '".(int) $store."'";
      }
      
      if ($this->ml_mode) {
        $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE " . $extra_where . " AND language_id = '" . (int) $lang . "'");
      } else {
        $this->db->query("DELETE FROM " . DB_PREFIX . $this->url_alias . " WHERE " . $extra_where);
      }
    }
  }

  public function editor_restore_aliases() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) return;
    
    $this->load->model('setting/friendlyurls');
    $this->load->model('localisation/language');
    
    $lang = (int) $this->request->get['lang'];
    $lang_code = $this->request->get['lang_code'];
    $store = (int) $this->request->get['store'];
    
    $languages = $this->model_localisation_language->getLanguages();
    
    $langs = array();
    foreach ($languages as $language) {
      $langs[$language['language_id']] = $language['code'];
    }
    
    $this->editor_delete_aliases();
    
    $default_urls = $this->model_setting_friendlyurls->getFriendlyUrls($lang_code);
    
    if (version_compare(VERSION, '3', '>=') || $this->multistore_mode) {
      $storeData = ", store_id = '".(int) $store."'";
    }
      
    foreach ($default_urls as $query => $keyword) {
      if ($this->config->get('mlseo_ascii_'.$lang)) {
        include_once(DIR_SYSTEM . 'library/gkd_urlify.php');
        if (function_exists('mb_substr')) {
          $keyword = URLify::downcode($keyword, mb_substr($lang_code, 0, 2));
        } else {
          $keyword = URLify::downcode($keyword, substr($lang_code, 0, 2));
        }
      }
      
      if ($this->ml_mode) {
        $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'route=" . $query . "', keyword = '" . $keyword . "', language_id = '" . (int) $lang . "'" . $storeData);
      } else {
        $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = 'route=" . $query . "', keyword = '" . $keyword . "'" . $storeData);
      }
    }
  }
  
  public function editor_export_aliases() {
    $type = $this->request->get['type'];
    $lang = $this->request->get['lang'];
    $lang_code = $this->request->get['lang_code'];
    
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=friendly_export.txt");

    echo "You translated friendly urls and want to integrate them in official package?" . PHP_EOL . "Please send this file to support@geekodev.com" . PHP_EOL . PHP_EOL;
    echo "Language : " . $lang_code . PHP_EOL . PHP_EOL;
     
    if ($type == 'common') {
      $extra_where = "query LIKE 'route=%'";
    } elseif ($type == 'special') {
      $extra_where = "query NOT LIKE 'route=%'
                   AND query NOT LIKE 'product_id=%'
                   AND query NOT LIKE 'category_id=%'
                   AND query NOT LIKE 'information_id=%'
                   AND query NOT LIKE 'manufacturer_id=%'";
    } else {
      exit();
    }
    
    if ($this->ml_mode) {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE " . $extra_where . " AND language_id = '" . (int) $lang . "'");
    } else {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE " . $extra_where);
    }
    
    foreach($query->rows as $row) {
      echo "'".str_replace('route=', '', $row['query'])."' => '".$row['keyword']."',". PHP_EOL;
    }
    
    exit();
  }
  
  /*complete>*/
  
   public function modal_related() {
    $this->load->language('module/complete_seo');
    
    $id = $this->request->post['id'];
       
    $related = $this->db->query("SELECT pr.related_id, pd.name FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pr.related_id WHERE pr.product_id=" . (int) $id . " AND pd.language_id=" . $this->config->get('config_language_id'))->rows;
       
    echo '<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">' . $this->language->get('text_seo_mode_related') . '</h4>
        </div>
        <div class="modal-body">
          <select class="related-select" multiple="multiple">';
    
    foreach ($related as $rel) {
      echo '<option value="' . $rel['related_id'] . '">' . $rel['name'] . '</option>';
    }
    
    echo '</select>
<script type="text/javascript">
  $("select.related-select").select2({
    
  });
</script>
        </div>
      </div>
    </div>';
    
    die;
  }
  
  public function product_search() {
    if (!isset($this->request->get['q'])) {
      header('Content-Type: application/json');
      echo json_encode(array('results'));
      exit;
    }
    
    $q = $this->request->get['q'];
     
    $json = array('results');
    
    $products = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE name LIKE '" . $this->db->escape($q) . "%' AND language_id=" . $this->config->get('config_language_id') . " LIMIT 30")->rows; 
    
    if (!$products) {
      $products = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE name LIKE '%" . $this->db->escape($q) . "%' AND language_id=" . $this->config->get('config_language_id') . " LIMIT 30")->rows;
    }
    
    foreach ($products as $product) {
      $json['results'][] = array(
        'id' => $product['product_id'],
        'text' => htmlspecialchars_decode($product['name']),
      );
    }
    
    header('Content-Type: application/json');
    echo json_encode($json);
    
    exit;
   }
   
   public function modal_info() {
    $this->load->language('module/complete_seo');
    
    $item = $this->request->post['info'];
    
    $extra_class = $this->language->get('info_css_' . $item) != 'info_css_' . $item ? $this->language->get('info_css_' . $item) : 'modal-lg';
    $title = $this->language->get('info_title_' . $item) != 'info_title_' . $item ? $this->language->get('info_title_' . $item) : $this->language->get('info_title_default');
    $message = $this->language->get('info_msg_' . $item) != 'info_msg_' . $item? $this->language->get('info_msg_' . $item) : $this->language->get('info_msg_default');
    
    echo '<div class="modal-dialog ' . $extra_class . '">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-info-circle"></i> ' . $title . '</h4>
        </div>
        <div class="modal-body">' . $message . '</div>
      </div>
    </div>';
    
    die;
  }
  
  public function install($redir = false) {
    if ($this->config->get('mlseo_enabled')) return;
    
    if (version_compare(VERSION, '3', '<') && is_dir(DIR_APPLICATION.'controller/extension/module')) {
      //@rename(DIR_APPLICATION.'controller/extension/module', DIR_APPLICATION.'controller/extension/.seo_package');
    }
    
    // rights
    $this->load->model('user/user_group');

    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'module/' . self::MODULE);
      $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'module/' . self::MODULE);
    }
    
    // check tables
    $this->db_tables();
    
    $this->load->model('localisation/language');
    $languages = array();
    $results = $this->model_localisation_language->getLanguages();
    
    foreach ($results as $result) {
      $languages[$result['code']] = $result;
    }

    // set old keywords to all languages
    /*
    if (count($languages) > 1) {
      $keywords = $this->db->query("SELECT * FROM `" . DB_PREFIX . $this->url_alias . "`")->rows;
      foreach ($languages as $language) {
        foreach ($keywords as $row) {
          if (strpos($row['query'], '=') !== false) {
            list($type, $id) = explode('=', $row['query']);
            $type = str_replace('_id', '', $type);
            if (in_array($type, array('product', 'category', 'information'))) {
              $this->db->query("UPDATE " . DB_PREFIX . $type . "_description SET seo_keyword = '" . $row['keyword'] . "' WHERE  " . $type . "_id = '" . $id . "' AND language_id = '" . $language['language_id'] . "'");
              $this->db->query("INSERT INTO " . DB_PREFIX . $this->url_alias . " SET query = '" . $row['query'] . "', keyword = '" . $row['keyword'] . "', language_id = '" . $language['language_id'] . "'");
            }
          }
        }
      }

      $this->db->query("DELETE FROM `" . DB_PREFIX . $this->url_alias . "` WHERE language_id = 0 AND (query LIKE 'product_id=%' OR query LIKE 'category_id=%' OR query LIKE 'information_id=%')");
    }
    */

    // Friendly urls
    /* @todo
    $this->load->model('localisation/language');
    $this->load->model('setting/friendlyurls');
    $languages = $this->model_localisation_language->getLanguages();
    $friendly_urls = array();
    foreach($languages as $language)
    {
      $friendly_urls['mlseo_urls_'.$language['code']] = $this->model_setting_friendlyurls->getFriendlyUrls($language['code']);
    }
    */
    
    $this->load->model('setting/setting');
    $this->model_setting_setting->editSetting('mlseo', array(
        'mlseo_whitespace' => '-',
        'mlseo_extension' => '',
        'mlseo_hreflang' => true,
        'mlseo_friendly' => true,
        //'mlseo_absolute' => true,
        'mlseo_lowercase' => true,
        'mlseo_duplicate' => true,
        'mlseo_canonical' => true,
        'mlseo_pagination_fix' => true,
        'mlseo_default_lang' => $this->config->get('config_language'),
        'mlseo_insertautotitle' => true,
        'mlseo_insertautourl' => true,
        'mlseo_editautourl' => true,
        'mlseo_insertautometakeyword' => true,
        'mlseo_editautometakeyword' => true,
        'mlseo_insertautoseotitle' => true,
        'mlseo_editautoseotitle' => true,
        'mlseo_insertautometadesc' => true,
        'mlseo_editautometadesc' => true,
        //'mlseo_banners' => true,
        'mlseo_safe_url' => 'ext',
        'mlseo_product_url_pattern' => '[name]',
        'mlseo_product_h1_pattern' => '[name]',
        'mlseo_product_h2_pattern' => '[name]',
        'mlseo_product_h3_pattern' => '[name]',
        'mlseo_product_image_alt_pattern' => '[name]',
        'mlseo_product_image_title_pattern' => '[name]',
        'mlseo_product_image_name_pattern' => '[name]',
        'mlseo_product_title_pattern' => '[name] - [model]',
        'mlseo_product_keyword_pattern' => '[name], [model], [category]',
        'mlseo_product_description_pattern' => '[name] - [model] - [category] - [desc]',
        'mlseo_product_full_desc_pattern' => '[name] - [model] - [category]',
        'mlseo_product_tag_pattern' => '[name], [model], [category]',
        'mlseo_category_url_pattern' => '[name]',
        'mlseo_category_h1_pattern' => '[name]',
        'mlseo_category_h2_pattern' => '[name]',
        'mlseo_category_h3_pattern' => '[name]',
        'mlseo_category_title_pattern' => '[name]',
        'mlseo_category_keyword_pattern' => '[name], [desc]',
        'mlseo_category_description_pattern' => '[name] - [desc]',
        'mlseo_category_full_desc_pattern' => '[name]',
        'mlseo_information_url_pattern' => '[name]',
        'mlseo_information_h1_pattern' => '[name]',
        'mlseo_information_h2_pattern' => '[name]',
        'mlseo_information_h3_pattern' => '[name]',
        'mlseo_information_title_pattern' => '[name]',
        'mlseo_information_keyword_pattern' => '[name] [desc]',
        'mlseo_information_description_pattern' => '[name] - [desc]',
        'mlseo_information_full_desc_pattern' => '[name]',
        'mlseo_manufacturer_url_pattern' => '[name]',
        'mlseo_manufacturer_h1_pattern' => '[name]',
        'mlseo_manufacturer_h2_pattern' => '[name]',
        'mlseo_manufacturer_h3_pattern' => '[name]',
        'mlseo_manufacturer_title_pattern' => '[name]',
        'mlseo_product_related_relevance' => 5,
        'mlseo_product_related_no' => 5,
        'mlseo_microdata_data' => array('model' => 1, 'desc' => 1, 'brand' => 1, 'reviews' => 1, 'product' => 1, 'organization' => 1, 'store' => 1, 'website' => 1, 'breadcrumbs' => 1, 'organization_search' => 1, 'store_logo' => 1, 'store_mail' => 1, 'website_search' => 1),
        'mlseo_tcard_data' => array('desc' => 1),
        'mlseo_opengraph_data' => array('desc' => 1),
      ));
      
    if (is_writable(DIR_CATALOG.'../index.php')) {
      $index = file_get_contents(DIR_CATALOG.'../index.php');
      if (strpos($index, 'new multilingual_seo') === false && strpos($index, '$languages = array();') !== false) {
        $index = str_replace('$languages = array();', '$languages = array();'."\n".'$multilingual = new multilingual_seo($registry); $multilingual->detect();', $index);
        file_put_contents(DIR_CATALOG.'../index.php', $index);
      }
    }
    
    if ($redir || !empty($this->request->get['redir'])) {
      if (version_compare(VERSION, '2', '>=')) {
				$this->response->redirect($this->url->link('module/'.self::MODULE, $this->token, 'SSL'));
			} else {
				$this->redirect($this->url->link('module/'.self::MODULE, $this->token, 'SSL'));
			}
    }
  }
  
  private function log($msg = '', $mode = 'all') {
    if ($this->config->get('mlseo_cron_log') == 'off') return;
    if ($this->config->get('mlseo_cron_log') == 'report' && $mode != 'report') return;
    
    $log = DIR_LOGS.'seo_package_cli.log';
    $txt = $msg . PHP_EOL;
    file_put_contents($log, $txt, FILE_APPEND | LOCK_EX);
  }
  
  public function uninstall() {
  /*
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` DROP `seo_keyword`");
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `seo_keyword`");
    if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` DROP `seo_keyword`");
    if (!$this->OC_V2) {
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` DROP `meta_title`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `meta_title`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_description'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `meta_description`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_keyword'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` DROP `meta_keyword`");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` DROP `meta_title`");
    }
    */
    //$default_lang = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $this->config->get('config_language') . "'")->row['language_id'];
    $default_lang = $this->config->get('config_language_id');
    
    if (version_compare(VERSION, '3', '<')) {
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'language_id'")->row) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . $this->url_alias . "` WHERE language_id <> " . $default_lang . " AND language_id <> 0");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . $this->url_alias . "` DROP `language_id`");
      }
    }
    
    if (version_compare(VERSION, '2.2', '<')) {
      $index = file_get_contents(DIR_CATALOG.'../index.php');
      $index = str_replace('$multilingual = new multilingual_seo($registry); $multilingual->detect();', '', $index);
      file_put_contents(DIR_CATALOG.'../index.php', $index);
    }
  }
  
  private function validate() {
    if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
      $this->error['error'] = $this->language->get('error_permission');
    }
    
    if (!$this->error)
      return true;
    return false;
  }
  
  private function db_tables() {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    $this->db->query("SET SESSION sql_mode = ''");
    
    // check DB columns
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product` LIKE 'meta_robots'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `meta_robots` VARCHAR(40) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information` LIKE 'meta_robots'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information` ADD `meta_robots` VARCHAR(40) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product` LIKE 'seo_canonical'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `seo_canonical` VARCHAR(32) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_keyword` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_h1'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_h1` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_h2'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_h2` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_h3'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `seo_h3` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'image_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `image_title` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'image_alt'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `image_alt` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_keyword` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_keyword'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_keyword` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_h1'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_h1` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_h2'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_h2` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_h3'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `seo_h3` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_h1'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_h1` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_h2'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_h2` VARCHAR(255) NOT NULL");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_h3'")->row)
      $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `seo_h3` VARCHAR(255) NOT NULL");
    if (!version_compare(VERSION, '2', '>=')) {
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_title'")->row && !$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` CHANGE `seo_title` `meta_title` VARCHAR(255) NOT NULL");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_title'")->row && !$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` CHANGE `seo_title` `meta_title` VARCHAR(255) NOT NULL");
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_title'")->row && !$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` CHANGE `seo_title` `meta_title` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product_description` ADD `meta_title` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `meta_title` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_description'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `meta_description` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'meta_keyword'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "information_description` ADD `meta_keyword` VARCHAR(255) NOT NULL");
      if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'meta_title'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "category_description` ADD `meta_title` VARCHAR(255) NOT NULL");
    }
    
    if (version_compare(VERSION, '3', '<')) {
      if (count($languages) > 1) {
        if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'language_id'")->row)
          $this->db->query("ALTER TABLE `" . DB_PREFIX . $this->url_alias . "` ADD `language_id` INT(11) NOT NULL DEFAULT '0'");
        
        $this->db->query("UPDATE " . DB_PREFIX . $this->url_alias . " SET language_id = ".(int) $this->config->get('config_language_id')." WHERE (query LIKE 'category_id=%' OR query LIKE 'product_id=%' OR query LIKE 'information_id=%' OR query LIKE 'route=%') AND language_id=0");
      }
    }
    
    try {
      if (!$this->db->query("SHOW INDEX FROM " . DB_PREFIX . "product_description WHERE Key_name='related_generator'")->row)
        $this->db->query("CREATE FULLTEXT INDEX related_generator ON " . DB_PREFIX . "product_description (name, description)");
    } catch (Exception $e) {}
    
    if ($this->config->get('mlseo_multistore')) {
       if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'store_id'")->row)
        $this->db->query("ALTER TABLE `" . DB_PREFIX . $this->url_alias . "` ADD `store_id` INT(11) NOT NULL DEFAULT '0'");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "seo_product_description` (
          `product_id` int(11) NOT NULL,
          `language_id` int(11) NOT NULL DEFAULT 0,
          `store_id` int(11) NOT NULL DEFAULT 0,
          `name` varchar(255) NOT NULL DEFAULT '',
          `description` text NOT NULL DEFAULT '',
          `meta_title` varchar(255) NOT NULL DEFAULT '',
          `meta_description` varchar(255) NOT NULL DEFAULT '',
          `meta_keyword` varchar(255) NOT NULL DEFAULT '',
          `image_title` varchar(255) NOT NULL DEFAULT '',
          `image_alt` varchar(255) NOT NULL DEFAULT '',
          `seo_h1` varchar(255) NOT NULL DEFAULT '',
          `seo_h2` varchar(255) NOT NULL DEFAULT '',
          `seo_h3` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`product_id`,`language_id`,`store_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
        
      $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "seo_category_description` (
          `category_id` int(11) NOT NULL,
          `language_id` int(11) NOT NULL DEFAULT 0,
          `store_id` int(11) NOT NULL DEFAULT 0,
          `name` varchar(255) NOT NULL DEFAULT '',
          `description` text NOT NULL DEFAULT '',
          `meta_title` varchar(255) NOT NULL DEFAULT '',
          `meta_description` varchar(255) NOT NULL DEFAULT '',
          `meta_keyword` varchar(255) NOT NULL DEFAULT '',
          `seo_h1` varchar(255) NOT NULL DEFAULT '',
          `seo_h2` varchar(255) NOT NULL DEFAULT '',
          `seo_h3` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`category_id`,`language_id`,`store_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
      
      $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "seo_information_description` (
          `information_id` int(11) NOT NULL,
          `language_id` int(11) NOT NULL DEFAULT 0,
          `store_id` int(11) NOT NULL DEFAULT 0,
          `name` varchar(255) NOT NULL DEFAULT '',
          `description` text NOT NULL DEFAULT '',
          `meta_title` varchar(255) NOT NULL DEFAULT '',
          `meta_description` varchar(255) NOT NULL DEFAULT '',
          `meta_keyword` varchar(255) NOT NULL DEFAULT '',
          `seo_h1` varchar(255) NOT NULL DEFAULT '',
          `seo_h2` varchar(255) NOT NULL DEFAULT '',
          `seo_h3` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`information_id`,`language_id`,`store_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
      }
        
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "seo_manufacturer_description` (
        `manufacturer_id` int(11) NOT NULL,
        `language_id` int(11) NOT NULL DEFAULT 0,
        `store_id` int(11) NOT NULL DEFAULT 0,
        `name` varchar(255) NOT NULL DEFAULT '',
        `description` text NOT NULL DEFAULT '',
        `meta_title` varchar(255) NOT NULL DEFAULT '',
        `meta_description` varchar(255) NOT NULL DEFAULT '',
        `meta_keyword` varchar(255) NOT NULL DEFAULT '',
        `seo_h1` varchar(255) NOT NULL DEFAULT '',
        `seo_h2` varchar(255) NOT NULL DEFAULT '',
        `seo_h3` varchar(255) NOT NULL DEFAULT '',
        PRIMARY KEY (`manufacturer_id`,`language_id`,`store_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_absolute` (
        `url_absolute_id` int(11) NOT NULL AUTO_INCREMENT,
        `query` varchar(1000) NOT NULL,
        `redirect` varchar(1000) NOT NULL,
        `language_id` int(3) NOT NULL DEFAULT '0',
        PRIMARY KEY (`url_absolute_id`),
        KEY `query` (`query`),
        KEY `redirect` (`redirect`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_autolink` (
        `url_autolink_id` int(11) NOT NULL AUTO_INCREMENT,
        `query` varchar(256) NOT NULL,
        `redirect` varchar(1000) NOT NULL,
        `language_id` int(3) NOT NULL DEFAULT '0',
        PRIMARY KEY (`url_autolink_id`),
        KEY `query` (`query`),
        KEY `redirect` (`redirect`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
      
      
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_redirect` (
        `url_redirect_id` int(11) NOT NULL AUTO_INCREMENT,
        `query` varchar(1000) NOT NULL,
        `redirect` varchar(1000) NOT NULL,
        `language_id` int(3) NOT NULL DEFAULT '0',
        `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`url_redirect_id`),
        KEY `query` (`query`),
        KEY `redirect` (`redirect`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
     
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "url_404` (
        `url_404_id` int(11) NOT NULL AUTO_INCREMENT,
        `query` varchar(1000) NOT NULL,
        `count` int(11) NOT NULL DEFAULT '0',
        `date_accessed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`url_404_id`),
        KEY `query` (`query`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
      
    foreach (array('product', 'category', 'information') as $type) {
      $varchar = $this->db->query("SELECT CHARACTER_MAXIMUM_LENGTH AS length FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = '" . DB_PREFIX . $type . "_description' AND COLUMN_NAME = 'seo_keyword'")->row;
      if ($varchar['length'] < 255) {
        $this->db->query("ALTER TABLE `" . DB_PREFIX . $type . "_description` MODIFY COLUMN `seo_keyword` VARCHAR(255) NOT NULL");
      }
    }
  }
  
  public function report() {
    set_time_limit(600);
    
    echo '<h3>URL ALIAS report</h3>';
    echo '<table border="1" cellpadding="10" style="border-collapse:collapse;"><tr style="font-weight:bold">';
    echo '<td>query</td>
          <td>keyword</td>
          <td>Issue</td>';

    
    $urls = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE keyword = '' ")->rows;
    
    foreach($urls as $url) {
       echo '<tr>
          <td>'.$url['query'].'</td>
          <td>'.$url['keyword'].'</td>
          <td><span style="color:red">empty</span></td>
          </tr>';
    }
    
    $urls = $this->db->query("SELECT count(*) AS count, query, keyword FROM " . DB_PREFIX . $this->url_alias . " GROUP BY keyword ")->rows;
    
    foreach($urls as $url) {
      if ($url['keyword'] && $url['count']> 1) {
        $duplicates = $this->db->query("SELECT query, keyword FROM " . DB_PREFIX . $this->url_alias . " WHERE keyword = '".$url['keyword']."' ")->rows;
        foreach($duplicates as $duplicate) {
        echo '<tr>
          <td>'.$duplicate['query'].'</td>
          <td>'.$duplicate['keyword'].'</td>
          <td>'.(!$duplicate['keyword'] ? '<span style="color:red">empty</span>' : '<span style="color:orange">duplicate</span>').'</td>
          </tr>';
        }
      }
    }
    die;
  }
  
  private function sortByName($a, $b) {
    return strcmp($a['name'], $b['name']);
  }
  
  public function backup() {
    header('Pragma: public');
    header('Expires: 0');
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="complete_seo_' . date('Y-m-d', time()) . '_backup.sql"');
    header('Content-Transfer-Encoding: binary');
    
    $rows = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE code = 'mlseo'")->rows;
    
    echo "DELETE FROM `" . DB_PREFIX . "setting` WHERE code = 'mlseo';\n\n";
    echo "INSERT INTO `" . DB_PREFIX . "setting` (`store_id`, `code`, `key`, `value`, `serialized`) VALUES\n";
    
    $first = false;
    foreach ($rows as $row) {
      echo $first ? ",\n" : '';
      echo "(".$row['store_id'].", 'mlseo', '".$row['key']."', '".$row['value']."', ".$row['serialized'].")";
      $first = true;
    }
    echo ';';
    
    die;
  }
  
  public function upgrade() {
    if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
      if (!$this->user->hasPermission('modify', 'module/complete_seo')) {
        die('Not allowed');
      }
      
      $this->load->model('setting/setting');
      
      $data['info'] = array();
      
      $data['info'][] = 'SEO URLs correctly transferred';
      
      // Remove extension
      if ($this->request->post['module'] == 'broken_link_manager') {
        $rows = $this->db->query("SELECT * FROM " . DB_PREFIX . "error")->rows;
        
        foreach ($rows as $row) {
          $this->db->query("INSERT INTO `" . DB_PREFIX . "url_redirect` SET `query` = '".$this->db->escape(urldecode($row['error']))."', `redirect` = '".$this->db->escape($row['redirect'])."'");
        }
        
        goto end;
      }
      
      if (!empty($this->request->post['ext'])) {
        $this->db->query("UPDATE " . DB_PREFIX . $this->url_alias . " SET keyword = REPLACE(keyword, '".$this->db->escape($this->request->post['ext'])."', '')");
      }
      
      // Copy image title and alt - Paladin
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'title_image'")->row) {
        $this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `image_title` = `title_image`");
      }
      
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'alt_image'")->row) {
        $this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `image_alt` = `alt_image`");
      }
      
      // Copy lang id of url alias table - All in one SEO
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'lang'")->row) {
        $this->db->query("UPDATE `" . DB_PREFIX . $this->url_alias . "` SET `language_id` = `lang`");
      }
      
      // Pack pro
      if ($this->request->post['module'] == 'seo_pack_pro') {
        foreach (array('canonicals', 'clickfix', 'custom_alt_generator', 'custom_h1_generator', 'custom_h2_generator', 'autolinks', 'keywords_generator', 'mlseo', 'not_found_report', 'bot_report', 'redirect', 'rename_files', 'richsnippets', 'seoedit', 'seoeditor', 'seoimages', 'seopagination', 'seoreplacer', 'custom_title_generator', 'custom_imgtitle_generator', 'extendedseo', 'l', 'meta_description_generator', 'rp_generator', 'seopack', 'seoreport', 'table_edit_ajax', 'tag_generator') as $file) {
          @rename(DIR_APPLICATION.'controller/extension/extension/'.$file.'.php', DIR_APPLICATION.'controller/extension/extension/'.$file.'.php.bak');
        }
        
        $data['info'][] = 'Disabled unecessary seo pack pro files';
        
        $store_seo_title = $this->config->get('config_meta_title');
        $store_seo_desc = $this->config->get('config_meta_description');
        $store_seo_keyword = $this->config->get('config_meta_keyword');
        
        $settings = $this->model_setting_setting->getSetting('mlseo');
        
        foreach (array('0') as $store) {
          if (is_array($store_seo_title)) {
            foreach ($store_seo_title as $language => $value) {
              $settings['mlseo_store'][$store.$language]['seo_title'] = $value;
            }
          }
          if (is_array($store_seo_desc)) {
            foreach ($store_seo_desc as $language => $value) {
              $settings['mlseo_store'][$store.$language]['description'] = $value;
            }
          }
          if (is_array($store_seo_keyword)) {
            foreach ($store_seo_keyword as $language => $value) {
              $settings['mlseo_store'][$store.$language]['keywords'] = $value;
            }
          }
        }
		
        $this->model_setting_setting->editSetting('mlseo', $settings);
        
        $data['info'][] = 'Store SEO correctly transferred';
        
        // Copy image title and alt
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description_seo` LIKE 'custom_h1'")->row) {
          $this->db->query("UPDATE `" . DB_PREFIX . "product_description` d, `" . DB_PREFIX . "product_description_seo` u SET d.image_title = u.custom_imgtitle, d.image_alt = u.custom_alt, d.seo_h1 = u.custom_h1, d.seo_h2 = u.custom_h2 WHERE d.product_id = u.product_id AND d.language_id = u.language_id");
        }
        
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description_seo` LIKE 'custom_h1'")->row) {
          $this->db->query("UPDATE `" . DB_PREFIX . "category_description` d, `" . DB_PREFIX . "category_description_seo` u SET d.seo_h1 = u.custom_h1, d.seo_h2 = u.custom_h2 WHERE d.category_id = u.category_id AND d.language_id = u.language_id");
        }
        
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description_seo` LIKE 'custom_h1'")->row) {
          $this->db->query("UPDATE `" . DB_PREFIX . "information_description` d, `" . DB_PREFIX . "information_description_seo` u SET d.seo_h1 = u.custom_h1, d.seo_h2 = u.custom_h2 WHERE d.information_id = u.information_id AND d.language_id = u.language_id");
        }
        
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "url_redirect` LIKE 'oldurl'")->row) {
          $this->db->query("RENAME TABLE " . DB_PREFIX . "url_redirect TO " . DB_PREFIX . "url_redirect_seopackpro");
        }
        
        $data['info'][] = 'SEO img titles, img alt, H1, H2 correctly transferred';
      } else if ($this->request->post['module'] == 'paladin') {
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_description` LIKE 'seo_title'")->row) {
          $this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_title` = `seo_title`");
        }
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "category_description` LIKE 'seo_title'")->row) {
          $this->db->query("UPDATE `" . DB_PREFIX . "category_description` SET `meta_title` = `seo_title`");
        }
        if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "information_description` LIKE 'seo_title'")->row) {
          $this->db->query("UPDATE `" . DB_PREFIX . "information_description` SET `meta_title` = `seo_title`");
        }
        
        $this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE query LIKE 'manufacturer_id=%' AND auto_gen = 'CPBI_urls'");
        $this->db->query("UPDATE `" . DB_PREFIX . "url_alias` SET language_id = 0 WHERE query LIKE 'manufacturer_id=%'");
        $this->db->query("UPDATE `" . DB_PREFIX . "url_alias` SET query = CONCAT('route=', query) WHERE auto_gen = 'STAN_urls'");
        
      // iSense BackPack
      } else if ($this->request->post['module'] == 'backpack') {
        if ($this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "seo_manufacturer_description'")->row) {
          $this->db->query("ALTER TABLE `" . DB_PREFIX . "seo_manufacturer_description` RENAME TO " . DB_PREFIX . "seo_manufacturer_description_isense");
        }
        
        if ($this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "seo_product_description'")->row) {
          $this->db->query("ALTER TABLE `" . DB_PREFIX . "seo_product_description` RENAME TO " . DB_PREFIX . "seo_product_description_isense");
          
          $this->db->query("UPDATE `" . DB_PREFIX . "product_description` d, `" . DB_PREFIX . "seo_product_description_isense` u SET d.seo_h1 = u.h1, d.seo_h2 = u.h2 WHERE d.product_id = u.product_id AND d.language_id = u.language_id");
        }
        
        if (version_compare(VERSION, '2.2', '>=')) {
          $this->load->model("setting/event");
          $this->model_setting_event->deleteEventByCode('isenselabs_seo');
        }
        
        if ($this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "seo_url_alias'")->row) {
          $this->db->query("TRUNCATE `" . DB_PREFIX . $this->url_alias . "`");
          $this->db->query("INSERT INTO `" . DB_PREFIX . $this->url_alias . "` (query, keyword, language_id) SELECT query, keyword, language_id FROM `" . DB_PREFIX . "seo_url_alias`");
        }

      // Mega Kit Plus
      } else if ($this->request->post['module'] == 'mega_kit') {
       if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'smp_language_id'")->row) {
         $this->db->query("UPDATE `" . DB_PREFIX . $this->url_alias . "` SET language_id = smp_language_id");
         
         if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'smp_language_id'")->row) {
           $this->db->query("ALTER TABLE `" . DB_PREFIX . $this->url_alias . "` DROP `smp_language_id`");
         }
        }
        
        $store_seo = $this->config->get('smp_meta_stores');
        
        $settings = $this->model_setting_setting->getSetting('mlseo');
        
        foreach ((array) $store_seo as $store) {
          foreach ($store['title'] as $language => $value) {
            $settings['mlseo_store'][$store.$language]['seo_title'] = $value;
          }
          foreach ($store['description'] as $language => $value) {
            $settings['mlseo_store'][$store.$language]['description'] = $value;
          }
          foreach ($store['keywords'] as $language => $value) {
            $settings['mlseo_store'][$store.$language]['keywords'] = $value;
          }
        }
		
        $this->model_setting_setting->editSetting('mlseo', $settings);
        
        $data['info'][] = 'Store SEO correctly transferred';
        
        $this->db->query("INSERT INTO `" . DB_PREFIX . "url_redirect` (query, redirect) SELECT broken_link, new_link FROM `" . DB_PREFIX . "redirects_smp`");
        
        $data['info'][] = 'Redirections correctly transferred';
      
      // Webkul Advanced SEO
      } else if ($this->request->post['module'] == 'webkul_advanced_seo') {
        $this->db->query("INSERT INTO `" . DB_PREFIX . $this->url_alias . "` (query, keyword, language_id) SELECT CONCAT('route=', route), keyword, language_id FROM `" . DB_PREFIX . "wkseo_sef`");
        
      }
      
      // Copy seo manufacturer data from other table
      // INSERT INTO `oc_seo_manufacturer_description` (`manufacturer_id`, `language_id`, `description`, `meta_title`, `seo_h1`, `meta_description`, `meta_keyword`) SELECT manufacturer_id, language_id, description, meta_title, meta_h1, meta_description, meta_keyword FROM `oc_manufacturer_description`
      
      // Copy keyword values to item tables - Common to all modules - copy first without language id to be sure to have it in case of not defined
      /* no more useful, we don't use anymore seo_keyword in desc
      $this->db->query("UPDATE `" . DB_PREFIX . "product_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'product_id=%' AND d.product_id = REPLACE(u.query, 'product_id=', '')");
      $this->db->query("UPDATE `" . DB_PREFIX . "category_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'category_id=%' AND d.category_id = REPLACE(u.query, 'category_id=', '')");
      $this->db->query("UPDATE `" . DB_PREFIX . "information_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'information_id=%' AND d.information_id = REPLACE(u.query, 'information_id=', '')");
      
      if ($this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . $this->url_alias . "` LIKE 'language_id'")->row) {
        $this->db->query("UPDATE `" . DB_PREFIX . "product_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'product_id=%' AND d.product_id = REPLACE(u.query, 'product_id=', '') AND d.language_id = u.language_id");
        $this->db->query("UPDATE `" . DB_PREFIX . "category_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'category_id=%' AND d.category_id = REPLACE(u.query, 'category_id=', '') AND d.language_id = u.language_id");
        $this->db->query("UPDATE `" . DB_PREFIX . "information_description` d, `" . DB_PREFIX . $this->url_alias . "` u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'information_id=%' AND d.information_id = REPLACE(u.query, 'information_id=', '') AND d.language_id = u.language_id");
      }
      */
      /* SQL query for manual input
      UPDATE oc_product_description d, oc_url_alias u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'product_id=%' AND d.product_id = REPLACE(u.query, 'product_id=', '');
      UPDATE oc_product_description d, oc_url_alias u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'product_id=%' AND d.product_id = REPLACE(u.query, 'product_id=', '') AND d.language_id = u.language_id;
      UPDATE oc_category_description d, oc_url_alias u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'category_id=%' AND d.category_id = REPLACE(u.query, 'category_id=', '');
      UPDATE oc_category_description d, oc_url_alias u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'category_id=%' AND d.category_id = REPLACE(u.query, 'category_id=', '') AND d.language_id = u.language_id;
      UPDATE oc_information_description d, oc_url_alias u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'information_id=%' AND d.information_id = REPLACE(u.query, 'information_id=', '');
      UPDATE oc_information_description d, oc_url_alias u SET d.seo_keyword = u.keyword WHERE u.query LIKE 'information_id=%' AND d.information_id = REPLACE(u.query, 'information_id=', '') AND d.language_id = u.language_id;
      */
      /* now handled by previous requests in pure sql
      $rows = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->url_alias . " WHERE query LIKE 'information_id=%' OR query LIKE 'product_id=%' OR query LIKE 'category_id=%'")->rows;
      
      foreach($rows as $row) {
        list($field, $id) = explode('=', $row['query']);
        
        $table = str_replace('_id', '', $field);
        
        $this->db->query("UPDATE " . DB_PREFIX . $table . "_description SET seo_keyword = '" . $this->db->escape($row['keyword']) . "' WHERE " .$field ." = '".$id."'");
        //echo "UPDATE " . DB_PREFIX . $table . "_description SET seo_keyword = '" . $this->db->escape($row['keyword']) . "' WHERE " .$field ." = '".$id."'". "<br/>";
      }
      */
      end:
      $data['upgrade_complete'] = true;
    }
    
    $this->document->setTitle('SEO Package Upgrade Tool');
    
    $data['upgrade'] = true;
    
    $data['action'] = $this->url->link('module/complete_seo/upgrade', $this->token, 'SSL');
    $data['cancel'] = $this->url->link('module/complete_seo', $this->token, 'SSL');
    
    if (version_compare(VERSION, '2', '>=')) {
      $data['header'] = $this->load->controller('common/header');
      $data['column_left'] = $this->load->controller('common/column_left');
      $data['footer'] = $this->load->controller('common/footer');
      
      if (version_compare(VERSION, '3', '>=')) {
        $this->config->set('template_engine', 'template');
        $this->response->setOutput($this->load->view('module/complete_seo', $data));
      } else {
        $this->response->setOutput($this->load->view('module/complete_seo.tpl', $data));
      }
    } else {
      $data['column_left'] = '';
      $this->data = &$data;
      $this->template = 'module/complete_seo.tpl';
      $this->children = array(
        'common/header',
        'common/footer'
      );

      // fix OC 1.5
      $this->response->setOutput(str_replace(array('view/javascript/jquery/jquery-1.6.1.min.js', 'view/javascript/jquery/jquery-1.7.1.min.js', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'), $asset_path . 'jquery.min.js', $this->render()));
    }
    
  }
  
  public function category_autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
//disable admin_save_and_keep_editing.xml