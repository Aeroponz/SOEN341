<!DOCTYPE html>
<html>

	<head>
		<title>BaseHomepage</title>
		<!-- Below can be imported later from CSS files -->
		<!-- Using: <link rel="stylesheet" href="StyleSheet.css"> -->
		<link rel="stylesheet" type="text/css" href="HomepageStyle.css">
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
				<li><a href="HomepageBase.php">Home</li>
				<li><a href="SettingsPage.php">Settings</a></li>
				<li><a href="loginPage.php">Logout</a></li>
			</ul>
		</div>
		
		<div class = "main">
			<!--Post format-->
			<div id = "container_post">
				<h2>Post Title</h2>
				<!-- image source taken from url. (not permanent)-->
				<img class="post" src = "https://i.pinimg.com/736x/36/f7/95/36f795ef5eec0acb7ea035e10102630d.jpg" alt="Test pic of a flower (Identifier)"/>
				<p>Post Info</p>
			</div>
			
		</div>
		
	</body>
</html>