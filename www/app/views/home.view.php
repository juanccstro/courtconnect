<?php ob_start(); ?>
<!-- Hero -->
<section class="hero">
    <div class="container-fluid px-0 text-center text-white d-flex flex-column justify-content-center align-items-center">
        <h1 class="display-4 fw-bold">CourtConnect</h1>
        <p class="lead mb-4">Descubre canchas, participa en torneos y vive el baloncesto.</p>
        <div>
            <a href="/canchas" class="btn btn-primary btn-lg mx-2">Ver canchas</a>
            <a href="/eventos" class="btn btn-outline-primary btn-lg mx-2">Ver eventos</a>
        </div>
    </div>
</section>

<!-- Sección de eventos -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold text-primary">Próximos eventos</h2>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="/img/evento1.webp" class="card-img-top" alt="Evento 1">
                    <div class="card-body">
                        <h5 class="card-title">Torneo 3x3 en O Grove</h5>
                        <p class="card-text">Participa con tu equipo en un torneo al aire libre junto al mar.</p>
                        <a href="/eventos" class="btn btn-primary">Más info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="/img/evento2.webp" class="card-img-top" alt="Evento 2">
                    <div class="card-body">
                        <h5 class="card-title">All Star CourtConnect</h5>
                        <p class="card-text">Un evento especial con los jugadores más destacados de la comunidad.</p>
                        <a href="/eventos" class="btn btn-primary">Más info</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de canchas -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold text-primary">Canchas destacadas</h2>
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="/img/canchas/pista_samil.jpg" class="card-img-top" alt="Pista Samil">
                    <div class="card-body">
                        <h5 class="card-title">Playa de Samil, Vigo</h5>
                        <p class="card-text">Tres pistas al aire libre junto al mar, arte y deporte unidos.</p>
                        <a href="/canchas" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="/img/canchas/pista_parque_lourido.jpg" class="card-img-top" alt="Terra de Porto">
                    <div class="card-body">
                        <h5 class="card-title">Pistas Parque Lourido</h5>
                        <p class="card-text">Amplia zona deportiva con gradas y vistas al paseo del Esteiro.</p>
                        <a href="/canchas" class="btn btn-outline-primary">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-final text-center text-white">
    <div class="container-fluid px-0 py-5">
        <h2 class="fw-bold mb-3">Conecta, compite y disfruta del baloncesto.</h2>
        <a href="/register" class="btn btn-primary btn-lg">Únete ahora</a>
    </div>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.view.php'; ?>
