<?php
include("../includes/ajax_config.php");
$account_info = $account->getAccountInfo($_GET['account_ID']);
$active_checked = ($account_info['active'] == 1 ? 'checked' : NULL);
$autopay_checked = ($account_info['autopay'] == 1 ? 'checked' : NULL);
?>
<h2>Edit Account</h2>
<form method="post" action="<?php BASE_PATH; ?>processes.php">
	<input type="hidden" value="<?php echo $_GET['account_ID']; ?>" name="id" />
	<table border="0" cellpadding="3" cellspacing="0">
		<tr>
			<td><label>Account Name: </label></td><td><input type="text" name="name" value="<?php echo $account_info['name']; ?>" /></td>
		</tr>
		<tr>
			<td><label>Account Number: </label></td><td><input type="text" name="number" value="<?php echo $account_info['number']; ?>" /></td>
		</tr>
		<tr>
			<td><label>Active?: </label></td><td><input type="checkbox" name="active" value="1" <?php echo $active_checked; ?> /></td>
		</tr>
		<tr>
			<td><label>AutoPay?: </label></td><td><input type="checkbox" name="autopay" value="1" <?php echo $autopay_checked; ?> /></td>
		</tr>
		<tr>
			<td valign="top"><label>Notes: </label></td><td><textarea name="notes" rows="5" cols="40"><?php echo $account_info['notes']; ?></textarea></td>
		</tr>
		<tr>
			<th colspan="2">
				<input type="submit" value="Update Account" name="edit_account" />
			</th>
	</table>
</form>