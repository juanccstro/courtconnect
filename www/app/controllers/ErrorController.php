<?php

class ErrorController
{
    public function error404()
    {
        require __DIR__ . '/../views/errors/error404.view.php';
    }

    public function error405()
    {
        require __DIR__ . '/../views/errors/error405.view.php';
    }
}
