<?php require_once 'templates/header.php'; ?>
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
                <th scope="row"><?php echo htmlspecialchars($order['id']); ?></th>
                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td><?php echo htmlspecialchars($order['total_price']); ?> €</td>
                <td><?php echo htmlspecialchars($order['count_products']); ?></td>
                <td>
                    <a href="order_products.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-success">Show</a>
                    <?php if ($order['status'] == 'Done'): ?>
                        <a href="download_invoice.php?file=<?php echo $order['invoice_pdf'] ?>" class="btn btn-danger">Download Invoice</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once 'templates/footer.php'; ?>