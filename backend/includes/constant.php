<?php
date_default_timezone_set("Asia/Kolkata");
if(!isset($_SESSION))
{
  session_start();
}


 if($_SERVER['HTTP_HOST'] == 'swimgymacademy.com' || $_SERVER['HTTP_HOST'] == 'www.swimgymacademy.com')
{
	
	define('APPLICATION_URL',"https://swimgymacademy.com/");
	define('APPLICATION_domain',"swimgymacademy.com");
	define('ENVIRONMENT',"LIVE");
	################## DB ##########################################
	define('HOST', 'localhost');
	define('USER', 'u583683241_swimgym');
	define('PASSWORD', 'jG#97r5V39hv'); 
	define('DATABASE', 'u583683241_swimdata');
	################## DB ############################################
    define("ABSOLUTE_ROOT_PATH", $_SERVER['DOCUMENT_ROOT'].'/backend/');
    define('Email_domain',"swimgymacademy.com");
	define('FROM_EMAIL', 'info@'.Email_domain);
	define('EMAIL_HOST', 'smtp.hostinger.com');
    define('USER_EMAIL', 'admin@swimgymacademy.com');
	define('MAIL_PASSWORD', 'Sgar@2024'); 
	define('PORT', 587);
}

else if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'www.localhost')
{
	define('APPLICATION_URL',"https://localhost/swimgym/");
	define('APPLICATION_domain',"swimgymacademy");
	define('ENVIRONMENT',"LOCAL");
	################## DB ##########################################
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', ''); 
	define('DATABASE', 'u504935519_examportal');
	################## DB ############################################
    define("ABSOLUTE_ROOT_PATH", $_SERVER['DOCUMENT_ROOT'].'/swimgym/');
}
else
{
    echo "Invalid config"; exit;
}
if(ENVIRONMENT == "LOCAL" )
{
      ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
}
else
{
      error_reporting(0);
      //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
}
define('APPLICATION_NAME',"Swim Gym Academy");
define('APP_NAME',"Swim Gym Academy");
define('COMPANY_NAME',"Swim Gym Academy");
define('APP_FULL_NAME',"Swim Gym Academy");
define('DEVELOPER_EMAIL', 'lavii15march@gmail.com'); 
define('DEVELOPER_NAME', 'Aman Gahlawat'); 
define('EXCEPTION_EMAIL', 'exception@'.APPLICATION_domain);
define('USERS', 'tbl_user');
define('FAMILY_ID', 'tbl_family_id');
define('PLANS', 'tbl_plans');
define('MEMBERS', 'tbl_members');
define('RECENT', 'tbl_recent_members');
define('REVENUE', 'tbl_revenue');
define('ENQUIRIES', 'tbl_enquiry');
define('HISTORY', 'tbl_membership_history');
define('NOTIFICATIONS', 'tbl_sent_notifications');
define('ATTENDANCE', 'tbl_attendance');
define('APPLICATION_FULL_NAME',"Swim Gym Academy");
define('LOGO_PATH',APPLICATION_URL."backend/images/logos/logo.png");
define('DEFAULT_PROFILE_PICTURE',APPLICATION_URL."backend/images/avatar/1.png");
define('LOGO_ALT',APPLICATION_FULL_NAME);
define('FAVICON_PATH',APPLICATION_URL."backend/images/logos/logo.png");
use includes\PHPMailer\PHPMailer\PHPMailer;
use includes\PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require_once(ABSOLUTE_ROOT_PATH.'/dompdf/autoload.inc.php');
 
use Dompdf\Dompdf;
$dompdf = new Dompdf();
?>