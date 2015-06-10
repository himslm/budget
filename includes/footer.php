<div id="footer">
	&copy;<?php echo date("Y"); ?> Project by Matt Himsl. All Rights Reserved.
</div>
<div id="add-account">
	<h2>Add Account</h2>
	<form method="post" action="<?php BASE_PATH; ?>processes.php">
		<table border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td><label>Account Name: </label></td><td><input type="text" name="name" /></td>
			</tr>
			<tr>
				<td><label>Account Number: </label></td><td><input type="text" name="number" onclick="this.select()" value="N/A" /></td>
			</tr>
			<tr>
				<td><label>Active?: </label></td><td><input type="checkbox" name="active" value="1" checked /></td>
			</tr>
			<tr>
				<td><label>AutoPay?: </label></td><td><input type="checkbox" name="autopay" value="1" /></td>
			</tr>
			<tr>
				<td valign="top"><label>Notes: </label></td><td><textarea name="notes" rows="5" cols="40"></textarea></td>
			</tr>
			<tr>
				<th colspan="2">
					<input type="submit" value="Add Account" name="add_account" />
				</th>
		</table>
	</form>
</div>

<div id="add-bill">
	<h2>Add Bill</h2>
	<form method="post" action="<?php BASE_PATH; ?>processes.php">
		<table border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td><label>Choose Account: </label></td><td><select name="account"><?php $account->getAccounts('select',1); ?></select></td>
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
</div>
</body>
</html>