<?php

date_default_timezone_set('Asia/Kolkata');
$start_time = date('Y-m-d H:i:s');
//if(1)
if(strtoupper(php_sapi_name()) == 'CLI')
{
	$root_path = '';
	if(!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT'] == '')
	{
		$root_path = '/home/u583683241/public_html';
	}else
	{
		$root_path = $_SERVER['DOCUMENT_ROOT']."/";
		$ABSOLUTE_ROOT_PATH = $root_path;
	}
	$_SERVER['DOCUMENT_ROOT'] = $root_path;
	$_SERVER['HTTP_HOST'] = 'swimgymacademy.com';
	$_SERVER['REMOTE_ADDR'] = "CRON";
	
	$log = array();
	$response = array();
	$record_id = '';
	require_once('includes/constant.php');
	require_once('includes/autoload.php');
	$mysqli = new MySqliDriver();

	error_log("expired report Started:".$start_time." ----- expired report Ended:" .date('Y-m-d H:i:s')."" . PHP_EOL."\r\n", 3, 'Report.txt');

	$logid = $mysqli->Resquest_Response_log("", strtoupper('expiry_mail'), '', 'mail to expired memberships', ''); 
	$cur_date = date('Y-m-d');
	 $sql = "SELECT * FROM ".MEMBERS." where end_date = '".$cur_date."' and status = 'Active'";
	$result = $mysqli->executeQry($sql);
	while ($row = $mysqli->fetch_assoc($result)) {
		extract($row);
		
		if($row['membership_type'] == 'Single' || $row['membership_type'] == 'Family' && $row['family_head'] == '1'){
			$plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$plan_id.'"');
			$subject = 'Welcome to Swim Gym Academy! Membership Expiring today | '.$member_id.'';
				 
						$body = '<p>Hello ' . $name . ',</p>';

						$body .= '<p>We hope you have enjoyed being a member of Swim Gym Academy. We would like to inform you that your membership will expire today.</p>';

						$body .= '<p>To continue your swimming journey with us, please renew your membership. You can visit our reception desk today, and our staff will be happy to assist you in selecting a new membership plan that suits your needs.</p>';

						$body .= '<p>Here are the details of your current membership plan:</p>';

						$body .= '<p><b>Membership ID: ' . $member_id . '</b></p>';

						$body .= '<p><b>Membership Plan: ' . $plan_details['title'] . '</b></p>';

						$body .= '<p>Thank you for being a valued member of Swim Gym Academy. We look forward to welcoming you back soon!</p>';

						$body .= '<p>Best Regards,<br/>Swim Gym Academy</p>';
						$fromEmail = 'info@swimgymacademy.com';
						$fromName = "Swim Gym Academy";
						 $toEmail = $email;
						
						 $attachmentPath = '';
						 $isMail = $mysqli->sendEmails($subject, $body, $attachmentPath, $fromEmail, $fromName, $toEmail,  $toName = '', $bcc = '');
						 
						 if($isMail > 0){
							 
							 $response['msg_code'] = "00";
							 $response['msg'] = "mail sent.";
						 }else{
							 $response['msg_code'] = "01";
							 $response['msg'] = "mail not sent.";
						 }
						 // Queue an expiring-today WhatsApp reminder; the batch processor sends at most configured batch size.
						 $mysqli->whatsappQueueExpiryTodayForMember($row);
		}
		
	}

$response['whatsapp'] = $mysqli->whatsappProcessQueue(WHATSAPP_BATCH_SIZE);

$logid = $mysqli->Resquest_Response_log($logid, '', $response, '',$record_id,$log);
}
else
{
	echo "You can not run this script through browser.";
}

					
		

?>
