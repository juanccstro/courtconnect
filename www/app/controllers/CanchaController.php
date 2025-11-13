<?php

require_once __DIR__ . '/../models/Cancha.php';

class CanchaController
{
    private $model;

    public function __construct()
    {
        $this->model = new Cancha();
    }

    public function index()
    {
        $canchas = $this->model->getAll();
        require_once __DIR__ . '/../views/canchas/index.view.php';
    }

    public function show($id)
    {
        $cancha = $this->model->getById($id);
        require_once __DIR__ . '/../views/canchas/show.view.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../views/canchas/create.view.php';
    }

    public function store()
    {
        // Subir imagen
        $imagen = null;
        if (!empty($_FILES['imagen']['name'])) {
            $imagen = 'cancha_' . time() . '.jpg';
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/canchas/' . $imagen);
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
            'tipo' => $_POST['tipo'],
            'estado' => $_POST['estado'],
            'imagen' => $imagen
        ];

        $this->model->create($data);
        header("Location: /canchas");
        exit;
    }

    public function edit($id)
    {
        $cancha = $this->model->getById($id);
        require_once __DIR__ . '/../views/canchas/edit.view.php';
    }

    public function update($id)
    {
        $data = [
            'nombre' => $_POST['nombre'],
            'ubicacion' => $_POST['ubicacion'],
            'tipo' => $_POST['tipo'],
            'estado' => $_POST['estado'],
            'imagen' => $_POST['imagen_actual']
        ];

        if (!empty($_FILES['imagen']['name'])) {
            $imagen = 'cancha_' . time() . '.jpg';
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../../public/uploads/canchas/' . $imagen);
            $data['imagen'] = $imagen;
        }

        $this->model->update($id, $data);
        header("Location: /canchas");
        exit;
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: /canchas");
        exit;
    }
}
