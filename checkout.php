<?php
require_once 'templates/header.php';
require_once 'models/ProductModel.php';
require_once 'models/UserModel.php';
require_once 'models/OrderModel.php';
?>


<?php
//MIDDLEWARE. RETURN THE GUEST TO LOGIN
if (Middleware::is_guest()) {
    $register_link = '<a href="register.php">Register</a>';
    $message = "you have to login first or $register_link to make a checkout!";
    Messages::setMessage(htmlspecialchars($message));
    header('location: login.php');
    exit();
}

?>

<?php

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $userModel = new UserModel();
    $invoice_addresses = $userModel->get_all_invoice_address_by_user_id($_SESSION['user']['id']);
    $addresses = $userModel->get_all_addresses_by_user_id($_SESSION['user']['id']);

    $total = 0;
    $productModel = new ProductModel();

    foreach ($_SESSION['cart'] as $key => $value) {
        $id = $key;
        $cart_products[$id] = $productModel->show($id);

        //REMOVE THE PRODUCT FROM THE CART IF IT DOES NOT EXIST ANYMORE IN THE DATABASE
        if (!$cart_products[$id]) {
            unset($cart_products[$id]);
            unset($_SESSION['cart'][$id]);
        } else {
            // If the user has e.g. 100 qty in the session but only 50 are available in the database,
            // only 50 qty will be saved in the cart.
            $cart_products[$id]['qty'] = min($value['qty'], $cart_products[$id]['stock']);

            // SAVE THE NEW STOCK IN THE SESSION
            $_SESSION['cart'][$key]['qty'] = $cart_products[$id]['qty'];
        }
    }
}
?>

<?php if (isset($cart_products)) : ?>

    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row align-items-start">

            <div class="col-9">

                <table class="table my-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cart_products as $product): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($product['id']) ?></th>
                        <td><img width="100px" height="100px"
                                 src="images/<?php echo htmlspecialchars($product['img']) ?: 'default.png' ?>"
                                 alt=""></td>
                        <td><?php echo htmlspecialchars($product['name']) ?></td>
                        <td><?php echo htmlspecialchars($product['price']) ?> €</td>
                        <td><?php echo htmlspecialchars($product['qty']) ?></td>
                        <td><?php echo htmlspecialchars($product['qty'] * $product['price']) ?> €</td>

                        <?php $total += $product['qty'] * $product['price']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-3">
                <ul class="list-group">
                    <li class="">Total: <?php echo htmlspecialchars($total) ?> €</li>
                </ul>
                <br>
            </div>

        </div>
        <form action="./controller/checkoutController.php" method="POST">
            <div class="row align-items-start">
                <div class="col">
                    <h2>Invoice Addresses</h2>
                    <?php foreach ($invoice_addresses as $address) : ?>

                        <label for="<?php echo htmlspecialchars($address['id'].'-invoice_address') ?>" class="card mt-4 mb-4 card-body">
                            <?php echo htmlspecialchars($address ['country']); ?>
                            <blockquote class="blockquote mb-0">
                                <p><?php echo htmlspecialchars($address ['street']); ?> - <?php echo htmlspecialchars($address ['home_number']); ?>
                                    - <?php echo htmlspecialchars($address ['plz']); ?></p>
                                <input type="radio" name="invoice_address_id"
                                       id="<?php echo htmlspecialchars($address['id'].'-invoice_address') ?>">
                            </blockquote>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php require_once 'templates/footer.php'; ?>