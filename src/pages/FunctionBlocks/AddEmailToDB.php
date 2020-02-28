<?php 
	function addEmailToDB($email){
		$u_id = $_SESSION['userID'];
		echo $u_id;
		$result = Database::safeQuery("UPDATE users SET email = '$email' WHERE u_id = '$u_id';");
	}
?>
