<?php
class account extends cxn{
	function getAccountInfo($account_ID){
		$account_ID = $this->escape($account_ID);
		$sql = $this->cxn->query("SELECT * FROM accounts WHERE account_ID = '" . $account_ID . "' LIMIT 1");
		WHILE($row = $sql->fetch_assoc()){
			$array = array(
				'name' => $row['account_name'],
				'number' => $row['account_number'],
				'notes' => $row['account_notes'],
				'active' => $row['account_active'],
				'autopay' => $row['account_auto_pay']
			);
		}
		return $array;
	}
	function addAccount($name, $number, $active, $autopay, $notes){
			$name = $this->escape($name);
			$number = $this->escape($number);
			$active = $this->escape($active);
			$autopay = $this->escape($autopay);
			$notes = $this->escape($notes);
			
			$sql = $this->cxn->query("INSERT INTO accounts (account_name, account_number, account_active, account_auto_pay, account_notes) VALUES" . 
												"('" . $name . "', '" . $number . "', '" . $active . "', '" . $autopay . "', '" . $notes . "')");
			switch($sql){
				case true:
					$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Account successfully added.</div>';
					header("Location: " . BASE_PATH . 'manage-accounts');
					break;
				case false:
					$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: Problem adding new account: ' . $sql->error . '</div>';
					header("Location: " . BASE_PATH . 'manage-accounts');
					break;
			}
	}
	function editAccount($id, $name, $number, $active, $autopay, $notes){
			$id = $this->escape($id);
			$name = $this->escape($name);
			$number = $this->escape($number);
			$active = $this->escape($active);
			$autopay = $this->escape($autopay);
			$notes = $this->escape($notes);
			
			$sql = $this->cxn->query("REPLACE INTO accounts (account_ID, account_name, account_number, account_active, account_auto_pay, account_notes) VALUES" . 
												"('" . $id . "', '" . $name . "', '" . $number . "', '" . $active . "', '" . $autopay . "', '" . $notes . "')");
			switch($sql){
				case true:
					$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Account successfully added.</div>';
					header("Location: " . BASE_PATH . 'manage-accounts');
					break;
				case false:
					$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: Problem adding new account: ' . $sql->error . '</div>';
					header("Location: " . BASE_PATH . 'manage-accounts');
					break;
			}
	}
	function deleteAccount($account_ID){
		$account_ID = $this->escape($account_ID);
		$this->checkAccountStatus($account_ID);
		$sql = $this->cxn->query("DELETE FROM bills WHERE bill_account_ID = '" . $account_ID . "'");
		$sql = $this->cxn->query("DELETE FROM accounts WHERE account_ID = '" . $account_ID . "' LIMIT 1");
		switch($sql){
				case true:
					$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Account successfully deleted.</div>';
					header("Location: " . BASE_PATH . 'manage-accounts');
					break;
				case false:
					$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: Problem deleting account: ' . $sql->error . '</div>';
					header("Location: " . BASE_PATH . 'manage-accounts');
					break;
			}
	}
	function toggleAccountStatus($account_ID){
		$account_ID = $this->escape($account_ID);
		$this->checkAccountStatus($account_ID);
		$sql = $this->cxn->query("SELECT account_active FROM accounts WHERE account_ID = '" . $account_ID . "' LIMIT 1");
		WHILE($row = $sql->fetch_assoc()){
			$status = ($row['account_active'] == 1 ? 0 : 1);
				$sql2 = $this->cxn->query("UPDATE accounts SET account_active = '" . $status . "' WHERE account_ID = '" . $account_ID . "' LIMIT 1");
			switch($sql2){
					case true:
						$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Account status successfully changed.</div>';
						header("Location: " . BASE_PATH . 'manage-accounts');
						break;
					case false:
						$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: Problem changing account status: ' . $sql->error . '</div>';
						header("Location: " . BASE_PATH . 'manage-accounts');
						break;
				}
		}
	}
	function getAccounts($type, $status, $bill_account_ID = NULL){
		if($status == 1){
			$sql = $this->cxn->query("SELECT * FROM accounts WHERE account_active = 1 ORDER BY account_name ASC");
		}elseif($status == 0){
			$sql = $this->cxn->query("SELECT * FROM accounts WHERE account_active = 0 ORDER BY account_name ASC");
		}
		if($sql->num_rows == 0 AND $type == 'table-list'){
			echo '<tr class="account">';
				echo '<td colspan="5"><i>There are currently no accounts available.</i></td>';
			echo '</tr>';
		}
		WHILE($row = $sql->fetch_assoc()){
			if($type == 'select'){
				$selected = ($bill_account_ID != NULL ? ($bill_account_ID == $row['account_ID'] ? 'selected' : NULL) : NULL);
				echo '<option value="' . $row['account_ID'] . '" ' . $selected . ' >' . $row['account_name'] . '</option>';
			}elseif($type == 'table-list'){
				$status = ($row['account_active'] == 1 ? 'Deactivate' : 'Activate');
				$name = stripslashes($row['account_name']);
				$auto_pay = ($row['account_auto_pay'] == '1' ? '<i class="fa fa-check fa-fw" style="color: #0F0;"></i>' : '<i class="fa fa-times fa-fw" style="color: #F00;"></i>');
				$notes = stripslashes($row['account_notes']);
				echo '<tr class="account">';
					echo '<td class="name" title="' . $notes . '" >' . $name . '</td>';
					echo '<td class="number">' . $row['account_number'] . '</td>';
					echo '<td class="unpaid">' . $this->getAccountUnpaid($row['account_ID']) . '</td>';
					echo '<td class="auto-pay">' . $auto_pay . '</td>';
					echo '<td class="options">';
						if($row['account_active'] == 1){
							echo '<button class="fancybox fancybox.ajax" href="' . BASE_PATH . 'ajax/add_bill.php?account_ID=' . $row['account_ID'] . '">Add Bill</button>&nbsp;';
						}
						echo '<button class="fancybox fancybox.ajax" href="' . BASE_PATH . 'ajax/edit_account.php?account_ID=' . $row['account_ID'] . '">Edit</button>&nbsp;';
						echo '<button onClick="toggleAccount(\'' . BASE_PATH . '\', \'' . $row['account_ID'] . '\')">' . $status . '</button>&nbsp;';
						if($row['account_active'] == 0){
							echo '<button onClick="deleteAccount(\'' . BASE_PATH . '\', \'' . $row['account_ID'] . '\')">Delete</button>';
						}
					echo '</td>';
				echo '</tr>';
			}
		}
	}
	function getAccountUnpaid($account_ID){
		$account_ID = $this->escape($account_ID);
		$sql = $this->cxn->query("SELECT * FROM bills WHERE bill_account_ID = '" . $account_ID . "' AND bill_paid = 0");
		return $sql->num_rows;
	}
	function checkAccountStatus($account_ID){
		$sql = $this->cxn->query("SELECT * FROM bills WHERE bill_account_ID = '" . $account_ID . "' AND bill_paid = 0 LIMIT 1");
		if($sql->num_rows == 1){
			$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">Cant Deactive account with Unpaid Bills</div>';
			header("Location: " . BASE_PATH . "manage-accounts");
			die;
		}else{
			return false;
		}
	}
	function getActiveAccountCount(){
		$sql = $this->cxn->query("SELECT * FROM accounts WHERE account_active = 1");
		return $sql->num_rows;
	}
}
$account = new account();
?>