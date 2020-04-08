<?php
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php'); //Must have at the top of any file that needs db connection.

class View{
	var $mU_id, $mP_id;
	
	function WithPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mP_id = $_REQUEST['id'];
    }
	
	function FetchUser() {
		
		if (isset($this->mU_id)) {
			$oLoggenOnUser = $this->mU_id;
			//echo "Found User: ", $oLoggenOnUser, "<br />";
		}else {
			 $oLoggenOnUser = -1;
		}
		return $oLoggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	function FetchPId() {
		$oPId = 0;
		if(isset($this->mP_id) && $this->mP_id !== ''){
		  $oPId = $this->mP_id;
		  //echo $p_id; //comment out echo when not debugging
		} else {
			 $oPId = -1;
		}
		return $oPId; //ensures a numerical value is returned	
	}
}
