<?php ob_start();
use App\models\Evento;
$eventoModel = new Evento();
?>

<div class="container mt-5">

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

            // Color dinámico dependiendo de número de participantes
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

            <?php if ($_SESSION['usuario']['rol'] === 'sponsor'): ?>
                <?php if (!empty($evento['sponsor_id'])): ?>
                    <div class="alert alert-warning mt-3">
                        Este evento ya tiene patrocinador asignado.
                    </div>
                <?php elseif ($eventoModel->sponsorYaPatrocina($_SESSION['usuario']['id'])): ?>
                    <div class="alert alert-info mt-3">
                        Ya has patrocinado un evento. No puedes patrocinar más.
                    </div>
                <?php else: ?>
                    <a href="/eventos/patrocinar/<?= $evento['id'] ?>" class="btn btn-info mt-3">
                        Patrocinar este evento
                    </a>
                <?php endif; ?>
            <?php endif; ?>


            <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin'): ?>
                <div class="d-flex gap-2 mt-3">
                    <a href="/eventos/editar/<?= $evento['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="/eventos/eliminar/<?= $evento['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('¿Eliminar este evento?');">
                        Eliminar
                    </a>
                    <a href="/eventos/solicitudes/<?= $evento['id'] ?>" class="btn btn-info">
                        Ver solicitudes de patrocinio
                    </a>
                </div>
            <?php endif; ?>

            <a href="/eventos" class="btn btn-secondary mt-3">Volver a eventos</a>

        </div>

    </div>

    <!-- Formulario de inscripción -->
    <?php if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'jugador'): ?>
        <?php if (!empty($inscripcionesAbiertas)): ?>
    <div class="mt-5 mb-4">
            <form action="/eventos/inscribir/<?= $evento['id'] ?>" method="POST">
                <h4 class="fw-bold text-primary mb-3">Inscribirse al evento</h4>

                <div class="row">
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
                        <input type="number" name="edad" min="16" max="40'" class="form-control" required>
                    </div>
                </div>

                <button class="btn btn-primary mt-3 w-100">Apuntarme al evento</button>
            </form>
    </div>
        <?php else: ?>
            <div class="alert alert-secondary mt-4">
                Las inscripciones para este evento ya están cerradas.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Participantes -->
    <div class="mt-5 mb-4">

        <h4 class="fw-bold text-light mb-4">Participantes</h4>

        <!-- Filtros -->
        <div class="row g-3 mb-3 participant-filters">
            <div class="col-md-4">
                <input type="text" id="filterNombre" class="form-control" placeholder="Buscar por nombre...">
            </div>

            <div class="col-md-4">
                <select id="filterPosicion" class="form-select">
                    <option value="">Todas las posiciones</option>
                    <option>Base</option>
                    <option>Escolta</option>
                    <option>Alero</option>
                    <option>Ala-Pívot</option>
                    <option>Pívot</option>
                </select>
            </div>

            <div class="col-md-4">
                <input type="number" id="filterEdad" class="form-control" placeholder="Edad mínima">
            </div>
        </div>

        <?php if (empty($participantes)): ?>
            <p class="text-light">Aún no hay participantes registrados.</p>
        <?php else: ?>

            <div class="table-responsive">
                <table class="table table-2k table-hover" id="tablaParticipantes">
                    <thead>
                    <tr>
                        <th data-col="nombre" class="sortable">Jugador <i class="bi bi-arrow-down-up"></i></th>
                        <th data-col="posicion" class="sortable">Posición <i class="bi bi-arrow-down-up"></i></th>
                        <th data-col="edad" class="sortable">Edad <i class="bi bi-arrow-down-up"></i></th>
                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                            <th class="text-center">Borrar</th>
                        <?php endif; ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($participantes as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['usuario_nombre'] ?? $p['nombre_participante']) ?></td>
                            <td><?= htmlspecialchars($p['posicion']) ?></td>
                            <td><?= htmlspecialchars($p['edad']) ?></td>

                            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                <td class="text-center">
                                    <a href="/eventos/participante/eliminar/<?= $p['id'] ?>/<?= $evento['id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('¿Eliminar a este jugador?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

    <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>

        <div class="mt-4 mb-4 add-participant">
            <h4 class="text-light mb-3">Añadir participante</h4>

            <form action="/eventos/participante/agregar/<?= $evento['id'] ?>" method="POST" class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nombre del jugador</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Posición</label>
                    <select name="posicion" class="form-select" required>
                        <option>Base</option>
                        <option>Escolta</option>
                        <option>Alero</option>
                        <option>Ala-Pívot</option>
                        <option>Pívot</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Edad</label>
                    <input type="number" name="edad" class="form-control" min="16" max="41" required>
                </div>

                <div class="col-12 text-end">
                    <button class="btn btn-primary px-4 mt-2">Añadir participante</button>
                </div>

            </form>
        </div>

    <?php endif; ?>

    <?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>

    <script src="/js/eventos.js"></script>
