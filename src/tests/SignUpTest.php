<?php
declare(strict_types=1);

$root = dirname(__FILE__, 3);
require_once ($root.'/src/db/DBConfig.php');
include $root.'/src/pages/FunctionBlocks/checkUsernameAndPassword.php';
include $root.'/src/pages/SignUpPage/SignUp.php';

use PHPUnit\Framework\TestCase;

final class SignUpTest extends TestCase
{
    public  function testCheckUsernameRequirements():void
    {
        //Username format is valid (No invalid characters)
        $this -> assertTrue(checkUsername('Ilikeplanes123'));

        //Username format is not valid (Contains invalid characters)
        $this -> assertFalse(checkUsername('Il!keplane$123'));

    }
    public  function testCheckPasswordRequirements():void
    {
        //Password format is valid (Contains: 1 uppercase, 1 lowercase, 1 special character, 1 number)
        $this -> assertTrue(checkPassword('Il!keplane$123'));

        //Password format is not valid (Does not contain a special character)
        $this -> assertFalse(checkPassword('Ilikeplanes123'));

        //Password format is not valid (Does not contain an uppercase character)
        $this -> assertFalse(checkPassword('ilikeplanes123'));

        //Password format is not valid (Does not contain a lowercase character)
        $this -> assertFalse(checkPassword('ILIKEPLANES123'));

        //Password format is not valid (Does not contain a number)
        $this -> assertFalse(checkPassword('ILIKEPLANES'));

        //Password format is not valid (Too short)
        $this -> assertFalse(checkPassword('Il!2'));

    }
    //Summary
    //This test will test the boundaries of the Signup Page. The user created will be used in the remainder of the tests.
    public  function testSignUp():void
    {
        //Password & Confirm Password Mismatch
        $this -> assertEquals(-3, SignUp('Aeroponz', 'Il!keplanes123', 'Ilikeplane$123'));
        //Username Invalid at Signup
        $this -> assertEquals(-1, SignUp('A$!roponz', 'Il!keplanes123', 'Ilikeplane$123'));
        //Password Invalid at Signup
        $this -> assertEquals(-1, SignUp('Aeroponz', '12345', '12345'));
        //User Successfully Created
        $this -> assertTrue(SignUp('TestUser', 'Tr4v!sCI', 'Tr4v!sCI') > 0);
        //Duplicate Username
        $this -> assertEquals(-2, SignUp('TestUser', 'Trav!sC1', 'Trav!sC1'));
    }

}