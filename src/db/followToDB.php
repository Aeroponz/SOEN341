<?php 
require_once('../db/DBConfig.php'); 
	//Author: Jasen Ratnam 40094237
	
	//TODO: Update to session values when available, update to new page after following
	$u_id = 2; 
	$redirect_path = '../db/dbPHPexample.php';
	
	// User ID of account you want to follow
	// get this from user profile page when its done
	$u_id2 = 4; 
	
	//Declare variables
	$dbconn = null;
	$sql = null;
		
	$sql = "INSERT INTO follow_tbl (u_id, follows) VALUES($u_id, $u_id2)";
	
	$dbconn = Database::getConnection();
	$dbconn->query($sql);
	$dbconn = null;		
	
	header('Location: '.$uri. $redirect_path);
?>
