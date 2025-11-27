<?php

require_once __DIR__ . '/../core/Database.php';

class JugadorDestacado
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->query("SELECT * FROM jugadores_destacados ORDER BY mvp_count DESC");
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM jugadores_destacados WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($nombre, $descripcion, $imagen, $mvp)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO jugadores_destacados (nombre, descripcion, imagen, mvp_count)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $descripcion, $imagen, $mvp]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM jugadores_destacados WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
