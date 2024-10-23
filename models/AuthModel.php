<?php

use Random\RandomException;

require_once('../autoload.php');

class AuthModel extends DB
{

    protected PDO $conn;

    public function __construct()
    {
        $this->conn = $this->connect();
    }

    public function register($fname, $lname, $email, $password): false|string
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $ps = $this->conn->prepare('
        INSERT INTO users
            (fname,lname,email,password,is_admin, is_active)
        VALUES 
            (:fname,:lname,:email,:password,0, 0)
');

        $ps->bindParam(':fname', $fname);
        $ps->bindParam(':lname', $lname);
        $ps->bindParam(':email', $email);
        $ps->bindParam(':password', $password);

        $ps->execute();

        return $this->conn->lastInsertId();
    }

    public function get_user_by_email($email)
    {
        $ps = $this->conn->prepare('
        SELECT * FROM users
        WHERE email = :email');

        $ps->bindParam(':email', $email);
        $ps->execute();
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @throws RandomException
     */
    public function create_token($user_id): string
    {
        $token = bin2hex(random_bytes(500));

        $ps = $this->conn->prepare('
            INSERT INTO active_tokens
                (user_id, token)
            VALUES 
                (:user_id, :token)
            ');

        $ps->bindParam(':user_id', $user_id);
        $ps->bindParam(':token', $token);

        $ps->execute();

        return $token;
    }

}