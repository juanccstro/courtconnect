<?php

require_once __DIR__ . '/BaseModel.php';

class JugadorDestacado extends BaseModel
{
    public function obtenerTodos()
    {
        $sql = "SELECT * 
                FROM jugadores_destacados 
                ORDER BY mvp_count DESC";

        return $this->run($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $descripcion, $imagen, $mvp)
    {
        $sql = "INSERT INTO jugadores_destacados (nombre, descripcion, imagen, mvp_count)
                VALUES (:nombre, :descripcion, :imagen, :mvp)";

        return $this->run($sql, [
            ':nombre'      => $nombre,
            ':descripcion' => $descripcion,
            ':imagen'      => $imagen,
            ':mvp'         => $mvp
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM jugadores_destacados WHERE id = :id";
        return $this->run($sql, [':id' => $id]);
    }
}
