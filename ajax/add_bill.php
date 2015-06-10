<?php
include("../includes/ajax_config.php");
?>
<h2>Add Bill</h2>
<form method="post" action="<?php BASE_PATH; ?>processes.php">
	<table border="0" cellpadding="3" cellspacing="0">
		<tr>
			<td><label>Choose Account: </label></td><td><select name="account"><?php $account->getAccounts('select', 1, $_GET['account_ID']); ?></select></td>
		</tr>
		<tr>
			<td><label>Amount: </label></td><td><input type="text" name="amount_dollars" size="3" maxlength="5" /> . <input type="text" name="amount_cents" size="1" maxlength="2" /></td>
		</tr>
		<tr>
			<td><label>Receive Date: </label></td><td><input type="text" name="receive_date" onclick="this.select()" placeholder="mm/dd/yyyy" value="<?php echo date("m/d/Y"); ?>" size="10" maxlength="10" /></td>
		</tr>
		<tr>
			<td><label>Due Date: </label></td><td><input type="text" name="due_date" placeholder="mm/dd/yyyy" size="10" maxlength="10" /></td>
		</tr>
		<tr>
			<th colspan="2">
				<input type="submit" value="Add Bill" name="add_bill" />
			</th>
	</table>
</form>