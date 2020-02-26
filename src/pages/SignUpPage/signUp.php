<!DOCTYPE html>
<?php require_once('../../db/DBConfig.php'); 
	  require('../FunctionBlocks/checkUsernameAndPassword.php');
?>	
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Sign Up</title>
		<link rel = "stylesheet" type = "text/css" href = "signUpPageStyle.css"/>
	</head>
	<body>
		<center><div class = "backgroundColor">
			<img src = "../GenericResources/Blu.png" class = "logo">
			
			<?php
				//Outputs a custom message depending if user was redirected to this page.
				if(isset($_GET["source"])) {
					if($_GET["source"] == 'post') echo "<p style = \"color:red;\"> You must have an account to create posts.</p>";
				}				
			?>
			
			<p>Sign up to view photos and videos<br>from your friends and family</p>
			<?php session_start();?>
			<form action = "signUp.php" method = "post">
			
				<!-- The code: echo htmlspecialchars($_POST['username'], ENT_QUOTES); written below as the value for username was taken from https://www.gamedev.net/forums/topic/564843-how-to-keep-input-fields-after-page-refresh/ -->
				<input type = "text" name = "username" placeholder = "Username" value = "<?php if (isset($_POST['username'])) {echo htmlspecialchars($_POST['username'], ENT_QUOTES);}?>" class = "creds"/><br><br>
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/><br><br>
				<input type = "password" name = "passwordConfirm" placeholder = "Confirm password" class = "creds"/><br><br>
				<input class = "button" type = "Submit" value = "Sign up" name = "submit"/><br><br>
				<label id = "password" class = "message"></label><br><br>
				<div class = "passwordRequirements" align = "left">
					<label>Your password must include at least:</label>
					<ul>
						<li>6 characters</li>
						<li>One number and one letter</li>
						<li>One special character</li>
					</ul>
				</div><br>
				<label><b>Have an account? <a class = "login" href = "../LoginPage/LoginPage.php"> Sign in </a></label></b>		
		</div></center>


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
			$availableUsername = true;
			$_SESSION['userID'] = "";
			//if(!(preg_match("/[^\w\.\-]/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/",$_POST['password'])) {
			if(checkUsername($_POST['username']) && checkPassword($_POST['password'])){
				while($row = $result->fetch_assoc()){ 	//fetches values of results and stores in array $row 
					if($row["name"] != $_POST['username'])
							$availableUsername = true;
					else {
						$availableUsername = false;
						break;
					}
				}	

				if($availableUsername == true && $_POST['password'] == $_POST['passwordConfirm']){
					$username = $_POST['username'];
					$password = $_POST['password'];
					$lastUserID = "SELECT u_id FROM users ORDER BY u_id DESC LIMIT 1";
					$dbconnection = Database::getConnection();
					$result2 = $dbconnection->query($lastUserID);
					$valueID = $result2->fetch_assoc();
					$valueID['u_id'] += 1;
					$userIDValue = $valueID['u_id'];
					$_SESSION['userID'] = $userIDValue;
					$sql3 = "INSERT INTO users(u_id, name, pass) VALUES ('$userIDValue', '$username', '$password')";
					$result3 = $dbconnection->query($sql3);
					$sql4 = "INSERT INTO user_profile(u_id) VALUES ('$userIDValue')";
					$result4 = $dbconnection->query($sql4);
					$dbconnection = null;
					$_SESSION['message'] = "Add a recovery email address to your account";
					header("Location: ../HomePage/HomepageBase.php");
				}
				else if($availableUsername == false)
					echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Username already exists\";
							</script>";
				else
					echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Passwords don't match\";
							</script>";
			}
			else
				echo "<script type = \"text/JavaScript\">
						document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
					</script>";
		}
		
		?>
	</body>
	
</html>


