<?php 
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__,3);
require_once($root . '/src/db/DBConfig.php'); 
//session_start();

class Follow{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
    var $mU_id, $mU_id2;
	function WithPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mU_id2 = $_POST["u_id2"];
    }
	
	function Follows($iLoggenOnUser,$iU_id2){

		$wDbConn = Database::getConnection();
		$wSql = "SELECT * FROM follow_tbl";  
		$wResult = Database::query($wSql, $wDbConn);
		
		if ($wResult->num_rows > 0) {
			// each row
			while($wRow = $wResult->fetch_assoc()) {
				
				if($iLoggenOnUser == $wRow["u_id"]){
					if($iU_id2 == $wRow["follows"]){
						return true;
					}	
				}
			}
		} 
		else{
			return false;
		}
		return false;
	}
	
	//get u_id from session.
	function FetchUser() {
		
		if (isset($this->mU_id)) {
			$oLoggenOnUser = $this->mU_id;
			echo "Found User: ", $oLoggenOnUser, "<br />";
		}else {
			 $oLoggenOnUser = -1;
		}
		return $oLoggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//get u_id of following user.
	function FetchFollowUser() {
		
		if (isset($this->mU_id2)) {
			$oLoggenOnUser = $this->mU_id2;
			echo "Found User: ", $oLoggenOnUser, "<br />";
		}else {
			 $oLoggenOnUser = -1;
		}
		return $oLoggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	function AddFollowToDb(){
		$wSql = null;
		$wU_id =null;
		$wU_id2 =null;

		$wU_id = $this->FetchUser();
		if($wU_id == -1){return -3;} //no user

		$wU_id2 = $this->FetchFollowUser();
		if($wU_id2 == -1){return -4;} //no user to follow

		$oFollowRes = 0;
		if(!$this->Follows($wU_id, $wU_id2)){
			$oFollowRes  = 1; //followd
			$wSql = "INSERT INTO follow_tbl (u_id, follows) VALUES($wU_id, $wU_id2)";
			
			Database::safeQuery($wSql);
		}
		else{
			$oFollowRes = 2;	//unfollowed		
			$wSql = "DELETE FROM follow_tbl WHERE u_id= $wU_id AND follows = $wU_id2";
		
			Database::safeQuery($wSql);
		}
		return $oFollowRes;
	}
}
	
?>