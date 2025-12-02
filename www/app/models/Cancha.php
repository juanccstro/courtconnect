<?php

require_once __DIR__ . '/BaseModel.php';

class Cancha extends BaseModel
{
    public function getAll()
    {
        $sql = "SELECT * FROM canchas ORDER BY id DESC";
        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM canchas WHERE id = :id";
        return $this->run($sql, [':id' => $id])->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        $sql = "INSERT INTO canchas (nombre, ubicacion, imagen, tipo, estado)
                VALUES (:nombre, :ubicacion, :imagen, :tipo, :estado)";

        return $this->run($sql, [
            ':nombre'    => $data['nombre'],
            ':ubicacion' => $data['ubicacion'],
            ':imagen'    => $data['imagen'],
            ':tipo'      => $data['tipo'],
            ':estado'    => $data['estado']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE canchas
                SET nombre = :nombre,
                    ubicacion = :ubicacion,
                    imagen = :imagen,
                    tipo = :tipo,
                    estado = :estado
                WHERE id = :id";

        return $this->run($sql, [
            ':id'        => $id,
            ':nombre'    => $data['nombre'],
            ':ubicacion' => $data['ubicacion'],
            ':imagen'    => $data['imagen'],
            ':tipo'      => $data['tipo'],
            ':estado'    => $data['estado']
        ]);
    }

    public function getEstado($id)
    {
        $sql = "SELECT estado FROM canchas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM canchas WHERE id = :id";
        return $this->run($sql, [':id' => $id]);
    }
}
