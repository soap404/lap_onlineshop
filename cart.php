<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/ProductModel.php'; ?>

<?php

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
    $productModel = new ProductModel();

    foreach($_SESSION['cart'] as $key => $value){
        $id = $key;
        $cart_products[$id] = $productModel->show($id);

        //REMOVE THE PRODUCT FROM THE CART IF IT DOES NOT EXIST ANYMORE IN THE DATABASE
        if(!$cart_products[$id]){
            unset($cart_products[$id]);
            unset($_SESSION['cart'][$id]);
        }else{
            // If the user has e.g. 100 qty in the session but only 50 are available in the database,
            // only 50 qty will be saved in the cart.
            $cart_products[$id]['qty'] = min($value['qty'], $cart_products[$id]['stock']);

            // SAVE THE NEW STOCK IN THE SESSION
            $_SESSION['cart'][$key]['qty'] = $cart_products[$id]['qty'];
        }

    }
}
?>

<?php if(isset($cart_products)) :?>
    <table class="table my-5">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">image</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart_products as $product): ?>
            <tr>
            <th scope="row"><?php echo $product['id'] ?></th>
            <td><img width="100px" height="100px"
                     src="images/<?php echo $product['img'] ? : 'default.png' ?>"
                     alt=""></td>
            <td><?php echo $product['name'] ?></td>
            <td><?php echo $product['description'] ?></td>
            <td><?php echo $product['price'] ?></td>

            <td><?php echo $product['qty'] ?></td>
            <td>

                <form action="controller/cartController.php" method="POST">
                    <input type="hidden" value="<?php echo $product['id'] ?>" name="id">
                    <button class="btn btn-danger" name="remove_from_cart">Remove</button>
                </form>
            </td>



        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<?php require_once 'templates/footer.php'; ?>