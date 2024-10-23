<?php
require_once 'templates/header.php';
require_once 'models/ProductModel.php';
$productModel = new ProductModel();
$products = $productModel->index_user();
?>

    <style>
        .card-img-top {
            object-fit: cover;
        }
    </style>

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <div class="ratio ratio-16x9">
                            <img src="images/<?php echo htmlspecialchars($product['img'] ?: 'default.png'); ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($product['description']); ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Stock: <?php echo htmlspecialchars($product['stock']); ?></li>
                                <li class="list-group-item">Price: <?php echo htmlspecialchars($product['price']); ?> €</li>
                            </ul>
                            <form action="controller/cartController.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                <select class="form-select form-select-sm" aria-label="Small select example" name="qty">
                                    <?php for ($i = 1; $i <= $product['stock'] && $i <= 30; $i++) : ?>
                                        <option value="<?php echo htmlspecialchars($i); ?>">Stock: <?php echo htmlspecialchars($i); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <br>
                                <button class="btn btn-primary mt-auto" name="add_to_cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once 'templates/footer.php'; ?>