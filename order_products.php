<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/ProductModel.php'; ?>
<?php require_once 'models/OrderModel.php'; ?>

<?php
//MIDDLEWARE. RETURN THE GUEST TO INDEX PHP
if (Middleware::is_guest()) {
    header('location: index.php');
    exit();
}
?>

<?php


$orderModel = new OrderModel();
$productModel = new ProductModel();


//Check if id is set
if (!isset($_GET['id'])) {
    header('location: index.php');
    exit();
}
$order_id = $_GET['id'];

$order = $orderModel->show($order_id);


//Check if order exists
if (!$order) {
    header('location: index.php');
    exit();
}


//Check if order belongs to user
if ($order['user_id'] != $_SESSION['user']['id']) {
    header('location: index.php');
    exit();
}


$orderProducts = $orderModel->get_order_products($order_id);

$invoice_address = $orderModel->get_invoice_address($order_id);
$delevery_address = $orderModel->get_delivery_address($order_id);



?>

<div class="row align-items-start mt-4">
    <div class="col">
        <h2>Invoice Addresses</h2>
        <div class="card mt-4 mb-4">
            <div class="card-header">
                <?php echo $invoice_address['country']; ?>
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p><?php echo $invoice_address['street']; ?> - <?php echo $invoice_address['home_number']; ?>
                        - <?php echo $invoice_address['plz']; ?></p>
                </blockquote>
            </div>
        </div>
    </div>


    <div class="col">
        <h2>Delivery address</h2>
        <div class="card mt-4 mb-4">
            <div class="card-header">
                <?php echo $delevery_address['country']; ?>
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p><?php echo $delevery_address['street']; ?> - <?php echo $delevery_address['home_number']; ?>
                        - <?php echo $delevery_address['plz']; ?></p>
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
                <td><img width="100px" height="100px" src="./images/<?php echo $product['image'] ?: 'default.png' ?>"></td>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['price'] ?> €</td>
                <td><?php echo $product['quantity'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php require_once 'templates/footer.php'; ?>