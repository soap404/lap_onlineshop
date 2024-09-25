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

    public function update_user_password_by_id($user_id, $password){

        $password = password_hash($password, PASSWORD_DEFAULT);

        $ps = $this->conn->prepare('UPDATE users SET password = :password WHERE id = :user_id');
        $ps->bindParam(':user_id', $user_id);
        $ps->bindParam(':password', $password);
        $ps->execute();

    }

}