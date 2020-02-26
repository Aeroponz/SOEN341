<?php 
require_once('../db/DBConfig.php'); 
session_start();
	//Author: Jasen Ratnam
	
	
	//get current user id
	if (isset($_SESSION["userID"])) {
		$loggenOnUser = $_SESSION["userID"];
		echo "Found User: ", $loggenOnUser, "<br />";
	} else {
		$loggenOnUser = " a public user";
	}

	
	
	$u_id = $loggenOnUser; 
	
	//Declare variables
	$dbconn = null;
	$sql = null;
	
	
	
	$text = $_POST["CommentText"];
	$p_id = $_POST["p_id"];
		
	$sql = "INSERT INTO comments (p_id, u_id, txt_content) VALUES($p_id, $u_id, '$text')";
	
	$dbconn = Database::getConnection();
	$dbconn->query($sql);
	$dbconn = null;	
	
	
	header("Location: ../pages/viewPostPage/viewPost.php?id= $p_id");
?>

<html>
<body>

Welcome <?php echo $p_id; ?><br>
Your email address is: <?php echo $text; ?>

</body>
</html>
