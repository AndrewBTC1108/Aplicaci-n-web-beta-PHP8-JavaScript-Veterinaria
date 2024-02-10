<header class="container-xl bg-primary">
    <div class="row">
        <div class="col-md-4">
            <a href="/">
                <img class="logo img-fluid" src="img/AmorPorTi.jpg" alt="amor por ti">
            </a>
        </div>

        <div class="col-md-8 d-flex align-items-center">
            <nav class="navbar-nav container d-flex flex-md-row align-items-center justify-content-md-around text-center">
                <a class="fs-4 text-dark text-decoration-none" href="/">Inicio</a>
                <a class="fs-4 text-dark text-decoration-none" href="/nosotros">Nosotros</a>
                <a class="fs-4 text-dark text-decoration-none" href="/tienda">Tienda</a>
                <a class="fs-4 text-dark text-decoration-none" href="/contacto">Contacto</a>
                <!-- si $auth es false va a mostrar Iniciar Sesion -->
                <?php if (!is_auth()) : ?>
                    <a class="dashboard__submit--logout" href="/login">Iniciar Sesion</a>
                <?php endif; ?>

                <!-- si $auth es false nos va a mostrar Cerrar sesion -->
                <?php if (is_auth()) : ?>
                    <form method="POST" action="/logout" class="dashboard__form">
                        <input type="submit" value="Cerrar Sesión" class="dashboard__submit--logout">
                    </form>
                <?php endif; ?>
            </nav>
        </div>

    </div>
</header>