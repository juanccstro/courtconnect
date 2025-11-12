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

            default:
                http_response_code(404);
                require __DIR__ . '/../views/error404.view.php';
                break;
        }
    }
}
