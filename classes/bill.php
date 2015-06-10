<?php
class bill extends cxn{
	function getBillInfo($bill_ID){
		$bill_ID = $this->escape($bill_ID);
		$sql = $this->cxn->query("SELECT * FROM bills, accounts WHERE bills.bill_account_ID = accounts.account_ID AND bill_ID = '" . $bill_ID . "' LIMIT 1");
		WHILE($row = $sql->fetch_assoc()){
			$array = array(
				'account_name' => $row['account_name'],
				'account_ID' => $row['bill_account_ID'],
				'amount' => $row['bill_amount'],
				'rec_date' => $row['bill_receive_date'],
				'due_date' => $row['bill_due_date']
			);
		}
		return $array;
	}
	function addBill($account_ID, $amount_dollars, $amount_cents, $rec_date, $due_date){
		$account_ID = $this->escape($account_ID);
		$amount_dollars = $this->escape($amount_dollars);
		$amount_cents = $this->escape($amount_cents);
		$rec_date = $this->escape($rec_date);
		$due_date = $this->escape($due_date);
		
		$rec_date = $this->configureDate($rec_date);
		$due_date = $this->configureDate($due_date);
		
		$amount = $this->configureAmount($amount_dollars, $amount_cents);
		
		$sql = $this->cxn->query("INSERT INTO bills (bill_account_ID, bill_amount, bill_receive_date, bill_due_date) VALUES " . 
											"('" . $account_ID . "', '" . $amount . "', '" . $rec_date . "', '" . $due_date . "')");
		switch($sql){
			case true:
				$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Bill successfully added.</div>';
				header("Location: " . BASE_PATH);
				break;
			case false:
				$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: There was a problem adding bill: ' . $sql->error . '</div>';
				header("Location: " . BASE_PATH);
				break;
		}
	}
	function editBill($bill_ID, $account_ID, $amount_dollars, $amount_cents, $rec_date, $due_date){
		$bill_ID = $this->escape($bill_ID);
		$account_ID = $this->escape($account_ID);
		$amount_dollars = $this->escape($amount_dollars);
		$amount_cents = $this->escape($amount_cents);
		$rec_date = $this->escape($rec_date);
		$due_date = $this->escape($due_date);
		
		$rec_date = $this->configureDate($rec_date);
		$due_date = $this->configureDate($due_date);
		
		$amount = $this->configureAmount($amount_dollars, $amount_cents);
		
		$sql = $this->cxn->query("REPLACE INTO bills (bill_ID, bill_account_ID, bill_amount, bill_receive_date, bill_due_date) VALUES " . 
											"('" . $bill_ID . "', '" . $account_ID . "', '" . $amount . "', '" . $rec_date . "', '" . $due_date . "')");
		switch($sql){
			case true:
				$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Bill successfully updated.</div>';
				header("Location: " . BASE_PATH);
				break;
			case false:
				$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: There was a problem updating bill: ' . $sql->error . '</div>';
				header("Location: " . BASE_PATH);
				break;
		}
	}
	function payBill($bill_ID, $paid_date, $amount_dollars, $amount_cents){
		$bill_ID = $this->escape($bill_ID);
		$paid_date = $this->escape($paid_date);
		$amount_dollars = $this->escape($amount_dollars);
		$amount_cents = $this->escape($amount_cents);
		
		$paid_date = $this->configureDate($paid_date);
		$paid_amt = $this->configureAmount($amount_dollars, $amount_cents);
		
		$sql = $this->cxn->query("UPDATE bills SET bill_paid = 1, bill_paid_date = '" . $paid_date . "', bill_paid_amount = '" . $paid_amt . "' WHERE bill_ID = '" . $bill_ID . "' LIMIT 1");
		switch($sql){
				case true:
					$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Bill successfully paid.</div>';
					header("Location: " . BASE_PATH);
					break;
				case false:
					$_SESSION['process_result'] = '<div class="notify-error notify-fadeout">ERROR: There was a problem marking your bill as paid: ' . $sql->error . '</div>';
					header("Location: " . BASE_PATH);
					break;
			}
	}
	function configureDate($value){
		if($value == null){
			$value = date("m/d/Y");
		}
		$value = explode("/", $value);
		$value = $value[2] . '-' . $value[0] . '-' . $value[1] . ' 00:00:00';
		return $value;
	}
	function configureAmount($dollars, $cents){
		$amount = $dollars . '.' . $cents;
		return $amount;
	}
	function getBills($type){
		if($type == 'unpaid'){
			$sql = $this->cxn->query("SELECT * FROM bills, accounts WHERE bills.bill_account_ID = accounts.account_ID AND bills.bill_paid = 0 ORDER BY bills.bill_due_date ASC");
		}elseif($type == 'paid'){
			$sql = $this->cxn->query("SELECT * FROM bills, accounts WHERE bills.bill_account_ID = accounts.account_ID AND bills.bill_paid = 1 AND MONTH(bill_paid_date) = '" . date("m") . "' AND YEAR(bill_paid_date) = '" . date("Y") . "' ORDER BY bills.bill_due_date ASC");
		}
		if($sql->num_rows == 0){
			echo '<tr>';
				echo '<td colspan="5"><i>There are no bills available.</i></td>';
			echo '</tr>';
		}
		WHILE($row = $sql->fetch_assoc()){
			$date = ($type == 'unpaid' ? date("l, F d, Y", strtotime($row['bill_due_date'])) : ($type == 'paid' ? date("l, F d, Y", strtotime($row['bill_paid_date'])) : NULL));
			$bill_amt = '$' . number_format($row['bill_amount'], 2);
			$auto_pay = ($row['account_auto_pay'] == '1' ? '<i class="fa fa-check fa-fw" style="color: #0F0;"></i>' : '<i class="fa fa-times fa-fw" style="color: #F00;"></i>');
			$account_notes = nl2br(stripslashes($row['account_notes']));
			echo '<tr class="bill">';
				echo '<td class="name" title="' . $account_notes . '">' . $row['account_name'] . ' <span style="color: #888;">(' . $row['account_number'] . ')</span></td>';
				echo '<td class="amount">' . $bill_amt . '</td>';
				echo '<td class="due-date">' . $date . '</td>';
				echo '<td class="auto-pay">' . $auto_pay . '</td>';
				echo '<td class="options">';
					if($row['bill_paid'] == 0){
						echo '<button class="fancybox fancybox.ajax" href="' . BASE_PATH . 'ajax/pay_bill.php?bill_ID=' . $row['bill_ID'] . '">Pay</button>&nbsp;';
					}
					echo '<button class="fancybox fancybox.ajax" href="' . BASE_PATH . 'ajax/edit_bill.php?bill_ID=' . $row['bill_ID'] . '">Edit</button>&nbsp;';
					echo '<button onClick="deleteBill(\'' . BASE_PATH . '\', \'' . $row['bill_ID'] . '\')">Delete</button>';
				echo '</td>';
			echo '</tr>';
		}
	}
	function getBillsSum($type){
		if($type == 'unpaid'){
			$sql = $this->cxn->query("SELECT SUM(bill_amount) AS total FROM bills WHERE bill_paid = 0");
		}else{
			$sql = $this->cxn->query("SELECT SUM(bill_amount) AS total FROM bills WHERE bill_paid = 1 AND MONTH(bill_paid_date) = '" . date("m") . "' AND YEAR(bill_paid_date) = '" . date("Y") . "'");
		}
		WHILE($row = $sql->fetch_assoc()){
			return '$' . number_format($row['total'], 2);
		}
	}
	function deleteBill($bill_ID){
		$bill_ID = $this->escape($bill_ID);
		$sql = $this->cxn->query("DELETE FROM bills WHERE bill_ID = '" . $bill_ID . "' LIMIT 1");
		switch($sql){
			case true:
				$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">Bill successfully deleted.</div>';
				header("Location: " . BASE_PATH);
				break;
			case false:
				$_SESSION['process_result'] = '<div class="notify-success notify-fadeout">ERROR: Bill could not be deleted: ' . $sql->error . '</div>';
				header("Location: " . BASE_PATH);
				break;
		}
	}
}
$bill = new bill();
?>