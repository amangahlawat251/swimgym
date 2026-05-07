<?php
if (!isset($_SESSION)) {
	session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
	header('Location: index.php');
	exit;
}

require_once('includes/constant.php');
require_once('includes/autoload.php');

$file_name = isset($_GET['file']) ? basename($_GET['file']) : '';
if ($file_name == '' || !preg_match('/^Invoice_[0-9]+\.pdf$/', $file_name)) {
	http_response_code(400);
	echo 'Invalid invoice request.';
	exit;
}

$base_path = realpath(ABSOLUTE_ROOT_INV);
$file_path = ABSOLUTE_ROOT_INV.$file_name;
$real_path = realpath($file_path);
if ($base_path === false || $real_path === false || strpos($real_path, $base_path) !== 0 || !is_file($real_path)) {
	http_response_code(404);
	echo 'Invoice not found or already removed.';
	exit;
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="'.$file_name.'"');
header('Content-Length: '.filesize($real_path));
header('Cache-Control: private, no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
readfile($real_path);
@unlink($real_path);
exit;
?>
