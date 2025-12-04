<?php ob_start();?>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-4 mb-5">
                <img src="/img/oficina-courtconnect.png" alt="Imagen oficina" class="img-fluid rounded shadow">
            </div>

            <div class="col-md-4">
                <h2 class="fw-bold text-primary mb-4">¿Quiénes Somos?</h2>
                <p class="text-light texto-descripcion">
                    Somos una empresa localizada en Vigo, con el objetivo de conectar a la comunidad de baloncesto local.
                </p>
                <p class="text-light texto-descripcion">
                    A través de nuestra plataforma, buscamos facilitar la participación en eventos, torneos y actividades deportivas en nuestra ciudad,
                    fomentando la cultura del baloncesto y promoviendo la integración de los jóvenes y adultos en esta actividad.
                </p>
            </div>
        </div>

        <div class="row justify-content-center mt-4 mb-4">
            <div class="col-md-8 add-participant">
                <h4 class="fw-bold text-primary text-center">Contáctanos</h4>

                <!-- Formulario -->
                <form action="/quienes-somos/enviar" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" value="<?= $_SESSION['form-data']['nombre'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" id="apellido" value="<?= $_SESSION['form_data']['apellido'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?= $_SESSION['usuario']['email'] ?? '' ?>" placeholder="<?= $_SESSION['usuario']['email'] ?? '' ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea name="mensaje" class="form-control" id="mensaje" rows="5" required><?= $_SESSION['form_data']['mensaje'] ?? '' ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-20">Enviar mensaje</button>
                </form>
            </div>
        </div>

    </div>

<?php
$content = ob_get_clean();
require 'layout.view.php';
