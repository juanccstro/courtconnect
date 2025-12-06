<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

class AuthController {
    private $db;
    private $usuario;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function showLogin() {
        Auth::redirectIfLoggedIn();
        require __DIR__ . '/../views/login.view.php';
    }

    public function showRegister() {
        Auth::redirectIfLoggedIn();
        require __DIR__ . '/../views/register.view.php';
    }

    public function login() {
        Auth::redirectIfLoggedIn();

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $passwordRegex = '/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/';

        if (empty($email) || empty($password)) {
            $error = 'Todos los campos son obligatorios.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'El email no es válido.';
        } elseif (!preg_match($passwordRegex, $password)) {
            $error = 'La contraseña debe tener al menos 8 caracteres y un número.';
        } else {
            if ($this->usuario->login($email, $password)) {
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $error = 'Datos incorrectos.';
            }
        }

        $_SESSION['form_data'] = ['email' => $email];
        require __DIR__ . '/../views/login.view.php';
    }

    public function register() {
        Auth::redirectIfLoggedIn();

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';
        $rol = $_POST['rol'] ?? '';

        $passwordRegex = '/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/';

        // Validaciones
        if (empty($nombre) || empty($email) || empty($password) || empty($confirmar)) {
            $error = "Todos los campos son obligatorios.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "El email no es válido.";
        } elseif (!preg_match($passwordRegex, $password)) {
            $error = "La contraseña debe tener al menos 8 caracteres y un número.";
        } elseif ($password !== $confirmar) {
            $error = "Las contraseñas no coinciden.";
        }

        // Si hay error, reinserta datos y muestra formulario
        if (!empty($error)) {
            $_SESSION['form_data'] = [
                'nombre' => $nombre,
                'email' => $email
            ];
            require __DIR__ . '/../views/register.view.php';
            return;
        }

        $this->usuario->registrar($nombre, $email, $password, $rol);

        header("Location: /login");
        exit;
    }

}
