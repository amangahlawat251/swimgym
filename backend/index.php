<?php
if(!isset($_SESSION))
{
  session_start();
}
require_once('includes/constant.php');
require_once('includes/autoload.php');


if(ENVIRONMENT == "LOCAL")
{
      ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
}
else
{
      error_reporting(0);
}
//require_once('includes/classes/class.json.php');
$url = $_SERVER['REQUEST_URI'];

$mysqli = new MySqliDriver();
$Qstring = $mysqli->option($url); 
//print_r($Qstring); exit;


extract($Qstring);
register_shutdown_function(array(&$mysqli, 'ShutDown')); 
if(!isset($stat))
{
  $stat = "";  
}
#echo $mysqli->encode('pass@123');
//echo $mysqli->decode($stat);

$Encript_arr = array();
$Encript_arr[] = $mysqli->encode('login');
$Encript_arr[] = $mysqli->encode('table_response');
$Encript_arr[] = $mysqli->encode('ajax');
$Encript_arr[] = $mysqli->encode('custom_ajax');
$Encript_arr[] = $mysqli->encode('logout');
$Encript_arr[] = $mysqli->encode('Dashboard');	
$Encript_arr[] = $mysqli->encode('messages');		
$Encript_arr[] = $mysqli->encode('plans');		
$Encript_arr[] = $mysqli->encode('users');		
$Encript_arr[] = $mysqli->encode('error_404');
$Encript_arr[] = $mysqli->encode('enquiry');
$Encript_arr[] = $mysqli->encode('feedback');
$Encript_arr[] = $mysqli->encode('export_ajax');


if (!empty($stat)) { 
    if (in_array($stat, $Encript_arr)) 
    {
		$stat = $mysqli->decode($stat);
		 
    }
	 
    switch ($stat) {
		
        case "login":
            include "login.php";
            break;
		
		case "Dashboard":
            include "Dashboard.php";
            break;
			
		case "users":
            include "users.php";
            break;
		
		case "plans":
            include "plans.php";
            break;
			
		case "enquiry":
            include "enquiry.php";
            break;
		
		case "feedback":
            include "feedback.php";
            break;
		
		case "messages":
            include "messages.php";
            break;
		
		case "ajax":
            include "includes/ajax.php";
            break;
			
		case "export_ajax":
            include "includes/export_ajax.php";
            break;
			
		case "custom_ajax":
            include "includes/custom_ajax.php";
            break;
		
		case "table_response":
            include "includes/table_response.php";
            break;
		
		case "logout":
            include "logout.php";
            break;
			
			case "error_404":
            include "error_404.php";
            break;
		
		default:
            include "error_404.php";		
	}
	
}
else if(!empty($_SESSION['user_type']))
{
	if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'SUPERADMIN')
	{
		include 'Dashboard.php';
	}
	
	else
	{
		include "error_404.php";
	}
}
else
{
	include "login.php";
	exit;
}
?>