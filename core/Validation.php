<?php

class Validation
{

    public static function setErrors(array $errors)
    {
        $_SESSION['errors'] = $errors;

    }

    public static function getErrors()
    {
        $errors = $_SESSION['errors'];

        unset($_SESSION['errors']);

        return $errors;
    }

    public static function is_errors()
    {
        if (isset($_SESSION['errors'])) {
            if (count($_SESSION['errors']) > 0) {
                return true;
            }
            return false;
        }
        return false;
    }


}