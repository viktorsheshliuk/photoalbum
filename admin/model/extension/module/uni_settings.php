<?php
class ModelExtensionModuleUniSettings extends Model
{
    public function getSetting($store_id)
    {
        $query = $this->db->query("show columns FROM `" . DB_PREFIX . "uni_setting` WHERE Field = 'store_id'");
        if (!$query->num_rows) {
            $this->update();
        }
        $query = $this->db->query("SELECT data FROM `" . DB_PREFIX . "uni_setting` WHERE store_id = " . (int) $store_id . "");
        return $query->rows ? json_decode($query->row["data"], true) : [];
    }
    public function setSetting($store_id, $data)
    {
        if ($this->check()) {
            $this->db->query("DELETE FROM `" . DB_PREFIX . "uni_setting` WHERE store_id = '" . (int) $store_id . "'");
            $this->db->query("INSERT INTO `" . DB_PREFIX . "uni_setting` SET store_id = '" . (int) $store_id . "', data = '" . $this->db->escape(json_encode($data, true)) . "'");
            $this->cache->delete("unishop.settings");
            return "success";
        }
        return "error";
    }
    public function deleteSetting()
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "uni_setting");
    }
    public function install()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "uni_setting (`store_id` int(11) NOT NULL, `data` mediumtext NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `upc` `upc` varchar(255) COLLATE 'utf8_general_ci' NOT NULL");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `ean` `ean` varchar(255) COLLATE 'utf8_general_ci' NOT NULL");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `jan` `jan` varchar(255) COLLATE 'utf8_general_ci' NOT NULL");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `isbn` `isbn` varchar(255) COLLATE 'utf8_general_ci' NOT NULL");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `mpn` `mpn` varchar(255) COLLATE 'utf8_general_ci' NOT NULL");
    }
    public function update()
    {
        $this->load->model("setting/store");
        $this->db->query("ALTER TABLE `" . DB_PREFIX . "uni_setting` ADD COLUMN `store_id` int(11) DEFAULT 99 FIRST");
        $results = $this->model_setting_store->getStores();
        $stores = [0];
        foreach ($results as $result) {
            $stores[] = $result["store_id"];
        }
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "uni_setting`");
        if ($query->rows) {
            $data = json_decode($query->row["data"], true);
            $new_data = "";
            foreach ($stores as $store_id) {
                $new_data = $this->db->escape(json_encode($data[(int) $store_id], true));
                $this->db->query("INSERT INTO `" . DB_PREFIX . "uni_setting` SET store_id = '" . (int) $store_id . "', data = '" . $new_data . "'");
            }
        }
    }
    public function getCategories($parent_id = 0, $store_id = 0)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category` c LEFT JOIN `" . DB_PREFIX . "category_description` cd ON (c.category_id = cd.category_id) LEFT JOIN `" . DB_PREFIX . "category_to_store` c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND cd.language_id = '" . (int) $this->config->get("config_language_id") . "' AND c2s.store_id = '" . (int) $store_id . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
        return $query->rows ? $query->rows : [];
    }
    private function check()
    {
        $key = $this->config->get("theme_unishop2_key");
        if ($key && $this->validKey($key)) {
            return true;
        }
    }
    private function validKey($k)
    {
        $k = $this->getKey($k, 1);
        $k_arr = array_slice(explode("||", $k), 0, 2);
        return isset($k_arr[0]) && $k_arr[0] == $this->host() && isset($k_arr[1]) && strtotime("now") < $k_arr[1] ? false : true;
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
}

?>