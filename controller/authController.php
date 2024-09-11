<?php
require_once('../autoload.php');
require_once('../models/authModel.php');

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
    // SET ERRORS ARRAY IN THE SESSION
    Validation::setErrors($errors);

    // CHECK IF WE HAVE ERRORS IN THE SESSION. IF YES SEND HIM BACK TO register.php
    if (Validation::is_errors()) {
        header('Location:'.DOMAIN.'/register.php');
        exit();
    } else {
        $authModel = new AuthModel();

        $authModel->register($fname, $lname, $email, $password);

        header('Location:'.DOMAIN.'/login.php');
    }
    exit();


}