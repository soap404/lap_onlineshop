<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/ProductModel.php'; ?>


<?php
//MIDDLEWARE. RETURN THE USER TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}

//CALL ALL PRODUCTS

$productModel = new ProductModel();

$products = $productModel->index();


?>
    <a href="create_product.php" class="btn btn-primary">Create Product</a>

    <table class="table my-5">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">image</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Stock</th>
            <th scope="col">Actions</th>
            <th scope="col">Active</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
            <th scope="row"><?php echo $product['id'] ?></th>
            <td><img width="100px" height="100px"
                     src="images/<?php echo $product['img'] ? : 'default.png' ?>"
                     alt=""></td>
            <td><?php echo $product['name'] ?></td>
            <td><?php echo $product['description'] ?></td>
            <td><?php echo $product['price'] ?></td>

            <td><?php echo $product['stock'] ?></td>
            <td>
                <a class="btn btn-warning" href="edit_product.php?id=<?php echo $product['id'] ?>">Edit</a>

                <form action="controller/productController.php" method="POST">
                    <input type="hidden" value="<?php echo $product['id'] ?>" name="id">
                    <button class="btn btn-danger" name="delete_product">Delete</button>
                </form>
            </td>

            <?php if ($product['is_active'] == 1): ?>
                <td><p class="text-success">Active</p></td>
            <?php else: ?>
                <td><p class="text-danger">not Active</p></td>
                </tr>
            <?php endif; ?>


        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once 'templates/footer.php'; ?>