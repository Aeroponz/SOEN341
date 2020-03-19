<?php
declare(strict_types=1);

namespace UnitTesting\UploadToDb;
$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require_once($root . '/src/db/UploadClass.php');
require('LoginTest.php');
include $root . '/src/db/uploadPostToDB.php';

use PHPUnit\Framework\TestCase;
use Website;
use UnitTesting\Login;

final class UploadPostToDbTest extends TestCase
{
    public function testGenerateStringIsRandom(): void
    {
        //String Is Random
        $this->assertFalse('Boeing' == Website\Upload::GenerateString('Boeing'));
    }

    public function testGenerateStringDefault(): void
    {
        //Default Length
        $this->assertTrue(strlen(Website\Upload::GenerateString('Airbus')) == 16);
    }

    public function testGenerateStringCustom(): void
    {
        //Custom Length
        $this->assertTrue(strlen(Website\Upload::GenerateString('Plane', 5)) == 5);
    }

    public function testCheckForHashtagsTrue(): void
    {
        $this->assertEquals('y', Website\Upload::CheckForHashTag('#Plop'));
    }

    public function testCheckForHashtagsFalse(): void
    {
        $this->assertEquals('n', Website\Upload::CheckForHashTag('Plop'));
    }

//    public function testFetchUserIDLoggedIn(): void
//    {
//        $TempUser = new Login\LoginTest();
//        $TempUser->testLoginSuccess();
//        //Logged IN
//        $this->assertTrue(fetch_user() > 0);
//    }

//    public function testFetchUserIDLoggedOut(): void
//    {
//        //Log Out
//        $TempUser = new Login\LoginTest();
//        $TempUser->testLogOut();
//        //Logged Out (failure)
//        $this->assertEquals(-1, fetch_user());
//    }

}
