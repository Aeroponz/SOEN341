<?php
//Author: Alya Naseer
namespace Website\functions;
use SqlDb\Database;
class UserEmail
{
	//This function adds the email of a specific userID to the database
	static function AddEmailToDB($iU_id, $iEmail)
	{
		Database::safeQuery("UPDATE users SET email = '$iEmail' WHERE u_id = '$iU_id';");
		return 0;
	}
}
?>
