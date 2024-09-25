<?php

class UserModel extends DB
{

    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }


    public function get_user_by_id($user_id)
    {
        $ps = $this->conn->prepare('
        SELECT fname, lname, email  FROM users
        WHERE id = :user_id');

        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function update_user($user_id, $fname, $lname, $email)
    {
        $ps = $this->conn->prepare('
        UPDATE users SET
        fname = :fname,
        lname = :lname,
        email = :email
        WHERE id = :user_id
        ');

        $ps->bindParam(':user_id', $user_id);
        $ps->bindParam(':fname', $fname);
        $ps->bindParam(':lname', $lname);
        $ps->bindParam(':email', $email);

        $ps->execute();

    }


    public function get_user_by_email($user_id, $email)
    {
        $ps = $this->conn->prepare('
        SELECT email FROM users
        WHERE email = :email
        AND id != :user_id');

        $ps->bindParam(':email', $email);
        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function get_user_password_by_id($user_id)
    {
        $ps = $this->conn->prepare('SELECT password FROM users WHERE id = :user_id');

        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function update_user_password_by_id($user_id, $password)
    {

        $password = password_hash($password, PASSWORD_DEFAULT);

        $ps = $this->conn->prepare('UPDATE users SET password = :password WHERE id = :user_id');
        $ps->bindParam(':user_id', $user_id);
        $ps->bindParam(':password', $password);
        $ps->execute();

    }

    public function get_all_countries()
    {
        $ps = $this->conn->prepare('SELECT * FROM countries');
        $ps->execute();
        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_country_by_id($id)
    {
        $ps = $this->conn->prepare('SELECT * FROM countries WHERE id = :id');
        $ps->bindParam(':id', $id);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function create_invoice_address($user_id, $country_id, $street, $plz, $home_number)
    {
        $ps = $this->conn->prepare('
    INSERT INTO invoice_addresses
            (user_id,country_id,street,plz,home_number )
    VALUES 
            (:user_id,:country_id,:street,:plz,:home_number)
    ');
        $ps->bindParam(':user_id', $user_id);
        $ps->bindParam(':country_id', $country_id);
        $ps->bindParam(':street', $street);
        $ps->bindParam(':plz', $plz);
        $ps->bindParam(':home_number', $home_number);
        $ps->execute();

        return $this->conn->lastInsertId();
    }


    public function create_address($user_id, $country_id, $street, $plz, $home_number)
    {
        $ps = $this->conn->prepare('
    INSERT INTO addresses
            (user_id,country_id,street,plz,home_number )
    VALUES 
            (:user_id,:country_id,:street,:plz,:home_number)
    ');
        $ps->bindParam(':user_id', $user_id);
        $ps->bindParam(':country_id', $country_id);
        $ps->bindParam(':street', $street);
        $ps->bindParam(':plz', $plz);
        $ps->bindParam(':home_number', $home_number);
        $ps->execute();

        return $this->conn->lastInsertId();
    }

    public function get_all_addresses_by_user_id($user_id)
    {
        $ps = $this->conn->prepare('
        SELECT
        addresses.id,
        countries.name AS country,
        addresses.user_id,
        addresses.street,
        addresses.plz,
        addresses.home_number
            FROM addresses 
        JOIN countries ON countries.id = addresses.country_id
        WHERE user_id = :user_id
');

        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_all_invoice_address_by_user_id($user_id)
    {
        $ps = $this->conn->prepare('
        SELECT
        invoice_addresses.id,
        countries.name AS country,
        invoice_addresses.user_id,
        invoice_addresses.street,
        invoice_addresses.plz,
        invoice_addresses.home_number
        FROM invoice_addresses 
        JOIN countries ON countries.id = invoice_addresses.country_id
        WHERE user_id = :user_id
');

        $ps->bindParam(':user_id', $user_id);
        $ps->execute();
        return $ps->fetchAll(PDO::FETCH_ASSOC);
    }

}