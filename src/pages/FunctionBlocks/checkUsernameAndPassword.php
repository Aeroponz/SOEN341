<?php

namespace Website\functions;
class CheckFormat
{
    //This function validates the username
    static function checkUsername($username)
    {
        if (!preg_match("/[^\w\.\-]/", $username))
            return true;
        else
            return false;
    }
    //This function validates the password
    static function checkPassword($password)
    {
        if (preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/", $password))
            return true;
        else
            return false;
    }
}

?>