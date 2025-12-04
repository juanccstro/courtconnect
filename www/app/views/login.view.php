<?php ob_start(); ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Iniciar sesión</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="/login" class="mx-auto" style="max-width:400px;">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $_SESSION['form_data']['email'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required minlength="8">
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
    <p class="text-center mt-3">¿No tienes cuenta? <a href="/register">Regístrate aquí</a></p>
</div>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.view.php'; ?>
