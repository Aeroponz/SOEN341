<!DOCTYPE html>
<?php require_once('C:/xampp/htdocs/SOEN341/src/db/DBConfig.php'); ?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Log In</title>
		<link rel = "stylesheet" type = "text/css" href = "loginPageStyle.css"/>
	</head>
	<body>
		<center>
		<div class = "backgroundColor">
			<img src = "http://localhost/SOEN341/src/pages/GenericRessources/Blu.png" class = "logoLogin">
		
			<?php session_start();?>
			<br><br><br>
			<form action = "loginPage.php" method = "post">
				<input type = "text" name = "username" placeholder = "Username" class = "creds"/><br><br>
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/><br><br>
				<input type = "Submit" name = "submit" value = "Log In"  class = "button"/><br><br>
				<label id = "password" class = "message"></label><br><br><br>
				<a href = "http://localhost/SOEN341/src/pages/ResetPasswordPage/resetPassword.php">Forgot password?</a>
				<p><b>Don't have an account? <a class = "signUp" href = "http://localhost/SOEN341/src/pages/SignUpPage/signUp.php"> Sign up </a></b></p>	
		</div>
		</center>

		<?php if ($_POST) {
			if(isset($_POST['submit'])){
				checkingDB();
			}
		}
		
		function checkingDB(){
			$sql = "SELECT u_id, name, pass FROM users";
			$dbconnection = Database::getConnection();
			$result = $dbconnection->query($sql);
			$dbconnection = null;
			$validUsername = true;
			$_SESSION['userID'] = "";
			if(!(preg_match("/[^\w\.\-]/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/",$_POST['password'])) {
				while($row = $result->fetch_assoc()){ 	//fetches values of results and stores in array $row 
					if($row["name"] == $_POST['username']) {
						$validUsername = true;
						if($row["pass"] == $_POST['password']) {
							$_SESSION['userID'] = $row["u_id"];
							header("Location: http://localhost/SOEN341/src/pages/HomePage/HomepageBase.php");
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
		?>
	</body>
</html>