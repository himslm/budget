<?php
if(isset($_SESSION['process_result'])){
	echo $_SESSION['process_result'];
	unset($_SESSION['process_result']);
}
?>

<div class="content-wrapper">
	<h2><i class="fa fa-flag fa-fw"></i> Overview</h2>
	<div id="overview">
		<?php $overview->getOverviewDetails(); ?>
	</div>
</div>

<div class="content-wrapper">
	<div>
		<h2 class="button"><i class="fa fa-warning fa-fw"></i> Unpaid Bills</h2>
		<button class="fancybox add-bill" href="#add-bill">+ Add Bill</button>
		<div class="clear"></div>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" id="unpaid-bills">
		<tr class="header">
			<th class="name">Account Name (#):</th>
			<th class="amount">Bill Amount:</th>
			<th class="due-date">Due/Auto Pay Date:</th>
			<th class="auto-pay">Auto Pay?:</th>
			<th class="options">Options:</th>
		</tr>
		<?php $bill->getBills('unpaid'); ?>
		<tr class="total">
			<td colspan="4">Total Due</td>
			<td align="right"><?php echo $bill->getBillsSum('unpaid'); ?></td>
		</tr>
	</table>
</div>

<div class="content-wrapper">
	<h2><i class="fa fa-calendar fa-fw"></i> Bills Paid in <?php echo date("F"); ?></h2>
	<table border="0" cellpadding="0" cellspacing="0" id="unpaid-bills">
		<tr class="header">
			<th class="name">Account Name (#):</th>
			<th class="amount">Bill Amount:</th>
			<th class="due-date">Paid Date:</th>
			<th class="auto-pay">Auto Pay?:</th>
			<th class="options">Options:</th>
		</tr>
		<?php $bill->getBills('paid'); ?>
		<tr class="total">
			<td colspan="4">Total Paid for <?php echo date ("F"); ?></td>
			<td align="right"><?php echo $bill->getBillsSum('paid'); ?></td>
		</tr>
	</table>
</div>