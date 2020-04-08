<?php
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;

class SignUp
{
    var $mUsername, $mPassword, $mPasswordConfirm, $mUserId;

    function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }
    //Default Constructor to be used when creating a new user
    function WithPost()
    {
        $this->mUsername = $_POST['username'];
        $this->mPassword = $_POST['password'];
        $this->mPasswordConfirm = $_POST['passwordConfirm'];
    }
    //Constructor used by TravisCI
    function WithInput($iUsername, $iPassword, $iPasswordConfirm)
    {
        $this->mUsername = $iUsername;
        $this->mPassword = $iPassword;
        $this->mPasswordConfirm = $iPasswordConfirm;
    }
    //This function checks the validity of the different signup parameters. If valid it calls the NewUserToDb function
    function SignUpUser()
    {
        if (functions\CheckFormat::CheckUsername($this->mUsername) && functions\CheckFormat::CheckPassword($this->mPassword))
            $mAvailableUsername = $this->GetUsernameAvailability($this->mUsername);
        else {
            echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
						</script>";
            return -1;
        }

        if (!$mAvailableUsername) {
            echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Username already exists\";
								</script>";
            return -2;
        }
        if (!$this->CheckPasswordMatch($this->mPassword, $this->mPasswordConfirm)) {
            echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Passwords don't match\";
								</script>";
            return -3;
        }
        $this->mUserId = $this->NewUserToDb($this->mUsername, $this->mPassword);
        return $this->mUserId;
    }
    //Add the new user to the database
    function NewUserToDb($iUsername, $iPassword)
    {

        $wDbQuery = Database::safeQuery("SELECT u_id FROM users ORDER BY u_id DESC LIMIT 1");
        $wValueID = $wDbQuery->fetch_assoc();
        $wValueID['u_id'] += 1;
        $wUserIDValue = $wValueID['u_id'];
        Database::safeQuery("INSERT INTO users(u_id, name, pass) VALUES ('$wUserIDValue', '$iUsername', '$iPassword')");
        Database::safeQuery("INSERT INTO user_profile(u_id) VALUES ('$wUserIDValue')");
        return $wUserIDValue;

    }
    //This function checks the username availability during signup
    function GetUsernameAvailability($iUsername)
    {
        $wDbQuery = Database::safeQuery("SELECT u_id, name, pass FROM users");
        $wOutput = true;
        while ($wRow = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
            if ($wRow["name"] == $iUsername) {
                $wOutput = false;
                break;
            }
        }
        return $wOutput;
    }
    //This function checks that the password and the confirm password fields match
    function CheckPasswordMatch($iPassword, $iPassConfirm)
    {
        return $iPassword == $iPassConfirm;
    }
}
?>