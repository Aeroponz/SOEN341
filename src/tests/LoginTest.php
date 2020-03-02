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
        $TestUserLogin = new Website\Login();
        //Wrong Password
        $TestUserLogin->withInput(__TESTUSERNAME__, 'TravisCI');
        $this->assertEquals(-1, $TestUserLogin->Login());
    }

    function testLoginWrongUsername(): void
    {
        $TestUserLogin = new Website\Login();
        //Wrong Username
        $TestUserLogin->withInput('TestUer', __TESTPASSWORD__);
        $this->assertEquals(-1, $TestUserLogin->Login());
    }

    function testLoginSuccess(): void
    {
        $TestUserLogin = new Website\Login();
        //Login Success
        $TestUserLogin->withInput(__TESTUSERNAME__, __TESTPASSWORD__);
        $this->assertTrue($TestUserLogin->Login() > 0);
    }

    function testLogOut(): void
    {
        //session_start();
        $_SESSION = array();
        //session_destroy();
        //Log Out
        $this->assetFalse(fetch_user() > 0);
    }
}