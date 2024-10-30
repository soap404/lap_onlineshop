<?php

class AdminModel extends DB
{

    protected PDO $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }


    public function index(): false|array
    {

        // we have to remove the password form the query
        $ps = $this->conn->prepare("SELECT * FROM `users`");

        $ps->execute();

        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): void
    {

        $ps = $this->conn->prepare("DELETE FROM `users` WHERE `id` = :id");
        $ps->bindParam(':id', $id);
        $ps->execute();

    }

    public function show(int $id): false|array
    {

        $ps = $this->conn->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $ps->bindParam(':id', $id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $fname, string $lname, string $email, bool $is_admin, bool $is_active): void
    {
        $ps = $this->conn->prepare("UPDATE `users` SET `fname` = :fname, `lname` = :lname, `email` = :email, `is_admin` = :is_admin, `is_active` = :is_active WHERE `id` = :id");
        $ps->bindParam(':id', $id);
        $ps->bindParam(':fname', $fname);
        $ps->bindParam(':lname', $lname);
        $ps->bindParam(':email', $email);
        $ps->bindParam(':is_admin', $is_admin, PDO::PARAM_BOOL);
        $ps->bindParam(':is_active', $is_active, PDO::PARAM_BOOL);
        $ps->execute();
    }
}