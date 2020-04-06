<?php

namespace UnitTesting\RatingToDb;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/db/ratingToDB.php');

use Website;
use PHPUnit\Framework\TestCase;

final class RatingTest extends TestCase
{

    public function testAddLikeToDb()
    {
        $wRating = new Website\Rating();

        //Missing User ID
        $this->assertEquals(-3, $wRating->AddLikeToDb());

        $wRating->mU_id =15;

        //Missing Poster ID
        $this->assertEquals(-4, $wRating->AddLikeToDb());

        $wRating->mU_id2 =16;

        //Missing Post ID
        $this->assertEquals(-5, $wRating->AddLikeToDb());

        $wRating->mP_id =12345;

        //Success
        $this->assertEquals(0, $wRating->AddLikeToDb());
    }

    public function testLiked()
    {
        $wRating = new Website\Rating();
        $wRating->mU_id =15;
        $wRating->mU_id2 =16;
        $wRating->mP_id =12345;

        $wRating->AddLikeToDb();
        $this->assertEquals(1, $wRating->Liked(15,12345));

    }

    public function testFetchUser()
    {
        $wRating = new Website\Rating();
        $this->assertEquals($wRating->FetchUser(), -1);
        $wRating->mU_id = 15;
        $this->assertEquals($wRating->FetchUser(), 15);
    }

    public function testFetchPoster()
    {
        $wRating = new Website\Rating();
        $this->assertEquals($wRating->FetchPoster(), -1);
        $wRating->mU_id2 = 16;
        $this->assertEquals($wRating->FetchPoster(), 16);
    }

    public function testAddDislikeToDb()
    {
        $wRating = new Website\Rating();

        //Missing User ID
        $this->assertEquals(-3, $wRating->AddDislikeToDb());

        $wRating->mU_id =15;

        //Missing Poster ID
        $this->assertEquals(-4, $wRating->AddDislikeToDb());

        $wRating->mU_id2 =16;

        //Missing Post ID
        $this->assertEquals(-5, $wRating->AddDislikeToDb());

        $wRating->mP_id =12345;

        //Success
        $this->assertEquals(0, $wRating->AddDislikeToDb());
    }

    public function testFetchPId()
    {
        $wRating = new Website\Rating();
        $this->assertEquals($wRating->FetchPId(), -1);
        $wRating->mP_id = 123456;
        $this->assertEquals($wRating->FetchPId(), 123456);
    }
}
