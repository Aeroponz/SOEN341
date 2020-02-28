<?php
namespace Website\functions;
use SqlDb\Database;
class UserEmail
{
	static function addEmailToDB($u_id, $email)
	{
		Database::safeQuery("UPDATE users SET email = '$email' WHERE u_id = '$u_id';");
		return 0;
	}
}
?>
