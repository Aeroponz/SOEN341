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
use Website\LogIn;
use SqlDb\Database;

class LogoutTest extends TestCase
{

    public function testLogOut()
    {
        $TestUserLogin = new LogIn();
        //Login Success
        $TestUserLogin->withInput(__TESTUSERNAME__, __TESTPASSWORD__);
        $this->assertTrue($TestUserLogin->Login() > 0);

        //Log out
        $this->assertTrue(LogIn::LogOut());
    }
}
