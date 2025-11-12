<?php
class Auth {
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function redirectIfLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public static function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
