<?php
namespace Website;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');
require('SignUp.php');
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
        <form action="signUpPage.php" method="post"/>

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
        $NewUser->withPost();
        $_SESSION['userID'] = $NewUser->SignUpUser();
        if ($_SESSION['userID'] > 0) {
            header("Location: ModalPopUp.php");
        }

    }
}
?>
</body>

</html>


