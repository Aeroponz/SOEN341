<?php
declare(strict_types=1);

$root = dirname(__FILE__, 3);
require_once ($root.'/src/db/DBConfig.php');

include 'TestFunction.php';
include $root.'/db/uploadPostToDB.php';

use PHPUnit\Framework\TestCase;

final class UploadPostToDbTest extends TestCase
{
    public function testCheckForHashtags():void
    {
        $this -> assertEquals('y', check_for_hashtag('#ILOVEPLANES'));
        $this -> assertEquals('n', check_for_hashtag('Plop'));
    }

}
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