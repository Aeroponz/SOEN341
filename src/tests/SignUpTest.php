<?php
declare(strict_types=1);

namespace UnitTesting;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/SignUpPage/SignUp.php');
require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');
require($root . '/src/pages/FunctionBlocks/AddEmailToDB.php');

use PHPUnit\Framework\TestCase;
use Website;
final class SignUpTest extends TestCase
{
    //Summary
    //This test checks the username requirements functions
    public function testCheckUsernameRequirements(): void
    {
        //Username format is valid (No invalid characters)
        $this->assertTrue(Website\functions\CheckFormat::checkUsername('Ilikeplanes123'));

        //Username format is not valid (Contains invalid characters)
        $this->assertFalse(Website\functions\CheckFormat::checkUsername('Il!keplane$123'));

    }
    //Summary
    //This test checks the password requirements functions
    public function testCheckPasswordRequirements(): void
    {
        //Password format is valid (Contains: 1 uppercase, 1 lowercase, 1 special character, 1 number)
        $this->assertTrue(Website\functions\CheckFormat::checkPassword('Il!keplane$123'));

        //Password format is not valid (Does not contain a special character)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('Ilikeplanes123'));

        //Password format is not valid (Does not contain an uppercase character)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('ilikeplanes123'));

        //Password format is not valid (Does not contain a lowercase character)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('ILIKEPLANES123'));

        //Password format is not valid (Does not contain a number)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('ILIKEPLANES'));

        //Password format is not valid (Too short)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('Il!2'));

    }
    //Summary
    //This test will test the boundaries of the Signup Page. The user created will be used in the remainder of the tests.
    public function testSignUp(): void
    {
        $TestUser = new Website\SignUp();
        $TestUser->withInput('Aeroponz', 'Il!keplanes123', 'Ilikeplane$123');
        //Password & Confirm Password Mismatch
        $this->assertEquals(-3, $TestUser->SignUpUser());
        //Username Invalid at Signup
        $TestUser->withInput('A$!roponz', 'Il!keplanes123', 'Ilikeplane$123');
        $this->assertEquals(-1, $TestUser->SignUpUser());
        //Password Invalid at Signup
        $TestUser->withInput('Aeroponz', '12345', '12345');
        $this->assertEquals(-1, $TestUser->SignUpUser());
        //User Successfully Created
        $TestUser->withInput('TestUser', 'Tr4v!sCI', 'Tr4v!sCI');
        $this->assertTrue($TestUser->SignUpUser() > 0);
        //Verify that an email address can be added to the user's account.
        $this->assertEquals(0, Website\functions\UserEmail::addEmailToDB($TestUser->mUserId,'737MaxMCAS@Boeing.com'));
        //Duplicate Username
        $this->assertEquals(-2, $TestUser->SignUpUser());
    }
}