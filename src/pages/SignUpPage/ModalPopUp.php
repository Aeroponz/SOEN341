<?php
namespace Website;
use Website\functions\UserEmail;

$cRoot = dirname(__FILE__, 4);
require_once($cRoot . '/src/db/DBConfig.php');
require($cRoot . '/src/pages/FunctionBlocks/AddEmailToDB.php');
	session_start();
?>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<link rel = "stylesheet" type = "text/css" href = "ModalPopUpStyle.css"/>	
		<script type = "text/javaScript" src = "ModalPopUpAppear.js"></script>
	</head>
	<body>
		<div class="bg-modal">
			<div class = "modal-content">
				<center class = "text">
				<form action = "ModalPopUp.php" method = "POST">
					<h2>Would you like to add a recovery email address to your account?</h2>
					<p><b>IMPORTANT: Not adding a recovery email address will result in loss of account access if password is forgotten.</b><br><br><i>An email address can be added later in the settings<i></p>
					<input type = "email" name = "email" class = "email" placeholder = "Email address" id = "email"/><br><br>
					<input type = "submit" name = "add" class = "button" value = "Add email address" onclick = "alert('Email added successfully!')"/>
					<input type = "button" name = "later" class = "button" value = "Maybe later" onclick = "location.href = '../HomePage/HomepageBase.php';"/>
				</form>
				</center>
			</div>
		</div>
		<?php
			if($_POST){
				if(isset($_POST['add']))
					$wEmail = $_POST['email'];
                    $wUId = $_SESSION['userID'];
					UserEmail::AddEmailToDB($wUId, $wEmail);
					header('Location: ../HomePage/HomepageBase.php');
			}
		?>
	</body>
</html> 