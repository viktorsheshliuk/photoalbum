<?php
class ControllerExtensionModuleUniSlideshowv2 extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/uni_slideshow_v2');
		
		//$this->document->addStyle('view/stylesheet/unishop.css');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/module');
		$this->load->model('localisation/language');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('uni_slideshow_v2', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		];

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/uni_slideshow_v2', 'user_token=' . $this->session->data['user_token'], true)
			];
		} else {
			$data['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/uni_slideshow_v2', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			];
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/uni_slideshow_v2', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/uni_slideshow_v2', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['effect_in'])) {
			$data['effect_in'] = $this->request->post['effect_in'];
		} elseif (!empty($module_info)) {
			$data['effect_in'] = $module_info['effect_in'];
		} else {
			$data['effect_in'] = '';
		}
		
		if (isset($this->request->post['effect_out'])) {
			$data['effect_out'] = $this->request->post['effect_out'];
		} elseif (!empty($module_info)) {
			$data['effect_out'] = $module_info['effect_out'];
		} else {
			$data['effect_out'] = '';
		}
		
		if (isset($this->request->post['delay'])) {
			$data['delay'] = $this->request->post['delay'];
		} elseif (!empty($module_info)) {
			$data['delay'] = $module_info['delay'];
		} else {
			$data['delay'] = 5;
		}
		
		if (isset($this->request->post['max_height_desktop'])) {
			$data['max_height_desktop'] = $this->request->post['max_height_desktop'];
		} elseif (!empty($module_info)) {
			$data['max_height_desktop'] = $module_info['max_height_desktop'];
		} else {
			$data['max_height_desktop'] = 350;
		}
		
		if (isset($this->request->post['max_height_mobile'])) {
			$data['max_height_mobile'] = $this->request->post['max_height_mobile'];
		} elseif (!empty($module_info)) {
			$data['max_height_mobile'] = $module_info['max_height_mobile'];
		} else {
			$data['max_height_mobile'] = 350;
		}
		
		if (isset($this->request->post['hide'])) {
			$data['hide'] = $this->request->post['hide'];
		} elseif (!empty($module_info['hide'])) {
			$data['hide'] = $module_info['hide'];
		} else {
			$data['hide'] = '';
		}
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['slides'])) {
			$slides = $this->request->post['slides'];
		} elseif (!empty($module_info['slides'])) {
			$slides = $module_info['slides'];
		} else {
			$slides = [];
		}
		
		$data['slides'] = [];
		
		foreach($slides as $slide) {
			
			$thumb = [];
			$img = [];
			
			if($slide['image']) {
				foreach($slide['image'] as $key => $img) {
					$thumb[$key] = $this->model_tool_image->resize($img, 100, 100);
				}
			}
			
			$thumb_mobile = [];
			$img = [];
			
			if($slide['image']) {
				foreach($slide['image_mobile'] as $key => $img) {
					$thumb_mobile[$key] = $this->model_tool_image->resize($img, 100, 100);
				}
			}
			
			$data['slides'][] = [
				'image' 			=> $slide['image'],
				'thumb' 			=> $thumb,
				'image_mobile' 		=> $slide['image_mobile'],
				'thumb_mobile' 		=> $thumb_mobile,
				'title' 			=> $slide['title'],
				'text' 				=> $slide['text'],
				'link' 				=> $slide['link'],
				'button'			=> $slide['button'],
				'sort' 				=> $slide['sort'] ? $slide['sort'] : 1,
				'text_over_image'	=> isset($slide['text_over_image']) ? $slide['text_over_image'] : [],
				'text_hide_mobile'	=> isset($slide['text_hide_mobile']) ? $slide['text_hide_mobile'] : [],
			];
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/uni_slideshow_v2', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/uni_slideshow_v2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}