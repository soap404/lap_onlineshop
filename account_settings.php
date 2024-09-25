<?php

require_once 'templates/header.php';
require_once 'models/UserModel.php';


//MIDDLEWARE. RETURN THE NOT GUEST TO INDEX PHP
if (Middleware::is_guest()) {
    header('location: index.php');
    exit();
}


$userModel = new UserModel();
$user = $userModel->get_user_by_id($_SESSION['user']['id']);
$countries = $userModel->get_all_countries();

$invoice_addresses = $userModel->get_all_invoice_address_by_user_id($_SESSION['user']['id']);
$addresses = $userModel->get_all_addresses_by_user_id($_SESSION['user']['id']);


?>

<?php if (Validation::is_errors()) {
    // LOOP THE ERRORS IF WE HAVE ERRORS IN THE SESSION
    $errors = Validation::getErrors();

    foreach ($errors as $error) {
        echo '<div class="alert alert-danger">'.$error.'</div>';
    }
} ?>


<?php if (Messages::is_message()) {
    // ECHO THE MESSAGE IF WE HAVE ONE
    $message = Messages::getMessage();

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
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password">
                </div>


                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm new password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>

                <button type="submit" class="btn btn-primary" name="save_new_password">Change Password</button>
            </form>
        </div>


    </div>

    <div class="row align-items-start mt-4">
        <div class="col">
            <h2>Invoice Addresses</h2>
            <?php foreach ($invoice_addresses as $address) : ?>

                <div class="card mt-4 mb-4">
                    <div class="card-header">
                        <?php echo $address ['name']; ?>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?php echo $address ['street']; ?> - <?php echo $address ['home_number']; ?>
                                - <?php echo $address ['plz']; ?></p>
                        </blockquote>
                    </div>
                </div>


            <?php endforeach; ?>
        </div>
        <div class="col">
            <h2>Delivery address</h2>

            <?php foreach ($addresses as $address) : ?>

                <div class="card mt-4 mb-4">
                    <div class="card-header">
                        <?php echo $address ['name']; ?>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?php echo $address ['street']; ?> - <?php echo $address ['home_number']; ?>
                                - <?php echo $address ['plz']; ?></p>
                        </blockquote>
                    </div>
                </div>


            <?php endforeach; ?>
        </div>

        <div class="col">
            <h2>Create New Address</h2>

            <form action="controller/userController.php" method="POST">

                <p>Address type</p>
                <select class="form-select" aria-label="Address type" name="type">
                    <option value="delivery">Delivery</option>
                    <option value="invoice" <?php echo Validation::getValue('type') == 'invoice' ? 'Selected' : '' ?> >
                        Invoice
                    </option>
                </select>
                <br>
                <p>Country</p>
                <select class="form-select" aria-label="Address type" name="country">
                    <?php $country_id = Validation::getValue('country'); ?>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country['id'] ?>" <?php echo $country_id == $country['id'] ? 'Selected' : '' ?>>
                            <?php echo $country['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <br>

                <div class="mb-3">
                    <label for="street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="street" name="street"
                           value="<?php echo Validation::getValue('street') ?>">
                </div>

                <div class="mb-3">
                    <label for="plz" class="form-label">PLZ</label>
                    <input type="text" class="form-control" id="plz" name="plz"
                           value="<?php echo Validation::getValue('plz') ?>">
                </div>

                <div class="mb-3">
                    <label for="home_number" class="form-label">Home Number</label>
                    <input type="text" class="form-control" id="home_number" name="home_number"
                           value="<?php echo Validation::getValue('home_number') ?>">
                </div>


                <button type="submit" class="btn btn-primary" name="save_new_address">Create Address</button>
            </form>
        </div>
    </div>

</div>

<?php require_once 'templates/footer.php'; ?>
