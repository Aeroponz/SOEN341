<?php 
require_once('../db/DBConfig.php'); 
session_start();
	//Author: Jasen Ratnam 40094237
	$dbconn = Database::getConnection();
	function follows($u_id2){
		global $loggenOnUser, $dbconn;
		$dbconn = Database::getConnection();
		$sql = "SELECT * FROM follow_tbl";  
		$result = $dbconn->query($sql);
		
		if ($result->num_rows > 0) {
			// each row
			while($row = $result->fetch_assoc()) {
				
				if($loggenOnUser == $row["u_id"]){
					if($u_id2 == $row["follows"]){
						return true;
					}	
				}
			}
		} 
		else{
			return false;
		}
	}
	
	//get current user id
	 if (isset($_SESSION["userID"])) {
		 $loggenOnUser = $_SESSION["userID"];
	 } else {
		 $loggenOnUser = " a public user";
	 }
	
	$u_id = $loggenOnUser;
	 
	//Declare variables
	$dbconn = null;
	$sql = null;
	
	// User ID of account you want to follow
	$u_id2 = $_POST["u_id2"];
	if(!follows($u_id2)){
			
		$sql = "INSERT INTO follow_tbl (u_id, follows) VALUES($u_id, $u_id2)";
		
		$dbconn = Database::getConnection();
		$dbconn->query($sql);
		$dbconn = null;	
	}
	else{	 
		$sql = "DELETE FROM follow_tbl WHERE u_id= $u_id AND follows = $u_id2";
	
		$dbconn = Database::getConnection();
		
		if ($dbconn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} 
		else {
			echo "Error deleting record: " . $conn->error;
		}
		$dbconn = null;	
	}
?>