<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourtConnect</title>

    <link rel="icon" href="/img/favicon-courtconnect.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body class="d-flex flex-column min-vh-100">

<?php if (!empty($_SESSION['flash'])): ?>
    <?php $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div id="ccToast" class="cc-toast cc-toast--<?= htmlspecialchars($flash['type']) ?>">
        <div class="cc-toast-icon">
            <?php if ($flash['type'] === 'success'): ?>
                <i class="bi bi-check-circle-fill"></i>
            <?php elseif ($flash['type'] === 'error'): ?>
                <i class="bi bi-x-circle-fill"></i>
            <?php else: ?>
                <i class="bi bi-info-circle-fill"></i>
            <?php endif; ?>
        </div>
        <div class="cc-toast-body">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
        <button type="button" class="cc-toast-close" onclick="document.getElementById('ccToast').classList.remove('show');">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container d-flex align-items-center">

        <!-- Logo móvil -->
        <a class="navbar-brand d-lg-none" href="/">
            <img src="/img/logo.png" alt="CourtConnect" width="120">
        </a>

        <!-- Botón hamburguesa -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCC" aria-controls="navbarCC"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido -->
        <div class="collapse navbar-collapse justify-content-between" id="navbarCC">

            <!-- Bloque izquierdo -->
            <ul class="navbar-nav me-auto align-items-lg-center flex-lg-1">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/canchas">Canchas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/eventos">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/destacados">Destacados</a></li>
                    <li class="nav-item"><a class="nav-link" href="/quienes-somos">¿Quiénes somos?</a></li>
                <?php endif; ?>
            </ul>

            <!-- Logo centro -->
            <a class="navbar-brand d-none d-lg-block" href="/">
                <img src="/img/logo.png" alt="CourtConnect" width="150">
            </a>

            <!-- Bloque derecho -->
            <ul class="navbar-nav ms-auto align-items-lg-center flex-lg-1 justify-content-lg-end">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout" aria-label="Cerrar sesión">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                            <span class="d-lg-none"> Cerrar sesión</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>

    </div>
</nav>

<main class="container">
    <?= $content ?? '' ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>&copy; <?= date('Y') ?> CourtConnect</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/custom.js"></script>
</body>
</html>
