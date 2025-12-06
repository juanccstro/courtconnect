<?php

class Auth {

    /** Verificar si hay sesión */
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    /** Si ya hay sesión, redirige a inicio */
    public static function redirectIfLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    /** Requiere un rol exacto */
    public static function requireRole($rol) {
        self::check();

        if ($_SESSION['usuario']['rol'] !== $rol) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No tienes permisos para acceder a esta sección.'
            ];
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public static function requireRoles($roles = []) {
        self::check();

        if (!in_array($_SESSION['usuario']['rol'], $roles)) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'No tienes permisos para acceder a este recurso.'
            ];
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    /** Obtener usuario logeado */
    public static function user() {
        return $_SESSION['usuario'] ?? null;
    }
}
