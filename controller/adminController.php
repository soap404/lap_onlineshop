<?php
require_once('../autoload.php');
require_once('../models/adminModel.php');


if (isset($_POST['delete_user'])) {
    //MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
    if (!Middleware::is_admin()) {
        header('location: '.DOMAIN.'/index.php');
        exit();
    }


    $user_id = $_POST['id'];

    $adminModel = new AdminModel();
    $adminModel->delete($user_id);

    header('location: '.DOMAIN.'/users.php');
    exit();
}

if (isset($_POST['edit_user'])) {
    //MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
    if (!Middleware::is_admin()) {
        header('location: '.DOMAIN.'/index.php');
        exit();
    }

    $errors = array();

    $user_id = trim($_POST['id']);
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $is_admin = trim($_POST['role']);
    $is_active = trim($_POST['active']);

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

    // SET ERRORS ARRAY IN THE SESSION
    Validation::setErrors($errors);

    // CHECK IF WE HAVE ERRORS IN THE SESSION. IF YES SEND HIM BACK TO register.php
    if (Validation::is_errors()) {
        // IF THE FORM HAVE ERROR WE SAVE IN THE SESSION WHAT THE USER SEND US
        header('Location:'.DOMAIN.'/edit_user.php?id='.$user_id);
    } else {

        $adminModel = new AdminModel();
        $adminModel->update($user_id, $fname, $lname, $email, $is_admin, $is_active);

        header('Location:'.DOMAIN.'/users.php');

    }
    exit();

}