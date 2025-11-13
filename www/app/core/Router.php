<?php
require_once __DIR__ . '/../../config/config.php';

class Router {
    public static function route($uri) {
        $path = trim(parse_url($uri, PHP_URL_PATH), '/');

        switch ($path) {
            case '':
                require_once __DIR__ . '/../controllers/HomeController.php';
                (new HomeController())->index();
                break;

            case 'login':
                require_once __DIR__ . '/../controllers/AuthController.php';
                $controller = new AuthController();
                $_SERVER['REQUEST_METHOD'] === 'POST'
                    ? $controller->login()
                    : $controller->showLogin();
                break;

            case 'register':
                require_once __DIR__ . '/../controllers/AuthController.php';
                $controller = new AuthController();
                $_SERVER['REQUEST_METHOD'] === 'POST'
                    ? $controller->register()
                    : $controller->showRegister();
                break;

            case 'logout':
                require_once __DIR__ . '/../controllers/AuthController.php';
                (new AuthController())->logout();
                break;

            // Rutas de canchas
            case 'canchas':
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->index();
                break;

            case (preg_match('/^canchas\/(\d+)$/', $path, $m) ? true : false):
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->show($m[1]);
                break;

            case 'canchas/crear':
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->crear();
                break;

            case 'canchas/guardar':
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->guardar();
                break;

            case (preg_match('/^canchas\/editar\/(\d+)$/', $path, $m) ? true : false):
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->editar($m[1]);
                break;

            case (preg_match('/^canchas\/actualizar\/(\d+)$/', $path, $m) ? true : false):
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->actualizar($m[1]);
                break;

            case (preg_match('/^canchas\/eliminar\/(\d+)$/', $path, $m) ? true : false):
                require_once __DIR__ . '/../controllers/CanchaController.php';
                (new CanchaController())->eliminar($m[1]);
                break;

            // Error 404
            default:
                http_response_code(404);
                require __DIR__ . '/../views/error404.view.php';
                break;
        }
    }
}
