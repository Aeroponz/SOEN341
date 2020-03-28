<?php
declare(strict_types=1);

namespace UnitTesting\UploadToDb;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/db/UploadClass.php');

use Website;
use PHPUnit\Framework\TestCase;

class UploadTest extends \PHPUnit_Framework_TestCase
{

    public function testCheckForHashtag()
    {
        $this->assertEquals('y', Website\Upload::CheckForHashTag('#Plop'));
        $this->assertEquals('n', Website\Upload::CheckForHashTag('Plop'));
    }

    public function testGetUserDelay()
    {

    }

    public function testValidText()
    {

    }

    public function testFetchUser()
    {

    }

    public function testGenerateString()
    {
        //String Is Random
        $this->assertFalse('Boeing' == Website\Upload::GenerateString('Boeing'));
        //Default Length
        $this->assertTrue(strlen(Website\Upload::GenerateString('Airbus')) == 16);
        //Custom Length
        $this->assertTrue(strlen(Website\Upload::GenerateString('Plane', 5)) == 5);
    }

    public function testValidFile()
    {

    }

    public function testGetRedirectPath()
    {

    }

    public function testGetTimeSinceLastPost()
    {

    }

    public function testAddPostToDB()
    {

    }
}
