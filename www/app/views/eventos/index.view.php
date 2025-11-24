<?php ob_start(); ?>

<h2 class="fw-bold text-primary mt-4 mb-4 text-center">Próximos eventos</h2>

<div class="d-flex justify-content-end mb-3">
    <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
        <a href="/eventos/crear" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Crear nuevo evento
        </a>
    <?php endif; ?>
</div>

<?php if (empty($eventos)): ?>
    <p class="text-center text-muted">No hay eventos programados.</p>

<?php else: ?>
    <div class="row">

        <?php foreach ($eventos as $e): ?>
            <div class="col-md-4 mb-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title fw-bold"><?= htmlspecialchars($e['titulo']) ?></h5>

                        <?php if (!empty($e['imagen'])): ?>
                            <img src="/uploads/eventos/<?= htmlspecialchars($e['imagen']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars($e['titulo']) ?>">
                        <?php else: ?>
                            <img src="/img/no-img.png" class="card-img-top">
                        <?php endif; ?>

                        <p class="text-muted mb-1 mt-2">
                            <i class="bi bi-calendar-event"></i>
                            <?= date("d/m/Y H:i", strtotime($e['fecha'])) ?>
                        </p>

                        <p class="text-muted mb-1">
                            <i class="bi bi-geo-alt"></i>
                            <?= htmlspecialchars($e['cancha_nombre']) ?>
                        </p>

                        <p class="text-muted">
                            <i class="bi bi-people"></i>
                            <?= htmlspecialchars($e['plazas']) ?> plazas
                        </p>

                        <a href="/eventos/<?= $e['id'] ?>"
                           class="btn btn-outline-primary mt-auto">
                            Ver detalles
                        </a>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
