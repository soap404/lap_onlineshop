<?php require_once 'templates/header.php'; ?>

<?php
//MIDDLEWARE. RETURN THE NOT GUEST TO INDEX PHP
if (Middleware::is_guest()) {
    header('location: index.php');
    exit();
}
?>

<a href="orders.php" class="btn btn-success">Orders</a>

<a href="account_settings.php" class="btn btn-primary">Account settings</a>



<?php require_once 'templates/footer.php'; ?>
