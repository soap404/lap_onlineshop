<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/OrderModel.php'; ?>

<?php
$orderModel = new OrderModel();

$orders = $orderModel->get_orders_by_user($_SESSION['user']['id']);


?>


<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Order Date</th>
            <th scope="col">Status</th>
            <th scope="col">Summe</th>
            <th scope="col">Anzahl Produkte</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <th scope="row"><?php echo $order['id'] ?></th>
                <td><?php echo $order['order_date'] ?></td>
                <td><?php echo $order['status'] ?></td>
                <td><?php echo $order['total_price'] ?> €</td>
                <td><?php echo $order['count_products'] ?></td>
                <td>
                    <a href="" class="btn btn-success">Show</a>
                    <a href="" class="btn btn-danger">Downlod Invoice</a>
            </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'templates/footer.php'; ?>