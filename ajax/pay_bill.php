<?php
include("../includes/ajax_config.php");
$bill_info = $bill->getBillInfo($_GET['bill_ID']);
$amount = explode('.', $bill_info['amount']);
$due_date = date("m/d/Y", strtotime($bill_info['due_date']));
$amt_dollars = $amount[0];
$amt_cents = $amount[1];
?>
<h2>Pay Bill</h2>
<form method="post" action="<?php BASE_PATH; ?>processes.php">
	<input type="hidden" name="id" value="<?php echo $_GET['bill_ID']; ?>" />
	<table border="0" cellpadding="3" cellspacing="0">
		<tr>
			<td><label>Bill Name:</label></td><td><?php echo $bill_info['account_name']; ?></td>
		</tr>
		<tr>
			<td><label>Due Date:</label></td><td><?php echo $due_date; ?></td>
		</tr>
		<tr>
			<td><label>Paid Date:</label></td><td><input type="text" name="paid_date" onclick="this.select()" value="<?php echo date("m/d/Y"); ?>" size="10" maxlength="10" /></td>
		</tr>
		<tr>
			<td><label>Paid Amount:</label></td>
			<td>
				<input type="text" name="amount_dollars" onclick="this.select()" value="<?php echo $amt_dollars; ?>" size="4" maxlength="5" /> . <input type="text" name="amount_cents" onclick="this.select()"  size="1" maxlength="2" value="<?php echo $amt_cents; ?>" />
			</td>
		</tr>
		<tr>
			<th colspan="2"><input type="submit" value="Pay Bill" name="pay_bill" /></th>
		</tr>
	</table>
</form>