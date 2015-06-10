<?php
include("../includes/ajax_config.php");

$bill_info = $bill->getBillInfo($_GET['bill_ID']);
$amount = explode('.', $bill_info['amount']);
$amt_dollars = $amount[0];
$amt_cents = $amount[1];
$rec_date = date("m/d/Y", strtotime($bill_info['rec_date']));
$due_date = date("m/d/Y", strtotime($bill_info['due_date']));
?>
<h2>Edit Bill</h2>
<form method="post" action="<?php BASE_PATH; ?>processes.php">
	<input type="hidden" name="id" value="<?php echo $_GET['bill_ID']; ?>" />
	<table border="0" cellpadding="3" cellspacing="0">
		<tr>
			<td><label>Choose Account: </label></td>
			<td>
				<select name="account">
					<?php $account->getAccounts('select', 1, $bill_info['account_ID']); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>Amount: </label></td><td><input type="text" name="amount_dollars" value="<?php echo $amt_dollars; ?>" size="3" maxlength="5" /> . <input type="text" name="amount_cents" value="<?php echo $amt_cents; ?>" size="1" maxlength="2" /></td>
		</tr>
		<tr>
			<td><label>Receive Date: </label></td><td><input type="text" name="receive_date" onclick="this.select()" value="<?php echo $rec_date; ?>" size="10" maxlength="10" /></td>
		</tr>
		<tr>
			<td><label>Due Date: </label></td><td><input type="text" name="due_date" value="<?php echo $due_date; ?>" size="10" maxlength="10" /></td>
		</tr>
		<tr>
			<th colspan="2">
				<input type="submit" value="Update" name="edit_bill" />
			</th>
	</table>
</form>