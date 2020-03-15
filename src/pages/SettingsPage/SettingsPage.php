<?php
namespace Website;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php');
require('Settings.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Settings</title>
    <link id = "style" rel="stylesheet" type="text/css" href="settingsPageStyle.css"/>
	<?php
		$_SESSION['u_id'] = 3;
		$wUserId = $_SESSION['u_id'];
		$wMode = new Settings();
		$wResult = $wMode->GetMode($wUserId);
	?>
</head>
<body>
<center>
    <div class="backgroundColor">
		<div class = "close"><a href = "../HomePage/HomepageBase.php">+</a></div>
        <img src="../GenericResources/Blu.png" class="logoLogin">
        <br><br><br>
		<button type = "button" name = "ChangePassword">Change Password</button><br><br>
		<button type = "button" name = "Email">Add or change recovery email address</button><br>
		<form action = "SettingsPage.php" method = "post" id = "form">
		<div class = "sliderWrapper">
				<div>Dark mode:</div>
				<label class = "switch">
					<input type = "checkbox" value = "dark" name = "dark" onclick = "document.getElementById('form').submit();" <?php echo (isset($_POST['dark']))? "checked='checked'": "";?>/>
					<span class = "slider round"></span>
				</label>
			</div><br>
		<form>
		<button type = "button" name = "Logout">Log out</button><br><br>
		<button type = "button" name = "DeleteAccount" class = "delete">Delete Account</button>
       
       
    </div>
<?php
	if (isset($_POST))
	{
		$wUserId = $_SESSION['u_id'];
		if(isset($_POST['dark'])){
			echo "<script>document.getElementById('style').setAttribute('href', 'settingsPageStyleDark.css');</script>";
			$wDark = new Settings();
			$wResult = $wDark->ChangeToDark($wUserId);
		}
		else {
			echo "<script>document.getElementById('style').setAttribute('href', 'settingsPageStyle.css');</script>";
			$wLight = new Settings();
			$wResult = $wLight->ChangeToLight($wUserId);
		}
	}
	?>
	</script>
</center>