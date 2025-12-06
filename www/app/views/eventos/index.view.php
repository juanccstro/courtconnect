<?php ob_start(); ?>

<h2 class="fw-bold text-light mt-5 mb-4 text-center">Próximos eventos</h2>

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

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100 evento-card">

                    <?php if (!empty($e['imagen'])): ?>
                        <img src="/uploads/eventos/<?= htmlspecialchars($e['imagen']) ?>"
                             class="card-img-top evento-img"
                             alt="<?= htmlspecialchars($e['titulo']) ?>">
                    <?php else: ?>
                        <img src="/img/no-img.png" class="card-img-top evento-img">
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title fw-bold text-white"><?= htmlspecialchars($e['titulo']) ?></h5>

                        <p class="mb-1 text-light">
                            <i class="bi bi-calendar-event"></i>
                            <?= date("d/m/Y H:i", strtotime($e['fecha'])) ?>
                        </p>
                        <p class="mb-1 text-light">
                            <i class="bi bi-geo-alt"></i>
                            <?= htmlspecialchars($e['cancha_nombre']) ?>
                        </p>
                        <p class="text-light">
                            <i class="bi bi-people"></i>
                            <?= htmlspecialchars($e['plazas']) ?> plazas
                        </p>

                        <!-- Sponsor del evento -->
                        <?php
                        $sponsorNombre = $e['sponsor_nombre'] ?? null;
                        $sponsorLogo   = $e['sponsor_logo'] ?? null;

                        if (!empty($sponsorNombre)): ?>
                            <div class="sponsor-box mt-3 mb-3 p-2 d-flex align-items-center">

                                <?php if (!empty($sponsorLogo)): ?>
                                    <img src="/uploads/logos/<?= htmlspecialchars($sponsorLogo) ?>"
                                         class="sponsor-logo">
                                <?php else: ?>
                                    <div class="sponsor-placeholder"></div>
                                <?php endif; ?>

                                <div class="text-white ps-2">
                                    <span class="small text-uppercase opacity-75">Sponsor oficial</span><br>
                                    <strong><?= htmlspecialchars($sponsorNombre) ?></strong>
                                </div>

                            </div>
                        <?php endif; ?>

                        <a href="/eventos/<?= $e['id'] ?>" class="btn btn-outline-primary mt-auto">
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
