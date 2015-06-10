<body>
<div id="top-div">
	<?php
	if(!isset($_SESSION['c_admin_ID'])){
	?>
	<form id="login-form" method="post" action="<?php BASE_PATH; ?>processes.php">
		<div class="field-div"><label><i class="fa fa-user fa-fw"></i> Username:</label><input type="text" name="user"></div>
		<div class="field-div"><label><i class="fa fa-key fa-fw"></i> Password:</label><input type="password" name="pass"></div>
		<div class="field-div"><input type="submit" value="Log In" name="login" /></div>
		<div class="field-div"><input type="checkbox" name="remember" value="1"><label>Remember Me</label></div>
	</form>
	<?php
	}else{
	$userInfo = $user->getUserInfo($_SESSION['c_admin_ID']);
	?>
	<div id="admin-nav">
		<ul>
			<li><a href="<?php echo BASE_PATH; ?>"><i class="fa fa-home fa-fw"></i> Home</a></li>
			<li><a href="<?php BASE_PATH; ?>manage-accounts"><i class="fa fa-pencil fa-fw"></i> Manage Accounts</a></li>
			<li><a href="<?php BASE_PATH; ?>logout" onclick="return confirm('Logout?')"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
			<li class="c-user">Logged in as <span style="color: #ABF"><?php echo $userInfo['fname'] . ' ' . $userInfo['lname'] . '.'; ?></a></li>
		</ul>
	</div>
	<?php
	}
	?>
</div>