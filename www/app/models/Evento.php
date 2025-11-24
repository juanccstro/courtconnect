<?php

require_once __DIR__ . '/../core/Database.php';

class Evento
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
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

    public function crear($data)
    {
        $sql = "INSERT INTO eventos (titulo, tipo, fecha, cancha_id, creador_id, plazas, estado, imagen)
            VALUES (:titulo, :tipo, :fecha, :cancha_id, :creador_id, :plazas, :estado, :imagen)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':titulo'    => $data['titulo'],
            ':tipo'      => $data['tipo'],
            ':fecha'     => $data['fecha'],
            ':cancha_id' => $data['cancha_id'],
            ':creador_id'=> $data['creador_id'],
            ':plazas'    => $data['plazas'],
            ':estado'    => $data['estado'],
            ':imagen'    => $data['imagen'],
        ]);
    }

    public function actualizar($id, $data)
    {
        $sql = "UPDATE eventos 
            SET titulo = :titulo,
                tipo = :tipo,
                fecha = :fecha,
                cancha_id = :cancha_id,
                plazas = :plazas,
                estado = :estado,
                imagen = :imagen
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'        => $id,
            ':titulo'    => $data['titulo'],
            ':tipo'      => $data['tipo'],
            ':fecha'     => $data['fecha'],
            ':cancha_id' => $data['cancha_id'],
            ':plazas'    => $data['plazas'],
            ':estado'    => $data['estado'],
            ':imagen'    => $data['imagen'],
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM eventos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }


}
