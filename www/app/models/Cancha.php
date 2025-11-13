<?php

require_once __DIR__ . '/../../config/db.php';

class Cancha
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM canchas ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM canchas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO canchas (nombre, ubicacion, imagen, tipo, estado)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['ubicacion'],
            $data['imagen'],
            $data['tipo'],
            $data['estado']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE canchas 
                SET nombre = ?, ubicacion = ?, imagen = ?, tipo = ?, estado = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['ubicacion'],
            $data['imagen'],
            $data['tipo'],
            $data['estado'],
            $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM canchas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
