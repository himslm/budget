<?php
class user extends cxn{
		function getUserInfo($user_ID){
				$user_ID = $this->escape($user_ID);
				$sql = $this->cxn->query("SELECT * FROM users WHERE user_ID = '" . $user_ID . "' LIMIT 1");
				WHILE($row = $sql->fetch_assoc()){
						$array = array(
							'ID' => $row['user_ID'],
							'fname' => $row['user_fname'],
							'lname' => $row['user_lname']
						);
				}
				return $array;
		}
}
$user = new user();
?>