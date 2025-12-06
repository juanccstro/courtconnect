<?php

require_once __DIR__ . '/BaseModel.php';

class Patrocinador extends BaseModel
{
    public function crear($usuarioId, $nombre, $logo)
    {
        $sql = "INSERT INTO patrocinadores (usuario_id, nombre, logo, aprobado)
                VALUES (?, ?, ?, 1)";

        return $this->run($sql, [$usuarioId, $nombre, $logo]);
    }
}
