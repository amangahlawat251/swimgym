<?php
if (!isset($tab)) {
	$tab = $_POST['tab'];
}
$log = array();
//echo $tab;
//print_r($_POST); exit;
$record_id = '';
$logid = $mysqli->Resquest_Response_log("", strtoupper($tab), '', json_encode($_POST), '');
extract($_POST);
if (!isset($_SESSION)) {
	session_start();
}

$mysqli->autocommit(TRUE);

if ($tab != 'login' && $tab != 'sign_up' &&  $tab != 'forgot_password' &&  $tab != 'verify_payment' &&  $tab != 'verify_email' && $tab != 'view_access_ip' &&  $tab != 'verify_contact') {
	require_once('check_session.php');
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


if ($tab == 'login') {
	$RecTimeStamp = $mysqli->RecTimeStamp("Y-m-d H:i:s");
	
		$obj_login = new login();
			$response = $obj_login->userLogin($user_email, $password, '');
	
		$record_id = $user_email;

}else if ($tab == 'new_family_id') {
			$RecTimeStamp = $mysqli->RecTimeStamp("Y-m-d H:i:s");
			$family_id = $mysqli->generate_family_id();
			$family_id = $familyTitle.'-'.$family_id;
			$sql = "INSERT INTO " . FAMILY_ID . " SET family_id = '" . $family_id . "', created_on = '" . $RecTimeStamp . "'";
			$log['sql'] = $sql;
			$res = $mysqli->executeQry($sql);
			$last_id = $mysqli->insert_id();
			if ($res > 0) {
				$response['msg_code'] = "00";
				$response['msg'] = "Family ID Generated.";
			
			} else {
				$response['msg'] = "05";
				$response['msg'] = "Unable to generate family id at this time.";
			}
}else if($tab == "get_base_price"){

	 $sql= "SELECT * from ".PLANS." WHERE id = '".$id."'";
	$result = $mysqli->executeQry($sql);
	$row = $mysqli->fetch_assoc($result);
	 extract($row); 

		$response['msg'] = "00";
		$response['price'] = $price;
	
}else if($tab == "get_existing_family_details"){

	 $sql= "SELECT * from ".MEMBERS." WHERE member_id = '".$id."' and family_head = '1'";
	$result = $mysqli->executeQry($sql);
	$row = $mysqli->fetch_assoc($result);
	if($row){
	 extract($row); 
		$plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$plan_id.'"');
		$response['msg_code'] = "00";
		$response['price'] = $plan_details['price'];
		$response['plan_id'] = $plan_id;
		$response['gender'] = $gender;
		$response['timing'] = $timing;
		$response['payment_mode'] = $payment_mode;
		$response['discounted_price'] = $discounted_price;
		$response['email'] = $email;
		$response['mobile'] = $mobile;
		$response['address'] = $address;
		$response['joining_date'] = $joining_date;
		$response['head'] = $family_head;
	}else{
		$response['msg_code'] = "008";
	}
}else if ($tab == 'add_members') {
	//print_r($_POST);exit;
	$plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$plans.'"');
	$total_days = $plan_details['duration'] - 1;
	$plan_con = '+'.$total_days.' days';
	$end_date = date('Y-m-d', strtotime($user_doj . $plan_con));
	$sportsperson = 0;
	if (isset($image) && $image !='') {
	$uploadsDir = "uploads/profile/";
	$image_parts = explode(";base64,", $image);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = $image_type_aux[1];

	$image_base64 = base64_decode($image_parts[1]);
	$fileName = uniqid() . '.png';
	$file = $uploadsDir . $fileName;
	file_put_contents($file, $image_base64);
	}else{
		$fileName = $picture;
	}
	
	if (isset($edit_id) && $edit_id !='') {
				if ($type == 'Single' || ($type == 'Family' && $family_head == '1')) {
					$paid_amount = ", discounted_price = '" . $paid . "'";
				}else{
					$paid_amount = "";
				}
			   $sql = "UPDATE " . MEMBERS . " SET membership_type = '".$type."', plan_id = '" . $plans . "', name = '" . $user_name . "' , email = '" . $user_email . "', mobile= '" . $user_contact . "', gender= '" . $gender . "', timing= '" . $timing . "' , age= '" . $age . "' , address = '" . $user_address . "', location = '" . $location . "', joining_date = '" . $user_doj . "', start_date = '" . $user_doj . "', end_date = '" . $end_date . "', picture = '" . $fileName . "', payment_mode = '" . $mode . "', payment_status = 'Paid' ".$paid_amount.", sportsperson = '".$sportsperson."' WHERE id = " . $edit_id;
			$res = $mysqli->executeQry($sql);
			if ($res > 0) {
					if ($type == 'Single' || ($type == 'Family' && $family_head == '1')) {
					$sql_u = "UPDATE " . REVENUE . " SET  amount_received = '" . $paid . "' WHERE start_date = '" . $user_doj . "'";
					$res = $mysqli->executeQry($sql_u);
				}

				if (isset($family_id) && $family_id !='' && $family_head == '1') {
			 	 $family_details = $mysqli->singleRowAssoc_new('*', MEMBERS, 'member_id = "'.$family_id.'"');
				 $sql_new = "UPDATE " . MEMBERS . " SET membership_type = '".$type."', plan_id = '" . $plans . "', address = '" . $user_address . "', location = '" . $location . "', payment_mode = '" . $mode . "', payment_status = 'Paid', discounted_price = '" . $paid . "' WHERE family_head != '1' AND member_id = '" . $family_id."'";
				$res1 = $mysqli->executeQry($sql_new);
				}
			
				$response['msg_code'] = "00";
				$response['msg'] = "Successfully updated";    
				$response['redirect'] = "index.php?".$mysqli->encode("stat=users");
			} else {
				$response['msg_code'] = "05";
				$response['msg'] = "unable to update  at this time, contact to webmaster.";
			} 
		} else {
		    
			if (isset($family_id) && $family_id !='') {
			 	$family_details = $mysqli->singleRowAssoc_new('*', MEMBERS, 'member_id = "'.$family_id.'"');
				if(!empty($family_details)){
					$family_head = ', family_head = "0"';
					$send_em = 0;
				}else{
					$family_head = ', family_head = "1"';
					$send_em = 1;
				}
				$member_id = $family_id;
			}else{
			$member_id = $mysqli->generate_membership_id();
			$family_head = '';
			$send_em = 1;
			}
			
			 $sql = "INSERT INTO " . MEMBERS . " SET membership_type = '".$type."', plan_id = '" . $plans . "',  member_id = '" . $member_id . "', name = '" . $user_name . "' , email = '" . $user_email . "', mobile= '" . $user_contact . "', gender= '" . $gender . "', timing= '" . $timing . "' , age= '" . $age . "' , address = '" . $user_address . "', location = '" . $location . "', joining_date = '" . $user_doj . "', start_date = '" . $user_doj . "', end_date = '" . $end_date . "', picture = '" . $fileName . "', payment_mode = '" . $mode . "', payment_status = 'Paid', discounted_price = '" . $paid . "', status = 'Active', sportsperson = '".$sportsperson."' ".$family_head.", created_on = '".date('Y-m-d H:i:s')."'";
			$log['sql'] = $sql;
			$res = $mysqli->executeQry($sql);
			$last_id = $mysqli->insert_id();
			if ($res > 0) {
				
			    if($send_em == 1){
					
				
				$sql_u = "INSERT INTO " . REVENUE . " SET member_id = '" . $member_id . "', amount_received = '" . $paid . "' , start_date = '" . $user_doj . "' , end_date = '" . $end_date . "' , received_on = '".date('Y-m-d H:i:s')."'";
				$res = $mysqli->executeQry($sql_u);
				
				$file = $mysqli->generateInvoice($last_id,$type);
				if($file){
				$sql_new = "UPDATE " . MEMBERS . " SET invoice = '".$file."' WHERE id = '" . $last_id."'";
				$res1 = $mysqli->executeQry($sql_new);
				}
				 $plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$plans.'"');
				 $subject = 'Welcome to Swim Gym Academy! Your Membership Details Inside | '.$member_id.'';
				 
						$body = '<p>Hello '.$user_name.',</p>';
						
						$body .= '<p>We are thrilled to welcome you to Swim Gym Academy! We are excited to have you as a member of our community and cant wait to support you on your swimming journey.</p>';
						
						$body .= '<p>Here are the details of your membership plan:</p>';
						
						$body .= '<p><b>Membership ID: '.$member_id.' </b></p>';
						
						$body .= '<p><b>Membership Plan: '.$plan_details['title'].' </b></p>';
						
						$body .= '<p><b>Start Date: '.$user_doj.'</b></p>';
						
						$body .= '<p><b>End Date: '.$end_date.'</b></p>';
						
						$body .= '<p><b>Timings: '.$timing.'</b></p>';
						
						$body .= '<p>Thank you for choosing Swim Gym Academy! We look forward to helping you achieve your swimming goals.</p>';
						
						$body .= '<p style="color:red;"><b>Note:</b> Please note that the swimming pool will be closed on Tuesdays.</p>';


						$body .= '<p>Best Regards,<br/>Swim Gym Academy</p>';
						
						$fromEmail = 'info@swimgymacademy.com';
						$fromName = "Swim Gym Academy";
						 $toEmail = $user_email;
						 $attachmentPath = ABSOLUTE_ROOT_INV.$file;
						
						 $isMail = $mysqli->sendEmails($subject, $body, $attachmentPath, $fromEmail, $fromName, $toEmail,  $toName = '', $bcc = '');
						 
						 
				}
				$apiKey = "11";
				$employeeCode = $last_id;
				$employeeName = $user_name;
				$cardNumber = "Blank";
				$serialNumber = "CUB7235301317";
				$userName = "sgar";
				$userPassword = "Sgar@2024";
				$commandId = 0;
				$bio = $mysqli->addEmployee($apiKey, $employeeCode, $employeeName, $cardNumber, $serialNumber, $userName, $userPassword, $commandId); 
				
				$response['msg_code'] = "00";
				$response['msg'] = "Member successfully added.";
			
			} else {
				$response['msg'] = "05";
				$response['msg'] = "Unable to add at this time.";
			}
		}
}else if ($tab == 'renew_membership') {
			$members = $mysqli->selectQry(MEMBERS,"member_id = '".$member_id."'",'',''); 
			if($members->num_rows>0){
					while($member_details = $mysqli->fetch_assoc($members)){
						$sql_u = "INSERT INTO " . HISTORY . " SET member_id = '" . $member_details['id'] . "', membership_id = '" . $member_id . "', start_date = '" . $member_details['start_date'] . "' ,end_date = '" . $member_details['end_date'] . "' ,plan_id = '" . $member_details['plan_id'] . "' ,amount = '" . $member_details['discounted_price'] . "' ,payment_mode = '" . $member_details['payment_mode'] . "' ,timing = '" . $member_details['timing'] . "' , renewd_on = '".date('Y-m-d H:i:s')."'";
						$res = $mysqli->executeQry($sql_u);	
						if ($res > 0) {
							
							$plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$renew_plans.'"');
							$total_days = $plan_details['duration'] - 1;
							$plan_con = '+'.$total_days.' days';
							$end_date = date('Y-m-d', strtotime($user_doj . $plan_con));
							
							if($member_details['end_date'] > $user_doj){
								// Convert the date strings to DateTime objects
								$endDateObject = new DateTime($member_details['end_date']);
								$userDojObject = new DateTime($user_doj);

								// Calculate the difference between the two dates
								$dateDifference = $endDateObject->diff($userDojObject);

								// Get the number of days from the DateInterval object
								$daysDifference = $dateDifference->days;
								
								$plan_con2 = '+'.$daysDifference.' days';
								$new_expiry_date = date('Y-m-d', strtotime($end_date . $plan_con2));
								
							}else{
								$new_expiry_date = $end_date;
							}
						     $sql12 = "UPDATE " . MEMBERS . " SET  plan_id = '" . $renew_plans . "', joining_date = '" . $user_doj . "', start_date = '" . $user_doj . "', end_date = '" . $new_expiry_date . "', payment_status = 'Paid', discounted_price = '".$paid."', is_freezed = '0', status = 'Active', payment_status = 'Paid' WHERE id = " . $member_details['id'];
							$res12 = $mysqli->executeQry($sql12);	
							
							
							
							if ($member_details['membership_type'] == 'Single' || ($member_details['membership_type'] == 'Family' && $member_details['family_head'] == '1')) { 
							
							$sql_r = "INSERT INTO " . REVENUE . " SET member_id = '" . $member_id . "', amount_received = '" . $paid . "' , start_date = '" . $user_doj . "' , end_date = '" . $new_expiry_date . "' , received_on = '".date('Y-m-d H:i:s')."'";
							$resr = $mysqli->executeQry($sql_r);
							
								$file = $mysqli->generateInvoice($member_details['id'],$member_details['membership_type']);
								if($file){
									$sql_new = "UPDATE " . MEMBERS . " SET invoice = '".$file."' WHERE id = '" . $member_details['id']."'";
									$res1 = $mysqli->executeQry($sql_new);
								}
								$subject = 'Welcome to Swim Gym Academy! Your Membership Details Inside | '.$member_id.'';
				 
								$body = '<p>Hello '.$user_name.',</p>';
								
								$body .= '<p>We are thrilled to welcome you to Swim Gym Academy! We are excited to have you as a member of our community and cant wait to support you on your swimming journey.</p>';
								
								$body .= '<p>Here are the details of your membership plan:</p>';
								
								$body .= '<p><b>Membership ID: '.$member_id.' </b></p>';
								
								$body .= '<p><b>Membership Plan: '.$plan_details['title'].' </b></p>';
								
								$body .= '<p><b>Start Date: '.$user_doj.'</b></p>';
								
								$body .= '<p><b>End Date: '.$new_expiry_date.'</b></p>';
								
								$body .= '<p>Thank you for choosing Swim Gym Academy! We look forward to helping you achieve your swimming goals.</p>';
								
								$body .= '<p style="color:red;"><b>Note:</b> Please note that the swimming pool will be closed on Tuesdays.</p>';


								$body .= '<p>Best Regards,<br/>Swim Gym Academy</p>';
								
								$fromEmail = 'info@swimgymacademy.com';
								$fromName = "Swim Gym Academy";
								 $toEmail = $member_details['email'];
								 $attachmentPath = ABSOLUTE_ROOT_INV.$file;
								 $isMail = $mysqli->sendEmails($subject, $body, $attachmentPath, $fromEmail, $fromName, $toEmail,  $toName = '', $bcc = '');
							}
							 $apiKey = "11";
							$employeeCode = $member_details['id'];
							$employeeName = $user_name;
							$isBlock = "false"; // or "false"
							$serialNumber = "CUB7235301317";
							$userName = "sgar";
							$userPassword = "Sgar@2024";
							$commandId = 0;
							$block = $mysqli->blockUnblockUser($apiKey, $employeeCode, $employeeName, $serialNumber, $isBlock, $userName, $userPassword, $commandId); 
							$response['msg_code'] = "00";
							$response['msg'] = "Membership renewed.";
							$response['redirect'] = "index.php?".$mysqli->encode("stat=users");
						}else {
							$response['msg'] = "05";
							$response['msg'] = "Unable to renew at this time.";
						} 
					}
			}					
			
		
} // Set execution time to 5 minutes

