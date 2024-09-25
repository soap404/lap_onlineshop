<?php
require_once('../autoload.php');
require_once('../models/userModel.php');

if (isset($_POST['save_account_settings'])) {
    //MIDDLEWARE. RETURN THE GUEST TO INDEX PHP
    if (Middleware::is_guest()) {
        header('location: '.DOMAIN.'/index.php');
        exit();
    }

    $userModel = new UserModel();
    $user_id = $_SESSION['user']['id'];

    $errors = array();

    // SAVE FORM INPUTS IN VARIABLES
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);

    // FORM VALIDATION
    if (empty($fname)) {
        $errors['fname'] = 'First name is required';
    }
    if (empty($lname)) {
        $errors['lname'] = 'Last name is required';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        } else {
            if ($userModel->get_user_by_email($user_id, $email)) {
                $errors['email'] = 'Email already exists';
            }
        }
    }

    Validation::setErrors($errors);

    if (!Validation::is_errors()) {
        $message = 'Successfully saved';
        Messages::setMessage($message);


        $userModel->update_user($user_id, $fname, $lname, $email);
    }
    header('location: '.DOMAIN.'/account_settings.php');
    exit();


}