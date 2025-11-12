<?php
require_once __DIR__ . '/../core/Auth.php';

class HomeController {
    public function index() {
        Auth::check();
        require __DIR__ . '/../views/home.view.php';
    }
}
