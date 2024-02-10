<footer class="footer container-xl bg-primary py-5 pt-5">
    <div class="footer__grid">
        <div class="footer__contenido">
            <h3 class="footer__logo">
                &#60;AmorPorti />
            </h3>

            <p class="footer__texto">
                AmorPorti es una sistema para veterianrias para el control y gestion de consultas, se lleva a cabo
                el control de consultas medicas en linea
            </p>
        </div>

    </div>

    <p class="footer__copyright">
        AmorPorti
        <span class="footer__copyright--regular">
            - Todos los derechos reservados <?php echo date('Y'); ?>
        </span>
    </p>

    <div class="row container-xl">
        <div class="col-md-8">
            <nav class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <a class="fs-4 text-dark text-decoration-none" href="/">Inicio</a>
                <a class="fs-4 text-dark text-decoration-none" href="/nosotros">Nosotros</a>
                <a class="fs-4 text-dark text-decoration-none" href="/tienda">Tienda</a>
                <a class="fs-4 text-dark text-decoration-none" href="/contacto">Contacto</a>
                <!-- si $auth es false va a mostrar Iniciar Sesion -->
                <?php if (!is_auth()) : ?>
                    <a class="dashboard__submit--logout" href="/login">Iniciar Sesion</a>
                <?php endif; ?>

                <!-- si $auth es false no va a mostrar Cerrar sesion -->
                <?php if (is_auth()) : ?>
                    <form method="POST" action="/logout" class="dashboard__form">
                        <input type="submit" value="Cerrar Sesión" class="dashboard__submit--logout">
                    </form>
                <?php endif; ?>
            </nav>
        </div>
        <div class="col-md-4">
            <p class="text-white text-center fs-4 mt-4 m-md-0">Todos los derechos Reservados</p>
        </div>
    </div>
</footer>