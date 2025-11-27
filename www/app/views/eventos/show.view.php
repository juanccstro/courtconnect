<?php ob_start(); ?>

<div class="container mt-4">

    <div class="row g-4">

        <!-- Imagen -->
        <div class="col-md-6">
            <?php if (!empty($evento['imagen'])): ?>
                <img src="/uploads/eventos/<?= htmlspecialchars($evento['imagen']) ?>"
                     class="img-fluid rounded shadow"
                     alt="<?= htmlspecialchars($evento['titulo']) ?>">
            <?php else: ?>
                <img src="/img/no-img.png" class="img-fluid rounded shadow">
            <?php endif; ?>
        </div>

        <!-- Información del evento -->
        <div class="col-md-6">
            <h2 class="fw-bold text-primary"><?= htmlspecialchars($evento['titulo']) ?></h2>

            <p class="mt-3">
                <strong>Fecha:</strong><br>
                <i class="bi bi-calendar-event"></i>
                <?= date("d/m/Y H:i", strtotime($evento['fecha'])) ?>
            </p>

            <p>
                <strong>Cancha:</strong><br>
                <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evento['cancha_nombre']) ?>
            </p>

            <p>
                <strong>Descripción:</strong><br>
                <?= !empty($evento['descripcion'])
                    ? nl2br(htmlspecialchars($evento['descripcion']))
                    : 'No hay descripción disponible.' ?>
            </p>

            <p>
                <strong>Estado:</strong><br>
                <i class="bi bi-check-circle"></i> <?= htmlspecialchars($evento['estado']) ?>
            </p>

            <?php
            $ocupadas = count($participantes);
            $totalPlazas = (int)$evento['plazas'];
            $porcentaje = $totalPlazas > 0 ? round(($ocupadas / $totalPlazas) * 100) : 0;

            // Color dinámico dependiendo de participantes
            $color = "bg-success";
            if ($porcentaje > 50) $color = "bg-warning";
            if ($porcentaje > 85) $color = "bg-danger";
            ?>

            <p class="mt-3">
                <strong>Plazas:</strong><br>
                Ocupadas: <?= $ocupadas ?> / <?= $totalPlazas ?>
            </p>

            <div class="progress" style="height: 22px;">
                <div class="progress-bar <?= $color ?>"
                     role="progressbar"
                     style="width: <?= $porcentaje ?>%;"
                     aria-valuenow="<?= $porcentaje ?>"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    <?= $porcentaje ?>%
                </div>
            </div>

            <a href="/eventos" class="btn btn-secondary mt-3">Volver a eventos</a>

            <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
                <div class="d-flex gap-2 mt-3">
                    <a href="/eventos/editar/<?= $evento['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="/eventos/eliminar/<?= $evento['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('¿Eliminar este evento?');">
                        Eliminar
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Formulario de inscripción -->
    <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'jugador'): ?>
        <div class="row mt-5">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm p-4">
                    <h4 class="fw-bold text-primary mb-3">Inscribirse al evento</h4>

                    <form action="/eventos/inscribir/<?= $evento['id'] ?>" method="POST">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Posición</label>
                                <select name="posicion" class="form-select" required>
                                    <option value="">Selecciona...</option>
                                    <option>Base</option>
                                    <option>Escolta</option>
                                    <option>Alero</option>
                                    <option>Ala-Pívot</option>
                                    <option>Pívot</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Edad</label>
                                <input type="number" name="edad" min="12" max="65" class="form-control" required>
                            </div>

                        </div>

                        <button class="btn btn-primary mt-3 w-100">Apuntarme al evento</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Participantes -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold text-primary">Participantes</h3>

            <?php if (empty($participantes)): ?>
                <p class="text-muted">Aún no hay participantes registrados.</p>

            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>Jugador</th>
                            <th>Posición</th>
                            <th>Edad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($participantes as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['usuario_nombre']) ?></td>
                                <td><?= htmlspecialchars($p['posicion']) ?></td>
                                <td><?= htmlspecialchars($p['edad']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
