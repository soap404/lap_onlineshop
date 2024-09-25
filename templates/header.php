<?php require_once('autoload.php') ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAP Onlineshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 20px 200px">
    <a class="navbar-brand" href="<?php echo DOMAIN ?>">LAP Onlineshop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

            <?php if (Middleware::is_guest()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo DOMAIN ?>/login.php">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo DOMAIN ?>/register.php">Register</a>
                </li>
            <?php endif; ?>


            <?php if (Middleware::is_admin()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Admin</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo DOMAIN ?>/products.php">Products</a>
                </li>
            <?php endif; ?>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo DOMAIN ?>/cart.php">Cart</a>
            </li>

            <?php if (Middleware::is_user()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo DOMAIN ?>/account.php"">Account</a>
                </li>

                <li class="nav-item">
                    <form action="<?php echo DOMAIN ?>/controller/authController.php" method="POST">
                        <button type="submit" name="logout" class="nav-link">Logout</button>
                    </form>
                </li>

            <?php endif; ?>
        </ul>
    </div>
</nav>


<section style="padding: 40px 200px">



