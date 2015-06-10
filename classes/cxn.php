<?php
class cxn{
	protected $cxn;
	protected $mysqli = array(
						'host' => '',
						'user' => '',
						'pass' => '',
						'db' => 'budget'
					);
	function __construct(){
		$this->cxn = new mysqli($this->mysqli['host'], $this->mysqli['user'], $this->mysqli['pass'], $this->mysqli['db']);
		if($this->cxn->connect_errno > 0){
			die($this->cxn->error);
		}
	}
	function escape($value){
		$value = $this->cxn->escape_string($value);
		return $value;
	}
}
$cxn = new cxn();
?>