<?php


namespace Website;

use SqlDb\Database;

$root = dirname(__FILE__, 4);
require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');

class LogIn
{
    var $mUsername, $mPassword, $mUserId;

    function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }

    //Default Constructor to be used to log in
    function withPost()
    {
        $this->mUsername = $_POST['username'];
        $this->mPassword = $_POST['password'];
    }

    //Constructor used by TravisCI
    function withInput($iUsername, $iPassword)
    {
        $this->mUsername = $iUsername;
        $this->mPassword = $iPassword;
    }

    //Initiate Login Sequence
    function Login()
    {
        if (!(functions\CheckFormat::checkUsername($this->mUsername) && functions\CheckFormat::checkPassword($this->mPassword))) {
            echo "<script type = \"text/JavaScript\">
							document.getElementById('password').innerHTML = \"Your username/password does not match the required format.\";
						</script>";
            return -1;
        }

        $wDbQuery = Database::safeQuery("SELECT u_id, name, pass FROM users ORDER BY u_id DESC LIMIT 1");

        while ($row = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
            if ($row["name"] == $this->mUsername) {
                if ($row["pass"] == $this->mPassword) {
                    $this->mUserId = $row["u_id"];
                    return $this->mUserId;
                } else break;
            }
        }
        echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Invalid login\";
								</script>";
        return -1;
    }
}