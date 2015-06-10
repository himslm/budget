<?php
class login extends cxn{
		function loginUser($user, $pass, $remember){
			$user = $this->escape($user);
			
			$this->verifyUserExists($user);
			$this->verifyUserPassword($user, $pass);
		}
		function verifyUserExists($user){
			$sql = $this->cxn->query("SELECT * FROM users WHERE user_username = '" . $user . "'");
			if($sql->num_rows > 0){
				return true;
			}else{
				$_SESSION['login_result'] = '<div class="notify-error notify-fadeout">Username or Password is incorrect.</div>';
				header("Location: " . BASE_PATH);
			}
		}
		function verifyUserPassword($user, $pass){
			$sql = $this->cxn->query("SELECT user_password, user_ID FROM users WHERE user_username = '" . $user . "' LIMIT 1");
			WHILE($row = $sql->fetch_assoc()){
				if(crypt($pass, $row['user_password']) == $row['user_password']){
					$_SESSION['c_admin_ID'] = $row['user_ID'];
					if($_POST['remember'] == 1){
						$rem_key = md5(microtime());
						$insert = $this->cxn->query("INSERT INTO remember_login (user_ID, rem_key) VALUES ('" . $row['user_ID'] . "', '" . $rem_key . "')");
						setcookie('rem_key', $rem_key, time()+(60 * 60 * 24 * 365), BASE_PATH);
					}
					header("Location: " . BASE_PATH);
				}else{
						$_SESSION['login_result'] = '<div class="notify-error notify-fadeout">Username or Password is incorrect.</div>';
						header("Location: " . BASE_PATH);
				}
			}
		}
		function logoutUser($user_ID){
			if(isset($_COOKIE['rem_key'])){
				setcookie('rem_key', "", time()-3600, BASE_PATH);
			}
			$delete = $this->cxn->query("DELETE FROM remember_login WHERE user_ID = '" . $user_ID . "'");
			unset($_SESSION['c_admin_ID']);
			header("Location: " . BASE_PATH);
		}
		function loginRememberedUser($rem_key){
			$sql = $this->cxn->query("SELECT user_ID FROM remember_login WHERE rem_key = '" . $rem_key . "' LIMIT 1");
			if($sql->num_rows > 0){
				WHILE($row = $sql->fetch_assoc()){
					$_SESSION['c_admin_ID'] = $row['user_ID'];
					header("Location: " . BASE_PATH);
				}
			}else{
				setcookie("rem_key", '', time()-3600, BASE_PATH);
				header("Location: " . BASE_PATH);
			}
		}
}
$login = new login();
?>