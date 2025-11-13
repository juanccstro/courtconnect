<?php ob_start(); ?>

<h2 class="text-center mb-4 mt-4 fw-bold text-primary">Canchas disponibles</h2>

<div class="d-flex justify-content-end mb-3">
    <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
        <a href="/canchas/crear" class="btn btn-primary">Añadir nueva cancha</a>
    <?php endif; ?>
</div>

<div class="row">

    <?php if (empty($canchas)): ?>
        <p class="text-center text-muted">No hay canchas registradas.</p>
    <?php else: ?>
        <?php foreach ($canchas as $c): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">

                    <?php if (!empty($c['imagen'])): ?>
                        <img src="/uploads/canchas/<?= htmlspecialchars($c['imagen']) ?>"
                             class="card-img-top" alt="<?= htmlspecialchars($c['nombre']) ?>">
                    <?php else: ?>
                        <img src="/img/no-image.png" class="card-img-top" alt="Sin imagen">
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($c['nombre']) ?></h5>

                        <p class="text-muted mb-1">
                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($c['ubicacion']) ?>
                        </p>

                        <p class="text-muted mb-2">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                            Tipo: <?= htmlspecialchars($c['tipo']) ?>
                        </p>

                        <p class="text-muted">
                            <i class="bi bi-check-circle"></i>
                            Estado: <?= htmlspecialchars($c['estado']) ?>
                        </p>

                        <a href="/canchas/<?= $c['id'] ?>" class="btn btn-outline-primary mt-auto">
                            Ver detalles
                        </a>

                        <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
                            <div class="mt-3 d-flex gap-2">
                                <a href="/canchas/editar/<?= $c['id'] ?>" class="btn btn-warning w-50">Editar</a>
                                <a href="/canchas/eliminar/<?= $c['id'] ?>" class="btn btn-danger w-50"
                                   onclick="return confirm('¿Eliminar esta cancha?');">
                                    Eliminar
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
