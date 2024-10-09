<?php

class OrderModel extends DB
{
    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }


    public function store($status_id, $invoice_address_id, $address_id, $user_id)
    {
        $ps = $this->conn->prepare(
            '
        INSERT INTO orders (status_id, invoice_address_id, address_id, user_id)
        VALUES (:status_id, :invoice_address_id, :address_id, :user_id)'
        );

        $ps->bindParam(':status_id', $status_id);
        $ps->bindParam(':invoice_address_id', $invoice_address_id);
        $ps->bindParam(':address_id', $address_id);
        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $this->conn->lastInsertId();
    }

    public function store_order_products($order_id, $product_id, $quantity, $price)
    {

        $ps = $this->conn->prepare(
            '
        INSERT INTO order_products (order_id, product_id, quantity, price)
        VALUES (:order_id, :product_id, :quantity, :price)'
        );

        $ps->bindParam(':order_id', $order_id);
        $ps->bindParam(':product_id', $product_id);
        $ps->bindParam(':quantity', $quantity);
        $ps->bindParam(':price', $price);
        $ps->execute();
    }



    public function get_orders_by_user($user_id)
    {
        $ps = $this->conn->prepare('
        SELECT o.id, s.name AS status, o.order_date, COUNT(op.id) AS count_products, SUM(op.price * op.quantity) AS total_price FROM orders o
        LEFT JOIN status s ON s.id = o.status_id
        LEFT JOIN order_products op ON op.order_id = o.id
        WHERE user_id = :user_id
        GROUP BY o.id
        ORDER BY o.order_date DESC
        ');
        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $ps->fetchAll();
    }
}
