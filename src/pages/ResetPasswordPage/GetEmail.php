<?php
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;
$cRoot = dirname(__FILE__, 4);
class GetEmail
{
    var $mEmail, $mUserId;
	
	
	 function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }

    //Default Constructor to be used to log in
    function WithPost()
    {
        $this->mEmail = $_POST['email'];
		
    }

    //Constructor used by TravisCI
    function WithInput($iEmail)
    {
        $this->mEmail = $iEmail;
    }
	
	//Getting email
    function GetEmail()
    {
        $wDbQuery = Database::safeQuery("SELECT email FROM users");

        while ($wRow = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
            if ($wRow["email"] == $this->mEmail) {
				$this->mEmail = $wRow["email"];
				return $this->mEmail;
			}
        }
	
		echo "<script type = \"text/JavaScript\">
				document.getElementById('message').innerHTML = \"Email address provided is not associated to an account\";
				</script>";
        return -1;
    }
	
	//Getting userID
	function GetUserId($mEmail)
	{
		$wDbQuery = Database::safeQuery("SELECT u_id, email FROM users WHERE email = '$mEmail'");

        while ($wRow = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
			$this->mUserId = $wRow["u_id"];
			return $this->mUserId;
        }
        return -1;
	}
}




?>