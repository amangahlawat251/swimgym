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
function whatsappDiwaliDateByYear($year)
{
	// Main Diwali/Lakshmi Puja dates. Keep this local so daily cron does not depend on an external calendar API.
	$dates = array(
		'2026' => '2026-11-08',
		'2027' => '2027-10-29',
		'2028' => '2028-10-17',
		'2029' => '2029-11-05',
		'2030' => '2030-10-26',
		'2031' => '2031-11-14',
		'2032' => '2032-11-03',
		'2033' => '2033-10-23',
		'2034' => '2034-11-11',
		'2035' => '2035-10-30',
		'2036' => '2036-10-19',
		'2037' => '2037-11-07',
		'2038' => '2038-10-27',
		'2039' => '2039-10-17',
		'2040' => '2040-11-04'
	);
	return isset($dates[$year]) ? $dates[$year] : '';
}

$festival = '';
if (isset($argv[1])) {
	$festival = strtolower(str_replace('festival=', '', $argv[1]));
}

$year = date('Y');
$today = date('m-d');
if ($festival == '' && $today == '01-01') {
	$festival = 'new_year';
}
if ($festival == '' && whatsappDiwaliDateByYear($year) == date('Y-m-d')) {
	$festival = 'diwali';
}

if ($festival != 'diwali' && $festival != 'new_year') {
	echo json_encode(array('queued' => 0, 'sent' => 0, 'msg' => 'No festival matched today. Daily cron can run safely at 9 AM.'));
	exit;
}

$queued = $mysqli->whatsappQueueFestivalMessages($festival, $year);
$sent = $mysqli->whatsappProcessQueue(WHATSAPP_BATCH_SIZE);
echo json_encode(array('festival' => $festival, 'year' => $year, 'queued' => $queued, 'send_result' => $sent));
?>
