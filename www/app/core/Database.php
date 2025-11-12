<?php
require_once __DIR__ . '/../../config/config.php';

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                    DB_USER,
                    DB_PASS,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
