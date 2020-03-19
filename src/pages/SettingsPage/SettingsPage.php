<?php
//Author: Alya Naseer
//Co-Author: Pierre-Alexis Barras <Pyxsys>
namespace Website;
$cRoot = dirname(__FILE__, 4);
require_once($cRoot . '/src/db/DBConfig.php');
require('Settings.php');
require('Logout.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Settings</title>
	<link id = 'style' rel='stylesheet' type='text/css' href='settingsPageStyle.css'/>
	<?php
		$cUserId = $_SESSION['userID'];
		$mMode = new Settings();
		$cLight = "settingsPageStyle.css";
		$cDark = "settingsPageStyleDark.css";
		$mResult = $mMode->GetMode($cUserId, $cLight, $cDark);
		echo "<script>document.getElementById('style').setAttribute('href', '$mResult');</script>";
	?>
</head>
<body>
<center>
    <div class="backgroundColor">
		<div class = "close"><a href = "../HomePage/HomepageBase.php">+</a></div>
        <img src="../GenericResources/Blu.png" class="logoLogin"/>
        <br/><br/><br/>
		
		<!-- PFP -->
			<div id = "submit_post" class = "upload_block, Content">
				<form method="POST" action="uploadPFP.php" enctype="multipart/form-data">
					<input type="file" id="fileinput" onchange="ValidatePFP();" name="PFPInput">
					<label for="fileinput" id="fl">Upload Profile Picture</label>
					<input class="dark" type="submit" id="submitbutton" name="submit_image" value="Update Profile Pic" style="font-weight:bold;">
				</form><br/>

				
			</div>
		<!-- endof PFP -->	
		
		<a href = "../ResetPasswordPage/newPasswordPageSettings.php"><button type = "button" name = "ChangePassword">Change Password</button><br/><br/></a>
		<a href = "../SignUpPage/ModalPopUpSettings.php"><button type = "button" name = "Email">Add or change recovery email address</button><br/><br/></a>
		<form action = "SettingsPage.php" method = "post" id = "form">
			<input type = "submit" value = "Dark mode" class= "dark" name = "dark"/>
			<input type = "submit" value = "Light mode" class= "light" name = "light"/>
			<br/><br/>
		</form>
		<button type = "submit" name = "Logout">Log out</button><br/><br/>
		<button type = "submit" name = "DeleteAccount" class = "delete">Delete Account</button>
       
       
    </div>
	<div id="warnings"></div>
	<script type="text/javascript" src="/SOEN341/src/pages/FunctionBlocks/validUpload.js"></script>
<?php
	if (isset($_POST))
	{
		if(isset($_POST['dark'])){
			echo "<script>document.getElementById('style').setAttribute('href', 'settingsPageStyleDark.css');</script>";
			$wDark = new Settings();
			$wResult = $wDark->ChangeToDark($cUserId);
		}
		else if(isset($_POST['light'])){
			echo "<script>document.getElementById('style').setAttribute('href', 'settingsPageStyle.css');</script>";
			$wLight = new Settings();
			$wResult = $wLight->ChangeToLight($cUserId);
		}
		else if(isset($_POST['Logout'])){
			$wLogOut = new LogOut();
			$wResult = $wLogOut->LogOut();
			if($wResult)
				header('Location: ../LoginPage/loginPage.php');
		}
		else if(isset($_POST['DeleteAccount'])){
			header('Location: DeleteAccountPage.php');
			$wDeleteAccount = new DeleteAccount();
			$wResult = $wDeleteAccount->DeleteAccount($_SESSION['userID']);
			if($wResult)
				header('Location: ../LoginPage/loginPage.php');
		}
	}
	?>
</center>
</body>
<htmll>