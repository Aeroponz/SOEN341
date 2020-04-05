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
    var $mUpload;

    public function testCheckForHashtag()
    {
        $this->assertEquals('y', Website\Upload::CheckForHashTag('#Plop'));
        $this->assertEquals('n', Website\Upload::CheckForHashTag('Plop'));
    }

    public function testGetUserDelay()
    {
        $this->mUpload = new Website\Upload();
        $wUserDelay = Website\Upload::GetUserDelay($this->mUpload->FetchUser());
        $this->assertEquals($wUserDelay, 0);
    }

    public function testValidText()
    {
        $this->mUpload = new Website\Upload();

        $wReturn = $this->mUpload->ValidText(null);
        $this->assertEquals($wReturn, null);

        $wReturn = $this->mUpload->ValidText("");
        $this->assertEquals($wReturn, 'BLU::INPUT_EXCEPTION::error');

        $wReturn = $this->mUpload->ValidText("Valid Input");
        $this->assertFalse($wReturn == 'BLU::INPUT_EXCEPTION::error' || $wReturn == null);
    }

    public function testFetchUser()
    {
        //user is logged in therefore Fetch User shall be > 0
        $this->mUpload = new Website\Upload();
        $this->assertTrue($this->mUpload->FetchUser() > 0);
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
        $this->mUpload = new Website\Upload();
        //Since user has never posted, time return should be Jan 1 2020
        $wLastPostTime = Website\Upload::GetTimeSinceLastPost($this->mUpload->FetchUser());
        $wPrevtime = mktime(12, 00, 00, 01, 01, 2020);
        $this->assertEquals($wLastPostTime, $wPrevtime);

    }

    public function testAddPostToDB()
    {
        //Failed to get user ID
        $this->assertEquals(Website\Upload::AddPostToDB(-1, null, "TEST INPUT", null), -3);

        //Error occurred when uploading text
        $this->assertEquals(Website\Upload::AddPostToDB(15, null, 'BLU::INPUT_EXCEPTION::error', null), -1);

        //Error occurred when uploading file
        $this->assertEquals(Website\Upload::AddPostToDB(15, 'BLU::INPUT_EXCEPTION::error', null, null), -1);

        //Upload Valid Text Post
        $this->mUpload = new Website\Upload();
        $wUserID = $this->mUpload->FetchUser();
        $this->assertEquals(Website\Upload::AddPostToDB($wUserID, null, 'Very interesting text post!', null), 1);
    }

    public function testGetTimeSinceNewPost()
    {
        $this->mUpload = new Website\Upload();
        //Since user has never posted, time return should be Jan 1 2020
        $wLastPostTime = Website\Upload::GetTimeSinceLastPost($this->mUpload->FetchUser());
        $wPrevtime = mktime(12, 00, 00, 01, 01, 2020);
        $this->assertTrue($wLastPostTime > $wPrevtime);

    }
}
