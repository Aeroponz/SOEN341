<?php 
namespace Website;
use SqlDb\Database;

class Logout
{
	
 
	//This function changes to light
    function LogOut()
    {
        session_start();
		$_SESSION = array();
		session_destroy();
        return true;

    }
	
	
}
?>