<?php
declare(strict_types=1);

namespace UnitTesting\CommentToDb;
$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require_once($root . '/src/db/commentToDB.php');
require('LoginTest.php');
include $root . '/src/db/commentToDB.php';

use PHPUnit\Framework\TestCase;
use Website;
use UnitTesting\Login;

final class CommentToDbTest extends TestCase
{
    public function testGenerateStringIsRandom(): void
    {
        //String Is Random
        $this->assertFalse('Boeing' == Website\Upload::generate_string('Boeing'));
    }
}
