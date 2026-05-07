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
} else {
	echo "You can not run this script through browser.";
	exit;
}

if (DIRECTORY_SEPARATOR == '\\') {
	ini_set('session.save_path', sys_get_temp_dir());
}
require_once('includes/constant.php');
require_once('includes/autoload.php');
$mysqli = new MySqliDriver();

$festival = '';
if (isset($argv[1])) {
	$festival = strtolower(str_replace('festival=', '', $argv[1]));
}

$today = date('m-d');
if ($festival == '' && $today == '01-01') {
	$festival = 'new_year';
}

if ($festival != 'diwali' && $festival != 'new_year') {
	echo json_encode(array('queued' => 0, 'sent' => 0, 'msg' => 'No festival matched today. For Diwali, schedule this script on the approved Diwali date with argument festival=diwali.'));
	exit;
}

$year = date('Y');
$queued = $mysqli->whatsappQueueFestivalMessages($festival, $year);
$sent = $mysqli->whatsappProcessQueue(WHATSAPP_BATCH_SIZE);
echo json_encode(array('festival' => $festival, 'year' => $year, 'queued' => $queued, 'send_result' => $sent));
?>
