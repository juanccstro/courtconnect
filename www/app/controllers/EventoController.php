<?php

require_once __DIR__ . '/../models/Evento.php';
require_once __DIR__ . '/../models/Cancha.php';

class EventoController
{
    private $model;

    public function __construct()
    {
        $this->model = new Evento();
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
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.view.php';
            return;
        }

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
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /eventos");
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

        if (!empty($evento['imagen'])) {
            $ruta = __DIR__ . '/../../public/uploads/eventos/' . $evento['imagen'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        $this->model->eliminar($id);

        header("Location: /eventos");
        exit;
    }




}
