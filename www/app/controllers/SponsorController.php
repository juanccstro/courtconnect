<?php
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/SolicitudSponsor.php';
require_once __DIR__ . '/../models/Evento.php';

class SponsorController {

    /** Mostrar formulario */
    public function formulario($eventoId) {
        Auth::requireRole("sponsor");

        $eventoModel = new Evento();
        $evento = $eventoModel->obtenerPorId($eventoId);

        // Si el evento ya tiene sponsor → bloquear
        if (!empty($evento['sponsor_id'])) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Este evento ya tiene un patrocinador asignado.'
            ];
            header("Location: /eventos/$eventoId");
            exit;
        }

        // Si este sponsor ya patrocinó otro evento → bloquear
        if ($eventoModel->sponsorYaPatrocina($_SESSION['usuario']['id'])) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Ya has patrocinado un evento. Solo puedes patrocinar uno.'
            ];
            header("Location: /eventos/$eventoId");
            exit;
        }

        require __DIR__ . '/../views/patrocinadores/patrocinar.view.php';
    }

    /** Procesar envío del formulario de patrocinio */
    public function enviar($eventoId) {
        Auth::requireRole("sponsor");

        $empresa    = trim($_POST['empresa'] ?? '');
        $aportacion = (float) ($_POST['aportacion'] ?? 0);
        $mensaje    = trim($_POST['mensaje'] ?? '');
        $email      = $_SESSION['usuario']['email'] ?? '';
        $sponsorId  = $_SESSION['usuario']['id'] ?? null;
        $eventoModel = new Evento();
        $evento = $eventoModel->obtenerPorId($eventoId);

        // Validaciones básicas
        if (empty($empresa) || empty($mensaje) || empty($email) || empty($sponsorId)) {
            $_SESSION['flash'] = [
                'type'    => 'error',
                'message' => 'Todos los campos son obligatorios.'
            ];
            header("Location: /eventos/patrocinar/$eventoId");
            exit;
        }

        if ($aportacion < 100) {
            $_SESSION['flash'] = [
                'type'    => 'error',
                'message' => 'La aportación mínima es de 100€.'
            ];
            header("Location: /eventos/patrocinar/$eventoId");
            exit;
        }

        if (!empty($evento['sponsor_id'])) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No se puede enviar una solicitud. Este evento ya tiene un patrocinador.'
            ];
            header("Location: /eventos/$eventoId");
            exit;
        }

        if ($eventoModel->sponsorYaPatrocina($_SESSION['usuario']['id'])) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Solo puedes patrocinar un evento en la plataforma.'
            ];
            header("Location: /eventos/$eventoId");
            exit;
        }

        // Subir logo
        $logoFilename = null;

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {

            $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            // Nombre único
            $logoFilename = uniqid('sponsor_') . '.' . $ext;

            $uploadDir  = __DIR__ . '/../../public/uploads/logos/';
            $uploadPath = $uploadDir . $logoFilename;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath);
        }

        // Guardar solicitud
        $model = new SolicitudSponsor();
        $model->crear($eventoId, $sponsorId, $empresa, $email, $aportacion, $mensaje, $logoFilename);

        $_SESSION['flash'] = [
            'type'    => 'success',
            'message' => 'Solicitud enviada correctamente.'
        ];

        header("Location: /eventos/$eventoId");
        exit;
    }

    /** Listado de solicitudes (solo admin) */
    public function listar($eventoId) {
        Auth::requireRole("admin");

        $model = new SolicitudSponsor();
        $solicitudes = $model->obtenerPorEvento($eventoId);

        require __DIR__ . '/../views/eventos/solicitudes.view.php';
    }

    public function aceptar($id) {
        Auth::requireRole("admin");

        $solicitudModel = new SolicitudSponsor();
        $solicitud = $solicitudModel->findById("solicitudes_sponsor", $id);

        if (!$solicitud) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Solicitud no encontrada.'];
            header("Location: /eventos");
            exit;
        }

        $solicitudModel->aceptar($id);

        $eventoModel = new Evento();
        $eventoModel->asignarSponsor(
            $solicitud['evento_id'],
            $solicitud['sponsor_id'],
            $solicitud['logo']
        );

        require_once __DIR__ . '/../models/Patrocinador.php';
        $patroModel = new Patrocinador();
        $patroModel->crear(
            $solicitud['sponsor_id'],
            $solicitud['nombre_empresa'],
            $solicitud['logo']
        );

        $solicitudModel->rechazar($id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Solicitud aceptada correctamente.'
        ];

        header("Location: /eventos/" . $solicitud['evento_id']);
        exit;
    }

}
