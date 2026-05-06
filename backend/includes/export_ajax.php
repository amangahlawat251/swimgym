<?php 
//code for log start
if (!isset($tab)) {
  $tab = $_POST['tab'];
}
$log = array();
$record_id = '';
$logid = $mysqli->Resquest_Response_log("", strtoupper($tab), '', json_encode($_POST), '');
//take log fields name(Query) and record id in every function 

//code for log end
extract($_POST);
if (!isset($_SESSION)) {
  session_start();
}

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
  echo "<script language='javascript' type='text/javascript'>";
  echo "alert('Request not identified as ajax request');";
  echo "</script>";
  $URL = "index.php";
  echo "<script>location.href='$URL'</script>";
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "<script language='javascript' type='text/javascript'>";
  echo "alert('Bad Request method');";
  echo "</script>";
  $URL = "index.php";
  echo "<script>location.href='$URL'</script>";
}


$response = array();

  
if ($tab == 'export_member') {
  $data = array();
  $con = '';
 if (!empty($membership_id) || $membership_id != "") {
		$con .= " and member_id = '" . trim($membership_id) . "'";
	}
	if (!empty($search_user_name) || $search_user_name != "") {
		$con .= " and name like '%" . trim($search_user_name) . "%'";
	}

	if (!empty($search_user_email) || $search_user_email != "") {
		$con .= " and email = '" . trim($search_user_email) . "'";
	}

	if (!empty($search_user_contact) || $search_user_contact != "") {
		$con .= " and mobile = '" . trim($search_user_contact) . "'";
	}
	if (!empty($search_status) || $search_status != "") {
		$con .= " and status = '" . trim($search_status) . "'";
	}
	if (!empty($plan_type) || $plan_type != "") {
		$con .= " and plan_id IN (" . $plan_type . ")";
	}
 $sql = "select * from ".MEMBERS." where 1 ".$con." order by id ASC";
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".MEMBERS." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];

  $header = 0;
  $i = 1;
  $files = glob(ABSOLUTE_ROOT_PATH . '/export/*'); // get all file names
  foreach ($files as $file) { // iterate files
    if (is_file($file)) {
      @unlink($file); // delete file
    }
  }
    $file_title = 'export/member_export_' . time() . '.csv';
    $file_path = ABSOLUTE_ROOT_PATH . "/" . $file_title;
   $fp = fopen($file_path, 'w+');
  while ($arr = $mysqli->fetch_array($result)) {
	extract($arr);
	$plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$plan_id.'"');
      $data_pass = array(
            'Id' => $id,
            'Member_id' => $member_id,
            'Name' => $name,
            'Plan' => $plan_details['title'],
            'Timing' => $timing,
            'Start_date' => $start_date,
            'End_date' => $end_date,
            'Status' => $status,
        );

        if ($header == 0) {
            $head = array_keys((array) $data_pass);
            fputcsv($fp, $head);
            $header = 1;
        }

        $val123 = array_values((array) $data_pass);
        fputcsv($fp, $val123);
	$i++;
}
		  fclose($fp);
			// Set headers to download the file
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
			header('Pragma: no-cache');
			
		  $response['msg_code'] = '00';
		  $response['msg'] = 'members export successfull';
		  $response['redirect'] = 'export/' . basename($file_title);
		  echo json_encode($response);
		  exit;
}
if ($tab == 'export_attendance') {
  $data = array();
  $con = '';
 if (!empty($membership_id) || $membership_id != "") {
		$con .= " and member_id = '" . trim($membership_id) . "'";
	}
	if (!empty($att_date) || $att_date != "") {
		$con .= " and attendance_date = '" . trim($att_date) . "'";
	}else{
		$att_date = date('Y-m-d');
	$con .="and attendance_date = '".$att_date."'";
	}
  $sql = "select * from ".ATTENDANCE." where 1 ".$con."  ORDER BY attendance_date DESC, sign_in DESC";
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".ATTENDANCE." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];

  $header = 0;
  $i = 1;
  $files = glob(ABSOLUTE_ROOT_PATH . '/export/*'); // get all file names
  foreach ($files as $file) { // iterate files
    if (is_file($file)) {
      @unlink($file); // delete file
    }
  }
    $file_title = 'export/attendance_export' . time() . '.csv';
    $file_path = ABSOLUTE_ROOT_PATH . "/" . $file_title;
   $fp = fopen($file_path, 'w+');
  while ($arr = $mysqli->fetch_array($result)) {
	extract($arr);
	$member_details = $mysqli->singleRowAssoc_new('*', MEMBERS, 'id = "'.$user_id.'" and member_id = "'.$member_id.'"');
	if($sign_out == '00:00:00'){
						$sign_out = 'Not Punched Out';
					}else{
						$sign_out = $mysqli->formatdate($sign_out,"h:i:s A");
					}
      $data_pass = array(
            'Member_id' => $member_details['member_id'],
            'Name' => $member_details['name'],
            'Attendance_Date' => $attendance_date,
            'Sign_In' => $mysqli->formatdate($sign_in,"h:i:s A"),
            'Sign_Out' => $sign_out,
        );

        if ($header == 0) {
            $head = array_keys((array) $data_pass);
            fputcsv($fp, $head);
            $header = 1;
        }

        $val123 = array_values((array) $data_pass);
        fputcsv($fp, $val123);
	$i++;
}
		  fclose($fp);
			// Set headers to download the file
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
			header('Pragma: no-cache');
			
		  $response['msg_code'] = '00';
		  $response['msg'] = 'attendance export successfull';
		  $response['redirect'] = 'export/' . basename($file_title);
		  echo json_encode($response);
		  exit;
}

?>