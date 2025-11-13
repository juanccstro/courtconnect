<?php ob_start(); ?>

<h2 class="fw-bold text-primary mb-4 mt-4">Añadir nueva cancha</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form action="/canchas/guardar" method="POST" enctype="multipart/form-data" class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Ubicación</label>
        <input type="text" name="ubicacion" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select" required>
            <option value="exterior">Exterior</option>
            <option value="interior">Interior</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="disponible">Disponible</option>
            <option value="ocupado">Ocupado</option>
            <option value="mantenimiento">En mantenimiento</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Imagen de la cancha</label>
        <input type="file" name="imagen" class="form-control" accept="image/*" required>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Guardar cancha</button>
        <a href="/canchas" class="btn btn-secondary">Cancelar</a>
    </div>

</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
