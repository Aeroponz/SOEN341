<?php
//Author: Alya Naseer
namespace Website;
$cRoot = dirname(__FILE__, 4);
require_once($cRoot . '/src/db/DBConfig.php');
require('LogIn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="loginPageStyle.css"/>
</head>
<body>
<center>
    <div class="backgroundColor">
        <img src="../GenericResources/Blu.png" class="logoLogin">

        <?php session_start();?>
        <br><br><br>
        <form action="loginPage.php" method="post">
            <input type="text" name="username" placeholder="Username" class="creds"/><br><br>
            <input type="password" name="password" placeholder="Password" class="creds"/><br><br>
            <input type="Submit" name="submit" value="Log In" class="button"/><br><br>
            <label id="password" class="message"></label><br><br><br>
            <a href="../ResetPasswordPage/resetPassword.php">Forgot password?</a>
            <p><b>Don't have an account? <a class="signUp" href="../SignUpPage/signUpPage.php"> Sign up </a></b></p>
    </div>
</center>

<?php if ($_POST) {
    if (isset($_POST['submit'])) {
        $wUserLogin = new LogIn();
        $wUserLogin->WithPost();
        $_SESSION['userID'] = $wUserLogin->LogIn();
		$_SESSION['time'] = date('Y-m-d H:i:s');
        if ($_SESSION['userID'] > 0) {
            header("Location: ../HomePage/HomepageBase.php");
        }
    }
}
?>
</body>
</html>