<?php

class DB
{
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const DATABASE = 'lap_onlineshop';

    protected function connect()
    {
        return new PDO('mysql:host='.self::HOST.';dbname='.self::DATABASE, self::USER, self::PASSWORD);
    }
}