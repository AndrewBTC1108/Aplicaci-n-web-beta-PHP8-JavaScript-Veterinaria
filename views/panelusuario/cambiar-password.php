<main class="container-xl">
    <div class="row justify-content-center min-vh-100">
        <form method="POST" class="col-md-6" action="/cambiar-password">
            <?php
            require_once __DIR__ . '/../templates/alertas.php';
            ?>
            <fieldset>
                <div class="d-flex justify-content-between">
                    <a href="/perfil">Volver</a>
                    <a href="/cambiar-password">Cambiar Contraseña</a>
                </div>
                <legend class="bg-primary text-center text-white fs-2"><?php echo $titulo; ?></legend>
                <div class="mb-3">
                    <label class="form-label" for="password_actual">Contraseña Actual:</label>
                    <input name="password_actual" type="password" class="form-control" id="password_actual" placeholder="Tu Contraseña">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password_nuevo">Nueva Contraseña:</label>
                    <input name="password_nuevo" type="password" class="form-control" id="password_nuevo" placeholder="Tu Contraseña">
                </div>
            </fieldset>

            <div class="col-md-6">
                <input class="btn btn-secondary fs-2 px-5 mt-5" type="submit" value="Guardar Cambios">
            </div>
        </form>
    </div>
</main>