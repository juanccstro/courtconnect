<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">

        <div class="d-flex align-items-center order-lg-1">
            <?php if (isset($_SESSION['usuario'])): ?>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="">Canchas</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Eventos</a></li>
                </ul>
            <?php endif; ?>
        </div>

        <a class="navbar-brand mx-auto order-lg-2 text-center" href="index.php">
            <img src="img/logo_courtconnect.png" alt="CourtConnect" width="170" class="d-inline-block align-text-center">
        </a>

        <div class="d-flex align-items-center order-lg-3">
            <ul class="navbar-nav ms-auto">
                <?php if (!isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" title="Iniciar sesión">
                            <i class="bi bi-box-arrow-in-right fs-5"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="">Destacados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" title="Cerrar sesión">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Main -->
<main class="container py-4">
    <?php if (isset($content)) echo $content; ?>
</main>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>&copy; <?php echo date('Y'); ?> CourtConnect - Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
