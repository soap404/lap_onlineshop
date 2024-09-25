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


if (isset($_POST['save_new_password'])) {
    //MIDDLEWARE. RETURN THE GUEST TO INDEX PHP
    if (Middleware::is_guest()) {
        header('location: '.DOMAIN.'/index.php');
        exit();
    }

    $userModel = new UserModel();
    $user_id = $_SESSION['user']['id'];

    $errors = array();

    // SAVE FORM INPUTS IN VARIABLES

    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($old_password)) {
        $errors[] = 'Old password is required';
    }
    if (empty($new_password)) {
        $errors[] = 'New password is required';
    }

    if (empty($confirm_password)) {
        $errors[] = 'Confirm password is required';
    } else {
        if ($new_password != $confirm_password) {
            $errors[] = 'New password and Confirm password do not match';
        } else {
            if (strlen($confirm_password) < 8) {
                $errors[] = 'New password must be at least 6 characters';
            } else {
                $hash_db_password = $userModel->get_user_password_by_id($user_id)['password'];

                if (!password_verify($old_password, $hash_db_password)) {
                    $errors[] = 'Old password is wrong';
                }

            }
        }
    }


    Validation::setErrors($errors);

    if (!Validation::is_errors()) {
        $message = 'Password successfully changed';
        Messages::setMessage($message);


        $userModel->update_user_password_by_id($user_id, $confirm_password);
    }
    header('location: '.DOMAIN.'/account_settings.php');
    exit();



}