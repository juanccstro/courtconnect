<?php
ob_start();
?>
<div class="text-center mt-5">
    <h1 class="fw-bold text-primary">Bienvenido a CourtConnect</h1>
    <p class="lead mt-3">Tu punto de encuentro para eventos y torneos de baloncesto.</p>
    <?php if (!isset($_SESSION['usuario'])): ?>
        <a href="login.php" class="btn btn-primary mt-3">Iniciar sesión</a>
        <a href="register.php" class="btn btn-outline-primary mt-3">Registrarse</a>
    <?php else: ?>
        <a href="" class="btn btn-primary mt-3">Ver eventos</a>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
