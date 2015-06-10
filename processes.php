<?php
include("includes/configuration.php");
switch(isset($_SESSION['c_admin_ID'])){
	case true:
		if(isset($_POST['add_account'])){
			$_POST['active'] = (isset($_POST['active']) ? 1 : 0);
			$_POST['autopay'] = (isset($_POST['autopay']) ? 1 : 0);
			$account->addAccount($_POST['name'], $_POST['number'], $_POST['active'], $_POST['autopay'], $_POST['notes']);
		}elseif(isset($_POST['edit_account'])){
			$_POST['active'] = (isset($_POST['active']) ? 1 : 0);
			$_POST['autopay'] = (isset($_POST['autopay']) ? 1 : 0);
			$account->editAccount($_POST['id'], $_POST['name'], $_POST['number'], $_POST['active'], $_POST['autopay'], $_POST['notes']);
		}elseif(isset($_POST['add_bill'])){
			$bill->addBill($_POST['account'], $_POST['amount_dollars'], $_POST['amount_cents'], $_POST['receive_date'], $_POST['due_date']);
		}elseif(isset($_POST['edit_bill'])){
			$bill->editBill($_POST['id'], $_POST['account'], $_POST['amount_dollars'], $_POST['amount_cents'], $_POST['receive_date'], $_POST['due_date']);
		}elseif(isset($_POST['pay_bill'])){
			$bill->payBill($_POST['id'], $_POST['paid_date'], $_POST['amount_dollars'], $_POST['amount_cents']);
		}else{
			if(isset($_GET['action'])){
				if($_GET['action'] == 'delete bill'){
					if(isset($_GET['bill_ID'])){
						$bill->deleteBill($_GET['bill_ID']);
					}
				}elseif($_GET['action'] == 'delete account'){
					if(isset($_GET['account_ID'])){
						$account->deleteAccount($_GET['account_ID']);
					}
				}elseif($_GET['action'] == 'change account status'){
					if(isset($_GET['account_ID'])){
						$account->toggleAccountStatus($_GET['account_ID']);
					}
				}
			}
		}
		break;
	case false:
		if(isset($_POST['login'])){
			$_POST['remember'] = (isset($_POST['remember']) ? 1 : 0);
			$login->loginUser($_POST['user'], $_POST['pass'], $_POST['remember']);
		}
		break;
}
?>