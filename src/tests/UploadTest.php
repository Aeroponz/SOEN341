<?php
declare(strict_types=1);

namespace UnitTesting\UploadToDb;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/db/UploadClass.php');

use Website;
use PHPUnit\Framework\TestCase;

final class UploadTest extends TestCase
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
        //PFP DB Error
        $this->assertEquals($this->mComment->GetRedirectPath(-10), '/SOEN341/src/pages/PopularFeedPage/PopularFeedPage.php?source=error');
        //User Cooldown
        $this->assertEquals($this->mComment->GetRedirectPath(-5), '/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=timeout');
        //DB error
        $this->assertEquals($this->mComment->GetRedirectPath(-4), '/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=dberror');
        //No User Info
        $this->assertEquals($this->mComment->GetRedirectPath(-3), '/SOEN341/src/pages/SignUpPage/signUpPage.php?source=post');
        //No Post Info
        $this->assertEquals($this->mComment->GetRedirectPath(0), '/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=empty');
        //PFP Success
        $this->assertEquals($this->mComment->GetRedirectPath(10), '/SOEN341/src/pages/PopularFeedPage/PopularFeedPage.php?source=pfpsucess');
        //Post Success
        $this->assertEquals($this->mComment->GetRedirectPath(1), '/SOEN341/src/pages/HomePage/HomepageBase.php');
    }

    public function testGetTimeSinceLastPost()
    {

    }

    public function testAddPostToDB()
    {

    }
}
