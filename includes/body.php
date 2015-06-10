<div id="main-wrapper">
<?php
if(isset($_SESSION['login_result'])){
	echo $_SESSION['login_result'];
	unset($_SESSION['login_result']);
}

if(isset($_SESSION['c_admin_ID'])){
	if(!isset($_GET['ToDo'])){
		require_once("pages/home.php");
	}else{
		switch($_GET['ToDo']){
			case 'manage-accounts':
				require_once("pages/manage_accounts.php");
				break;
			default:
				require_once("pages/404.php");
				break;
		}
	}
}
?>
</div>