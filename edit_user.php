<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/AdminModel.php'; ?>


<?php
//MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
if (!Middleware::is_admin()) {
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

<?php
if (!isset($_GET['id'])) {
    header('location: users.php');
    exit();
}

$user_id = $_GET['id'];
$adminModel = new AdminModel();
$user = $adminModel->show($user_id);

if (!$user) {
    header('location: users.php');
    exit();
}
?>


<form action="controller/adminController.php" method="POST">
    <input type="hidden" value="<?php echo htmlspecialchars($user['id']); ?>" name="id">
    <div class="mb-3">
        <label for="fname" class="form-label">First name</label>
        <input type="text" class="form-control" id="fname" name="fname"
               value="<?php echo $user['fname'] ?>">
    </div>

    <div class="mb-3">
        <label for="lname" class="form-label">Last name</label>
        <input type="text" class="form-control" id="lname" name="lname"
               value="<?php echo $user['lname'] ?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="text" class="form-control" id="email" name="email"
               value="<?php echo $user['email'] ?>">
    </div>

    <div class="mb-3">
        <select class="form-select" aria-label="Default select example" name="role">
            <option <?php echo $user['is_admin'] ? 'Selected' : '' ?> value="1">Admin</option>
            <option <?php echo $user['is_admin'] ? '' : 'Selected' ?> value="0">User</option>
        </select>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="active" id="active" name="active"
            <?php echo $user['is_active'] ? 'checked' : ''; ?>>

        <label class="form-check-label" for="active">
            Active
        </label>
    </div>

    <button type="submit" class="btn btn-primary" name="edit_user">Edit</button>
</form>


<?php require_once 'templates/footer.php'; ?>
