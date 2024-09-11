<?php


class Middleware
{

    public static function is_guest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    public static function is_user()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    public static function is_admin()
    {
        if (self::is_user() && $_SESSION['user']['is_admin'] == 1) {
            return true;
        }
        return false;
    }

}