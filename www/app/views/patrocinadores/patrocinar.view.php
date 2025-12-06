<?php ob_start(); ?>

<h2 class="text-light mt-4 mb-4 text-center">Patrocinar Evento</h2>

<div class="add-participant p-4">

    <form action="/eventos/patrocinar/<?= $evento['id'] ?>" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Nombre empresa</label>
            <input type="text" name="empresa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Aportación (€)</label>
            <input type="number" name="aportacion" class="form-control" min="100" max="9999" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo del sponsor</label>
            <input type="file" name="logo" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary">Enviar solicitud</button>

    </form>


</div>

<?php $content = ob_get_clean(); require __DIR__ . '/../layout.view.php'; ?>
