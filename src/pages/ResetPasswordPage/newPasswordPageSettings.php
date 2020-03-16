<?php
	namespace Website;
	$root = dirname(__FILE__, 4);
	require_once($root . '/src/db/DBConfig.php');
	require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');
	require('ResettingPassword.php');
	require('../SettingsPage/Settings.php');
	session_start();
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Reset Password</title>
		<link id = "style" rel = "stylesheet" type = "text/css" href = "resetPasswordStyle.css"/>
		<?php
			$cUserId = $_SESSION['userID'];
			$mMode = new Settings();
			$cLight = "resetPasswordStyle.css";
			$cDark = "resetPasswordStyleDark.css";
			$mResult = $mMode->GetMode($cUserId, $cLight, $cDark);
			echo "<script>document.getElementById('style').setAttribute('href', '$mResult');</script>";
		?>
	</head>
	<body>
		<center>
		<div class = "backgroundColor">
			<div class = "close"><a class = "a" href = "../SettingsPage/SettingsPage.php">+</a></div>
			<img src = "../GenericResources/Blu.png" class = "logoLogin">
			<br><br>
			<p>Enter below your new password</p>
			<form action = "newPasswordPageSettings.php" method = "post">
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/><br><br>
				<input type = "password" name = "passwordConfirm" placeholder = "Confirm Password" class = "creds"/><br><br>
				<input type = "Submit" name = "submit" value = "Change Password"  class = "button"/><br><br>
				<label id = "message" class = "message"></label><br><br>
				<div class = "passwordRequirements" align = "left">
					<label>Your password must include at least:</label>
					<ul>
						<li>6 characters</li>
						<li>One number and one letter</li>
						<li>One special character</li>
					</ul>
				</div><br>
		</div>
		</center>
		
		<?php 
		namespace Website;
		use SqlDb\Database;
		
		if ($_POST) {
			if(isset($_POST['submit'])){
				$wUserPassword = new ResettingPassword();
				$wUserPassword->withPost();
				$wResult = $wUserPassword->CheckingPasswordValidity();	
				if ($wResult > 0) {
					echo "<script type='text/javascript'>alert('Password changed successfully!');window.location = '../HomePage/HomepageBase.php';</script>";
				}
			}
		}
	
		?>
		
	</body>
</html>