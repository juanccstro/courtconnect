<?php
namespace App\models;
use PDO;
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/BaseModel.php';

class SolicitudSponsor extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function crear($eventoId, $sponsorId, $empresa, $email, $aportacion, $mensaje, $logoFilename = null) {
        $sql = "INSERT INTO solicitudes_sponsor 
                (evento_id, sponsor_id, nombre_empresa, email, aportacion, mensaje, logo, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pendiente')";

        return $this->run($sql, [
            $eventoId,
            $sponsorId,
            $empresa,
            $email,
            $aportacion,
            $mensaje,
            $logoFilename
        ]);
    }

    public function obtenerPorEvento($eventoId) {
        $sql = "SELECT s.*, u.logo, u.nombre AS sponsor_nombre
            FROM solicitudes_sponsor s
            JOIN usuarios u ON u.id = s.sponsor_id
            WHERE s.evento_id = ? AND s.estado = 'pendiente'";

        return $this->run($sql, [$eventoId])->fetchAll();
    }

    public function aceptar($id) {
        $sql = "UPDATE solicitudes_sponsor 
                SET estado = 'aceptada' 
                WHERE id = ?";

        return $this->run($sql, [$id]);
    }

    public function rechazar($id) {
        $sql = "DELETE FROM solicitudes_sponsor WHERE id = ?";
        return $this->run($sql, [$id]);
    }
}
