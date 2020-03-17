<?php
namespace Website;
use Website\functions\UserEmail;

$cRoot = dirname(__FILE__, 4);
require_once($cRoot . '/src/db/DBConfig.php');
require($cRoot . '/src/pages/FunctionBlocks/AddEmailToDB.php');
require('../SettingsPage/Settings.php');
session_start();
?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link id = "style" rel = "stylesheet" type = "text/css" href = "ModalPopUpStyle.css"/>	
		<?php
			$cUserId = $_SESSION['userID'];
			$mMode = new Settings();
			$cLight = "ModalPopUpStyle.css";
			$cDark = "ModalPopUpStyleDark.css";
			$mResult = $mMode->GetMode($cUserId, $cLight, $cDark);
			echo "<script>document.getElementById('style').setAttribute('href', '$mResult');</script>";
		?>
	</head>
	<body>
		<div class="bg-modal">
		<div class = "close"><a class = "a" href = "../SettingsPage/SettingsPage.php">+</a></div>
			<div class = "modal-content">
				<center class = "text">
				<form action = "ModalPopUpSettings.php" method = "POST">
					<h2>Would you like to add a recovery email address to your account?</h2>
					<p><b>IMPORTANT: Not adding a recovery email address will result in loss of account access if password is forgotten.</b><br><br></p>
					<input type = "email" name = "email" class = "email" placeholder = "Email address" id = "email"/><br><br>
					<input type = "submit" name = "add" class = "button" value = "Add email address" onclick = "alert('Email added successfully!')"/>				</form>
				</center>
			</div>
		</div>
		<?php
			if($_POST){
				if(isset($_POST['add']))
					$wEmail = $_POST['email'];
                    $wUId = $_SESSION['userID'];
					UserEmail::AddEmailToDB($wUId, $wEmail);
					echo "<script>alert('Email added successfully!');</script>";
					header('Location: ../HomePage/HomepageBase.php');
			}
		?>
	</body>
</html> 