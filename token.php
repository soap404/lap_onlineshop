<?php
require_once('./autoload.php');
require_once('./models/AuthModel.php');

if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $authModel = new AuthModel();

    $user_id = $authModel->user_id_by_token($token);


    // if the token is false
    if(!$user_id){
        header("Location: index.php");
        exit();
    }

    $authModel->activate($user_id);
    $authModel->remove_token($user_id);

    Messages::setMessage('Your account has been activated.');
    header("Location: login.php");


}else{
    header("Location: index.php");
}
exit();