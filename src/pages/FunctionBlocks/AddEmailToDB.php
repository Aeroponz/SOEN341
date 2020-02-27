<?php 
	require('../FunctionBlocks/CheckingDBFunction.php'); 
	session_start();
	
	function addEmailToDB($email){
		$u_id = $_SESSION['userID'];
		checkingDB("UPDATE users SET email = '$email' WHERE u_id = '$u_id';");
		$dbconnection = null;
	}
?>
