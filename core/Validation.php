<?php

class Validation
{

    public function setErrors(array $errors)
    {
        $_SESSION['errors'] = $errors;

    }

    public function getErrors()
    {
        $errors = $_SESSION['errors'];

        unset($_SESSION['errors']);

        return $errors;
    }



}