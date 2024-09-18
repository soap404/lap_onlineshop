<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/ProductModel.php' ?>

<?php
//MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}

//CALL PRODUCT DATA

$product_id = $_GET['id'];
$productModel = new ProductModel();
$product = $productModel->show($product_id);

if(!$product) {
    header('location: products.php');
    exit();
}

?>

<?php if (Validation::is_errors()) {
    // LOOP THE ERRORS IF WE HAVE ERRORS IN THE SESSION
    $errors = Validation::getErrors();

    foreach ($errors as $error) {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
} ?>

    <form action="controller/productController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $product['id'] ?>" name="id">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="<?php echo $product['name'] ?>">
        </div>

        <div class="form-floating">
            <textarea class="form-control" id="description" name="description"
                      style="height: 100px"><?php echo $product['description'] ?></textarea>
            <label for="description">Description</label>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price"
                   value="<?php echo $product['price'] ?>">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock"
                   value="<?php echo $product['stock']  ?>">
        </div>


        <div class="form-check">
            <input type="file" id="image" name="image" accept="image/png, image/jpeg">
            <label class="form-check-label" for="image">Image</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="active" id="active" name="active"
                <?php echo $product['is_active']  ? 'checked' : ''; ?>>
            <label class="form-check-label" for="active">
                Active
            </label>
        </div>


        <button type="submit" class="btn btn-primary" name="update">Edit</button>
    </form>

<?php require_once 'templates/footer.php'; ?>