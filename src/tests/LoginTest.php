<?php
declare(strict_types=1);

namespace UnitTesting\Login;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/LoginPage/LogIn.php');

//Account Used for testing
define('__TESTUSERNAME__', 'TestUser', true);
define('__TESTPASSWORD__', 'Tr4v!sCI', true);

use PHPUnit\Framework\TestCase;
use Website;

final class LoginTest extends TestCase
{

    function testLoginWrongPass(): void
    {
        $wTestUserLogin = new Website\Login();
        //Wrong Password
        $wTestUserLogin->withInput(__TESTUSERNAME__, 'TravisCI');
        $this->assertEquals(-1, $wTestUserLogin->Login());
    }

    function testLoginWrongUsername(): void
    {
        $wTestUserLogin = new Website\Login();
        //Wrong Username
        $wTestUserLogin->withInput('TestUer', __TESTPASSWORD__);
        $this->assertEquals(-1, $wTestUserLogin->Login());
    }

    function testLoginSuccess(): void
    {
        $wTestUserLogin = new Website\Login();
        //Login Success
        $wTestUserLogin->withInput(__TESTUSERNAME__, __TESTPASSWORD__);
        $this->assertTrue($wTestUserLogin->Login() > 0);
    }

//    function testLogOut(): void
//    {
//        //session_start();
//        $_SESSION = array();
//        //session_destroy();
//        //Log Out
//        $this->assetFalse(fetch_user() > 0);
//    }
}