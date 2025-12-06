<?php ob_start(); ?>

<h2 class="fw-bold text-light text-center mt-4">Solicitudes de patrocinio</h2>

<div class="container mt-4">

    <?php foreach ($solicitudes as $s): ?>
        <div class="card p-3 mb-3">

            <h5><?= htmlspecialchars($s['nombre_empresa']) ?></h5>
            <p><strong>Email:</strong> <?= htmlspecialchars($s['email']) ?></p>
            <p><strong>Aportación:</strong> <?= $s['aportacion'] ?> €</p>
            <p><?= nl2br(htmlspecialchars($s['mensaje'])) ?></p>

            <?php if (!empty($s['logo'])): ?>
                <img src="/uploads/logos/<?= $s['logo'] ?>" width="120" class="mt-2">
            <?php endif; ?>

            <div class="mt-3">
                <a href="/solicitud/aceptar/<?= $s['id'] ?>" class="btn btn-success">Aceptar</a>
                <a href="/solicitud/rechazar/<?= $s['id'] ?>" class="btn btn-danger">Rechazar</a>
            </div>

        </div>
    <?php endforeach; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
