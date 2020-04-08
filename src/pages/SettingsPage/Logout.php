<?php 
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;

class Logout
{
	
 
	//This function changes to light
    static function LogOut()
    {
        //session_start();
		$_SESSION = array();
		//session_destroy();

        if ($_SESSION['userID'] != null) return false;
        return true;

    }
	
	
}
?>