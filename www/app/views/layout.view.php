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
        <a class="navbar-brand mx-auto" href="/">
            <img src="/img/logo.png" alt="CourtConnect" width="140">
        </a>
    </div>
</nav>

<main class="container py-4">
    <?= $content ?? '' ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>&copy; <?= date('Y') ?> CourtConnect</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/custom.js"></script>
</body>
</html>
