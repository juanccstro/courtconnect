<?php ob_start(); ?>
<div class="error-404">
    <h1>404</h1>
    <p>404 - Tiempo muerto. Esa página no está en el marcador.</p>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/../layout.view.php'; ?>
