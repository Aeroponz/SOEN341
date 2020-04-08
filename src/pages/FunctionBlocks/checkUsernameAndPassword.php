<?php
//Author: Alya Naseer
namespace Website\functions;
class CheckFormat
{
    //This function validates the username
    static function CheckUsername($iUsername)
    {
        if (!preg_match("/[^\w\.\-]/", $iUsername))
            return true;
        else
            return false;
    }
    //This function validates the password
    static function CheckPassword($iPassword)
    {
        if (preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/", $iPassword))
            return true;
        else
            return false;
    }
}

?>