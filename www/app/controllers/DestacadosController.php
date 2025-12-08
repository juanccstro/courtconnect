<?php
namespace App\controllers;
use App\models\JugadorDestacado;

require_once __DIR__ . '/../models/JugadorDestacado.php';

class DestacadosController
{
    private $model;

    public function __construct()
    {
        $this->model = new JugadorDestacado();
    }

    public function index()
    {
        $jugadores = $this->model->obtenerTodos();
        require __DIR__ . '/../views/destacados/index.view.php';
    }

    public function crear()
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /destacados");
            exit;
        }

        require __DIR__ . '/../views/destacados/crear.view.php';
    }

    public function guardar()
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /destacados");
            exit;
        }

        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion']);
        $mvp = intval($_POST['mvp']);

        $imagen = null;

        if (!empty($_FILES['imagen']['name'])) {
            $nombreArchivo = time() . "_" . basename($_FILES['imagen']['name']);
            $rutaDestino = __DIR__ . '/../../public/uploads/jugadores/' . $nombreArchivo;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
            $imagen = $nombreArchivo;
        }

        $this->model->crear($nombre, $descripcion, $imagen, $mvp);

        header("Location: /destacados");
        exit;
    }

    public function eliminar($id)
    {
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /destacados");
            exit;
        }

        $this->model->eliminar($id);

        header("Location: /destacados");
        exit;
    }
}
