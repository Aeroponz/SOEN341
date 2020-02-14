<!DOCTYPE html>
<?php require_once('C:/xampp/htdocs/SOEN341/src/db/DBConfig.php'); ?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Home</title>
		<link rel = "stylesheet" type = "text/css" href = "resetPasswordStyle.css"/>
	</head>
	<body>
		<center>
		<div class = "backgroundColor">
			<img src = "http://localhost/SOEN341/src/pages/GenericRessources/Blu.png" class = "logoLogin">
			<br><br><br>
			<p>Enter below the email address associated to your account</p>
			<?php session_start();?>
			<form action = "resetPassword.php" method = "post">
				<input type = "email" name = "email" placeholder = "Email Address" class = "creds"/><br><br>
				<input type = "Submit" name = "submit" value = "Email code"  class = "button"/><br><br>
				<label id = "message" class = "message"></label><br><br><br>
		</div>
		</center>
		
		<?php if ($_POST) {
			if(isset($_POST['submit'])){
				checkingDB();
			}
		}
		
		function checkingDB(){
			$sql = "SELECT u_id, email FROM users";
			$dbconnection = Database::getConnection();
			$result = $dbconnection->query($sql);
			$dbconnection = null;
			$validEmail = true;
			$_SESSION['userID'] = "";
			while($row = $result->fetch_assoc()){ 	//fetches values of results and stores in array $row 
				if($row["email"] == $_POST['email']) {
					$validEmail = true;
					$_SESSION['userID'] = $row["u_id"];
					$msg = "test";
					$email = "alya_naseer@outlook.com";//$row['email'];
					ini_set();
					mail($email, "Test", $msg);
					echo "<script type = \"text/JavaScript\"> 
					document.getElementById('message').innerHTML = \"An email has been sent with a link to reset your password. <br>Please make sure to check your spam folder\";</script>";
					break;
				}
				else 
					$validEmail = false;
			}
			if($validEmail == false){
				echo "<script type = \"text/JavaScript\">
					document.getElementById('message').innerHTML = \"Email address provided is not associated to an account\";
					</script>";
			}
		}
		?>
		
	</body>
</html>