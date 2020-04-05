<?php
declare(strict_types=1);

namespace UnitTesting\UploadToDb;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/db/UploadClass.php');

use UnitTesting\Login\LoginTest;
use Website;
use PHPUnit\Framework\TestCase;

final class UploadTest extends TestCase
{
    var $mUpload;
    
    public function testCheckForHashtag()
    {
        $this->assertEquals('y', Website\Upload::CheckForHashTag('#Plop'));
        $this->assertEquals('n', Website\Upload::CheckForHashTag('Plop'));
    }

    public function testGetUserDelay()
    {
        //New User delay is 600
        $this->mUpload = new Website\Upload();
        $wUserDelay = Website\Upload::GetUserDelay($this->mUpload->FetchUser());
        $this->assertEquals($wUserDelay, 600);
    }

    public function testValidText()
    {
        $this->mUpload = new Website\Upload();

        $wReturn = $this->mUpload->ValidText(null);
        $this->assertEquals($wReturn, null);

        $iInput = "Valid Input Text";
        $_POST[$iInput] = "Valid Input Text";
        $this->assertTrue($wReturn != 'BLU::INPUT_EXCEPTION::error' && $wReturn != null);
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

    public function testGetRedirectPath()
    {
        //PFP DB Error
        $this->assertEquals(Website\Upload::GetRedirectPath(-10), '/SOEN341/src/pages/PopularFeedPage/PopularFeedPage.php?source=error');
        //User Cooldown
        $this->assertEquals(Website\Upload::GetRedirectPath(-5), '/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=timeout');
        //DB error
        $this->assertEquals(Website\Upload::GetRedirectPath(-4), '/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=dberror');
        //No User Info
        $this->assertEquals(Website\Upload::GetRedirectPath(-3), '/SOEN341/src/pages/SignUpPage/signUpPage.php?source=post');
        //No Post Info
        $this->assertEquals(Website\Upload::GetRedirectPath(0), '/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=empty');
        //PFP Success
        $this->assertEquals(Website\Upload::GetRedirectPath(10), '/SOEN341/src/pages/PopularFeedPage/PopularFeedPage.php?source=pfpsucess');
        //Post Success
        $this->assertEquals(Website\Upload::GetRedirectPath(1), '/SOEN341/src/pages/HomePage/HomepageBase.php');
    }

    public function testGetTimeSinceLastPost()
    {
        $this->mUpload = new Website\Upload();
        $wCurrtime = time();
        //Since user has never posted, time return should be Jan 1 2020
        $wLastPostTime = Website\Upload::GetTimeSinceLastPost(15);
        $wPrevtime = mktime(12, 00, 00, 01, 01, 2020);
        $wDeltaPrev = floor(($wCurrtime-$wPrevtime)-18000);
        $this->assertEquals($wLastPostTime, $wDeltaPrev);
    }

    public function testAddPostToDB()
    {
        //Failed to get user ID
        $this->assertEquals(Website\Upload::AddPostToDB(-1, null, "TEST INPUT", null), -3);

        //Error occurred when uploading text
        $this->assertEquals(Website\Upload::AddPostToDB(15, null, 'BLU::INPUT_EXCEPTION::error', null), -1);

        //Error occurred when uploading file
        $this->assertEquals(Website\Upload::AddPostToDB(15, 'BLU::INPUT_EXCEPTION::error', null, null), -2);

        //Upload Valid Text Post
        $this->assertEquals(Website\Upload::AddPostToDB(15, null, 'Very interesting text post!', null), 1);
    }
}
