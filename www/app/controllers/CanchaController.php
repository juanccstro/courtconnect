<?php
namespace App\controllers;
use App\models\Cancha;
use App\models\Evento;


require_once __DIR__ . '/../models/Cancha.php';
require_once __DIR__ . '/../models/Evento.php';

class CanchaController
{

    private $canchaModel;
    private $eventoModel;
    private $model;

    public function __construct()
    {
        $this->model = new Cancha();
        $this->eventoModel = new Evento();
    }

    public function index()
    {
        $canchas = $this->model->getAll();
        require_once __DIR__ . '/../views/canchas/index.view.php';
    }

    public function show($id)
    {
        $cancha = $this->model->getById($id);

        if (!$cancha) {
            http_response_code(404);
            require __DIR__ . '/../views/error404.view.php';
            return;
        }

        require __DIR__ . '/../views/canchas/show.view.php';
    }


    public function crear()
    {
        // Solo admin
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /canchas");
            exit;
        }

        require __DIR__ . '/../views/canchas/crear.view.php';
    }

    public function guardar()
    {
        // Solo admin
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /");
            exit;
        }

        // Validación
        if (empty($_POST['nombre']) || empty($_POST['ubicacion']) || empty($_POST['tipo']) || empty($_POST['estado'])) {
            $error = "Todos los campos son obligatorios";
            require __DIR__ . '/../views/canchas/crear.view.php';
            return;
        }

        // Procesar imagen
        $nombreImagen = null;

        if (!empty($_FILES['imagen']['name'])) {

            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImagen = 'cancha_' . time() . '.' . $ext;

            $rutaDestino = __DIR__ . '/../../public/uploads/canchas/' . $nombreImagen;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        }

        $this->model->crear([
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
            'tipo' => $_POST['tipo'],
            'estado' => $_POST['estado'],
            'imagen' => $nombreImagen
        ]);

        header("Location: /canchas");
        exit;
    }


    public function editar($id)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /canchas");
            exit;
        }

        $cancha = $this->model->getById($id);

        if (!$cancha) {
            http_response_code(404);
            require __DIR__ . '/../views/error404.view.php';
            return;
        }

        require __DIR__ . '/../views/canchas/editar.view.php';
    }

    public function actualizar($id)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /");
            exit;
        }

        $cancha = $this->model->getById($id);

        if (!$cancha) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.view.php';
            return;
        }


        if (empty($_POST['nombre']) || empty($_POST['ubicacion'])) {
            $error = "Los campos nombre y ubicación son obligatorios.";
            require __DIR__ . '/../views/canchas/editar.view.php';
            return;
        }

        $nombreImagen = $cancha['imagen'];

        // Si se cambia la imagen se guarda
        if (!empty($_FILES['imagen']['name'])) {

            if (!empty($cancha['imagen'])) {
                $rutaVieja = __DIR__ . '/../../public/uploads/canchas/' . $cancha['imagen'];
                if (file_exists($rutaVieja)) {
                    unlink($rutaVieja);
                }
            }

            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImagen = 'cancha_' . time() . '.' . $ext;

            move_uploaded_file(
                $_FILES['imagen']['tmp_name'],
                __DIR__ . '/../../public/uploads/canchas/' . $nombreImagen
            );
        }

        $this->model->update($id, [
            'nombre'    => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
            'tipo'      => $_POST['tipo'],
            'estado'    => $_POST['estado'],
            'imagen'    => $nombreImagen
        ]);

        header("Location: /canchas/$id");
        exit;
    }

    public function eliminar($id)
    {
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No tienes permisos para eliminar canchas.'
            ];
            header('Location: /canchas');
            exit;
        }

        if ($this->eventoModel->existenEventosEnCancha($id)) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No se puede eliminar la cancha porque tiene eventos asociados.'
            ];
            header('Location: /canchas');
            exit;
        }

        $this->model->delete($id);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cancha eliminada correctamente.'
        ];
        header('Location: /canchas');
        exit;
    }

}
