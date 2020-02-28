<?php
namespace Website;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="signUpPageStyle.css"/>

</head>
<body>
<center>
    <div class="backgroundColor">
        <img src="../GenericResources/Blu.png" class="logo">

        <?php
        //Outputs a custom message depending if user was redirected to this page.
        if (isset($_GET["source"])) {
            if ($_GET["source"] == 'post') echo "<p style = \"color:red;\"> You must have an account to create posts.</p>";
        }
        ?>

        <p>Sign up to view photos and videos<br>from your friends and family</p>
        <?php session_start(); ?>
        <form action="signUp.php" method="post"/>

        <!-- The code: echo htmlspecialchars($_POST['username'], ENT_QUOTES); written below as the value for username was taken from https://www.gamedev.net/forums/topic/564843-how-to-keep-input-fields-after-page-refresh/ -->
        <input type="text" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) {
            echo htmlspecialchars($_POST['username'], ENT_QUOTES);
        } ?>" class="creds"/><br><br>
        <input type="password" name="password" placeholder="Password" class="creds"/><br><br>
        <input type="password" name="passwordConfirm" placeholder="Confirm password" class="creds"/><br><br>
        <input class="button" type="Submit" value="Sign up" name="submit"/><br><br>
        <label id="password" class="message"></label><br><br>
        <div class="passwordRequirements" align="left">
            <label>Your password must include at least:</label>
            <ul>
                <li>6 characters</li>
                <li>One number and one letter</li>
                <li>One special character</li>
            </ul>
        </div>
        <br>
        <label><b>Have an account? <a class="login" href="../LoginPage/LoginPage.php"> Sign in </a></label></b>
    </div>
</center>


<?php
namespace Website;
use SqlDb\Database;
if ($_POST) {
    if (isset($_POST['submit'])) {
        $NewUser = new SignUp();
        $_SESSION['userID'] = $NewUser->SignUpUser();

    }
}

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

?>
</body>

</html>


