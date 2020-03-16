<?php 
namespace Website;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php');
require('GetEmail.php');
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
			<br><br><br>
			<p>Enter below the email address associated to your account</p>
			<?php session_start();?>
			<form action = "resetPassword.php" method = "post">
				<input type = "email" name = "email" placeholder = "Email Address" class = "creds"/><br><br>
				<input type = "Submit" name = "submit" value = "Email link"  class = "button"/><br><br>
				<label id = "message" class = "message"></label><br><br><br>
		</div>
		</center>
		
		<?php if ($_POST) {
			if(isset($_POST['submit'])){
				$UserEmail = new GetEmail();
				$UserID = new GetEmail();
				$UserEmail->withPost();
				$_SESSION['email'] = $UserEmail->Get_email();
				$_SESSION['userID'] = $UserID->Get_userID($_POST['email']);
				echo $_SESSION['userID'];
				if($_SESSION['email'] != -1) {
					require_once('MailTrap/PhpMailer.php');
					echo "<script type = \"text/JavaScript\"> 
						document.getElementById('message').innerHTML = \"An email has been sent with a link to reset your password. <br>Please make sure to check your spam folder\";</script>";

				}
			}
		}
		?>
		
	</body>
</html>