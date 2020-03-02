<?php
declare(strict_types=1);

namespace UnitTesting;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/LoginPage/LogIn.php');

use PHPUnit\Framework\TestCase;
use Website;
final class LoginTest extends TestCase
{
    function testLoginWrongPass():void
    {
        $TestUserLogin = new Website\Login();
        //Wrong Password
        $TestUserLogin->withInput(SignUpTest::$mTestUsername, 'TravisCI');
        $this->assertEquals(-1, $TestUserLogin->Login());
    }
    function testLoginWrongUsername():void
    {
        $TestUserLogin = new Website\Login();
        //Wrong Username
        $TestUserLogin->withInput('TestUer', SignUpTest::$mTestPassword);
        $this->assertEquals(-1, $TestUserLogin->Login());
    }
    function testLoginSuccess():void
    {
        $TestUserLogin = new Website\Login();
        //Login Success
        $TestUserLogin->withInput(SignUpTest::$mTestUsername, SignUpTest::$mTestPassword);
        $wUID = $TestUserLogin->Login();
        $this->assertTrue($wUID > 0);
        //User ID should match the one given at account creation due to it being unique to the user's account
        $this->assertEquals($wUID, SignUpTest::$mUserId);
    }
}