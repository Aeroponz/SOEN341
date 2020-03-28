<?php
declare(strict_types=1);

namespace UnitTesting\Comment;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/db/commentToDB.php');

use Website;
use PHPUnit\Framework\TestCase;

final class CommentTest extends TestCase
{
    var $mComment;

    public function testFetchPId()
    {
       $this->mComment = new Website\Comment();
       $this->assertTrue( $this->mComment->FetchPId() == -1);

       $this->mComment->mP_id = 1234;
       $this->assertTrue( $this->mComment->FetchPId() == 1234);
    }

    public function testFetchUser()
    {
        $this->mComment = new Website\Comment();
        $this->assertTrue( $this->mComment->FetchUser() == -1);

        $this->mComment->mU_id = 1234;
        $this->assertTrue( $this->mComment->FetchUser() == 1234);;
    }

    public function testCommentToDb()
    {
        $this->mComment = new Website\Comment();

        //All Fields Missing
        $this->assertTrue($this->mComment->CommentToDb(-1, "", -1) == -3);

        //User not logged in
        $this->assertTrue($this->mComment->CommentToDb(-1, "Test Comment", 123) == -3);

        //Failed to Fetch Post ID
        $this->assertTrue($this->mComment->CommentToDb(12, "Test Comment", -1) == -4);

        //Empty Comment
        $this->assertTrue($this->mComment->CommentToDb(12, "", 123) == -1);

        //Comment added successfully
        //$this->assertTrue($this->mComment->CommentToDb(12, "Test Comment", 1234) == 1);
    }

    public function testGetRedirectPath()
    {
        $this->mComment = new Website\Comment();
        $this->mComment->mP_id = 1234;

        //No User ID error code
        $this->assertEquals($this->mComment->GetRedirectPath(-3), '../SignUpPage/signUP.php?source=post');
        //No Post ID error code
        $this->assertEquals($this->mComment->GetRedirectPath(-4), '../viewPostPage/viewPost.php?id= 1234&source=noP_id');
        //No Comment Error code
        $this->assertEquals($this->mComment->GetRedirectPath(-1), '../viewPostPage/viewPost.php?id= 1234&source=noComment');
        //Default (Comment success)
        $this->assertEquals($this->mComment->GetRedirectPath(1), '../viewPostPage/viewPost.php?id= 1234');
    }
}
