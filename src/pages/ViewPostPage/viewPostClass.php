<?php
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php'); //Must have at the top of any file that needs db connection.

class view{
	var $mU_id, $mP_id;
	
	function withPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mP_id = $_REQUEST['id'];
    }
	
	function fetch_user() {
		
		if (isset($this->mU_id)) {
			$loggenOnUser = $this->mU_id;
			//echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	function fetch_p_id() {
		$p_id = 0;
		if(isset($this->mP_id) && $this->mP_id !== ''){
		  $p_id = $this->mP_id;
		  //echo $p_id; //comment out echo when not debugging
		} else {
			 $p_id = -1;
		}
		return $p_id; //ensures a numerical value is returned	
	}
}
