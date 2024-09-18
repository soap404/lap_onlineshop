<?php
require_once('../autoload.php');
require_once('../models/productModel.php');


if(isset($_POST['add_to_cart'])){
    $productModel = new ProductModel();

    $id =$_POST['id'];
    $qty =$_POST['qty'];

    $product = $productModel->show($id);

    if(!$product || $product['stock'] < $qty || $qty < 1){
        header('location: '.DOMAIN.'/index.php');
        exit();
    }


    $product_cart['qty'] = $qty;

    $_SESSION['cart'][$id] = $product_cart;

    header('location: '.DOMAIN.'/cart.php');
    exit();
}