<?php
declare(strict_types=1);

namespace UnitTesting\Login;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/SettingsPage/Logout.php');

use PHPUnit\Framework\TestCase;
use Website\LogIn;
use SqlDb\Database;

class LogoutTest extends TestCase
{

    public function testLogOut()
    {
        $this->assertTrue($_SESSION['userID'] > 0);
        $this->assertTrue(LogIn::LogOut());
    }
}
