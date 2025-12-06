<?php

require_once __DIR__ . '/BaseModel.php';

class Evento extends BaseModel
{
    public function obtenerTodos()
    {
        $sql = "SELECT e.*,
                c.nombre AS cancha_nombre,
                p.nombre AS sponsor_nombre,
                p.logo AS sponsor_logo
            FROM eventos e
            LEFT JOIN canchas c ON e.cancha_id = c.id
            LEFT JOIN patrocinadores p ON p.usuario_id = e.sponsor_id
            ORDER BY e.fecha ASC";

        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existenEventosEnCancha($canchaId)
    {
        $sql = "SELECT COUNT(*) AS total FROM eventos WHERE cancha_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$canchaId]);
        $row = $stmt->fetch();
        return $row && $row['total'] > 0;
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT e.*,
                c.nombre AS cancha_nombre,
                c.ubicacion AS cancha_ubicacion,
                c.imagen AS cancha_imagen,
                p.nombre AS sponsor_nombre,
                p.logo AS sponsor_logo
            FROM eventos e
            LEFT JOIN canchas c ON e.cancha_id = c.id
            LEFT JOIN patrocinadores p ON p.usuario_id = e.sponsor_id
            WHERE e.id = :id";

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

    public function asignarSponsor($eventoId, $sponsorId, $logo)
    {
        $sql = "UPDATE eventos 
            SET sponsor_id = ?, sponsor_logo = ?
            WHERE id = ?";

        return $this->run($sql, [$sponsorId, $logo, $eventoId]);
    }

    public function sponsorYaPatrocina($sponsorId) {
        $sql = "SELECT COUNT(*) FROM eventos WHERE sponsor_id = ?";
        return $this->run($sql, [$sponsorId])->fetchColumn() > 0;
    }


    public function eliminar($id)
    {
        $sql = "DELETE FROM eventos WHERE id = :id";
        return $this->run($sql, [':id' => $id]);
    }
}
