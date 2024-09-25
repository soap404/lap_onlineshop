<?php

require_once 'templates/header.php';
require_once 'models/UserModel.php';

$userModel = new UserModel();
$user = $userModel->get_user_by_id($_SESSION['user']['id']);

?>

<?php if (Validation::is_errors()) {
    // LOOP THE ERRORS IF WE HAVE ERRORS IN THE SESSION
    $errors = Validation::getErrors();

    foreach ($errors as $error) {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
} ?>


<?php if (Validation::is_message()) {
    // ECHO THE MESSAGE IF WE HAVE ONE
    $message = Validation::getMessage();

    echo '<div class="alert alert-success">'.$message.'</div>';

} ?>

<div class="container">
    <div class="row align-items-start">

        <div class="col">
            <h2>Change Account Settings</h2>
            <form action="controller/userController.php" method="POST">
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


                <button type="submit" class="btn btn-primary" name="save_account_settings">Save Details</button>
            </form>
        </div>

        <div class="col">
            <h2>Change Account Password</h2>
            <form action="controller/userController.php" method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           value="<?php echo Validation::getValue('password') ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           value="<?php echo Validation::getValue('password') ?>">
                </div>

                <button type="submit" class="btn btn-primary" name="save_new_password">Change Password</button>
            </form>
        </div>


    </div>

</div>

<?php require_once 'templates/footer.php'; ?>
