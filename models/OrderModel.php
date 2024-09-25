<?php

class OrderModel extends DB
{
    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }


}