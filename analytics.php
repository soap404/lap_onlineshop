<?php
require_once 'templates/header.php';
require_once 'models/Analytics.php';

$analyticsModel = new Analytics();

$top_quantity_products = $analyticsModel->top_quantity_products();
$top_total_profit_products = $analyticsModel->top_total_profit_products();

?>

<?php
//MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}
?>


    <h1>Analytics</h1>
    <hr>
    <h2>TOP QUANTITY PRODUCTS</h2>

    <table class="table my-5">
        <thead>
        <tr>
            <th scope="col">Top</th>
            <th scope="col">id</th>
            <th scope="col">image</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Profit</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1;?>
        <?php foreach ($top_quantity_products as $product): ?>
        <tr>
            <th><?php echo $i; $i++?> </th>
            <th scope="row"><?php echo htmlspecialchars($product['id']) ?></th>
            <td><img width="100px" height="100px"
                     src="images/<?php echo $product['img'] ?: 'default.png' ?>"
                     alt=""></td>
            <td><?php echo htmlspecialchars($product['name']) ?></td>
            <td><?php echo htmlspecialchars($product['quantity']) ?></td>
            <td><?php echo htmlspecialchars($product['total_profit']) ?> €</td>

            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>
    <h2>TOP TOTAL PROFIT PRODUCTS</h2>
    <table class="table my-5">
        <thead>
        <tr>
            <th scope="col">top</th>
            <th scope="col">id</th>
            <th scope="col">image</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Profit</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1;?>
        <?php foreach ($top_total_profit_products as $product): ?>
        <tr>
            <th><?php echo $i; $i++?> </th>
            <th scope="row"><?php echo htmlspecialchars($product['id']) ?></th>
            <td><img width="100px" height="100px"
                     src="images/<?php echo $product['img'] ?: 'default.png' ?>"
                     alt=""></td>
            <td><?php echo htmlspecialchars($product['name']) ?></td>
            <td><?php echo htmlspecialchars($product['quantity']) ?></td>
            <td><?php echo htmlspecialchars($product['total_profit']) ?> €</td>

            <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once 'templates/footer.php'; ?>