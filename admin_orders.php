<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/OrderModel.php'; ?>



<?php
//MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}
?>

<?php
$orderModel = new OrderModel();

$orders = $orderModel->index();




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
            <th>Status Actions</th>
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
                    <a href="order_products.php?id=<?php echo $order['id'] ?>" class="btn btn-success">Show</a>
                    <?php if ($order['status'] == 'Done'): ?>
                        <a href="" class="btn btn-danger">Downlod Invoice</a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($order['status'] == 'Pending'): ?>
                        <form action="controller/orderController.php" method="POST">
                            <button name="order_done" class="btn btn-warning">Mark as Done</button>
                            <button name="order_cancel" class="btn btn-danger">Cancel</button>
                            <input type="hidden" value="<?php echo $order['id'] ?>" name="order_id">
                        </form>
                    <?php else: ?>
                        You can not Edit this Order anymore
                    <?php endif; ?>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<?php require_once 'templates/footer.php'; ?>