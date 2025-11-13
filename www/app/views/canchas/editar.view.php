<?php ob_start(); ?>

<h2 class="fw-bold text-primary mb-4 mt-5">Editar cancha</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form action="/canchas/actualizar/<?= $cancha['id'] ?>"
      method="POST"
      enctype="multipart/form-data"
      class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control"
               value="<?= htmlspecialchars($cancha['nombre']) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Ubicación</label>
        <input type="text" name="ubicacion" class="form-control"
               value="<?= htmlspecialchars($cancha['ubicacion']) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="exterior" <?= $cancha['tipo']==='exterior'?'selected':'' ?>>Exterior</option>
            <option value="interior" <?= $cancha['tipo']==='interior'?'selected':'' ?>>Interior</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="disponible" <?= $cancha['estado']==='disponible'?'selected':'' ?>>Disponible</option>
            <option value="ocupado" <?= $cancha['estado']==='ocupado'?'selected':'' ?>>Ocupado</option>
            <option value="mantenimiento" <?= $cancha['estado']==='mantenimiento'?'selected':'' ?>>En mantenimiento</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Imagen actual</label><br>
        <img src="/uploads/canchas/<?= htmlspecialchars($cancha['imagen']) ?>"
             width="250" class="rounded shadow mb-3">
    </div>

    <div class="col-12">
        <label class="form-label">Subir nueva imagen (opcional)</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Guardar cambios</button>
        <a href="/canchas/<?= $cancha['id'] ?>" class="btn btn-secondary">Cancelar</a>
    </div>

</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
