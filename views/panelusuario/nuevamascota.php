<main class="container-xl">
    <div class="row justify-content-center min-vh-100">
        <form id="formRegsMascota" class="col-md-6">
            <a href="/principal">Volver al incio</a>
            <h2><?php echo $titulo; ?></h2>
            <div class="mb-3">
                <label for="nombreMascota" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" require>
                <div id="emailHelp" class="form-text">Nunca compartiremos su correo electrónico con nadie más.</div>
            </div>
            <div class="mb-3">
                <div class="campo">
                    <label class="form-label" for="nacimiento">Fecha nacimiento</label>
                    <input id="nacimiento" type="date" require />

                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="exampleInputEmail1" class="form-label">Especie</label>
                <input type="text" class="form-control" id="especie" aria-describedby="emailHelp" require>
            </div>
            <div class="mb-3">
                <label class="form-label" for="raza" class="form-label">Raza</label>
                <input type="text" class="form-control" id="raza" require>
            </div>
            <div class="mb-3">
                <label class="form-label" for="color" class="form-label">Color</label>
                <input type="text" class="form-control" id="color" require>
            </div>
            <div class="mb-3">
                <label class="form-label" for="color" class="form-label">Sexo</label>
                <input type="text" class="form-control" id="sexo" require>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</main>