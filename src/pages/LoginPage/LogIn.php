<?php
//Author: Alya Naseer
namespace Website;

use SqlDb\Database;

$cRoot = dirname(__FILE__, 4);
require($cRoot . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');

class LogIn
{
    var $mUsername, $mPassword, $mUserId;

    function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }

    //Default Constructor to be used to log in
    function WithPost()
    {
        $this->mUsername = $_POST['username'];
        $this->mPassword = $_POST['password'];
    }

    //Constructor used by TravisCI
    function WithInput($iUsername, $iPassword)
    {
        $this->mUsername = $iUsername;
        $this->mPassword = $iPassword;
    }

    //Initiate Login Sequence
    function LogIn()
    {
        if (!(functions\CheckFormat::checkUsername($this->mUsername) && functions\CheckFormat::checkPassword($this->mPassword))) {
            echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
						</script>";
            return -1;
        }

        $wDbQuery = Database::safeQuery("SELECT u_id, name, pass FROM users");

        while ($wRow = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
            if ($wRow["name"] == $this->mUsername) {
                if ($wRow["pass"] == $this->mPassword) {
                    $this->mUserId = $wRow["u_id"];
                    return $this->mUserId;
                } else break;
            }
        }
        echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Invalid login\";
								</script>";
        return -1;
    }

    static function LogOut()
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        if ($_SESSION['userID'] != null) return false;
        return true;

    }
}