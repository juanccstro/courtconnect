<?php

require_once __DIR__ . '/../core/Database.php';

class Participacion
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Obtener participantes
     */
    public function getByEvento($eventoId)
    {
        $query = $this->db->prepare("
            SELECT p.posicion, p.edad, u.nombre AS usuario_nombre
            FROM participaciones p
            JOIN usuarios u ON u.id = p.usuario_id
            WHERE p.evento_id = ?
        ");
        $query->execute([$eventoId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Comprobar si el usuario ya está inscrito en el evento
     */
    public function yaInscrito($eventoId, $usuarioId)
    {
        $query = $this->db->prepare("
            SELECT id FROM participaciones
            WHERE evento_id = ? AND usuario_id = ?
        ");
        $query->execute([$eventoId, $usuarioId]);
        return $query->fetch();
    }

    public function inscribir($eventoId, $usuarioId, $posicion, $edad)
    {
        $query = $this->db->prepare("
            INSERT INTO participaciones (evento_id, usuario_id, posicion, edad)
            VALUES (?, ?, ?, ?)
        ");
        return $query->execute([$eventoId, $usuarioId, $posicion, $edad]);
    }
}
