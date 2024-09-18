<?php require_once 'templates/header.php'; ?>

<?php
//MIDDLEWARE. RETURN THE USER TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}
?>
    <a href="create_product.php" class="btn btn-primary">Create Product</a>

<?php require_once 'templates/footer.php'; ?>