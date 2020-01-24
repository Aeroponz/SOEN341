<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Login</title>
		<link rel = "stylesheet" type = "text/css" href = "loginPageStyle.css"/>
	</head>
	<body>
		<center>
		<div class = "backgroundColor">
			<img src = "Blu.png" class = "logoLogin">
		
			<?php session_start();?>
			<br><br><br>
			<form action = "loginPage.php" method = "post">
				<input type = "text" name = "username" placeholder = "Username" class = "creds"/><br><br>
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/><br><br>
				<input type = "Submit" name = "readingFile" value = "Log In"  class = "button"/><br><br>
				<label id = "password" class = "message"></label><br><br><br>
				<a href = "resetPassword.php">Forgot password?</a>
				<p><b>Don't have an account? <a class = "signUp" href = "signUp.php"> Sign up </a></b></p>	
		</div>
		</center>

		<?php if ($_POST) {
			if(isset($_POST['readingFile'])){
				readingFile();
			}
		}

		function readingFile(){
			$fileName = "loginFile.txt";
			$file = fopen($fileName, "r, w");
			$fileRead = fread($file, filesize($fileName));
			$fileInfo = file($fileName, FILE_IGNORE_NEW_LINES);
			$i = 0;
			$validUsername = true;
			$validPassword = true;
			$_SESSION['user'] = "";
			if((preg_match("/([A-Z]*[a-z]*[0-9]*)/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z]).{6,}$/",$_POST['password'])) {
				while($i < sizeof($fileInfo)&& $validPassword){
					$string = explode(":", $fileInfo[$i]);
					if(isset($_POST['username'])){
						if($_POST['username'] == $string[0]) {
							$validUsername = true;
							if(isset($_POST['password'])){
								if($_POST['password'] == $string[1]) {
									$_SESSION['user'] = $_POST['username'];
									header("Location: HomepageBase.html");
									break;
								}
								else {
									echo "<script type = \"text/JavaScript\">
									document.getElementById('password').innerHTML = \"Invalid login\";
									</script>";
									$validPassword = false;
								}
							}
						}
						else
							$validUsername = false;
					}
					$i++;
				}
				if($validUsername == false){
					fclose($file);
					echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Invalid login\";
							</script>";
				}
			}
			if((preg_match("/([A-Z]*[a-z]*[0-9]*)/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z]).{6,}$/",$_POST['password']) == false)
				echo "<script type = \"text/JavaScript\">
						document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
					</script>";
		}
		?>
	</body>
</html>

