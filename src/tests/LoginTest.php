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
    //This function will use the user create in the Signup tests to Login. Login returns a negative number if failed, and
    //a positive userID if successful.
    function testLogin():void
    {
        $TestUserLogin = new Website\Login();
        //Wrong Password
        $TestUserLogin->withInput('TestUser', 'TravisCI');
        $this->assertEquals(-1, $TestUserLogin->Login());
        //Wrong Username
        $TestUserLogin->withInput('TestUer', 'Tr4v!sCI');
        $this->assertEquals(-1, $TestUserLogin->Login());
        //Login Success
        $TestUserLogin->withInput('TestUser', 'Tr4v!sCI');
        $this->assertTrue($TestUserLogin->Login() > 0);
    }
}