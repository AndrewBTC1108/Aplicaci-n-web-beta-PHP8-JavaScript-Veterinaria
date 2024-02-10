<main class="contenedor-xl">
    <div class="row justify-content-center d-flex flex-column min-vh-100 align-items-center">
        <div class="col-md-6">
            <?php
            require_once __DIR__ . '/../templates/alertas.php';
            ?>

            <?php if ($token_valido) { ?>
                <form method="POST" class="formulario">
                    <fieldset>
                        <legend class="bg-primary text-center text-white fs-2"><?php echo $titulo; ?></legend>
                        <div class="mb-3">
                            <label class="form-label" for="email">Password:</label>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Tu Password">
                        </div>
                    </fieldset>

                    <div class="col-md-6">
                        <input class="btn btn-secondary fs-2 px-5 mt-5" type="submit" value="Guardar Contraseña">
                    </div>
                </form>
            <?php } ?>
            <div class="row">
                <a href="/login" class="col-md-8 text-center text-md-start">¿Ya tienes una cuenta? Iniciar sesion</a>
                <a href="/registro" class="col-md-4 text-center text-md-end">¿Aun no tienes una cuenta? Crea una</a>
            </div>
        </div>
    </div>
</main>