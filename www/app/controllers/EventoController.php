<?php

require_once __DIR__ . '/../models/Evento.php';

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
}
