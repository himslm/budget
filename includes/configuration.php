<?php
//Starts Session
session_start();

//Sets Default Timezone
date_default_timezone_set("America/Chicago");

define('BASE_PATH', '/budget/');

//Call to get Class Library
include('classes/cxn.php');
include('classes/login.php');
include('classes/user.php');
include('classes/overview.php');
include('classes/account.php');
include('classes/bill.php');

if(isset($_COOKIE['rem_key']) AND !isset($_SESSION['c_admin_ID'])){ //Looks for rem_key cookie if user decided to stay logged in
	$login->loginRememberedUser($_COOKIE['rem_key']);
}

if(isset($_GET['ToDo'])){ //Logs user out when $_GET['ToDo'] == 'logout'
 	if($_GET['ToDo'] == 'logout'){
		$login->logoutUser($_SESSION['c_admin_ID']);
	}
}
?>