<?php  
class ControllerExtensionModuleUniGallery extends Controller {
	public function index($setting) {
		static $module = 0;
		
		$uniset = $this->config->get('config_unishop2');
		$language_id = $this->config->get('config_language_id');
	
		$this->load->model('extension/module/uni_gallery');
		$this->load->model('tool/image');
		
		$this->load->language('extension/module/uni_gallery');
		
		$data['type_view'] = isset($setting['view_type']) ? 'grid' : 'carousel';

		$this->document->addStyle('catalog/view/theme/unishop2/stylesheet/gallery.css');
		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
		
		$data['images'] = [];
		
		$gallery_id = (int)$setting['gallery_id'];
		
		if($gallery_id) {
			$gallery_info = $this->model_extension_module_uni_gallery->getGallery($gallery_id);
			
			if($gallery_info) {
				
				$gallery_setting = $this->config->get('uni_gallery');
				
				$data['heading_title'] = $gallery_info['name'];
				
				$data['gallery_href'] = $this->url->link('information/uni_gallery', 'gallery_id='.$gallery_id, true);
				
				$filter_data = [
					'gallery_id' => $gallery_id,
					'start'      => 0,
					'limit'      => (int)$setting['limit']
				];
				
				$results = $this->model_extension_module_uni_gallery->getGalleryImages($filter_data);
				
				$results_total = $this->model_extension_module_uni_gallery->getGalleryImagesTotal($gallery_id);
				
				$data['show_more'] = $results_total > $filter_data['limit'] ? true : false;
		
				foreach ($results as $result) {
					if (file_exists(DIR_IMAGE . $result['image'])) {
						$data['images'][] = [
							'title' => $result['title'],
							'link'  => $result['link'],
							'image' => $this->model_tool_image->resize($result['image'], $gallery_setting['image_width'], $gallery_setting['image_height']),
							'popup' => $this->model_tool_image->resize($result['image'], $gallery_setting['image_popup_width'], $gallery_setting['image_popup_height'])
						];
					}
				}
			}
		}
		
		$data['module'] = $module++;

		return $this->load->view('extension/module/uni_gallery', $data);
	}
}
?>