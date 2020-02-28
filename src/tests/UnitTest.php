<?php
declare(strict_types=1);

//define(__DIR__, getenv('TRAVIS_BUILD_DIR'));
//require_once (__DIR__.'/src/db/DBConfig.php');

define(__DIR__, dirname(__FILE__, 2));
require_once (__DIR__.'/src/db/DBConfig.php');

include 'TestFunction.php';
//include $path;

//Login Page
//include "../pages/LoginPage/uploadPostToDB.php";

use PHPUnit\Framework\TestCase;

//final class PostIDTest extends TestCase
//{
//    public function testPostIDLength(): void
//    {
//        $wTemp = generate_string();
//        $this->assertEquals(strlen($wTemp), 16);
//    }
//    public function testPostIDIsUnique(): void
//    {
//        $wTemp1 = generate_string();
//        $wTemp2 = generate_string();
//        $this->assertFalse($wTemp1 == $wTemp2);
//    }
//    public function testPostIDIsNotNull(): void
//    {
//        $wTemp = generate_string();
//        $this->assertFalse($wTemp == null);
//    }
//}
final class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Email::class,
            Email::fromString('user@example.com')
        );
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Email::fromString('user@example.com')
        );
    }
}