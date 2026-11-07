<?php
class Powercache {

	private static $instance;
	private $file;
	
	public static function getInstance()
	{
		if ( is_null( self::$instance ) )
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
  
	public static function get($file, $key = null) {
		$c = self::getInstance();
			
		if (!isset($c->file[$file])) {
			if (!file_exists(DIR_CACHE . 'pcache.' . $file))
				return null;

			$c->file[$file] = include DIR_CACHE . 'pcache.' . $file;
		}

		if (!$key)
			return $c->file[$file];
		
		if (!is_array($c->file[$file]) || !array_key_exists($key, $c->file[$file]))
			return null;
		return $c->file[$file][$key];
	}

	public static function set($file, $value) {
		file_put_contents(DIR_CACHE . 'pcache.' . $file, "<?php\nreturn " . var_export($value, true) . ";\n", LOCK_EX);
	}
	
	public static function add($file, $key, $value) {
		if (file_exists(DIR_CACHE . 'pcache.' . $file)) {
			$arr = include DIR_CACHE . 'pcache.' . $file;
		} else {
			$arr = array();
		}

	    if (!is_array($arr)) {
	      $arr = array();
	    }
    
		$arr[$key] = $value;
		
		file_put_contents(DIR_CACHE . 'pcache.' . $file, "<?php\nreturn " . var_export($arr, true) . ";\n", LOCK_EX);
	}
	
	public static function remove($file, $key, $val = null) {
		$files = array();
		if (file_exists(DIR_CACHE . 'pcache.' . $file)) {
			$files[] = DIR_CACHE . 'pcache.' . $file;
		} else {
			$glob = glob(DIR_CACHE . 'pcache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $file) . '.*');

			if ($glob) {
				foreach ($glob as $file) {
					if (file_exists($file)) {
						$files[] = $file;
					}
				}
			}
		}
		
		foreach ($files as $file) {
			$arr = include $file;
			$changed = false;
			
			if (!is_null($val)) {
				foreach(array_keys($arr) as $node) {
					if (strpos($node, $key) !== false) {
						$values = explode('_', str_replace($key, '', $node));
						if (in_array($val, $values)) {
							$changed = true;
							unset($arr[$node]);
						}
					}
				}
			} else {
				if (isset($arr[$key])) {
					$changed = true;
					unset($arr[$key]);
				}
			}
			if ($changed) {
				file_put_contents($file, "<?php\nreturn " . var_export($arr, true) . ";\n", LOCK_EX);
			}
		}
	}

	public static function delete($file) {
		if (file_exists(DIR_CACHE . 'pcache.' . $file)) {
			return unlink(DIR_CACHE . 'pcache.' . $file);
		}
		
		$files = glob(DIR_CACHE . 'pcache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $file) . '.*');

		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
}
?>