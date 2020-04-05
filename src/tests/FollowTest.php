<?php

namespace SqlDb;

use Website;
use PHPUnit\Framework\TestCase;

final class FollowTest extends TestCase
{

    public function testAddFollowToDb()
    {
        $wFollow = new Website\Follow();

        $wFollow->mU_id =-1;
        $this->assertEquals(-3, $wFollow->AddFollowToDb());

        $wFollow->mU_id =15;
        $wFollow->mU_id2 =-1;
        $this->assertEquals(-4, $wFollow->AddFollowToDb());

        $wFollow->mU_id =15;
        $wFollow->mU_id2 =16;
        $this->assertEquals(1, $wFollow->AddFollowToDb()); //Followed

        $wFollow->mU_id =15;
        $wFollow->mU_id2 =14;
        $this->assertEquals(1, $wFollow->AddFollowToDb()); //Followed

        $wFollow->mU_id =15;
        $wFollow->mU_id2 =16;
        $this->assertEquals(2, $wFollow->AddFollowToDb()); //unfollowed

    }
    public function testFollows()
    {
        $wFollow = new Website\Follow();

        $wFollow->mU_id =15;
        $wFollow->mU_id2 =16;
        $this->assertFalse($wFollow->Follows($wFollow->mU_id,$wFollow->mU_id2));

        $wFollow->mU_id =15;
        $wFollow->mU_id2 =14;
        $this->assertTrue($wFollow->Follows($wFollow->mU_id,$wFollow->mU_id2));
    }
}
