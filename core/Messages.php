<?php

class Messages
{
    public static function is_message(): bool
    {
        if (isset($_SESSION['message'])) {
            return true;
        }
        return false;


    }

    public static function setMessage(string $message)
    {
        $_SESSION['message'] = $message;

    }

    public static function getMessage()
    {
        if (self::is_message()) {
            $message = $_SESSION['message'];

            unset($_SESSION['message']);

            return $message;
        } else {
            return null;
        }

    }
}