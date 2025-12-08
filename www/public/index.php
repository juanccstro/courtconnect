<?php
session_start();
use App\core\Router;
require_once __DIR__ . '/../app/core/Router.php';
Router::route($_SERVER['REQUEST_URI']);
