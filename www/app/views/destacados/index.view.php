<?php ob_start(); ?>

    <h2 class="text-center my-4 mt-5 fw-bold text-primary">Jugadores Destacados</h2>

    <div class="d-flex justify-content-end mb-3">
        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <a href="/destacados/crear" class="btn btn-primary">Añadir jugador destacado</a>
        <?php endif; ?>
    </div>

    <div class="row">

        <?php foreach ($jugadores as $j): ?>
            <div class="col-md-3 mb-4">

                <div class="card shadow-sm player-card h-100 d-flex flex-column">

                    <img src="/uploads/jugadores/<?= htmlspecialchars($j['imagen']) ?>"
                         class="card-img-top"
                         alt="<?= htmlspecialchars($j['nombre']) ?>">

                    <div class="card-body d-flex flex-column flex-grow-1">
                        <h5 class="fw-bold"><?= htmlspecialchars($j['nombre']) ?></h5>

                        <p class=""><?= htmlspecialchars($j['descripcion']) ?></p>

                    <div class="badge-mvp mb-2 text-center">
                        <i class="bi bi-star me-1"></i>
                        <?= $j['mvp_count'] ?> veces MVP
                    </div>

                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                            <a href="/destacados/eliminar/<?= $j['id'] ?>"
                               class="btn btn-danger mt-auto"
                               onclick="return confirm('¿Eliminar jugador destacado?');">
                                Eliminar
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        <?php endforeach; ?>

    </div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
