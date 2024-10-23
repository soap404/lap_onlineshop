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

    public static function is_errors(): bool
    {
        if (isset($_SESSION['errors'])) {
            if (count($_SESSION['errors']) > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function setValues(array $values)
    {
        $_SESSION['values'] = $values;
    }

    public static function getValue(string $key)
    {
        if (isset($_SESSION['values'][$key])) {
            $value = $_SESSION['values'][$key];
            $_SESSION['values'][$key] = '';
            return $value;
        }
        return null;
    }


}