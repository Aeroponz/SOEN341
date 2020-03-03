<?php
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__, 4);
class GetEmail
{
    var $mEmail, $mUserId;
	
	
	 function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }

    //Default Constructor to be used to log in
    function withPost()
    {
        $this->mEmail = $_POST['email'];
		
    }

    //Constructor used by TravisCI
    function withInput($iEmail)
    {
        $this->mEmail = $iEmail;
    }
	
	//Getting email
    function Get_email()
    {
        $wDbQuery = Database::safeQuery("SELECT email FROM users");

        while ($row = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
            if ($row["email"] == $this->mEmail) {
				$this->mEmail = $row["email"];
				return $this->mEmail;
			}
        }
	
		echo "<script type = \"text/JavaScript\">
				document.getElementById('message').innerHTML = \"Email address provided is not associated to an account\";
				</script>";
        return -1;
    }
	
	//Getting userID
	function Get_userID($mEmail)
	{
		$wDbQuery = Database::safeQuery("SELECT u_id, email FROM users WHERE email = '$mEmail'");

        while ($row = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
			$this->mUserId = $row["u_id"];
			return $this->mUserId;
        }
        return -1;
	}
}




?>