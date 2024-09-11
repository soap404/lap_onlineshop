<?php
require_once('../autoload.php');

class ProductModel extends DB
{
    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function store($name, $description, $price, $stock, $active, $image){
        $ps = $this->conn->prepare('
        INSERT INTO products (name, description, price, stock, img, is_active)
        VALUES (:name, :description, :price, :stock, :active, :image)'
        );

        $ps->bindParam(':name', $name);
        $ps->bindParam(':description', $description);
        $ps->bindParam(':price', $price);
        $ps->bindParam(':stock', $stock);
        $ps->bindParam(':active', $active);
        $ps->bindParam(':image', $image);
        $ps->execute();
        return $this->conn->lastInsertId();
    }
}