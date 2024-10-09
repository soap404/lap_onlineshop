<?php

class OrderModel extends DB
{
    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function index()
    {
        $ps = $this->conn->prepare('
            SELECT o.id, s.name AS status, o.order_date, COUNT(op.id) AS count_products, SUM(op.price * op.quantity) AS total_price FROM orders o
            LEFT JOIN status s ON s.id = o.status_id
            LEFT JOIN order_products op ON op.order_id = o.id
            GROUP BY o.id
            ORDER BY o.order_date DESC
        ');
        $ps->execute();
        return $ps->fetchAll();
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



    public function show($id)
    {
        $ps = $this->conn->prepare('SELECT * FROM orders WHERE id = :id');
        $ps->bindParam(':id', $id, PDO::PARAM_INT);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
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


    public function get_order_products($order_id)
    {
        $ps = $this->conn->prepare('
        SELECT  p.name AS name , p.img AS image , op.quantity AS quantity, op.price AS price
        FROM order_products op 
        LEFT JOIN products p ON p.id = op.product_id
        WHERE op.order_id = :order_id
        ');

        $ps->bindParam(':order_id', $order_id);
        $ps->execute();
        return $ps->fetchAll();
    }

    public function get_invoice_address($order_id)
    {
        $ps = $this->conn->prepare('
        SELECT 
            ia.id,
            c.name AS country,
            ia.street,
            ia.plz,
            ia.home_number
        FROM invoice_addresses ia
        LEFT JOIN countries c ON c.id = ia.country_id
        LEFT JOIN orders o ON o.invoice_address_id = ia.id
        WHERE o.id = :order_id

        ');
        $ps->bindParam(':order_id', $order_id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function get_delivery_address($order_id)
    {
        $ps = $this->conn->prepare('
        SELECT 
            a.id,
            c.name AS country,
            a.street,
            a.plz,
            a.home_number
        FROM addresses a
        LEFT JOIN countries c ON c.id = a.country_id
        LEFT JOIN orders o ON o.address_id = a.id
        WHERE o.id = :order_id
        ');
        $ps->bindParam(':order_id', $order_id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function update_status($order_id, $status_id)
    {
        $ps = $this->conn->prepare('
        UPDATE orders
        SET status_id = :status_id
        WHERE id = :order_id
        ');
        $ps->bindParam(':order_id', $order_id);
        $ps->bindParam(':status_id', $status_id);
        $ps->execute();
    }
}
