<?php ob_start(); ?>
<h1 class="text-center mt-5 text-primary">Bienvenido a CourtConnect</h1>
<p class="text-center mt-3">Accede al menú para ver eventos y canchas.</p>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.view.php'; ?>
