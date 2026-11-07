<?php  
class ControllerInformationUniGallery extends Controller {

	public function index() {
		$uniset = $this->config->get('config_unishop2');
		$language_id = $this->config->get('config_language_id');
	
		$this->load->model('extension/module/uni_gallery');
		$this->load->model('tool/image');
		
		$this->load->language('extension/module/uni_gallery');
		
		$data['text_limit'] = $this->language->get('text_limit');

		$this->document->addStyle('catalog/view/theme/unishop2/stylesheet/gallery.css');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		
		$data['shop_name'] = $this->config->get('config_name');
		
		$route = isset($this->request->get['route']) ? $this->request->get['route'] : '';
		$menu_schema = isset($uniset['menu_schema']) ? $uniset['menu_schema'] : [];
		$data['menu_expanded'] = ($uniset['menu_type'] == 1 && in_array($route, $menu_schema)) ? true : false;
		
		$setting = $this->config->get('uni_gallery');
		
		$data['breadcrumbs'] = [];

   		$data['breadcrumbs'][] = [
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
   		];

   		$data['breadcrumbs'][] = [
       		'text'      => isset($setting['name'][$language_id]) ? $setting['name'][$language_id] : $this->language->get('heading_title'),
			'href'      => $this->url->link('information/uni_gallery'),
   		];
		
		$data['images'] = [];
		$data['gallerys'] = [];
		
		$gallery_id = isset($this->request->get['gallery_id']) ? $this->request->get['gallery_id'] : 0;
		
		if($gallery_id) {

			$gallery_info = $this->model_extension_module_uni_gallery->getGallery($gallery_id);
			
			if($gallery_info) {
				$this->document->setTitle($gallery_info['name']);
				$this->document->setDescription($gallery_info['meta_description']);
				$this->document->setKeywords($gallery_info['meta_keyword']);
				
				$data['heading_title'] = $gallery_info['name'];
			
				$data['breadcrumbs'][] = array(
					'text'      => $gallery_info['name'],
					'href'      => $this->url->link('information/uni_gallery&gallery='.$gallery_id),
				);
				
				$data['description'] = html_entity_decode($gallery_info['description'], ENT_QUOTES, 'UTF-8');
				
				$url = '';
		
				if (isset($this->request->get['sort'])) {
					$sort = $this->request->get['sort'];
				} else {
					$sort = 'g.sort_order';
				}

				if (isset($this->request->get['order'])) {
					$order = $this->request->get['order'];
				} else {
					$order = 'DESC';
				}
				
				if (isset($this->request->get['page'])) {
					$page = (int)$this->request->get['page'];
				} else {
					$page = 1;
				}
				
				if (isset($this->request->get['limit']) && (int)$this->request->get['limit'] > 0) {
					$limit = (int)$this->request->get['limit'];
				} else { 
					$limit = $this->config->get('theme_'.$this->config->get('config_theme').'_product_limit');
			
					if(isset($uniset['catalog']['limit']['status'])) {
						$new_limit = explode(',', $uniset['catalog']['limit']['value']);
	
						$limit = $new_limit[0] ? (int)$new_limit[0] : $limit;
					}
				}
				
				$limit = 300;
				
				$filter_data = [
					'gallery_id' => $gallery_id,
					'start'      => 0,
					'limit'      => $limit
				];
				
				$results = $this->model_extension_module_uni_gallery->getGalleryImages($filter_data);
			
				$results_total = $this->model_extension_module_uni_gallery->getGalleryImagesTotal($gallery_id);
		
				foreach ($results as $result) {
					if (file_exists(DIR_IMAGE . $result['image'])) {
						$data['images'][] = [
							'title' => $result['title'],
							'link'  => $result['link'],
							'image' => $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']),
							'popup' => $this->model_tool_image->resize($result['image'], $setting['image_popup_width'], $setting['image_popup_height'])
						];
					}
				}
				
				$data['limits'] = [];
				
				if(isset($uniset['catalog']['limit']['status'])) {
					$new_limits = array_unique(explode(',', $uniset['catalog']['limit']['value']));

					$limits = $new_limits ? $new_limits : $limits;
				} else {
					$limits = array_unique(array($this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));
				}				

				sort($limits);

				foreach($limits as $value) {
					$data['limits'][] = [
						'text'  => $value,
						'value' => $value,
						'href'  => $this->url->link('information/uni_gallery', 'gallery_id='.$gallery_id.'&limit='.$value)
					];
				}
				
				$url = '';

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . (int)$this->request->get['limit'];
				}
				
				$data['sorts'] = [];
				
				$data['sorts'][] = [
					'text'  => $this->language->get('text_default'),
					'value' => 'n.date_added-DESC',
					'href' 	=> $this->url->link('information/uni_gallery', 'gallery_id=' . $gallery_id . '&sort=n.date_added&order=DESC' . $url)
				];
			
				$data['sorts'][] = [
					'text'  => $this->language->get('text_date_desc'),
					'value' => 'n.date_added-DESC',
					'href' 	=> $this->url->link('information/uni_gallery', 'gallery_id=' . $gallery_id . '&sort=n.date_added&order=DESC' . $url)
				];

				$data['sorts'][] = [
					'text'  => $this->language->get('text_date_asc'),
					'value' => 'n.date_added-ASC',
					'href' 	=> $this->url->link('information/uni_gallery', 'gallery_id=' . $gallery_id . '&sort=n.date_added&order=ASC' . $url)
				];

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}
			
				$data['limit'] = $limit;
			
				$pagination = new Pagination();
				$pagination->total = $results_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('information/uni_gallery', 'gallery_id=' . $gallery_id . $url . '&page={page}', true);

				$data['pagination'] = $pagination->render();

				$data['results'] = sprintf($this->language->get('text_pagination'), ($results_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($results_total - $limit)) ? $results_total : ((($page - 1) * $limit) + $limit), $results_total, ceil($results_total / $limit));
			}
		} else {
			$this->document->setTitle(isset($setting['name'][$language_id]) ? $setting['name'][$language_id] : $this->language->get('heading_title'));
			$this->document->setDescription(isset($setting['meta_description'][$language_id]) ? $setting['meta_description'][$language_id] : '');
			$this->document->setKeywords(isset($setting['meta_keyword'][$language_id]) ? $setting['meta_keyword'][$language_id] : '');
				
			$data['heading_title'] = isset($setting['name'][$language_id]) ? $setting['name'][$language_id] : $this->language->get('heading_title');
			
			$data['description'] = html_entity_decode((isset($setting['description'][$language_id]) ? $setting['description'][$language_id] : ''), ENT_QUOTES, 'UTF-8');
			
			$gallerys = $this->model_extension_module_uni_gallery->getGallerys();
		
			if($gallerys) {
				foreach ($gallerys as $gallery) {
					$images = [];
					
					$filter_data = [
						'gallery_id' => $gallery['gallery_id'],
						'start'		 => 0,
						'limit'		 => 5
					];
		
					$results = $this->model_extension_module_uni_gallery->getGalleryImages($filter_data);
		
					$results_total = $this->model_extension_module_uni_gallery->getGalleryImagesTotal($gallery['gallery_id']);
					
					foreach ($results as $result) {
						if (file_exists(DIR_IMAGE . $result['image'])) {
							$images[] = [
								'title' => $result['title'],
								'link'  => $result['link'],
								'image' => $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']),
								'popup' => $this->model_tool_image->resize($result['image'], $setting['image_popup_width'], $setting['image_popup_height'])
							];
						}
					}
		
					$data['gallerys'][] = [
						'gallery_id'=> $gallery['gallery_id'],
						'name' 		=> $gallery['name'],
						'images'    => $images,
						'show_more'	=> $results_total > $filter_data['limit'] ? true : false,
						'href'		=> $this->url->link('information/uni_gallery', 'gallery_id='.$gallery['gallery_id'], true)
					];
				}
			}
		}
		
		if($data['images'] || $data['gallerys']) {
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			$this->response->setOutput($this->load->view('information/uni_gallery', $data));
		} else {
			$this->document->setTitle($this->language->get('text_error'));
			$data['heading_title'] = $this->language->get('text_error');
			$data['text_error'] = $this->language->get('text_error');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['continue'] = $this->url->link('common/home');
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}
?>