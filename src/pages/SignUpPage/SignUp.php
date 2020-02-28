<?php


namespace Website;


class SignUp
{
    var $mUsername, $mPassword, $mPasswordConfirm, $mUserId;

    function __construct()
    {
        //PHP doesn't allow multiple constructors...
    }

    function withPost()
    {
        $this->mUsername = $_POST['username'];
        $this->mPassword = $_POST['password'];
        $this->mPasswordConfirm = $_POST['passwordConfirm'];
    }

    function withInput($iUsername, $iPassword, $iPasswordConfirm)
    {
        $this->mUsername = $iUsername;
        $this->mPassword = $iPassword;
        $this->mPasswordConfirm = $iPasswordConfirm;
    }

    function SignUpUser()
    {
        if (functions\CheckFormat::checkUsername($this->mUsername) && functions\CheckFormat::checkPassword($this->mPassword))
            $mAvailableUsername = $this->get_Username_Availability($this->mUsername);
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
        if (!$this->checkPasswordMatch($this->mPassword, $this->mPasswordConfirm)) {
            echo "<script type = \"text/JavaScript\">
								document.getElementById('password').innerHTML = \"Passwords don't match\";
								</script>";
            return -3;
        }
        $this->mUserId = $this->NewUserToDb($this->mUsername, $this->mPassword);
        return $this->mUserId;
    }

    function NewUserToDb($iUsername, $iPassword)
    {

        $wDbQuery = Database::safeQuery("SELECT u_id FROM users ORDER BY u_id DESC LIMIT 1");
        $valueID = $wDbQuery->fetch_assoc();
        $valueID['u_id'] += 1;
        $userIDValue = $valueID['u_id'];
        echo $userIDValue;
        Database::safeQuery("INSERT INTO users(u_id, name, pass) VALUES ('$userIDValue', '$iUsername', '$iPassword')");
        Database::safeQuery("INSERT INTO user_profile(u_id) VALUES ('$userIDValue')");
        header("Location: ModalPopUp.php");
        return $userIDValue;

    }

    function get_Username_Availability($iUsername)
    {
        $wDbQuery = Database::safeQuery("SELECT u_id, name, pass FROM users");
        $wOutput = true;
        while ($row = $wDbQuery->fetch_assoc()) {    //fetches values of results and stores in array $row
            if ($row["name"] == $iUsername) {
                $wOutput = false;
                break;
            }
        }
        return $wOutput;
    }

    function checkPasswordMatch($iPassword, $iPassConfirm)
    {
        return $iPassword == $iPassConfirm;
    }
}