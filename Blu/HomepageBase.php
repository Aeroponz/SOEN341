<!DOCTYPE html>
<?php
require_once('../db/DBConfig.php'); //Must have at the top of any file that needs db connection.
require_once('../uploadBlock.php'); //Must have at the top of any page that will be able to post.
require_once('../followBlock.php'); 
session_start();
?>

<html>

	<head>
		<title>BaseHomepage</title>
		<!-- Below can be imported later from CSS files -->
		<!-- Using: <link rel="stylesheet" href="StyleSheet.css"> -->
		<link rel="stylesheet" type="text/css" href="HomepageStyle.css">
	</head>

	<body>
		<!-- get current user id -->
		<?php
		 if (isset($_SESSION["userID"])) {
			 $loggenOnUser = $_SESSION["userID"];
			 echo "Found User: ", $loggenOnUser, "<br />";
		 } else {
			 $loggenOnUser = " a public user";
		 }
		?>
		
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
				<div id="LoggedInUser" class="fluid ">
					<!-- output current user id -->
					Hi.  I'm <?php echo $loggenOnUser; ?> 
				</div>
				
				<!-- inserting post upload block -->
				<?php
					echo uploadBlock::insertForm();
				?>
				
				<!-- inserting follow block -->
				<?php
					echo followblock::follow();
				?>
				
				<h2>Post Title</h2>
				<!-- image source taken from url. (not permanent)-->
				<img class="post" src = "https://i.pinimg.com/736x/36/f7/95/36f795ef5eec0acb7ea035e10102630d.jpg" alt="Test pic of a flower (Identifier)"/>
				<p>Post Info</p>
			</div>
			
		</div>
		
	</body>
</html>