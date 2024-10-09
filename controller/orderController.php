<?php
require_once('../autoload.php');
require_once('../models/OrderModel.php');
require_once('../pdf/PDF.PHP');




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

    $pdf = new PDF();
    $pdf->order($order_id);


    header('location: ' . DOMAIN . '/admin_orders.php');
    exit;
}


if (isset($_POST['order_cancel'])) {

    //MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
    if (!Middleware::is_admin()) {
        header('location: ' . DOMAIN . '/index.php');
        exit;
    }

    $orderModel = new OrderModel();

    //Update status (change the status id to your cancel id)
    $orderModel->update_status($_POST['order_id'], 3);

    header('location: ' . DOMAIN . '/admin_orders.php');
    exit;
}
