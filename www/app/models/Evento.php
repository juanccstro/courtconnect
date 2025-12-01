<?php

require_once __DIR__ . '/BaseModel.php';

class Evento extends BaseModel
{
    public function obtenerTodos()
    {
        $sql = "SELECT eventos.*, canchas.nombre AS cancha_nombre 
                FROM eventos
                LEFT JOIN canchas ON eventos.cancha_id = canchas.id
                ORDER BY fecha ASC";

        return $this->run($sql)->fetchAll();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT eventos.*, canchas.nombre AS cancha_nombre,
                canchas.ubicacion AS cancha_ubicacion,
                canchas.imagen AS cancha_imagen
                FROM eventos
                LEFT JOIN canchas ON eventos.cancha_id = canchas.id
                WHERE eventos.id = :id";

        return $this->run($sql, [':id' => $id])->fetch();
    }

    public function crear($data)
    {
        $sql = "INSERT INTO eventos (titulo, tipo, fecha, cancha_id, creador_id, plazas, estado, imagen)
                VALUES (:titulo, :tipo, :fecha, :cancha_id, :creador_id, :plazas, :estado, :imagen)";

        return $this->run($sql, [
            ':titulo'     => $data['titulo'],
            ':tipo'       => $data['tipo'],
            ':fecha'      => $data['fecha'],
            ':cancha_id'  => $data['cancha_id'],
            ':creador_id' => $data['creador_id'],
            ':plazas'     => $data['plazas'],
            ':estado'     => $data['estado'],
            ':imagen'     => $data['imagen']
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

        return $this->run($sql, [
            ':id'        => $id,
            ':titulo'    => $data['titulo'],
            ':tipo'      => $data['tipo'],
            ':fecha'     => $data['fecha'],
            ':cancha_id' => $data['cancha_id'],
            ':plazas'    => $data['plazas'],
            ':estado'    => $data['estado'],
            ':imagen'    => $data['imagen']
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM eventos WHERE id = :id";
        return $this->run($sql, [':id' => $id]);
    }
}
