<!DOCTYPE html>
<?php require_once('../../db/DBConfig.php'); 
	  require('../FunctionBlocks/checkUsernameAndPassword.php');
?>
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
		
		<?php if ($_POST) {
			if(isset($_POST['submit'])){
				checkingPassword();
			}
		}
		
		function checkingPassword(){
			if(checkPassword($_POST['password'])) {
				if($_POST['password'] == $_POST['passwordConfirm']){
					$password = $_POST['password'];
					$user = $_SESSION['userID'];
					$result = Database::safeQuery("UPDATE users SET pass = '$password' WHERE u_id = '$user'");
					header("Location: ../HomePage/HomepageBase.php");
				}
				else
					echo "<script type = \"text/JavaScript\">
							document.getElementById('message').innerHTML = \"Passwords don't match\";
							</script>";
				}	
			else
				echo "<script type = \"text/JavaScript\">
						document.getElementById('message').innerHTML = \"Your password does not match the required format.\";
					</script>";
		
		}
		?>
		
	</body>
</html>