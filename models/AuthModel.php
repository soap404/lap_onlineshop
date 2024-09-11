<?php
require_once('../autoload.php');

class AuthModel extends DB
{

    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function register($fname, $lname, $email, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $ps = $this->conn->prepare('
        INSERT INTO users
            (fname,lname,email,password,is_admin, is_active)
        VALUES 
            (:fname,:lname,:email,:password,0, 1)
');

        $ps->bindParam(':fname', $fname);
        $ps->bindParam(':lname', $lname);
        $ps->bindParam(':email', $email);
        $ps->bindParam(':password', $password);

        $ps->execute();

        return $this->conn->lastInsertId();
    }

}