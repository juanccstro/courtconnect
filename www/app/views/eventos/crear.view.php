<?php ob_start(); ?>

<h2 class="text-center my-4 fw-bold text-primary mt-5">Crear nuevo evento</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form action="/eventos/guardar" method="POST" enctype="multipart/form-data" class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Título del evento</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Fecha</label>
        <input type="datetime-local" name="fecha" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="1x1">1x1</option>
            <option value="3x3">3x3</option>
            <option value="5x5">5x5</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Cancha</label>
        <select name="cancha_id" class="form-select" required>
            <?php foreach ($canchas as $c): ?>
                <option value="<?= $c['id']; ?>"
                    <?= strtolower($c['estado']) === 'mantenimiento' ? 'disabled' : ''; ?>>
                    <?= htmlspecialchars($c['nombre']); ?>
                    <?= strtolower($c['estado']) === 'mantenimiento' ? ' (Mantenimiento)' : ''; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Plazas</label>
        <input type="number" name="plazas" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="abierto">Abierto</option>
            <option value="cerrado">Cerrado</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Subir imagen (opcional)</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <div class="col-12 mb-3">
        <button class="btn btn-primary">Guardar evento</button>
        <a href="/eventos" class="btn btn-secondary">Cancelar</a>
    </div>

</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
