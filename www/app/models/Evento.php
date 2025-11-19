<?php

require_once __DIR__ . '/../core/Database.php';

class Evento
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT eventos.*, canchas.nombre AS cancha_nombre 
                FROM eventos
                LEFT JOIN canchas ON eventos.cancha_id = canchas.id
                ORDER BY fecha ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT eventos.*, canchas.nombre AS cancha_nombre,
                canchas.ubicacion AS cancha_ubicacion,
                canchas.imagen AS cancha_imagen
                FROM eventos
                LEFT JOIN canchas ON eventos.cancha_id = canchas.id
                WHERE eventos.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
