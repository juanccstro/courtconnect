<?php
namespace App\controllers;

use App\models\Participacion;
use App\models\Evento;

require_once __DIR__ . '/../models/Participacion.php';
require_once __DIR__ . '/../models/Evento.php';

class ParticipacionController {

    public function inscribir($evento_id) {

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'jugador') {
            header("Location: /login");
            exit;
        }

        $usuario_id = $_SESSION['usuario']['id'];

        if (Participacion::exists($evento_id, $usuario_id)) {
            $_SESSION['error'] = "Ya estás inscrito en este evento.";
            header("Location: /eventos/$evento_id");
            exit;
        }

        $posicion = $_POST['posicion'];
        $edad     = $_POST['edad'];

        Participacion::add($evento_id, $usuario_id, $posicion, $edad);

        $_SESSION['success'] = "Te has inscrito correctamente.";
        header("Location: /eventos/$evento_id");
    }
}
