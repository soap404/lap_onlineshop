<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    .email-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .email-header {
        text-align: center;
        background-color: #4CAF50;
        padding: 10px;
        border-radius: 8px 8px 0 0;
        color: #ffffff;
    }

    .email-body {
        padding: 20px;
        color: #333333;
    }

    .email-body h2 {
        color: #4CAF50;
    }

    .order-details {
        margin: 20px 0;
    }

    .order-details th,
    .order-details td {
        padding: 8px;
        border: 1px solid #dddddd;
        text-align: left;
    }

    .order-details th {
        background-color: #f4f4f4;
    }

    .order-summary {
        text-align: right;
        margin-top: 20px;
    }

    .email-footer {
        text-align: center;
        margin-top: 20px;
        color: #777777;
    }
</style>

<div class="email-container">
    <div class="email-header">
        <h1>Vielen Dank für Ihre Bestellung!</h1>
    </div>
    <div class="email-body">
        <h2>Hallo <?php echo htmlspecialchars($mail_user['fname']) . ' ' . htmlspecialchars($mail_user['lname']) ?>,</h2>
        <p>Wir haben Ihre Bestellung erhalten und ist unterweges. Hier sind die Details Ihrer Bestellung:</p>

        <table class="order-details">
            <tr>
                <th>Artikel</th>
                <th>Menge</th>
                <th>Preis</th>
            </tr>
            <?php foreach ($mail_order_products as $order_product): ?>
                <tr>
                    <td><?php echo  htmlspecialchars($order_product ['name'])?></td>
                    <td><?php echo  htmlspecialchars($order_product ['quantity'])?></td>
                    <td>€<?php echo  htmlspecialchars($order_product ['price'])?> €</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="order-summary">
            <p><strong>Gesamtbetrag:</strong> <?php echo htmlspecialchars($mail_order['total_price'])?> €</p>
            <p><strong>Datum:</strong> <?php echo htmlspecialchars($mail_order['order_date'])?></p>
        </div>

        <p>Falls Sie Fragen haben, kontaktieren Sie unseren Kundenservice.</p>
    </div>
    <div class="email-footer">
        <p>Mit freundlichen Grüßen,<br>
            Ihr Abdul Onlineshop-Team</p>
        <p><small>Diese E-Mail wurde automatisch generiert. Bitte antworten Sie nicht direkt darauf.</small></p>
    </div>
</div>