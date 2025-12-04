<?php

require_once __DIR__ . '/../models/Usuario.php';

class QuienesSomosController
{
    public function index()
    {
        // Verificar si hay un usuario logueado
        $usuario = $_SESSION['usuario'] ?? null;

        require __DIR__ . '/../views/quienes-somos.view.php';
    }

    public function enviarFormulario()
    {
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $email = $_POST['email'] ?? '';
        $mensaje = $_POST['mensaje'] ?? '';

        // Simular el "envío" del formulario:
        if ($nombre && $apellido && $email && $mensaje) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Mensaje enviado con éxito'];
            $_SESSION['form_data'] = [];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Por favor, complete todos los campos'];
            $_SESSION['form_data'] = $_POST;
        }

        header('Location: /quienes-somos');
        exit;
    }
}
