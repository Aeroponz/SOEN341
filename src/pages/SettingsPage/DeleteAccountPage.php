<?php
//Author: Alya Naseer
namespace Website;
$cRoot = dirname(__FILE__, 4);
require_once($cRoot . '/src/db/DBConfig.php');
require('DeleteAccount.php');
require('Settings.php');
session_start();
?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link id = "style" rel = "stylesheet" type = "text/css" href = "DeleteAccountPopUp.css"/>	
		<?php
			$cUserId = $_SESSION['userID'];
			echo $cUserId;
			$mMode = new Settings();
			$cLight = "DeleteAccountPopUp.css";
			$cDark = "DeleteAccountPopUpDark.css";
			$mResult = $mMode->GetMode($cUserId, $cLight, $cDark);
			echo "<script>document.getElementById('style').setAttribute('href', '$mResult');</script>";
		?>
	</head>
	<body>
		<div class="bg-modal">
			<div class = "modal-content">
				<center class = "text">
				<form action = "DeleteAccountPage.php" method = "POST">
					<h2>Are you sure you want to delete your account?</h2>
					<p><b>This cannot be undone</b></p><br>
					<input type = "submit" name = "yes" class = "yes" value = "Yes"/>
					<input type = "submit" name = "no" class = "no" value = "No"/>
				</form>
				</center>
			</div>
		</div>
		<?php
			if($_POST){
				if(isset($_POST['yes'])) {
					$wDeleteAccount = new DeleteAccount();
					$wResult = $wDeleteAccount->DeleteAccount($_SESSION['userID']);
					if($wResult)
						header('Location: ../LoginPage/LoginPage.php');
				}
				else if(isset($_POST['no']))
					header('Location: ../SettingsPage/SettingsPage.php');
			}
		?>
	</body>
</html> 