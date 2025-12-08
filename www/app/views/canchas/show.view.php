<?php ob_start(); ?>

<div class="row mt-5">

    <div class="col-md-6 mb-3">
        <?php if (!empty($cancha['imagen'])): ?>
            <img src="/uploads/canchas/<?= htmlspecialchars($cancha['imagen']) ?>"
                 class="img-fluid rounded shadow"
                 alt="<?= htmlspecialchars($cancha['nombre']) ?>">
        <?php else: ?>
            <img src="/img/no-image.png" class="img-fluid rounded shadow">
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <h2 class="fw-bold text-primary"><?= htmlspecialchars($cancha['nombre']) ?></h2>

        <p class="mt-3">
            <strong>Ubicación:</strong><br>
            <i class="bi bi-geo-alt"></i>
            <?= htmlspecialchars($cancha['ubicacion']) ?>
        </p>

        <p>
            <strong>Tipo:</strong><br>
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <?= htmlspecialchars($cancha['tipo']) ?>
        </p>

        <p>
            <strong>Estado:</strong><br>
            <i class="bi bi-check-circle"></i>
            <?= htmlspecialchars($cancha['estado']) ?>
        </p>

        <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
            <div class="d-flex gap-2 mt-3">
                <a href="/canchas/editar/<?= $cancha['id'] ?>" class="btn btn-warning">Editar</a>
                <a href="/canchas/eliminar/<?= $cancha['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('¿Seguro que deseas eliminar esta cancha?');">
                    Eliminar
                </a>
            </div>
        <?php endif; ?>

        <a href="/canchas" class="btn btn-secondary mt-3 mb-3">Volver</a>

    </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
