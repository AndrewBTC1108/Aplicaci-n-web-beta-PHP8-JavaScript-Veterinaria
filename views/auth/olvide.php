<main class="container-xl">
    <div class="row justify-content-center">

        <form method="POST" class="col-md-6">
            <?php
            require_once __DIR__ . '/../templates/alertas.php';
            ?>
            <fieldset>
                <legend class="bg-primary text-center text-white fs-2"><?php echo $titulo; ?></legend>
                <div class="mb-3">
                    <label class="form-label" for="email">Email:</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Tu Email">
                </div>
                <div class="col-md-6">
                    <input class="btn btn-secondary fs-2 px-5 mt-5" type="submit" value="Enviar Intrucciones">
                </div>

                <div class="row">
                    <a href="/login" class="col-md-8 text-center text-md-start">¿Ya tienes una cuenta? Iniciar sesion</a>
                    <a href="/registro" class="col-md-4 text-center text-md-end">¿Aun no tienes una cuenta? Crea una</a>
                </div>
            </fieldset>
        </form>
    </div>
</main>