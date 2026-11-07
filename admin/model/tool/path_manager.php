<?php
if (isset($vqmod)) {
	require_once($vqmod->modCheck(DIR_SYSTEM.'../catalog/model/tool/path_manager.php'));
} else if (class_exists('VQMod')) {
	require_once(VQMod::modCheck(DIR_SYSTEM.'../catalog/model/tool/path_manager.php'));
} else {
	require_once(DIR_SYSTEM.'../catalog/model/tool/path_manager.php');
}