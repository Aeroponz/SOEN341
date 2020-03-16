<?php 
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__,3);
require_once($root . '/src/db/DBConfig.php'); 
//session_start();

class follow{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
    var $mU_id, $mU_id2;
	function withPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mU_id2 = $_POST["u_id2"];
    }
	
	function follows($iLoggenOnUser,$iU_id2){

		$dbconn = Database::getConnection();
		$sql = "SELECT * FROM follow_tbl";  
		$result = Database::query($sql, $dbconn);
		
		if ($result->num_rows > 0) {
			// each row
			while($row = $result->fetch_assoc()) {
				
				if($iLoggenOnUser == $row["u_id"]){
					if($iU_id2 == $row["follows"]){
						return true;
					}	
				}
			}
		} 
		else{
			return false;
		}
		$dbconn = null;
	}
	
	//get u_id from session.
	function fetch_user() {
		
		if (isset($this->mU_id)) {
			$loggenOnUser = $this->mU_id;
			echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//get u_id of following user.
	function fetch_follow_user() {
		
		if (isset($this->mU_id2)) {
			$loggenOnUser = $this->mU_id2;
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
		
		$u_id = $this->fetch_user();
		if($u_id == -1){return -3;} //no user
		
		$u_id2 = $this->fetch_follow_user();
		if($u_id2 == -1){return -4;} //no user to follow
		
		$followRes = 0;
		if(!$this->follows($u_id, $u_id2)){
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
}
	
?>