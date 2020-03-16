<?php 
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;

class DeleteAccount
{
	
 
	//This function changes to light
    function DeleteAccount($iUserId)
    {
        $wDbQuery = Database::safeQuery("UPDATE users SET name = '[deleted]', pass = '', email = 'NULL', rating = '0' WHERE u_id = '$iUserId'");
        return true;

    }
}
?>