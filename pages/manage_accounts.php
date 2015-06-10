<?php
if(isset($_SESSION['process_result'])){
	echo $_SESSION['process_result'];
	unset($_SESSION['process_result']);
}
?>
<div class="content-wrapper">
	<div>
		<h2 class="button"><i class="fa fa-sun-o fa-fw"></i> Active Accounts (<?php echo $account->getActiveAccountCount(); ?>)</h2>
		<button class="fancybox add-bill" href="#add-account">+ Add Account</button>
		<div class="clear"></div>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" id="accounts">
		<tr class="header">
			<th class="name">Account Name:</th>
			<th class="number">Account #:</th>
			<th class="unpaid">Unpaid:</th>
			<th class="auto-pay">Auto Pay?:</th>
			<th class="options">Options:</th>
		</tr>
		<?php $account->getAccounts('table-list',1); ?>
	</table>
</div>

<div class="content-wrapper">
	<h2><i class="fa fa-moon-o fa-fw"></i> Inactive Accounts</h2>
	<?php
	if(isset($_SESSION['process_result'])){
		echo $_SESSION['process_result'];
		unset($_SESSION['process_result']);
	}
	?>
	<table border="0" cellpadding="0" cellspacing="0" id="accounts">
		<tr class="header">
			<th class="name">Account Name:</th>
			<th class="number">Account #:</th>
			<th class="unpaid">Unpaid:</th>
			<th class="auto-pay">Auto Pay?:</th>
			<th class="options">Options:</th>
		</tr>
		<?php $account->getAccounts('table-list',0); ?>
	</table>
</div>