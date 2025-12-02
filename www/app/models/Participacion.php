<?php

require_once __DIR__ . '/BaseModel.php';

class Participacion extends BaseModel
{
    /**
     * Obtener participantes de un evento
     */
    public function getByEvento($eventoId)
    {
        $sql = "
        SELECT 
            p.id,
            p.usuario_id,
            p.nombre_participante,
            p.posicion,
            p.edad,
            u.nombre AS usuario_nombre
        FROM participaciones p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        WHERE p.evento_id = ?
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$eventoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Comprobar si un usuario ya está inscrito
     */
    public function yaInscrito($eventoId, $usuarioId)
    {
        $sql = "
            SELECT id 
            FROM participaciones
            WHERE evento_id = :evento_id 
            AND usuario_id = :usuario_id
        ";

        return $this->run($sql, [
            ':evento_id' => $eventoId,
            ':usuario_id' => $usuarioId
        ])->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Inscribir usuario en un evento
     */
    public function inscribir($eventoId, $usuarioId, $nombre, $posicion, $edad)
    {
        $query = $this->db->prepare("
        INSERT INTO participaciones (evento_id, usuario_id, nombre_participante, posicion, edad)
        VALUES (?, ?, ?, ?, ?)
    ");

        return $query->execute([$eventoId, $usuarioId, $nombre, $posicion, $edad]);
    }

    public function countByEvento($eventoId)
    {
        $query = $this->db->prepare("
        SELECT COUNT(*) AS total
        FROM participaciones
        WHERE evento_id = ?
    ");
        $query->execute([$eventoId]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['total'] : 0;
    }

    public function tieneConflictoHorarios($usuarioId, $eventoId)
    {
        $eventoStmt = $this->db->prepare("SELECT fecha FROM eventos WHERE id = ?");
        $eventoStmt->execute([$eventoId]);
        $evento = $eventoStmt->fetch(PDO::FETCH_ASSOC);

        if (!$evento) {
            return false;
        }

        $fecha = $evento['fecha'];

        $query = $this->db->prepare("
        SELECT e.id
        FROM participaciones p
        JOIN eventos e ON e.id = p.evento_id
        WHERE p.usuario_id = ?
          AND e.fecha = ?
    ");
        $query->execute([$usuarioId, $fecha]);
        return (bool) $query->fetch();
    }

        public function eliminar($participacionId)
    {
        $query = $this->db->prepare("DELETE FROM participaciones WHERE id = ?");
        return $query->execute([$participacionId]);
    }

    public function agregarManual($eventoId, $nombre, $posicion, $edad)
    {
        $query = $this->db->prepare("
        INSERT INTO participaciones (evento_id, nombre_participante, posicion, edad)
        VALUES (?, ?, ?, ?)
        ");

        return $query->execute([$eventoId, $nombre, $posicion, $edad]);
    }


}
