<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/ProductModel.php'; ?>


<?php if (Validation::is_errors()) {
    // LOOP THE ERRORS IF WE HAVE ERRORS IN THE SESSION
    $errors = Validation::getErrors();

    foreach ($errors as $error) {
        echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>';
    }
} ?>

<?php

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $total = 0;
    $productModel = new ProductModel();

    foreach ($_SESSION['cart'] as $key => $value) {
        $id = $key;
        $cart_products[$id] = $productModel->show_active($id);

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
    <table class="table my-5">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">image</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart_products

        as $product): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($product['id']) ?></th>
            <td><img width="100px" height="100px"
                     src="images/<?php echo htmlspecialchars($product['img']) ?: 'default.png' ?>"
                     alt=""></td>
            <td><?php echo htmlspecialchars($product['name']) ?></td>
            <td><?php echo htmlspecialchars($product['price']) ?> €</td>

            <td>
                <form action="controller/cartController.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <select class="form-select form-select-sm" aria-label="Small select example" name="qty">
                        <?php for ($i = 1; $i <= $product['stock'] && $i <= 30; $i++) : ?>
                            <option <?php echo htmlspecialchars($product['qty'] == $i ? 'selected="selected"' : '') ?>
                                    value="<?php echo htmlspecialchars($i) ?>">
                                Quantity: <?php echo htmlspecialchars($i) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                    <br>
                    <button class="btn btn-info mt-auto" name="update_qty">Update Quantity</button>
                </form>
            </td>
            <td><?php echo htmlspecialchars($product['qty'] * $product['price']) ?> €</td>
            <td>

                <form action="controller/cartController.php" method="POST">
                    <input type="hidden" value="<?php echo htmlspecialchars($product['id']) ?>" name="id">
                    <button class="btn btn-danger" name="remove_from_cart">Remove</button>
                </form>
            </td>

            <?php $total += $product['qty'] * $product['price']; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between">

        <a href="./checkout.php" class="btn btn-success">Checkout</a>
    </div>
<?php endif; ?>

<?php require_once 'templates/footer.php'; ?>