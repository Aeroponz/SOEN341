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
        $this->assertFalse('Boeing' == Website\Upload::generate_string('Boeing'));
    }

    public function testGenerateStringDefault(): void
    {
        //Default Length
        $this->assertTrue(strlen(Website\Upload::generate_string('Airbus')) == 16);
    }

    public function testGenerateStringCustom(): void
    {
        //Custom Length
        $this->assertTrue(strlen(Website\Upload::generate_string('Plane', 5)) == 5);
    }

    public function testCheckForHashtagsTrue(): void
    {
        $this->assertEquals('y', Website\Upload::check_for_hashtag('#Plop'));
    }

    public function testCheckForHashtagsFalse(): void
    {
        $this->assertEquals('n', Website\Upload::check_for_hashtag('Plop'));
    }

    public function testFetchUserIDLoggedIn(): void
    {
        $TempUser = new Login\LoginTest();
        $TempUser->testLoginSuccess();
        //Logged IN
        $this->assertTrue(fetch_user() > 0);
    }

//    public function testFetchUserIDLoggedOut(): void
//    {
//        //Log Out
//        $TempUser = new Login\LoginTest();
//        $TempUser->testLogOut();
//        //Logged Out (failure)
//        $this->assertEquals(-1, fetch_user());
//    }

}
