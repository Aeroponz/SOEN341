<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Login</title>
		<link rel = "stylesheet" type = "text/css" href = "headerStyle.css"/>
		<!-- Used https://www.w3schools.com/howto/howto_google_fonts.asp for font -->
		<!--<link href='https://fonts.googleapis.com/css?family=Big Shoulders Text' rel='stylesheet'>
		<style>
		body {
			font-family: 'Big Shoulders Text';
		}
		</style> -->
	</head>
	<body>
		<center><div class = "backgroundColor">
			<img src = "Blu.png" class = "logo">
			<p>Sign up to view photos and videos<br>from your friends and family</p>
			<?php session_start();?>
			<form action = "signUp.php" method = "post">
				<input type = "text" name = "username" placeholder = "Username" class = "creds"/>
				<br><br>
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/>
				<br><br>
				<input type = "password" name = "passwordConfirm" placeholder = "Confirm password" class = "creds"/>
				<br><br>
				<input class = "button" type = "Submit" value = "Sign up" name = "readingFile"/>
				<br><br>
				<label id = "password" class = "message"></label><br>	
				<label id = "message" class = "message"></label>
				<br>
				<p>Have an account? <a class = "signUp" href = "loginPage.php"> Sign in </a></p>
				
				
				<style>
					.message {color: red;}
				</style>
		
		</div></center>

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
			$availableUsername = true;
			$validPassword = true;
			$_SESSION['user'] = "";
			if((preg_match("/([A-Z]*[a-z]*[0-9]*)/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z]).{6,}$/",$_POST['password']) && preg_match("/^(?=.*\d)(?=.*[A-Za-z]).{6,}$/",$_POST['passwordConfirm'])) {
				while($i < sizeof($fileInfo)&& $validPassword){
					$string = explode(":", $fileInfo[$i]);
					if(isset($_POST['username'])){
						if($_POST['username'] != $string[0]) {
							$availableUsername = true;
						}
						else {
							echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Username already exists\";
								</script>";
								$validPassword = false;
								$availableUsername = false;
						}
					}	
						
					else
						$availableUsername = false;
				
					$i++;
				}
				if($availableUsername == true && $_POST['password'] == $_POST['passwordConfirm']){
					$info = "\n".$_POST['username'].":".$_POST['password'];
					$write = file_put_contents("loginFile.txt", $info, FILE_APPEND | LOCK_EX);
					fclose($file);
					$_SESSION['user'] = $_POST['username'];
					header("Location: HomepageBase.html");
				}
				else
					echo "<script type = \"text/JavaScript\">
							document.getElementById('message').innerHTML = \"Passwords don't match\";
							</script>";
			}
			if((preg_match("/([A-Z]*[a-z]*[0-9]*)/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z]).{6,}$/",$_POST['password']) == false)
				echo "<script type = \"text/JavaScript\">
						document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
					</script>";
		}
		?>
	</body>
</html>