else if ($tab == 'send_email') {
    
    if (!isset($email_body) || trim($email_body) == '') {
        $response['msg'] = "Email body can't be blank.";
    } elseif (strlen($email_body) <= 10) {
        $response['msg'] = "Email body must be more than 30 characters.";
    } else {
        $RecTimeStamp = $mysqli->RecTimeStamp("Y-m-d H:i:s");
        $subject = 'Stay Updated with Swim Gym Academy: Important News and Updates Inside';
        $sql_u = "INSERT INTO " . NOTIFICATIONS . " SET subject = '" . $subject . "', email = '" . $email_body . "', sent_on = '" . $RecTimeStamp . "'";
        $res = $mysqli->executeQry($sql_u);

        $sql = "SELECT * FROM " . MEMBERS . " WHERE (membership_type = 'single' OR (membership_type = 'family' AND family_head = 1))";
        $result = $mysqli->executeQry($sql);

        while ($member_details = $mysqli->fetch_assoc($result)) {
            $body = '<p>Hello ' . $member_details['name'] . ',</p>';
            $body .= $email_body;
            $body .= '<p>Best Regards,<br/>Swim Gym Academy</p>';

            $fromEmail = 'info@swimgymacademy.com';
            $fromName = "Swim Gym Academy";
            $toEmail = $member_details['email'];
            $attachmentPath = '';

            $isMail = $mysqli->sendEmails($subject, $body, $attachmentPath, $fromEmail, $fromName, $toEmail, $toName = '', $bcc = '');

        }

        $response['msg_code'] = "00";
        $response['msg'] = "Notification sent.";
        $response['redirect'] = "index.php?" . $mysqli->encode("stat=messages");
    }
}
else if ($tab == 'add_plans') {
	
	if (isset($edit_id) && $edit_id !='') {
			
			   $sql = "UPDATE " . PLANS . " SET SET title = '".$title."', price = '" . $price . "',  plan_type = '" . $plan_type . "', duration = '" . $duration . "' WHERE id = " . $edit_id;
			$res = $mysqli->executeQry($sql);
			if ($res > 0) {
				
				$response['msg_code'] = "00";
				$response['msg'] = "Plan successfully updated";    
				$response['redirect'] = "index.php?".$mysqli->encode("stat=plans");
			} else {
				$response['msg_code'] = "05";
				$response['msg'] = "unable to update  at this time, contact to webmaster.";
			} 
		} else {
			
			 $sql = "INSERT INTO " . PLANS . " SET title = '".$title."', price = '" . $price . "',  plan_type = '" . $plan_type . "', duration = '" . $duration . "' ";
			$log['sql'] = $sql;
			$res = $mysqli->executeQry($sql);
			$last_id = $mysqli->insert_id();
			if ($res > 0) {
				$response['msg_code'] = "00";
				$response['msg'] = "Plan successfully added.";
				$response['redirect'] = "index.php?".$mysqli->encode("stat=plans");
			
			} else {
				$response['msg'] = "05";
				$response['msg'] = "Unable to add at this time.";
			}
		}
}else if($tab == 'add_declaration'){
		
	$uploadsDir = "uploads/declarations/";
        $allowedFileType = array('jpg', 'jpeg', 'pdf', 'JPG', 'JPEG', 'PDF','png', 'PNG');
        if (!empty($_FILES['dec_file']['name'])) {
           
                // Get files upload path
                $fileName        = $_FILES['dec_file']['name'];
                $tempLocation    = $_FILES['dec_file']['tmp_name'];
                $file_name  = time() .$fileName;
				 
                $fileType        = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $uploadsDir.'/'.$file_name)){
							//$img_path = $mysqli->add_border($targetFilePath,"",$width,$height);
                            $file = $file_name;
					
                        } else {
								$response['msg_code'] = "033";
								$response['msg'] = "Unable to upload attachments at this time.";
								
							}
                 
                } else {
						$response['msg_code'] = "034";
						$response['msg'] =  "file format not supported.";
					}
				

    }
    $sql = "UPDATE " . MEMBERS . " SET  declaration = '".$file."' where id = " . $edit_id;
	$res = $mysqli->executeQry($sql);
	
	$log['query'] = $sql;

	 if ($res > 0) {
		$response['msg_code'] = "00";
		$response['msg'] = "declaration successfully uploaded";
		$response['redirect'] = "index.php?".$mysqli->encode("stat=users");
	} else {
		$response['msg_code'] = "05";
		$response['msg'] = "Unable to upload declaration at this time.Please try again later.";
	} 
	
}else if ($tab == 'freeze_membership') {
	if($freeze <= 15){
	$end_date = $mysqli->singleRowAssoc_new('end_date', MEMBERS, 'id = "'.$edit_id.'"');
	$freeze = $freeze - 1;
	$plan_con = '+'.$freeze.' days';
	$cur_date = date('Y-m-d');
	$new_date = date('Y-m-d', strtotime($end_date['end_date'] . $plan_con));
	$freezed_till = date('Y-m-d', strtotime($cur_date . $plan_con));
	
	 $sql = "UPDATE " . MEMBERS . " SET end_date = '".$new_date."', is_freezed = '1', membership_freezed_till = '".$freezed_till."', membership_freezed_on = '".$cur_date."', freezed_for_days = '".$freeze."' WHERE id = " . $edit_id;
	$res = $mysqli->executeQry($sql);
	if ($res > 0) {
		$response['msg_code'] = "00";
		$response['msg'] = "Membership successfully freezed.";
		$response['redirect'] = "index.php?".$mysqli->encode("stat=users");
	} else {
		$response['msg_code'] = "05";
		$response['msg'] = "unable to freeze at this time, contact to webmaster.";
	} 
	}else{
		$response['msg_code'] = "05";
		$response['msg'] = "Only 15 days are allowed to freeze membership.";
	}
}else if ($tab == 'delete_member') {
	$sql = "DELETE FROM " . MEMBERS . " WHERE id = " . $id . " LIMIT 1";
	$res = $mysqli->executeQry($sql);
	if ($res > 0) {
		$response['msg_code'] = "00";
		$response['msg'] = "Member successfully deleted.";
	} else {
		$response['msg_code'] = "05";
		$response['msg'] = "unable to remove at this time, contact to webmaster.";
	}

	$record_id = $id;
} else if ($tab == 'delete_plans') {
	$sql = "DELETE FROM " . PLANS . " WHERE id = " . $id . " LIMIT 1";
	$res = $mysqli->executeQry($sql);
	if ($res > 0) {
		$response['msg_code'] = "00";
		$response['msg'] = "Plan successfully deleted.";
	} else {
		$response['msg_code'] = "05";
		$response['msg'] = "unable to remove at this time, contact to webmaster.";
	}

	$record_id = $id;
} 
 else {
	$response['msg_code'] = "102";
	$response['msg'] = "Option not found";
}
$mysqli->autocommit(true);
$logid = $mysqli->Resquest_Response_log($logid, '', $response, '', $record_id, $log);
echo json_encode($response);
$log = array();
exit;
