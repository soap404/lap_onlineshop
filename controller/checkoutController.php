<?php
require_once('../autoload.php');
require_once('../models/ProductModel.php');
require_once('../models/OrderModel.php');



if (isset($_POST['checkout'])) {
    //MIDDLEWARE. RETURN THE Guest TO INDEX PHP
    if (Middleware::is_guest()) {
        header('location: ' . DOMAIN . '/index.php');
        exit();
    }

    $errors = array();

    $productModel = new ProductModel();

    //VALIDATE THE PRODUCT STOCK
    foreach ($_SESSION['cart'] as $product_id => $value) {
        $product = $productModel->show_active($product_id);

        if (!$product) {
            unset($_SESSION['cart'][$product_id]);
            $errors[] = "Product $product_id not found";
            continue;
        }

        $stock = $value['qty'];

        if ($product['stock'] < $stock) {
            $errors[] = "Product " . $product['name'] . " have max of " . $product['stock'] . " in stock";
            continue;
        }

        // SAVE THE PRODUCT PRICE FORM THE DB TO THE SESSION
        $_SESSION['cart'][$product_id]['price'] = $product['price'];
    }

    //CHECK IF THERE ARE ERRORS
    Validation::setErrors($errors);

    if (Validation::is_errors()) {
        header('location: ' . DOMAIN . '/cart.php');
        exit();
    }


    //SAVE THE ORDER IN THE DATABASE
    $user_id = $_SESSION['user']['id'];
    $invoice_address_id = $_POST['invoice_address_id'];
    $delivery_address_id = $_POST['delivery_address_id'];

    // CREATE PDF NAME WITH TIMESTAMP

    $invoice_pdf = time() . '.pdf';
    //CALL THE ORDER MODEL
    $orderModel = new OrderModel();
    //CALL THE STORE FUNCTION - 1 is FOR BANDING STATUS
    $orderid = $orderModel->store('1', $invoice_address_id, $delivery_address_id, $user_id, $invoice_pdf);


    //SAVE PRODUCTS IN THE order_products TABLE
    foreach ($_SESSION['cart'] as $product_id => $value) {
        $orderModel->store_order_products($orderid, $product_id, $value['qty'], $value['price']);

        //UPDATE THE PRODUCT STOCK
        $product = $productModel->show($product_id);

        $new_stock = $product['stock'] - $value['qty'];

        $productModel->update_stock($product_id, $new_stock);
    }

    //REMOVE THE CART FROM THE SESSION
    unset($_SESSION['cart']);

    //REDIRECT TO THE ORDERS PAGE
    header('location: ' . DOMAIN . '/orders.php');
    exit();
}
