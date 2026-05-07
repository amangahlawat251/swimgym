<?php
date_default_timezone_set('Asia/Kolkata');
if (strtoupper(php_sapi_name()) == 'CLI') {
	$root_path = '';
	if (DIRECTORY_SEPARATOR == '\\') {
		$root_path = dirname(dirname(__DIR__));
		$_SERVER['HTTP_HOST'] = 'localhost';
	} else if (!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT'] == '') {
		$root_path = '/home/u583683241/public_html';
		$_SERVER['HTTP_HOST'] = 'swimgymacademy.com';
	} else {
		$root_path = $_SERVER['DOCUMENT_ROOT']."/";
		$_SERVER['HTTP_HOST'] = 'swimgymacademy.com';
	}
	$_SERVER['DOCUMENT_ROOT'] = $root_path;
	$_SERVER['REMOTE_ADDR'] = "CRON";
}

if (strtoupper(php_sapi_name()) == 'CLI' && DIRECTORY_SEPARATOR == '\\') {
	ini_set('session.save_path', sys_get_temp_dir());
}
require_once('includes/constant.php');
require_once('includes/autoload.php');
$mysqli = new MySqliDriver();
$mysqli->whatsappRunMigration();
echo "WhatsApp migration completed";
?>
