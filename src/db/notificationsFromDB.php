<?php 
namespace Website;
use SqlDb\Database;
$Root = dirname(__FILE__,3);
require_once($Root . '/src/db/DBConfig.php'); 
require_once($Root . '/src/db/UploadClass.php');

class Notifications{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
	var $mU_id, $mTime;
	function WithPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mTime = $_SESSION['time'];
    }
	
	function GetFlag()
	{
		if (isset($_SESSION['flag'])) {
			$oFlag = $_SESSION['flag'];
		}else {
			 $oFlag = -1;
		}
		return $oFlag;
	}
	
	function GetTime()
	{
		if (isset($_SESSION['time'])) {
			$oTime = $_SESSION['time'];
		}else {
			 $oTime = -1;
		}
		return $oTime;
	}
	
	function UpdateTimeStamp($iRefreshTime)
	{
		$_SESSION['time'] = $iRefreshTime;
		//echo $iRefreshTime;
		return true;
	}
	
	function NewPosts()
    {
		$New = new Follow();
		
		$wU_id = Upload::FetchUser();
		if($wU_id == -1){return -3;} //no user
		
		$wTime = $this->GetTime();
		if($wTime == -1){return -4;} //Time error
		
		$wDbConn = Database::getConnection();
		$wSql = "SELECT * FROM posts
				 WHERE posts.posted_on > '$wTime'";//DATE_SUB(CURDATE(), INTERVAL 1 DAY)";  
		$wResult = Database::query($wSql, $wDbConn);
		if($wResult === false)
		{
		   echo "fail";
		   return false;
		}
		if ($wResult->num_rows > 0) {
			// each row
			while($wRow = $wResult->fetch_assoc()) {
				
				if($New->Follows($wU_id,$wRow["u_id"])){
					return true;
				}
			}
		} 
		$wDbConn = null;
		return false;
	}
}