<main class="container-xl">
    <div class="row justify-content-center min-vh-45">
        <form method="POST" class="col-md-6" action="/perfil" >
            <?php
            require_once __DIR__ . '/../templates/alertas.php';
            ?>
            <fieldset>
                <div class="d-flex justify-content-between">
                    <a href="/principal">Volver al incio</a>
                    <a href="/cambiar-password">Cambiar Contraseña</a>
                </div>
                <legend class="bg-primary text-center text-white fs-2"><?php echo $titulo; ?></legend>
                <div class="mb-3">
                    <label class="form-label" for="cedula">Cedula:</label>
                    <input name="cedula" type="text" class="form-control" id="cedula" placeholder="Tu Cedula" maxlength="10" value="<?php echo s($usuario->cedula); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Tu Nombre" value="<?php echo s($usuario->nombre); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="apellido">Apellido:</label>
                    <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Tu Apellido" value="<?php echo s($usuario->apellido); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="telefono">Telefono:</label>
                    <input name="telefono" type="text" class="form-control" id="cedula" placeholder="Tu Telefono" maxlength="10" value="<?php echo s($usuario->telefono); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="direccion">Direccion:</label>
                    <input name="direccion" type="text" class="form-control" id="direccion" placeholder="Tu Direccion" maxlength="60" value="<?php echo s($usuario->direccion); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email:</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Tu Email" value="<?php echo s($usuario->email); ?>">
                </div>
            </fieldset>

            <div class="col-md-6">
                <input class="btn btn-secondary fs-2 px-5 mt-5" type="submit" value="Cambiar Datos">
            </div>
        </form>
    </div>
</main>