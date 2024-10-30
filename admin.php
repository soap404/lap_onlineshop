<?php require_once 'templates/header.php'; ?>
<?php
//MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}
?>


<a href="users.php" class="btn btn-primary">Users</a>
<a href="admin_orders.php" class="btn btn-success">Orders</a>
<a href="analytics.php" class="btn btn-warning">Analytics</a>
<a href="products.php" class="btn btn-secondary">Products</a>





<?php require_once 'templates/footer.php'; ?>