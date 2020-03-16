<?php 
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;

class DeleteAccount
{
	
 
	//This function changes to light
    function DeleteAccount($iUserId)
    {
        $wDbQuery = Database::safeQuery("DELETE FROM user_profile WHERE u_id = '$iUserId'");
		$wDbQuery2 = Database::safeQuery("DELETE FROM users WHERE u_id = '$iUserId'");
        return true;

    }
	
	
}
?>