<?php ob_start(); ?>

<h2 class="text-center my-4 fw-bold text-primary">Añadir Jugador Destacado</h2>

<form method="POST" action="/destacados/guardar" enctype="multipart/form-data" class="card p-4 shadow">

    <div class="mb-3">
        <label class="form-label">Nombre del jugador</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Veces MVP</label>
        <input type="number" name="mvp" class="form-control" min="0" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen del jugador</label>
        <input type="file" name="imagen" class="form-control" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
