<?php
require_once('../autoload.php');

if (isset($_POST['register'])) {
    $errors = array();
    // SAVE FORM INPUTS IN VARIABLES
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // FORM VALIDATION
    if (empty($fname)) {
        $errors[] = 'First name is required';
    }
    if (empty($lname)) {
        $errors[] = 'Last name is required';
    }
    if (empty($email)) {
        $errors[] = 'Email is required';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    } else {
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }
    }

    Validation::setErrors($errors);

    if (Validation::getErrors()) {
        echo 'you are registered ';
    }


}