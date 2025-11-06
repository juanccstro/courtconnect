<?php
// Conexión con base de datos
$host = 'mysql';
$dbname = 'proxectodb';
$user = 'admin';
$pass = 'daw2pass';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión:" . $e->getMessage());
}
?>
