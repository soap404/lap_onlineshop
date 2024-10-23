<?php
require_once('../autoload.php');
require_once('../models/OrderModel.php');
require_once('../pdf/PDF.PHP');
require_once('../mail/Mail.php');
require_once('../models/UserModel.php');




if (isset($_POST['order_done'])) {

    //MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
    if (!Middleware::is_admin()) {
        header('location: ' . DOMAIN . '/index.php');
        exit;
    }

    $order_id = $_POST['order_id'];
    $orderModel = new OrderModel();


    //Update status (change the status id to your done id)
    $orderModel->update_status($order_id, 2);


    //CREATE THE PDF
    $pdf = new PDF();
    $pdf->order($order_id);

    //SEND EMAIL
    $order = $orderModel->get_order_by_id($order_id);

    $userid = $order['user_id'];
    $userModel = new UserModel();

    $user = $userModel->get_user_by_id($userid);
    $order_products = $orderModel->get_order_products($order_id);

    $mailModel = new Mail();
    $mailModel->doneOrder($user, $order_products, $order);


    header('location: ' . DOMAIN . '/admin_orders.php');
    exit;
}


if (isset($_POST['order_cancel'])) {

    //MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
    if (!Middleware::is_admin()) {
        header('location: ' . DOMAIN . '/index.php');
        exit;
    }
    $order_id = $_POST['order_id'];

    $orderModel = new OrderModel();

    //Update status (change the status id to your cancel id)
    $orderModel->update_status($order_id , 3);

    //SEND EMAIL
    $order = $orderModel->get_order_by_id($order_id);

    $userid = $order['user_id'];
    $userModel = new UserModel();

    $user = $userModel->get_user_by_id($userid);
    $order_products = $orderModel->get_order_products($order_id);

    $mailModel = new Mail();
    $mailModel->cancelOrder($user, $order_products, $order);

    header('location: ' . DOMAIN . '/admin_orders.php');
    exit;
}
