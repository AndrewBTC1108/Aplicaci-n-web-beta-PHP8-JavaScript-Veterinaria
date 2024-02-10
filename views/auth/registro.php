<main class="container-xl">
    <div class="row justify-content-center min-vh-100">
        <form method="POST" action="/registro" class="col-md-6">
            <?php
            require_once __DIR__ . '/../templates/alertas.php';
            ?>
            <fieldset>
                <legend class="bg-primary text-center text-white fs-2"><?php echo $titulo; ?></legend>
                <div class="mb-3">
                    <label class="form-label" for="cedula">Cedula:</label>
                    <input name="cedula" type="text" class="form-control" id="cedula" placeholder="Tu Cedula" maxlength="10" value="<?php echo $usuario->cedula; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Tu Nombre" value="<?php echo $usuario->nombre; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="apellido">Apellido:</label>
                    <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Tu Apellido" value="<?php echo $usuario->apellido; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="telefono">Telefono:</label>
                    <input name="telefono" type="text" class="form-control" id="cedula" placeholder="Tu Telefono" maxlength="10" value="<?php echo $usuario->telefono; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="direccion">Direccion:</label>
                    <input name="direccion" type="text" class="form-control" id="direccion" placeholder="Tu Direccion" maxlength="60" value="<?php echo $usuario->direccion; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email:</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Tu Email" value="<?php echo $usuario->email; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña:</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Tu Contraseña">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="contraseña2">Repetir Contraseña:</label>
                    <input name="password2" type="password" class="form-control" id="password2" placeholder="Tu Contraseña">
                </div>
            </fieldset>

            <div class="col-md-6">
                <input class="btn btn-secondary fs-2 px-5 mt-5" type="submit" value="Crear Cuenta">
            </div>

            <div class="row">
                <a href="/login" class="col-md-8 text-center text-md-start">¿Ya tienes una cuenta? Iniciar sesion</a>
                <a href="/olvide" class="col-md-4 text-center text-md-end">¿Olvidaste tu Password?</a>
            </div>
        </form>
    </div>
</main>