<?php
	define("ABSOLUTE_ROOT", ABSOLUTE_ROOT_PATH.'/declarations/');
	define("ABSOLUTE_ROOT_INV", ABSOLUTE_ROOT_PATH.'/invoice/');
	define("ABSOLUTE_ROOT_DOWNLOAD", APPLICATION_URL.'backend/declarations/');
	define("ABSOLUTE_ROOT_INV_DOWNLOAD", APPLICATION_URL.'backend/invoice/');
	//print_r(ABSOLUTE_ROOT_PATH);exit;
	
spl_autoload_register(function ($class_name) {
	if (strpos($class_name, '\\') !== false) {
		return;
	}
	$file =  ABSOLUTE_ROOT_PATH.'includes/classes/'.$class_name . '.php';
    if(file_exists($file))
    require_once($file);
});

?>
