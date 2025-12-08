<?php ob_start(); ?>

<h2 class="text-center my-4 fw-bold text-primary mt-5">Añadir Jugador Destacado</h2>

<form method="POST" action="/destacados/guardar" enctype="multipart/form-data" class="row g-3">

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

    <div class="col-12 mb-3">
        <button class="btn btn-primary">Añadir jugador</button>
        <a href="/destacados" class="btn btn-secondary">Cancelar</a>
    </div>

</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.view.php';
?>
