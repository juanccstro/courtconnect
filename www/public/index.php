<?php
session_start();
require_once __DIR__ . '/../app/core/Router.php';
Router::route($_SERVER['REQUEST_URI']);
