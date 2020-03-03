<?php
	namespace Website;
	$root = dirname(__FILE__, 4);
	require_once($root . '/src/db/DBConfig.php');
	require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');
	require('ResettingPassword.php');
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Reset Password</title>
		<link rel = "stylesheet" type = "text/css" href = "resetPasswordStyle.css"/>
	</head>
	<body>
		<center>
		<div class = "backgroundColor">
			<img src = "../GenericResources/Blu.png" class = "logoLogin">
			<br><br>
			<p>Enter below your new password</p>
			<?php session_start();?>
			<form action = "newPasswordPage.php" method = "post">
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
				$UserPassword = new ResettingPassword();
				$UserPassword->withPost();
				$_SESSION['userID'] = $UserPassword->CheckingPasswordValidity();
				echo $_SESSION['userID'];
				if ($_SESSION['userID'] > 0) {
					header("Location: ../HomePage/HomepageBase.php");
				}
			}
		}
	
		?>
		
	</body>
</html>