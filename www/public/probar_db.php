<?php
require_once __DIR__ . '/../config/db.php';

// Probar conexión a bbdd
try {
    $stmt = $db->query("SELECT COUNT(*) FROM usuarios");
    $count = $stmt->fetchColumn();
    echo "<h1>CourtConnect</h1>";
    echo "<p>Conexión establecida.</p>";
    echo "<p>Usuarios: <strong>$count</strong></p>";
} catch (PDOException $e) {
    echo "<p style='color:red'> Error en la consulta: " . $e->getMessage() . "</p>";
}
?>
