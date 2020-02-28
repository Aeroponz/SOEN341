<?php

namespace Website\functions;
class CheckFormat
{
    static function checkUsername($username)
    {
        if (!preg_match("/[^\w\.\-]/", $username))
            return true;
        else
            return false;
    }

    static function checkPassword($password)
    {
        if (preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/", $password))
            return true;
        else
            return false;
    }
}

?>