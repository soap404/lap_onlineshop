<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/ProductModel.php'; ?>
<?php require_once 'models/OrderModel.php'; ?>

<?php
// MIDDLEWARE. RETURN THE GUEST TO INDEX PHP
if (Middleware::is_guest()) {
    header('location: index.php');
    exit();
}
?>

<?php
$orderModel = new OrderModel();
$productModel = new ProductModel();

// Check if id is set
if (!isset($_GET['id'])) {
    header('location: index.php');
    exit();
}
$order_id = $_GET['id'];

$order = $orderModel->show($order_id);

// Check if order exists
if (!$order) {
    header('location: index.php');
    exit();
}

// Check if order belongs to user or the user is admin
if ($order['user_id'] != $_SESSION['user']['id'] && !Middleware::is_admin()) {
    header('location: index.php');
    exit();
}

$orderProducts = $orderModel->get_order_products($order_id);

$invoice_address = $orderModel->get_invoice_address($order_id);
$delivery_address = $orderModel->get_delivery_address($order_id);
?>

    <div class="row align-items-start mt-4">
        <div class="col">
            <h2>Invoice Address</h2>
            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <?php echo htmlspecialchars($invoice_address['country']); ?>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p><?php echo htmlspecialchars($invoice_address['street']); ?> - <?php echo htmlspecialchars($invoice_address['home_number']); ?> - <?php echo htmlspecialchars($invoice_address['plz']); ?></p>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="col">
            <h2>Delivery Address</h2>
            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <?php echo htmlspecialchars($delivery_address['country']); ?>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p><?php echo htmlspecialchars($delivery_address['street']); ?> - <?php echo htmlspecialchars($delivery_address['home_number']); ?> - <?php echo htmlspecialchars($delivery_address['plz']); ?></p>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orderProducts as $product): ?>
            <tr>
                <td><img width="100px" height="100px" src="./images/<?php echo htmlspecialchars($product['image'] ?: 'default.png'); ?>" alt=""></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?> €</td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once 'templates/footer.php'; ?>