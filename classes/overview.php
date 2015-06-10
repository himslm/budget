<?php
class overview extends cxn{
	function getOverviewDetails(){
		$overview_array = array(
			'Past Due Bills' => $this->getCount("SELECT * FROM bills WHERE bill_due_date < NOW() AND bill_paid = 0"),
			'Unpaid Bills' => $this->getCount("SELECT * FROM bills WHERE bill_paid = 0"),
			'Active Accounts' => $this->getCount("SELECT * FROM accounts WHERE account_active = 1"),
			'Bills Paid in ' . date('F') => $this->getCount("SELECT * FROM bills WHERE MONTH(bill_paid_date) = '" . date("m") . "' AND YEAR(bill_paid_date) = '" . date("Y") ."' AND bill_paid = 1")
		);
		echo '<ul>';
		foreach($overview_array as $key => $value){
			echo '<li><div class="key">' . $key . '</div><div class="value">' .  $value . '</div><div class="clear"></div></li>';
		}
		echo '</ul>';
	}
	function getCount($sql){
		$sql = $this->cxn->query($sql);
		return $sql->num_rows;
	}
}
$overview = new overview();
?>