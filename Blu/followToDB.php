<?php 
require_once('../db/DBConfig.php'); 
session_start();

	//Author: Jasen Ratnam 40094237
		//get current user id
		 if (isset($_SESSION["userID"])) {
			 $loggenOnUser = $_SESSION["userID"];
			 echo "Found User: ", $loggenOnUser, "<br />";
		 } else {
			 $loggenOnUser = " a public user";
		 }
	
	$u_id = $loggenOnUser; 
	
	$redirect_path = 'HomepageBase.php';
	
	// User ID of account you want to follow
	// get this from user profile page when its done
	$u_id2 = 5; 
	
	//Declare variables
	$dbconn = null;
	$sql = null;
		
	$sql = "INSERT INTO follow_tbl (u_id, follows) VALUES($u_id, $u_id2)";
	
	$dbconn = Database::getConnection();
	$dbconn->query($sql);
	$dbconn = null;		
	
	header('Location: '.$uri. $redirect_path);
?>