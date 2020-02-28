<?php
namespace Website\functions;
use SqlDb\Database;
class UserEmail
{
	static function addEmailToDB($email)
	{
		$u_id = $_SESSION['userID'];
		if($u_id <= 1) return -1;
		echo $u_id;
		Database::safeQuery("UPDATE users SET email = '$email' WHERE u_id = '$u_id';");
		return 0;
	}
}
?>
