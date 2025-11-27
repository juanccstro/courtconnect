<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../app/controllers/ErrorController.php';
require_once __DIR__ . '/../../app/controllers/EventoController.php';
require_once __DIR__ . '/../../app/controllers/HomeController.php';
require_once __DIR__ . '/../../app/controllers/CanchaController.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';
require_once __DIR__ . '/../../app/controllers/DestacadosController.php';
require_once __DIR__ . '/../../app/controllers/ParticipacionController.php';
require_once __DIR__ . '/../libraries/simplePHPRouter/src/Steampixel/Route.php';
use Steampixel\Route;

class Router
{
    public static function route($uri)
    {

        // Rutas públicas
        Route::add('/', function () {
            $controller = new HomeController();
            $controller->index();
        }, 'get');

        // Login y registro
        if (!isset($_SESSION['usuario'])) {

            Route::add('/login', function () {
                $controller = new AuthController();
                $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->login() : $controller->showLogin();
            }, ['get', 'post']);

            Route::add('/register', function () {
                $controller = new AuthController();
                $_SERVER['REQUEST_METHOD'] === 'POST' ? $controller->register() : $controller->showRegister();
            }, ['get', 'post']);

        }

        // Rutas para usuarios logueados
        if (isset($_SESSION['usuario'])) {

            // Ruta de canchas
            Route::add('/canchas', function () {
                $controller = new CanchaController();
                $controller->index();
            }, 'get');

            Route::add('/canchas/([0-9]+)', function ($id) {
                $controller = new CanchaController();
                $controller->show($id);
            }, 'get');

            Route::add('/canchas/crear', function () {
                $controller = new CanchaController();
                $controller->crear();
            }, 'get');

            Route::add('/canchas/guardar', function () {
                $controller = new CanchaController();
                $controller->guardar();
            }, 'post');

            Route::add('/canchas/editar/([0-9]+)', function ($id) {
                $controller = new CanchaController();
                $controller->editar($id);
            }, 'get');

            Route::add('/canchas/actualizar/([0-9]+)', function ($id) {
                $controller = new CanchaController();
                $controller->actualizar($id);
            }, 'post');

            Route::add('/canchas/eliminar/([0-9]+)', function ($id) {
                $controller = new CanchaController();
                $controller->eliminar($id);
            }, 'get');

            // Rutas de eventos
            Route::add('/eventos', function () {
                $controller = new EventoController();
                $controller->index();
            }, 'get');

            Route::add('/eventos/([0-9]+)', function ($id) {
                $controller = new EventoController();
                $controller->show($id);
            }, 'get');

            Route::add('/eventos/crear', function () {
                $controller = new EventoController();
                $controller->crear();
            }, 'get');

            Route::add('/eventos/guardar', function () {
                $controller = new EventoController();
                $controller->guardar();
            }, 'post');

            Route::add('/eventos/editar/([0-9]+)', function ($id) {
                $controller = new EventoController();
                $controller->editar($id);
            }, 'get');

            Route::add('/eventos/actualizar/([0-9]+)', function ($id) {
                $controller = new EventoController();
                $controller->actualizar($id);
            }, 'post');

            Route::add('/eventos/inscribir/([0-9]+)', function($id) {
                $controller = new EventoController();
                $controller->inscribir($id);
            }, 'post');

            Route::add('/eventos/eliminar/([0-9]+)', function ($id) {
                $controller = new EventoController();
                $controller->eliminar($id);
            }, 'get');

            // Rutas de jugadores destacados
            // Jugadores destacados
            Route::add('/destacados', function () {
                (new DestacadosController())->index();
            }, 'get');

            Route::add('/destacados/crear', function () {
                (new DestacadosController())->crear();
            }, 'get');

            Route::add('/destacados/guardar', function () {
                (new DestacadosController())->guardar();
            }, 'post');

            Route::add('/destacados/eliminar/([0-9]+)', function ($id) {
                (new DestacadosController())->eliminar($id);
            }, 'get');
        }

        // Logout
        Route::add('/logout', function () {
            session_destroy();
            header('Location: /');
            exit;
        }, 'get');

        // Ruta error (404)
        Route::pathNotFound(function () {
            $controller = new ErrorController();
            $controller->error404();
        });

        // Método no permitido (405)
        Route::methodNotAllowed(function () {
            $controller = new ErrorController();
            $controller->error405();
        });

        Route::run();
    }
}
