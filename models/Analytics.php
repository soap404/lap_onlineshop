<?php

class Analytics extends DB
{

    protected PDO $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }


    public function top_quantity_products(): array
    {
        $ps = $this->conn->prepare("
        SELECT
        p.id, p.name, p.img, SUM(op.quantity) AS quantity, SUM(op.price * op.quantity) AS total_profit
        FROM products p
        LEFT JOIN order_products op ON op.product_id = p.id
        GROUP BY op.product_id
        ORDER BY quantity DESC
        LIMIT 3
        ");

        $ps->execute();

        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }


    public function top_total_profit_products(): array
    {
        $ps = $this->conn->prepare("
        SELECT
        p.id, p.name, p.img, SUM(op.quantity) AS quantity, SUM(op.price * op.quantity) AS total_profit
        FROM products p
        LEFT JOIN order_products op ON op.product_id = p.id
        GROUP BY op.product_id
        ORDER BY total_profit DESC
        LIMIT 3
        ");

        $ps->execute();

        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }


}