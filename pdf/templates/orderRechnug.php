<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechnung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            text-align: center;
            background-color: #4CAF50;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            color: #ffffff;
        }

        .invoice-body {
            padding: 20px;
            color: #333333;
        }

        .invoice-body h2 {
            color: #4CAF50;
        }

        .invoice-details {
            margin: 20px 0;
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        .invoice-details th {
            background-color: #f4f4f4;
        }

        .invoice-summary {
            text-align: right;
            margin-top: 20px;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 20px;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Rechnung</h1>
        </div>
        <div class="invoice-body">
            <h2>Rechnung für <?php echo $user['fname'] . ' ' . $user['lname'] ?></h2>
            <p>Vielen Dank für Ihren Einkauf! Hier sind die Details Ihrer Bestellung:</p>

            <table class="invoice-details">
                <tr>
                    <th>Artikel</th>
                    <th>Menge</th>
                    <th>Preis</th>
                    <th>Gesamt</th>
                </tr>
                <?php foreach ($order_products as $order_product): ?>
                    <tr>
                        <td><?php echo  $order_product['name'] ?></td>
                        <td><?php echo  $order_product['quantity'] ?></td>
                        <td>€<?php echo  $order_product['price'] ?> €</td>
                        <td>€<?php echo  $order_product['quantity'] * $order_product['price'] ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="order-summary">
                <p><strong>Datum:</strong> <?php echo $order['order_date'] ?></p>
            </div>
        </div>
        <div class="invoice-footer">
            <p>Mit freundlichen Grüßen,<br>
                Ihr Abdul Onlineshop-Team</p>
            <p><small>Diese Rechnung wurde automatisch generiert und ist ohne Unterschrift gültig.</small></p>
        </div>
    </div>
</body>

</html>