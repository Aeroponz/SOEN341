<?php
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;
$cRoot = dirname(__FILE__, 4);
class ResettingPassword
{
    var $mPassword, $mPasswordConfirm, $mUserId;
	
	
	 function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }

    //Default Constructor to be used to log in
    function WithPost()
    {
        $this->mPassword = $_POST['password'];
		$this->mPasswordConfirm = $_POST['passwordConfirm'];
		
    }

    //Constructor used by TravisCI
    function WithInput($iPassword, $iPasswordConfirm)
    {
        $this->mPassword = $iPassword;
		$this->mPasswordConfirm = $iPasswordConfirm;
    }
	
	
   function CheckingPasswordValidity()
    {
		if (!(functions\CheckFormat::CheckPassword($this->mPassword))){
		
            echo "<script type = \"text/JavaScript\">
							document.getElementById('message').innerHTML = \"Your password does not match the required format.\";
						</script>";
            return -1;
        }

        if (!$this->CheckPasswordMatch($this->mPassword, $this->mPasswordConfirm)) {
            echo "<script type = \"text/JavaScript\">
								document.getElementById('message').innerHTML = \"Passwords don't match\";
								</script>";
            return -2;
        }
		else {
			$this->mUserId = $this->ChangingPassword($_SESSION['userID'], $this->mPassword);
			$_SESSION['userID'];
			return $this->mUserId;
		}
    }
    //Changing Password
    function ChangingPassword($iUserId, $iPassword)
    {
        $wDbQuery = Database::safeQuery("UPDATE users SET pass = '$iPassword' WHERE u_id = '$iUserId'");
        return $iUserId;

    }
	
	//This function checks that the password and the confirm password fields match
    function CheckPasswordMatch($iPassword, $iPassConfirm)
    {
        return $iPassword == $iPassConfirm;
    }
}




?>