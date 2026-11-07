<?php
class ControllerExtensionModuleUniSettings extends Controller
{
    private $error = [];
    private $status = "";
    private $time_left = "";
    public function index()
    {
        $this->load->model("extension/module/uni_settings");
        $this->load->model("tool/image");
        $this->load->model("localisation/language");
        $this->load->model("setting/store");
        $this->load->model("setting/setting");
        $this->load->model("setting/extension");
        $this->load->model("setting/module");
        $this->load->model("catalog/information");
        $this->load->model("catalog/category");
        $this->load->language("extension/module/uni_settings");
        $this->document->setTitle(strip_tags($this->language->get("heading_title")));
        $data["heading_title"] = $this->language->get("heading_title");
        $this->document->addStyle("view/stylesheet/unishop.css");
        $this->document->addStyle("view/stylesheet/bootstrap-colorpicker.min.css");
        $this->document->addScript("view/javascript/bootstrap-colorpicker.min.js");
        $this->document->addScript("view/javascript/unishop.js");
        if ($this->config->get("config_editor_default")) {
            $this->document->addScript("view/javascript/ckeditor/ckeditor.js");
            $this->document->addScript("view/javascript/ckeditor/ckeditor_init.js");
        } else {
            $this->document->addStyle("view/javascript/summernote/summernote.css");
            $this->document->addScript("view/javascript/summernote/summernote.js");
            $this->document->addScript("view/javascript/summernote/summernote-image-attributes.js");
            $this->document->addScript("view/javascript/summernote/opencart.js");
        }
        $data["ckeditor"] = $this->config->get("config_editor_default");
        $data["languages"] = $this->model_localisation_language->getLanguages();
        $data["error_warning"] = isset($this->error["warning"]) ? $this->error["warning"] : "";
        $data["breadcrumbs"] = [];
        $data["breadcrumbs"][] = ["text" => $this->language->get("text_home"), "href" => $this->url->link("common/home", "user_token=" . $this->session->data["user_token"], true)];
        $data["breadcrumbs"][] = ["text" => $this->language->get("text_module"), "href" => $this->url->link("marketplace/extension", "user_token=" . $this->session->data["user_token"] . "&type=module", true)];
        $data["breadcrumbs"][] = ["text" => $this->language->get("heading_title"), "href" => $this->url->link("extension/module/uni_settings", "user_token=" . $this->session->data["user_token"], true)];
        $data["cancel"] = $this->url->link("marketplace/extension", "user_token=" . $this->session->data["user_token"] . "&type=module", true);
        $data["catalog"] = $this->config->get("config_secure") ? HTTPS_CATALOG : HTTP_CATALOG;
        $data["token"] = "user_token=" . $this->session->data["user_token"];
        $data["placeholder"] = $this->model_tool_image->resize("no_image.png", 100, 100);
        $data["store_id"] = $store_id = isset($this->request->get["store_id"]) ? $this->request->get["store_id"] : 0;
        $store_info = $this->model_setting_setting->getSetting("config", $store_id);
        $data["telephone"] = $store_info ? $store_info["config_telephone"] : $this->config->get("config_telephone");
        $data["set"] = $this->model_extension_module_uni_settings->getSetting($store_id);
        $data["stores"][] = ["store_id" => 0, "name" => $this->config->get("config_name"), "href" => $this->url->link("extension/module/uni_settings", "user_token=" . $this->session->data["user_token"] . "&store_id=0", true)];
        $sort_string = isset($data["set"]["sort_stories"]) ? $data["set"]["sort_stories"] : "id,asc";
        $sort_1 = substr($sort_string, 0, 2) == "id" ? "store_id" : "url";
        $sort_2 = substr($sort_string, -3) == "asc" ? "ASC" : "DESC";
        $stores = $this->model_setting_store->getStores();
        if (1 < count($stores)) {
            foreach ($stores as $key => $value) {
                $sort[$key] = $value[$sort_1];
            }
            if ($sort_2 == "ASC") {
                array_multisort($sort, SORT_ASC, $stores);
            } else {
                array_multisort($sort, SORT_DESC, $stores);
            }
        }
        foreach ($stores as $store) {
            $data["stores"][] = ["store_id" => $store["store_id"], "name" => html_entity_decode($store["name"], ENT_QUOTES, "UTF-8"), "href" => $this->url->link("extension/module/uni_settings", "user_token=" . $this->session->data["user_token"] . "&store_id=" . $store["store_id"], true)];
        }
        $data["modules"] = [];
        $request_modules = ["latest", "special", "featured", "bestseller"];
        $modules = $this->model_setting_extension->getInstalled("module");
        foreach ($modules as $module) {
            $this->load->language("extension/module/" . $module);
            $modules = $this->model_setting_module->getModulesByCode($module);
            foreach ($modules as $module) {
                if (in_array($module["code"], $request_modules)) {
                    $data["modules"][] = ["name" => $this->language->get("heading_title"), "name2" => $module["name"]];
                }
            }
        }
        $data["informations"] = [];
        $filter_data = ["sort" => "name", "order" => "ASC"];
        $infos = $this->model_catalog_information->getInformations($filter_data);
        foreach ($infos as $info) {
            $seo_link = $this->model_catalog_information->getInformationSeoUrls($info["information_id"]);
            $data["informations"][] = ["information_id" => $info["information_id"], "name" => $info["title"], "link" => "index.php?route=information/information&information_id=" . $info["information_id"], "seo_link" => isset($seo_link[$store_id]) ? $seo_link[$store_id] : ""];
        }
        $data["categories"] = [];
        $filter_data = ["sort" => "name", "order" => "ASC"];
        $categories = $this->model_catalog_category->getCategories($filter_data);
        foreach ($categories as $category) {
            $data["categories"][] = ["category_id" => $category["category_id"], "name" => $category["name"]];
        }
        $data["categories2"] = [];
        $categories2 = $this->model_extension_module_uni_settings->getCategories(0, $store_id);
        foreach ($categories2 as $category) {
            $data["categories2"][] = ["category_id" => $category["category_id"], "name" => $category["name"]];
        }
        $data["trial_empty"] = false;
        if (!$this->config->get("theme_unishop2_key")) {
            $this->install();
            $data["trial_empty"] = true;
        }
        $check_key = $this->checkKey();
        $data["show_settings"] = $check_key == "ok" ? true : false;
        $data["trial_end"] = $check_key == "trial_end" ? true : false;
        $data["time_left"] = false;
        $time_left = $this->time_left;
        if ($time_left) {
            $time_left = ceil(($time_left - strtotime("now")) / 3600 / 24);
            $data["time_left"] = 0 < $time_left ? sprintf($this->language->get("text_remain"), $time_left) : "";
        }
        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view("extension/module/uni_settings", $data));
    }
    public function save()
    {
        $this->load->language("extension/module/uni_settings");
        $this->load->model("extension/module/uni_settings");
        $result = "";
        $store_id = isset($this->request->post["store_id"]) ? $this->request->post["store_id"] : 0;
        if ($this->request->server["REQUEST_METHOD"] == "POST" && isset($this->request->post["uni_set"]) && $this->checkKey() == "ok" && $this->permission()) {
            $result = $this->model_extension_module_uni_settings->setSetting($store_id, $this->request->post["uni_set"]);
        }
        $this->response->setOutput($result);
    }
    public function install()
    {
        $this->load->model("extension/module/uni_settings");
        $this->load->model("setting/setting");
        $this->model_extension_module_uni_settings->install();
        $this->model_setting_setting->editSetting("theme_unishop2_key", ["theme_unishop2_key" => ""]);
    }
    public function addTrial()
    {
        $json = [];
        $key = $this->requestKey("trial");
        if ($key && $this->checkKey($key) != "ok") {
            $this->setKey($key);
            $json["success"] = true;
        } else {
            if (!$key) {
                $this->setReserveKey();
                $json["success"] = true;
            }
        }
        $this->response->addHeader("Content-Type: application/json");
        $this->response->setOutput(json_encode($json));
    }
    public function addKey()
    {
        $json = [];
        if ($this->request->server["REQUEST_METHOD"] == "POST" && isset($this->request->post["key"])) {
            $key = trim(strip_tags($this->request->post["key"]));
            if ($key && $this->checkKey($key) != "ok") {
                $this->setKey($key);
                $json["success"] = true;
            }
        }
        $this->checkKey($key);
        $this->response->addHeader("Content-Type: application/json");
        $this->response->setOutput(json_encode($json));
    }
    public function addKey2()
    {
        $json = [];
        $key = $this->requestKey("full");
        if ($key && $this->checkKey($key) != "ok") {
            $this->setKey($key);
            $json["success"] = true;
        }
        $this->response->addHeader("Content-Type: application/json");
        $this->response->setOutput(json_encode($json));
    }
    public function getIconBlock()
    {
        $this->load->language("extension/module/uni_settings");
        $data = [];
        $this->response->setOutput($this->load->view("extension/module/uni_icon_block", $data));
    }
    private function checkKey($key = "")
    {
        $k = $key ? $key : $this->config->get("theme_unishop2_key");
        $k_arr = explode("||", $this->getKey($k, 1));
        if (count($k_arr) == 3) {
            $host = $k_arr[0] == $this->host() ? true : false;
            $date = is_numeric($k_arr[1]) ? $k_arr[1] : false;
            $type = $k_arr[2] == "trial" || $k_arr[2] == "full" ? $k_arr[2] : false;
            if ($host && $type) {
                if (strtotime("now") < $date) {
                    $this->time_left = $type == "trial" ? $date : "";
                    return "ok";
                }
                if ($type == "trial") {
                    return "trial_end";
                }
            }
        }
        if (!$key) {
            $key = $this->requestKey("full");
            if ($key && $this->checkKey($key) != "ok") {
                $this->setKey($key);
                return "ok";
            }
        }
    }
    private function requestKey($type)
    {
        $key = $this->getKey($this->host() . "||" . $type, 0);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://getlic.tk/key.php?key=" . urlencode($key));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result !== false && $result != "" ? trim(strip_tags($result)) : "error";
    }
    private function setKey($key)
    {
        $this->load->model("setting/setting");
        $this->model_setting_setting->editSettingValue("theme_unishop2_key", "theme_unishop2_key", $key);
    }
    private function setReserveKey()
    {
        $key = $this->getKey($this->host() . "||" . strtotime("+7day") . "||trial", 0);
        $this->load->model("setting/setting");
        $this->model_setting_setting->editSettingValue("theme_unishop2_key", "theme_unishop2_key", $key);
    }
    private function host()
    {
        $host = explode("/", $this->config->get("config_secure") ? HTTPS_SERVER : HTTP_SERVER);
        return substr($host[2], 0, 3) == "www" ? substr($host[2], 4, 50) : $host[2];
    }
    private function getKey($t, $f)
    {
        $t = $f ? base64_decode($t) : $t;
        $r = "";
        $k = "56U35e670s";
        while (strlen($r) < strlen($t)) {
            $r .= substr(md5($k . $r), 0, 8);
        }
        return $f ? $t ^ $r : base64_encode($t ^ $r);
    }
    private function permission()
    {
        $this->load->language("extension/module/uni_settings");
        if ($this->user->hasPermission("modify", "extension/module/uni_settings")) {
            return true;
        }
        $this->error["warning"] = $this->language->get("error_permission");
        return false;
    }
}

?>