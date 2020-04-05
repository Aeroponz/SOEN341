<?php

namespace UnitTesting\FollowToDb;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/db/followToDB.php');

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
        $this->assertEquals(1, $wFollow->AddFollowToDb());

    }
}
