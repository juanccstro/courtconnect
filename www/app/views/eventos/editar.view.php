<?php ob_start(); ?>

<h2 class="fw-bold text-primary mb-4 mt-5">Editar evento</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form action="/eventos/actualizar/<?= $evento['id'] ?>" method="POST" enctype="multipart/form-data" class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Título del evento</label>
        <input type="text" name="titulo" class="form-control"
               value="<?= htmlspecialchars($evento['titulo']) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Fecha</label>
        <input type="datetime-local" name="fecha" class="form-control"
               value="<?= date("Y-m-d\TH:i", strtotime($evento['fecha'])) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="1x1" <?= $evento['tipo'] === '1x1' ? 'selected' : '' ?>>1x1</option>
            <option value="3x3" <?= $evento['tipo'] === '3x3' ? 'selected' : '' ?>>3x3</option>
            <option value="5x5" <?= $evento['tipo'] === '5x5' ? 'selected' : '' ?>>5x5</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Cancha</label>
        <select name="cancha_id" class="form-select" required>
            <!-- Aquí deberías cargar as canchas desde a base de datos -->
            <option value="1" <?= $evento['cancha_id'] === 1 ? 'selected' : '' ?>>Parque Lourido</option>
            <option value="2" <?= $evento['cancha_id'] === 2 ? 'selected' : '' ?>>O Grove</option>
            <option value="3" <?= $evento['cancha_id'] === 3 ? 'selected' : '' ?>>Samil</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Plazas</label>
        <input type="number" name="plazas" class="form-control" value="<?= htmlspecialchars($evento['plazas']) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="abierto" <?= $evento['estado'] === 'abierto' ? 'selected' : '' ?>>Abierto</option>
            <option value="cerrado" <?= $evento['estado'] === 'cerrado' ? 'selected' : '' ?>>Cerrado</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Imagen actual</label><br>
        <?php if (!empty($evento['imagen'])): ?>
            <img src="/uploads/eventos/<?= htmlspecialchars($evento['imagen']) ?>"
                 width="250" class="rounded shadow mb-3">
        <?php else: ?>
            <img src="/img/no-img.png" width="250" class="rounded shadow mb-3">
        <?php endif; ?>
    </div>

    <div class="col-12">
        <label class="form-label">Subir nueva imagen (opcional)</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <div class="col-12 mb-3">
        <button class="btn btn-primary">Guardar cambios</button>
        <a href="/eventos/<?= $evento['id'] ?>" class="btn btn-secondary">Cancelar</a>
    </div>

</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
