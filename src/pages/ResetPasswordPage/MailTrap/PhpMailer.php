<?php
//This code was modified from the original source: https://blog.mailtrap.io/php-email-sending/#PHP_built-in_mail_function (See section on PHPMailtrap)
//Other sources used for creating this code: https://blog.mailtrap.io/phpmailer/
//											 https://github.com/PHPMailer/PHPMailer


// Start with PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
require('../../../../../PHPMailer-master/src/PHPMailer.php');
require('../../../../../PHPMailer-master/src/SMTP.php');
require('../../../../../PHPMailer-master/src/Exception.php');
require_once('../../../../../phpMyAdmin/vendor/autoload.php');
// create a new object
$wMail = new PHPMailer();
// configure an SMTP using mailtrap.io
$wMail->isSMTP();
$wMail->Host = 'smtp.mailtrap.io';
$wMail->SMTPAuth = true;
$wMail->Username = '11bfc59a708cdb';
$wMail->Password = 'c43ef4e9436ac0';
$wMail->SMTPSecure = 'tls';
$wMail->Port = 2525;

$wMail->setFrom('no-reply@blu.com', 'Blu');
$wMail->addAddress($_SESSION['email'], 'Me');
$wMail->Subject = 'Reset your password';

//Add image
$wMail->addEmbeddedImage('../GenericResources/Blu.png', 'image');

// Set HTML 
$wMail->isHTML(TRUE);
$wMail->Body = '<br><br><center><img src="cid:image" style = "width: 83.5px; height: 50px"><html><br><h1><font face = "calibri">Password Reset</h1>To reset your password click the link below:<br><a href = "http://localhost/SOEN341/src/pages/ResetPasswordPage/newPasswordPage.php">Reset Password</a>. <br><br>If you did not request to change your password, <br>you may disregard this email.</front></html></center>';

// send the message
if(!$wMail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $wMail->ErrorInfo;
} 