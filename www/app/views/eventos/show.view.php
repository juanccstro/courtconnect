<?php ob_start(); ?>

<div class="row mt-4">

    <div class="col-md-6">
        <?php if (!empty($evento['imagen'])): ?>
            <img src="/uploads/eventos/<?= htmlspecialchars($evento['imagen']) ?>"
                 class="img-fluid rounded shadow"
                 alt="<?= htmlspecialchars($evento['titulo']) ?>">
        <?php else: ?>
            <img src="/img/no-img.png" class="img-fluid rounded shadow">
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <h2 class="fw-bold text-primary"><?= htmlspecialchars($evento['titulo']) ?></h2>

        <p class="mt-3">
            <strong>Fecha:</strong><br>
            <i class="bi bi-calendar-event"></i> <?= date("d/m/Y H:i", strtotime($evento['fecha'])) ?>
        </p>

        <p>
            <strong>Cancha:</strong><br>
            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evento['cancha_nombre']) ?>
        </p>

        <p>
            <strong>Descripción:</strong><br>
            <?= !empty($evento['descripcion']) ? nl2br(htmlspecialchars($evento['descripcion'])) : 'No hay descripción disponible para este evento.' ?>
        </p>

        <p>
            <strong>Estado:</strong><br>
            <i class="bi bi-check-circle"></i> <?= htmlspecialchars($evento['estado']) ?>
        </p>

        <p>
            <strong>Plazas disponibles:</strong><br>
            <?= htmlspecialchars($evento['plazas']) ?> plazas
        </p>

        <a href="/eventos" class="btn btn-secondary mt-3">Volver a eventos</a>

        <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
            <div class="d-flex gap-2 mt-3">
                <a href="/eventos/editar/<?= $evento['id'] ?>" class="btn btn-warning">Editar evento</a>
                <a href="/eventos/eliminar/<?= $evento['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('¿Seguro que quieres eliminar este evento?');">
                    Eliminar evento
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
