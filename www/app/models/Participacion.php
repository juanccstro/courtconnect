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
            SELECT p.posicion, p.edad, u.nombre AS usuario_nombre
            FROM participaciones p
            JOIN usuarios u ON u.id = p.usuario_id
            WHERE p.evento_id = :evento_id
        ";

        return $this->run($sql, [
            ':evento_id' => $eventoId
        ])->fetchAll(PDO::FETCH_ASSOC);
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
    public function inscribir($eventoId, $usuarioId, $posicion, $edad)
    {
        $sql = "
            INSERT INTO participaciones (evento_id, usuario_id, posicion, edad)
            VALUES (:evento_id, :usuario_id, :posicion, :edad)
        ";

        return $this->run($sql, [
            ':evento_id'  => $eventoId,
            ':usuario_id' => $usuarioId,
            ':posicion'   => $posicion,
            ':edad'       => $edad
        ]);
    }
}
