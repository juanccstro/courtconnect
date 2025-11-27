<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourtConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">

        <div class="row w-100 align-items-center">

            <div class="col-4 d-flex justify-content-start">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="/canchas">Canchas</a></li>
                        <li class="nav-item"><a class="nav-link" href="/eventos">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="/destacados">Destacados</a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="col-4 d-flex justify-content-center">
                <a class="navbar-brand text-center" href="/">
                    <img src="/img/logo.png" alt="CourtConnect" width="140">
                </a>
            </div>

            <div class="col-4 d-flex justify-content-end">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout" title="Cerrar sesión">
                                <i class="bi bi-box-arrow-right fs-5"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

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
