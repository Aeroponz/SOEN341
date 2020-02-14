<!DOCTYPE html>
<html>

	<head>
		<title>Settings</title>
		<!-- Below can be imported later from CSS files -->
		<!-- Using: <link rel="stylesheet" href="StyleSheet.css"> -->
		<link rel="stylesheet" type="text/css" href="SettingsStyle.css">
	</head>

	<body>
		<!--Header Format-->
		<div id = "container_top">
			<img class="post" src = "Blu_logo_square.png" alt="Company Logo"
			style="width:75px;height:75px;">
		</div>
		
		<!--Sidebar Format-->
		<div id = "container_sideL">
			<img class="post" src = "Blu.png" alt="Company Logo"
			style="width:112.5px;height:45px;">
			<p>Welcome to Blu</p>
			<ul>
				<li><a href="http://localhost/SOEN341/src/pages/HomePage/HomepageBase.php">Home</li>
				<li><a href="http://localhost/SOEN341/src/pages/SettingsPage/SettingsPage.php">Settings</a></li>
				<li><a href="http://localhost/SOEN341/src/pages/LoginPage/loginPage.php">Logout</a></li>
			</ul>
		</div>
		
		<div class = "main">
			<div id = "container_settings">

				<form id="settings" action="" >
					<input type="text" name="nameChange" placeholder="New Username">
					<br>
					<input type="password" name="newPassword" placeholder="New Password">
					<br>
					Enable Dark Mode:  
					<input type="checkbox" name="enableDarkmode">
					<br>
					<input type="submit" >
				</form>

				<button class="logOut" id="logoutSignout" name="logout" >Logout</button> <br>
				<button class="deleteAcc" id="logoutSignout">Delete Account</button>
				</form>
			</div>
		</div>
		
	</body>
</html>