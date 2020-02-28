<?php 
require_once('../db/DBConfig.php'); 
session_start();
	//Author: Jasen Ratnam 40094237
	
	function follows($loggenOnUser,$u_id2){
		$dbconn = Database::getConnection();
		$sql = "SELECT * FROM follow_tbl";  
		$result = Database::query($sql, $dbconn);
		
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
	
	//get u_id from session.
	function fetch_user() {
		
		if (isset($_SESSION["userID"])) {
			$loggenOnUser = $_SESSION["userID"];
			echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//get u_id of following user.
	function fetch_follow_user() {
		
		if (isset($_POST["u_id2"])) {
			$loggenOnUser = $_POST["u_id2"];
			echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	function add_follow_to_db(){
		$sql = null;
		$u_id =null;
		$u_id2 =null;
		
		$u_id = fetch_user();
		if($u_id == -1){return -3;} //no user
		
		$u_id2 = fetch_follow_user();
		if($u_id2 == -1){return -4;} //no user to follow
		
		$followRes = 0;
		if(!follows($u_id, $u_id2)){
			$followRes  = 1; //followd
			$sql = "INSERT INTO follow_tbl (u_id, follows) VALUES($u_id, $u_id2)";
			
			Database::safeQuery($sql);
		}
		else{
			$followRes = 2;	//unfollowed		
			$sql = "DELETE FROM follow_tbl WHERE u_id= $u_id AND follows = $u_id2";
		
			Database::safeQuery($sql);
		}
		return $followRes;
	}
	
	//script
	$output = add_follow_to_db();
	
?>