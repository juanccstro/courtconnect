<?php
namespace App\controllers;
use App\models\Evento;
use App\models\Cancha;
use App\models\Participacion;
use DateTime;

require_once __DIR__ . '/../models/Evento.php';
require_once __DIR__ . '/../models/Cancha.php';
require_once __DIR__ . '/../models/Participacion.php';

class EventoController
{
    private $model;
    private $participacionModel;

    public function __construct()
    {
        $this->model = new Evento();
        $this->participacionModel = new Participacion();
    }

    public function index()
    {
        $eventos = $this->model->obtenerTodos();
        require __DIR__ . '/../views/eventos/index.view.php';
    }

    public function show($id)
    {
        $evento = $this->model->obtenerPorId($id);

        if (!$evento) {
            $errorController = new ErrorController();
            $errorController->error404();
            return;
        }

        $participantes = $this->participacionModel->getByEvento($id);

        $ahora = new DateTime();
        $fechaEvento = new DateTime($evento['fecha']);
        $inscripcionesAbiertas = $fechaEvento > $ahora;

        require __DIR__ . '/../views/eventos/show.view.php';
    }

    public function crear()
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /eventos");
            exit;
        }

        $canchas = (new Cancha())->getAll();

        require __DIR__ . '/../views/eventos/crear.view.php';
    }

    public function guardar()
    {
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No tienes permisos para crear eventos.'
            ];
            header('Location: /eventos');
            exit;
        }

        $canchaId = $_POST['cancha_id'] ?? null;

        $canchaModel = new Cancha();
        $estadoCancha = $canchaModel->getEstado($canchaId);

        if (!$estadoCancha) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'La cancha seleccionada no existe.'
            ];
            header('Location: /eventos/crear');
            exit;
        }

        if (strtolower($estadoCancha['estado']) === 'mantenimiento') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'La cancha seleccionada está en mantenimiento. Elige otra cancha.'
            ];
            header('Location: /eventos/crear');
            exit;
        }

        // Validación
        if (empty($_POST['titulo']) || empty($_POST['fecha']) || empty($_POST['cancha_id']) || empty($_POST['plazas']) || empty($_POST['estado'])) {
            $error = "Todos los campos son obligatorios.";
            require __DIR__ . '/../views/eventos/crear.view.php';
            return;
        }

        // Procesar imagen
        $imagen = null;

        if (!empty($_FILES['imagen']['name'])) {

            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $imagen = 'evento_' . time() . '.' . $ext;

            $rutaDestino = __DIR__ . '/../../public/uploads/eventos/' . $imagen;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        }

        $data = [
            'titulo'    => $_POST['titulo'],
            'tipo'      => $_POST['tipo'],
            'fecha'     => $_POST['fecha'],
            'cancha_id' => $_POST['cancha_id'],
            'creador_id'=> $_SESSION['usuario']['id'],
            'plazas'    => $_POST['plazas'],
            'estado'    => $_POST['estado'],
            'imagen'    => $imagen
        ];

        $evento = $this->model->crear($data);

        header("Location: /eventos");
        exit;
    }

    public function editar($id)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /eventos");
            exit;
        }

        $evento = $this->model->obtenerPorId($id);

        if (!$evento) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.view.php';
            return;
        }

        require __DIR__ . '/../views/eventos/editar.view.php';
    }

    public function actualizar($id)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /eventos");
            exit;
        }

        $evento = $this->model->obtenerPorId($id);

        if (!$evento) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.view.php';
            return;
        }

        if (empty($_POST['titulo']) || empty($_POST['fecha']) || empty($_POST['plazas']) || empty($_POST['estado'])) {
            $error = "Los campos título, fecha, plazas y estado son obligatorios.";
            require __DIR__ . '/../views/eventos/editar.view.php';
            return;
        }

        $imagen = $evento['imagen'];

        if (!empty($_FILES['imagen']['name'])) {
            if (!empty($evento['imagen'])) {
                $rutaVieja = __DIR__ . '/../../public/uploads/eventos/' . $evento['imagen'];
                if (file_exists($rutaVieja)) {
                    unlink($rutaVieja);
                }
            }

            // Subir imagen nueva
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $imagen = 'evento_' . time() . '.' . $ext;

            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/eventos/' . $imagen);
        }

        $this->model->actualizar($id, [
            'titulo'    => $_POST['titulo'],
            'tipo'      => $_POST['tipo'],
            'fecha'     => $_POST['fecha'],
            'cancha_id' => $_POST['cancha_id'],
            'plazas'    => $_POST['plazas'],
            'estado'    => $_POST['estado'],
            'imagen'    => $imagen
        ]);

        header("Location: /eventos/$id");
        exit;
    }

    public function eliminar($id)
    {
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No tienes permisos para eliminar eventos.'
            ];
            header('Location: /eventos');
            exit;
        }

        $inscritos = $this->participacionModel->countByEvento($id);
        if ($inscritos > 0) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No se puede eliminar un evento con participantes inscritos.'
            ];
            header("Location: /eventos/$id");
            exit;
        }

        $this->model->eliminar($id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Evento eliminado correctamente.'
        ];
        header('Location: /eventos');
        exit;
    }

    public function inscribir($id)
    {
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'jugador') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Debes iniciar sesión como jugador para inscribirte.'
            ];
            header("Location: /login");
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];

        if ($this->participacionModel->yaInscrito($id, $usuarioId)) {
            $_SESSION['flash'] = [
                'type' => 'info',
                'message' => 'Ya estás inscrito en este evento.'
            ];
            header("Location: /eventos/$id");
            exit;
        }

        if ($this->participacionModel->tieneConflictoHorarios($usuarioId, $id)) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No puedes inscribirte, ya tienes otro evento en el mismo horario.'
            ];
            header("Location: /eventos/$id");
            exit;
        }

        $evento = $this->model->obtenerPorId($id);
        if (!$evento) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'El evento no existe.'
            ];
            header('Location: /eventos');
            exit;
        }

        $inscritos = $this->participacionModel->countByEvento($id);
        if ($inscritos >= (int) $evento['plazas']) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Este evento ya ha alcanzado el límite de plazas.'
            ];
            header("Location: /eventos/$id");
            exit;
        }

        $posicion = $_POST['posicion'] ?? '';
        $edad = $_POST['edad'] ?? '';

        if (empty($posicion) || empty($edad)) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Debes indicar posición y edad para inscribirte.'
            ];
            header("Location: /eventos/$id");
            exit;
        }

        $nombreJugador = $_SESSION['usuario']['nombre'];

        $this->participacionModel->inscribir(
            $id,            // eventoId
            $usuarioId,     // usuarioId
            $nombreJugador, // nombre_participante
            $posicion,      // posicion
            (int)$edad      // edad
        );

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Te has inscrito correctamente al evento.'
        ];
        header("Location: /eventos/$id");
        exit;
    }


    public function eliminarParticipante($idParticipacion, $eventoId)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Acceso denegado'];
            header("Location: /eventos/$eventoId");
            exit;
        }

        require_once __DIR__ . '/../models/Participacion.php';
        $p = new Participacion();

        $p->eliminar($idParticipacion);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Participante eliminado correctamente'];
        header("Location: /eventos/$eventoId");
        exit;
    }

    public function agregarParticipante($eventoId)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Acceso denegado'];
            header("Location: /eventos/$eventoId");
            exit;
        }

        $evento = $this->model->obtenerPorId($eventoId);

        // Contar participantes actuales
        $participantesActuales = count($this->participacionModel->getByEvento($eventoId));

        if ($participantesActuales >= $evento['plazas']) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Este evento ya está completo. No se pueden añadir más participantes.'];
            header("Location: /eventos/$eventoId");
            exit;
        }

        $nombre = trim($_POST['nombre']);
        $posicion = $_POST['posicion'];
        $edad = $_POST['edad'];

        $this->participacionModel->agregarManual($eventoId, $nombre, $posicion, $edad);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Participante añadido correctamente'];
        header("Location: /eventos/$eventoId");
        exit;
    }


}
