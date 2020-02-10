<!DOCTYPE html>
<?php require_once('C:/xampp/htdocs/Blu/db/DBConfig.php'); ?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>Login</title>
		<link rel = "stylesheet" type = "text/css" href = "loginPageStyle.css"/>
	</head>
	<body>
		<center><div class = "backgroundColor">
			<img src = "Blu.png" class = "logo">
			<p>Sign up to view photos and videos<br>from your friends and family</p>
			<?php session_start();?>
			<form action = "signUp.php" method = "post">
			
				<!-- The code: echo htmlspecialchars($_POST['username'], ENT_QUOTES); written below as the value for username was taken from https://www.gamedev.net/forums/topic/564843-how-to-keep-input-fields-after-page-refresh/ -->
				<input type = "text" name = "username" placeholder = "Username" value = "<?php if (isset($_POST['username'])) {echo htmlspecialchars($_POST['username'], ENT_QUOTES);}?>" class = "creds"/><br><br>
				<input type = "password" name = "password" placeholder = "Password" class = "creds"/><br><br>
				<input type = "password" name = "passwordConfirm" placeholder = "Confirm password" class = "creds"/><br><br>
				<input class = "button" type = "Submit" value = "Sign up" name = "readingFile"/><br><br>
				<label id = "password" class = "message"></label><br><br>
				<div class = "passwordRequirements" align = "left">
					<label>Your password must include at least:</label>
					<ul>
						<li>6 characters</li>
						<li>One number and one letter</li>
						<li>One special character</li>
					</ul>
				</div><br>
				<label><b>Have an account? <a class = "signUp" href = "loginPage.php"> Sign in </a></label></b>		
		</div></center>


		<?php if ($_POST) {
			if(isset($_POST['readingFile'])){
				checkingDB();
			}
		}

		function checkingDB(){
			$fileName = "loginFile.txt";
			$file = fopen($fileName, "r, w");
			$fileRead = fread($file, filesize($fileName));
			$fileInfo = file($fileName, FILE_IGNORE_NEW_LINES);
			$i = 0;
			$availableUsername = true;
			$validPassword = true;
			$_SESSION['user'] = "";
			if(!(preg_match("/[^\w\.\-]/", $_POST['username'])) && preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/",$_POST['password'])) {
				while($i < sizeof($fileInfo)&& $validPassword){
					$string = explode(":", $fileInfo[$i]);
					if(isset($_POST['username'])){
						if($_POST['username'] != $string[0]) {
							$availableUsername = true;
						}
						else {
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

