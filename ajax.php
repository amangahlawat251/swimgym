<?php
session_start();
require_once('backend/includes/constant.php');
require_once('backend/includes/autoload.php');

$mysqli = new MySqliDriver();
$tab  = $_POST['tab'];
$log = array();

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
    echo "<script language='javascript' type='text/javascript'>";
    echo "alert('Request not identified as ajax request');";
    echo "</script>";
    $URL="index.php";
    echo "<script>location.href='$URL'</script>";
}


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script language='javascript' type='text/javascript'>";
    echo "alert('Bad Request method');";
    echo "</script>";
    $URL="index.php";
    echo "<script>location.href='$URL'</script>";
}
extract($_POST);
if ($tab == 'enquire_now') {
			 $sql = "INSERT INTO tbl_enquiry SET name = '" . $name . "', email = '" . $email . "', phone = '" . $phone . "', message = '" . $message . "', recTimestamp = '".date('Y-m-d H:i:s')."'";
			$log['sql'] = $sql;
			$res = $mysqli->executeQry($sql);
			$last_id = $mysqli->insert_id();
			if ($res > 0) {
				$response['msg_code'] = "00";
				$response['msg'] = "Thank you for reaching out! We appreciate your message and will get back to you shortly.";
			
			} else {
				$response['msg'] = "05";
				$response['msg'] = "Error.";
			}
			echo json_encode($response);
}else if ($tab == 'share_feedback') {
			 $sql = "INSERT INTO tbl_feedback SET name = '" . $name . "', message = '" . $message . "', recTimestamp = '".date('Y-m-d H:i:s')."'";
			$log['sql'] = $sql;
			$res = $mysqli->executeQry($sql);
			$last_id = $mysqli->insert_id();
			if ($res > 0) {
				$response['msg_code'] = "00";
				$response['msg'] = "Thank you for your feedback! We appreciate your input and will use it to improve our services.";
			
			} else {
				$response['msg'] = "05";
				$response['msg'] = "Error.";
			}
			echo json_encode($response);
}
else
{
	echo "Invalid option";
}
exit;
?>