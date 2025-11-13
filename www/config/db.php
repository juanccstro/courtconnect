<?php

class Database
{
    public static function connect()
    {
        $host = 'mysql';       
        $dbname = 'proxectodb';
        $user = 'admin';
        $pass = 'daw2pass';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, $options);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
