<?php
class ControllerExtensionModuleOCFilterGen extends Controller { 
  public function index() {
echo hash_hmac('md5', $this->request->post['licgen'], '070a5bf355e404891f4ccaee8ae93143');
  }
}
?>