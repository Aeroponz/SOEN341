<?php
namespace Website\functions;
use SqlDb\Database;
class UserEmail
{
	//This function adds the email of a specific userID to the database
	static function addEmailToDB($u_id, $email)
	{
		Database::safeQuery("UPDATE users SET email = '$email' WHERE u_id = '$u_id';");
		return 0;
	}
}
?>
