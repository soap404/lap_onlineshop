<?php
require_once('../autoload.php');
require_once('../models/authModel.php');

if (isset($_POST['register'])) {
    //MIDDLEWARE. RETURN THE USER TO INDEX PHP
    if (Middleware::is_user()) {
        header('location: '.DOMAIN.'/index.php');
        exit();
    }

    $authModel = new AuthModel();

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
        } else {
            if ($authModel->get_user_by_email($email)) {
                $errors['email'] = 'Email already exists';
            }
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
        // IF THE FORM HAVE ERROR WE SAVE IN THE SESSION WHAT THE USER SEND US
        Validation::setValues($_POST);

        header('Location:'.DOMAIN.'/register.php');
        exit();
    } else {


        $user_id = $authModel->register($fname, $lname, $email, $password);
        $token = $authModel->create_token($user_id);

        //send the token to the user email

        header('Location:'.DOMAIN.'/login.php');
    }
    exit();


}

if (isset($_POST['login'])) {
    //MIDDLEWARE. RETURN THE USER TO INDEX PHP
    if (Middleware::is_user()) {
        header('location: index.php');
        exit();
    }

    $errors = array();
    // SAVE FORM INPUTS IN VARIABLES
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    // FORM VALIDATION
    if (empty($email)) {
        $errors[] = 'Email is required';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    }

    // SET ERRORS ARRAY IN THE SESSION
    Validation::setErrors($errors);


    // CHECK IF WE HAVE ERRORS IN THE SESSION. IF YES SEND HIM BACK TO register.php
    if (Validation::is_errors()) {
        // IF THE FORM HAVE ERROR WE SAVE IN THE SESSION WHAT THE USER SEND US
        Validation::setValues($_POST);

        header('Location:'.DOMAIN.'/login.php');
    } else {
        $authModel = new AuthModel();
        $user = $authModel->get_user_by_email($email);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                if($user['is_active'] == 1){
                    unset($user['password']);
                    $_SESSION['user'] = $user;
                }else{
                    $message = 'Your account is inactive. Please click the link you revised by email';
                    Messages::setMessage($message);
                    header('Location:'.DOMAIN.'/login.php');
                    exit();
                }

            } else {
                $errors[] = 'Wrong password';
            }
        } else {
            $errors[] = 'Invalid email';
        }

        // SET ERRORS ARRAY IN THE SESSION
        Validation::setErrors($errors);

        if (Validation::is_errors()) {
            Validation::setValues($_POST);
            header('Location:'.DOMAIN.'/login.php');
        } else {
            header('Location:'.DOMAIN.'/index.php');
        }
    }
    exit();


}

if (isset($_POST['logout'])) {
    //MIDDLEWARE. RETURN THE GUEST TO INDEX PHP
    if (Middleware::is_guest()) {
        header('location:'.DOMAIN.'/index.php');
        exit();
    }
    unset($_SESSION['user']);
    header('Location:'.DOMAIN.'/index.php');
    exit();
}