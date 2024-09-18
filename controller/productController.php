<?php
require_once('../autoload.php');
require_once('../models/productModel.php');

if (isset($_POST["create"])) {
    //MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
    if (!Middleware::is_admin()) {
        header('location: '.DOMAIN.'index.php');
        exit();
    }

    $errors = array();

    // SAVE FORM INPUTS IN VARIABLES
    $name = trim($_POST["name"]);
    $description = $_POST['description'] ? trim($_POST["description"]) : null; // NOT REQUIRED
    $price = trim($_POST["price"]);
    $stock = trim($_POST["stock"]);
    $active = isset($_POST["active"]) ? 1 : 0;
    $image = $_FILES["image"]["name"] ? time().'_'.$_FILES["image"]["name"] : null; // NOT REQUIRED

    // FORM VALIDATION
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($price)) {
        $errors[] = "Price is required";
    } else {
        if (!is_numeric($price)) {
            $errors[] = "Price must be a number";
        }
    }

    if (empty($stock)) {
        $errors[] = "Stock is required";
    } else {
        if (!ctype_digit($stock)) {
            $errors[] = "Stock must be a number";
        }
    }


    Validation::setErrors($errors);

    if (Validation::is_errors()) {
        Validation::setValues($_POST);
        header('location: '.DOMAIN.'/create_product.php');
        exit();
    } else {
        // SAVE IMAGE IN images FOLDER
        if ($image) {
            $target_file = "../images/".$image;
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }

        $productModel = new ProductModel();

        $productModel->store($name, $description, $price, $stock, $active, $image);

        header('Location:'.DOMAIN.'/products.php');
    }


}

if(isset($_POST["delete_product"])){
    if (!Middleware::is_admin()) {
        header('location: '.DOMAIN.'/index.php');
        exit();
    }

    $product_id = $_POST["id"];

    $productModel = new ProductModel();

    $product = $productModel->show($product_id);

    // check if the $product_id was correct
    if(!$product){
        header('location: '.DOMAIN.'/products.php');
        exit();
    }

    // delete the image form the images folder
    $image = $product['img'];
    if($image){
        unlink("../images/".$image);
    }

    $productModel->delete($product_id);

    header('location: '.DOMAIN.'/products.php');
    exit();
}