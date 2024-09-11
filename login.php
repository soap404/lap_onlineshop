<?php require_once 'templates/header.php'; ?>

<?php
//MIDDLEWARE. RETURN THE USER TO INDEX PHP
if (Middleware::is_user()) {
    header('location: index.php');
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


    <form action="controller/authController.php" method="POST">

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="text" class="form-control" id="email" name="email"
                   value="<?php echo Validation::getValue('email') ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password"
                   value="<?php echo Validation::getValue('password') ?>">
        </div>

        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>

<?php require_once 'templates/footer.php'; ?>