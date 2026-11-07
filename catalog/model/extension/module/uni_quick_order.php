<?php
class ModelExtensionModuleUniQuickOrder extends Model {
	private $email = 'quickorder@localhost.com';
	
	public function getAttempts($ip) {
		$email = $this->email;
		
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."customer_login` WHERE email = '".$this->db->escape(mb_strtolower($email))."' AND ip = '".$this->db->escape($ip)."'");

		return $query->row;
	}
	
	public function addAttempt($ip) {
		$email = $this->email;
		
		$query = $this->db->query("SELECT * FROM `".DB_PREFIX."customer_login` WHERE email = '".$this->db->escape(mb_strtolower($email))."' AND ip = '".$this->db->escape($ip)."'");
		
		if (!$query->num_rows) {
			$this->db->query("INSERT INTO `".DB_PREFIX."customer_login` SET email = '".$this->db->escape(mb_strtolower($email))."', ip = '".$this->db->escape($ip)."', total = 1, date_added = '".$this->db->escape(date('Y-m-d H:i:s'))."', date_modified = '".$this->db->escape(date('Y-m-d H:i:s'))."'");
		} else {
			$total = strtotime($query->row['date_modified']) < strtotime('-1 hour') ? 1 : '(total + 1)';
			
			$this->db->query("UPDATE `".DB_PREFIX."customer_login` SET total = ".$total.", date_modified = '".$this->db->escape(date('Y-m-d H:i:s'))."' WHERE customer_login_id = '".(int)$query->row['customer_login_id']."'");
		}
	}
}
?>