<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechnung</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            text-align: center;
            background-color: #2a9d8f;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .invoice-body {
            padding: 20px;
            color: #333;
        }

        .invoice-body h2 {
            color: #264653;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .invoice-details {
            margin: 20px 0;
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            text-align: left;
        }

        .invoice-details th {
            background-color: #264653;
            color: #fff;
        }

        .invoice-details tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        .invoice-summary {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            color: #2a9d8f;
        }

        .invoice-summary p {
            margin: 5px 0;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #6c757d;
        }

        .invoice-footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            Rechnung
        </div>
        <div class="invoice-body">
            <ul>
                <li>
                    <strong>Rechnungsnummer:</strong> <?php echo $order['id'] ?><br>
                    <strong>Datum:</strong> <?php echo $order['order_date'] ?><br>
                    <strong>Land:</strong> <?php echo $get_invoice_address['country'] ?><br>
                    <strong>Postleitzahl:</strong> <?php echo $get_invoice_address['plz'] ?><br>
                    <strong>Strasse:</strong> <?php echo $get_invoice_address['street'] ?><br>
                    <strong>Haus Nummer:</strong> <?php echo $get_invoice_address['home_number'] ?>
                </li>
            </ul>

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
                        <td><?php echo $order_product['name'] ?></td>
                        <td><?php echo $order_product['quantity'] ?></td>
                        <td>€<?php echo number_format($order_product['price'], 2, ',', '.') ?></td>
                        <td>€<?php echo number_format($order_product['quantity'] * $order_product['price'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <div class="invoice-summary">
                <p><strong>Gesamtbetrag:</strong> €<?php echo number_format($order['total_price'], 2, ',', '.') ?></p>
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