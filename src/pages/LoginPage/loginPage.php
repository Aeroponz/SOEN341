<!DOCTYPE html>
<?php require_once('../../db/DBConfig.php');
	  require('../FunctionBlocks/checkUsernameAndPassword.php');
?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Log In</title>
		<link rel = "stylesheet" type = "text/css" href = "loginPageStyle.css"/>
	</head>
	<body>
		<center>
		<div class = "backgroundColor">
			<img src = "../GenericResources/Blu.png" class = "logoLogin">
		
			<?php session_start();?>
			<br><br><br>
			<form action = "loginPage.php" method = "post">
				<input type = "text" name = "username" placeholder = "Username" class = "creds"/><br><br>
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/><br><br>
				<input type = "Submit" name = "submit" value = "Log In"  class = "button"/><br><br>
				<label id = "password" class = "message"></label><br><br><br>
				<a href = "../ResetPasswordPage/resetPassword.php">Forgot password?</a>
				<p><b>Don't have an account? <a class = "signUp" href = "../SignUpPage/signUp.php"> Sign up </a></b></p>	
		</div>
		</center>

		<?php if ($_POST) {
			if(isset($_POST['submit'])){
				$result = Database::safeQuery("SELECT u_id, name, pass FROM users");
				$validUsername = true;
				$_SESSION['userID'] = "";
				if(checkUsername($_POST['username']) && checkPassword($_POST['password'])){
					while($row = $result->fetch_assoc()){ 	//fetches values of results and stores in array $row 
						if($row["name"] == $_POST['username']) {
							$validUsername = true;
							if($row["pass"] == $_POST['password']) {
								$_SESSION['userID'] = $row["u_id"];
								header("Location: ../HomePage/HomepageBase.php");
								break;
							}
							else {
								echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Invalid login\";
								</script>";
							}
						}
						else 
							$validUsername = false;
					}
					if($validUsername == false){
						echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Invalid login\";
								</script>";
					}
				}
				else
					echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
						</script>";
			}
		}
		?>
	</body>
</html>