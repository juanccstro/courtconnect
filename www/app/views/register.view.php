<?php ob_start(); ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Registro</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="/register" class="mx-auto" style="max-width:400px;">
        <div class="mb-3"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Contraseña</label><input type="password" name="password" class="form-control" required minlength="8"></div>
        <div class="mb-3"><label>Confirmar contraseña</label><input type="password" name="confirmar" class="form-control" required minlength="8"></div>
        <div class="mb-3">
            <label>Rol</label>
            <select name="rol" class="form-select" required>
                <option value="">Seleccionar...</option>
                <option value="jugador">Jugador</option>
                <option value="club">Club</option>
                <option value="sponsor">Sponsor</option>
                <option value="visitante">Visitante</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.view.php'; ?>
