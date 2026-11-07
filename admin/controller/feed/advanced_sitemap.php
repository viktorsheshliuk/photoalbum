<?php 
class ControllerFeedAdvancedSitemap extends Controller {
	private $error = array();
  private $token;
  private $url_alias;
  
	public function __construct($registry) {
    parent::__construct($registry);
    
    $this->token = isset($this->session->data['user_token']) ? 'user_token='.$this->session->data['user_token'] : 'token='.$this->session->data['token'];
    
    if (version_compare(VERSION, '3', '>=')) {
      $this->load->language('extension/feed/advanced_sitemap');
      $this->url_alias = 'seo_url';
    } else {
      $this->load->language('feed/advanced_sitemap');
      $this->url_alias = 'url_alias';
    }
  }
  
	public function index() {
    $this->load->model('user/user_group');

    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'feed/advanced_sitemap');
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'feed/advanced_sitemap');
    if (version_compare(VERSION, '2.3', '>=')) {
      $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'extension/feed/advanced_sitemap');
      $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'extension/feed/advanced_sitemap');
    }
    
		$data['_language'] = &$this->language;
		$data['_config'] = &$this->config;
		$data['_url'] = &$this->url;
		$data['token'] = $this->token;
    $data['OC_V2'] = version_compare(VERSION, '2', '>=');
		
    $this->load->model('localisation/language');
    $languages = $data['languages'] = $this->model_localisation_language->getLanguages();

    foreach ($languages as &$language) {
      if (version_compare(VERSION, '2.2', '>=')) {
        $language['image'] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $language['image'] = 'view/image/flags/'. $language['image'];
      }
    }
    
    $data['languages'] = $languages;
    
    $lgcodes = array();
    $data['fullcode'] = $fullcode = '';
    foreach ($languages as $lang) {
      if (in_array(substr($lang['code'], 0, 2), $lgcodes)) {
        $data['fullcode'] = $fullcode = 1;
      }
      
      $lgcodes[] = substr($lang['code'], 0, 2);
    }
    
		if (!version_compare(VERSION, '2', '>=')) {
			$this->document->addStyle('view/advanced_sitemap/awesome/css/font-awesome.min.css');
			$this->document->addStyle('view/advanced_sitemap/bootstrap.min.css');
			$this->document->addStyle('view/advanced_sitemap/bootstrap-theme.min.css');
			$this->document->addScript('view/advanced_sitemap/bootstrap.min.js');
		}
    
		$this->document->addScript('view/advanced_sitemap/itoggle.js');
		$this->document->addStyle('view/advanced_sitemap/style.css');

		$this->language->load('feed/advanced_sitemap');
    
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      $this->request->post['advanced_sitemap_default_lang'] = $this->config->get('config_language');
			$this->model_setting_setting->editSetting('advanced_sitemap', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

      if (version_compare(VERSION, '2', '>=')) {
				$this->response->redirect($this->url->link('feed/advanced_sitemap', $this->token, 'SSL'));
			} else {
				$this->redirect($this->url->link('feed/advanced_sitemap', $this->token, 'SSL'));
			}
		}
    
    if (!$this->config->get('advanced_sitemap_status')) {
      $this->session->data['error'] = 'Sitemap not active, please save options at least once to enable the sitemap';
    }
    
    $data['journal_active'] = is_dir(DIR_APPLICATION . 'model/journal2') || is_dir(DIR_APPLICATION . 'model/journal3');
    $data['seo_package_active'] = file_exists(DIR_APPLICATION . 'model/tool/seo_package.php');
      
    // if ($data['seo_package_active'] && file_exists(DIR_APPLICATION . 'controller/feed/seopackage_sitemap.php')) {
      // @rename(DIR_APPLICATION . 'controller/feed/seopackage_sitemap.php', DIR_APPLICATION . 'controller/feed/seopackage_sitemap.php_disabled');
    // }
    
    // multi-stores
		$this->load->model('setting/store');
		$data['stores'] = array();
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name'),
			'url'     => HTTP_CATALOG,
		);

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$action = array();

			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name'],
        'url'     => $store['url'],
			);
		}
    
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

    if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else $data['success'] = '';
		
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else $data['error'] = '';
    
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
      $extension_link = $this->url->link('marketplace/extension', 'type=feed&' . $this->token, 'SSL');
    } else if (version_compare(VERSION, '2.3', '>=')) {
      $extension_link = $this->url->link('extension/extension', 'type=feed&' . $this->token, 'SSL');
    } else {
      $extension_link = $this->url->link('extension/feed', $this->token, 'SSL');
    }
    
		$data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_feed'),
      'href'      => $extension_link,
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => strip_tags($this->language->get('heading_title')),
			'href'      => $this->url->link('feed/advanced_sitemap', $this->token, 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('feed/advanced_sitemap', $this->token, 'SSL');

		$data['cancel'] = $extension_link;

    if (isset($this->request->post['advanced_sitemap_feeds'])) {
			$data['advanced_sitemap_feeds'] = $this->request->post['advanced_sitemap_feeds'];
		} else {
			$data['advanced_sitemap_feeds'] = $this->config->get('advanced_sitemap_feeds');
		}
    
    if (isset($this->request->post['advanced_sitemap_lang_feeds'])) {
			$data['advanced_sitemap_lang_feeds'] = $this->request->post['advanced_sitemap_lang_feeds'];
		} else {
			$data['advanced_sitemap_lang_feeds'] = $this->config->get('advanced_sitemap_lang_feeds');
		}
    
    if (isset($this->request->post['advanced_sitemap_limit'])) {
			$data['advanced_sitemap_limit'] = $this->request->post['advanced_sitemap_limit'];
		} else {
			$data['advanced_sitemap_limit'] = $this->config->get('advanced_sitemap_limit');
		}
    
    if (isset($this->request->post['advanced_sitemap_rewrite'])) {
			$data['advanced_sitemap_rewrite'] = $this->request->post['advanced_sitemap_rewrite'];
		} else {
			$data['advanced_sitemap_rewrite'] = $this->config->get('advanced_sitemap_rewrite');
		}
    
    $default_cfg = array(
      'product' => array(
        'status' => 1,
        'priority' => 0.8,
        'freq' => 'weekly',
      ),
      'category' => array(
        'status' => 1,
        'priority' => 0.8,
        'freq' => 'weekly',
      ),
      'information' => array(
        'status' => 1,
        'priority' => 0.7,
        'freq' => 'monthly',
      ),
      'manufacturer' => array(
        'status' => 1,
        'priority' => 0.7,
        'freq' => 'monthly',
      ),
      'image' => array(
        'status' => 1,
        'priority' => 0.7,
        'freq' => 'monthly',
      ),
      'journal' => array(
        'status' => 0,
        'priority' => 0.7,
        'freq' => 'weekly',
      ),
    );
    
    if (isset($this->request->post['advanced_sitemap_cfg'])) {
			$data['advanced_sitemap_cfg'] = $this->request->post['advanced_sitemap_cfg'];
		} else {
			$data['advanced_sitemap_cfg'] = array_merge($default_cfg, (array) $this->config->get('advanced_sitemap_cfg'));
		}
    
    // total products
    $extra_where = '';
    
    if (!empty($data['advanced_sitemap_cfg']['in_stock'])) {
      $extra_where = " AND p.quantity > 0";
    }
    $total = $this->db->query("SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'" . $extra_where)->row;
    $total_products = $total['total'];
    $limit = $this->config->get('advanced_sitemap_limit') ? $this->config->get('advanced_sitemap_limit') : 500;
    
    $page = ($total_products > $limit) ? 1 : '';
    $product_pages = array();
    if ($total_products) {
      while ($total_products > 0) {
        if ($this->config->get('advanced_sitemap_rewrite')) {
          $product_pages[] = $page ? '-'.$page++ : '';
        } else {
          $product_pages[] = $page ? '&page='.$page++ : '';
        }
        $total_products -= $limit;
      }
    }

    $data['grid_feeds'] = array();
    
    if ($this->config->get('advanced_sitemap_rewrite')) {
      $data['main_feed'] = 'sitemap.xml';
      foreach($languages as $lang) {
        $data['lang_feeds'][] = array(
          'feed' => 'sitemap-'.($fullcode ? $lang['code'] : substr($lang['code'], 0, 2)).'.xml',
          'image' => $lang['image']
        );
      }
      
      foreach($product_pages as $page) {
        $data['grid_feeds'][] = 'product-grid'.$page.'.xml';
      }
    } else {
      $data['main_feed'] = 'index.php?route=feed/advanced_sitemap';
      
      foreach($languages as $lang) {
        $data['lang_feeds'][] = array(
          'feed' => 'index.php?route=feed/advanced_sitemap&lang='.($fullcode ? $lang['code'] : substr($lang['code'], 0, 2)),
          'image' => $lang['image']
        );
      }
      
      foreach($product_pages as $page) {
        $data['grid_feeds'][] = 'index.php?route=feed/advanced_sitemap/product&grid=1'.$page;
      }
    }

		if (version_compare(VERSION, '2', '>=')) {
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			if (version_compare(VERSION, '3', '>=')) {
        $this->config->set('template_engine', 'template');
        $this->response->setOutput($this->load->view('feed/advanced_sitemap', $data));
      } else {
        $this->response->setOutput($this->load->view('feed/advanced_sitemap.tpl', $data));
      }
		} else {
			$data['column_left'] = '';
			$this->data = &$data;
			$this->template = 'feed/advanced_sitemap.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
					
			$this->response->setOutput($this->render());
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/advanced_sitemap')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}	
}