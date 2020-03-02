<?php
declare(strict_types=1);

namespace UnitTesting;

$root = dirname(__FILE__, 3);
require_once($root . '/src/db/DBConfig.php');
require($root . '/src/pages/SignUpPage/SignUp.php');
require($root . '/src/pages/FunctionBlocks/checkUsernameAndPassword.php');
require($root . '/src/pages/FunctionBlocks/AddEmailToDB.php');

//Account to be created and used for tests
define('__TESTUSERNAME__', 'TestUser', true);
define('__TESTPASSWORD__', 'Tr4v!sCI', true);

use PHPUnit\Framework\TestCase;
use Website;

final class SignUpTest extends TestCase
{
    var $mUserID = -1;

    //Summary
    //This test checks the username requirements function (Valid)
    public function testCheckUsernameRequirementsValid(): void
    {
        //Username format is valid (No invalid characters)
        $this->assertTrue(Website\functions\CheckFormat::checkUsername('Ilikeplanes123'));
    }

    //Summary
    //This test checks the username requirements function (Invalid)
    public function testCheckUsernameRequirementsInvalid(): void
    {
        //Username format is not valid (Contains invalid characters)
        $this->assertFalse(Website\functions\CheckFormat::checkUsername('Il!keplane$123'));
    }

    //Summary
    //The five (5) following tests check the password requirements functions
    public function testCheckPasswordRequirementsValid(): void
    {
        //Password format is valid (Contains: 1 uppercase, 1 lowercase, 1 special character, 1 number)
        $this->assertTrue(Website\functions\CheckFormat::checkPassword('Il!keplane$123'));

    }

    public function testCheckPasswordRequirementsSpecialChar(): void
    {
        //Password format is not valid (Does not contain a special character)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('Ilikeplanes123'));
    }

    public function testCheckPasswordRequirementsUpperCase(): void
    {
        //Password format is not valid (Does not contain an uppercase character)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('ilikeplanes123'));
    }

    public function testCheckPasswordRequirementsLowerCase(): void
    {
        //Password format is not valid (Does not contain a lowercase character)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('ILIKEPLANES123'));
    }

    public function testCheckPasswordRequirementsNumber(): void
    {
        //Password format is not valid (Does not contain a number)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('ILIKEPLANES'));
    }

    public function testCheckPasswordRequirementsLength(): void
    {
        //Password format is not valid (Too short)
        $this->assertFalse(Website\functions\CheckFormat::checkPassword('Il!2'));
    }

    //Summary
    //The following tests will test the boundaries of the Signup Page. The user created will be used in the remainder of the tests.
    public function testSignUpPassMatch(): void
    {
        //Password & Confirm Password Mismatch
        $TestUser = new Website\SignUp();
        $TestUser->withInput('Aeroponz', 'Il!keplanes123', 'Ilikeplane$123');
        $this->assertEquals(-3, $TestUser->SignUpUser());
    }

    public function testSignUpUsernameValid(): void
    {
        $TestUser = new Website\SignUp();
        //Password Invalid at Signup
        $TestUser->withInput('Aeroponz', '12345', '12345');
        $this->assertEquals(-1, $TestUser->SignUpUser());
    }

    public function testSignUpPasswordInvalid(): void
    {
        $TestUser = new Website\SignUp();
        //Password Invalid at Signup
        $TestUser->withInput('Aeroponz', '12345', '12345');
        $this->assertEquals(-1, $TestUser->SignUpUser());
    }

    public function testSignUpSuccess(): void
    {
        $TestUser = new Website\SignUp();
        //User Successfully Created
        $TestUser->withInput(__TESTUSERNAME__, __TESTPASSWORD__, __TESTPASSWORD__);
        $this->mUserID = $TestUser->SignUpUser();
        $this->assertTrue( $this->mUserID> 0);
    }

    public function testSignUpEmail(): void
    {
        //Verify that an email address can be added to the user's account.
        $this->assertEquals(0, Website\functions\UserEmail::addEmailToDB($this->mUserID, '737MaxMCAS@Boeing.com'));
    }

    public function testSignUpUnique(): void
    {
        //Duplicate Username
        $TestUser = new Website\SignUp();
        $TestUser->withInput(__TESTUSERNAME__, __TESTPASSWORD__, __TESTPASSWORD__);
        $this->assertEquals(-2, $TestUser->SignUpUser());
    }
}