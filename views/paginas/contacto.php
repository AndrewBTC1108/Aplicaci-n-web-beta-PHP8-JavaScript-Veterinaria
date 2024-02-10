<main class="container-xl py-5">

    <div class="row justify-content-center">
        <form class="col-md-8 needs-validation" novalidate>
            <fieldset>
                <legend class="bg-primary text-center text-white fs-2">Tus Datos</legend>

                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Tu Nombre" required>
                    <span class="invalid-feedback">Hubo un error...</span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="asunto">Asunto:</label>
                    <input type="text" class="form-control" id="asunto" placeholder="Tu Asunto">
                    <span class="valid-feedback">Muy bien!!</span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Tu Email">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="tel">Teléfono:</label>
                    <input type="tel" class="form-control" id="tel" placeholder="Tu Teléfono">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="tel">Mensaje:</label>
                    <textarea class="form-control" rows="10"></textarea>
                </div>
            </fieldset>

            <fieldset>
                <legend class="bg-primary text-center text-white fs-2">País</legend>

                <div class="mb-3">
                    <label class="form-label" for="pais">País:</label>
                    <select class="form-control" id="pais">
                        <option value="">--Seleccione--</option>
                        <option value="MX">México</option>
                        <option value="PR">Perú</option>
                        <option value="CO">Colombia</option>
                        <option value="AR">Argentina</option>
                        <option value="ES">España</option>
                        <option value="CL">Chile</option>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <legend class="bg-primary text-center text-white fs-2">Información Extra</legend>

                <div class="mb-3">
                    <label class="form-label" for="cliente">Cliente:</label>
                    <input name="tipo" type="radio" class="form-check-input" id="cliente">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="proveedor">Proveedor:</label>
                    <input name="tipo" type="radio" class="form-check-input" id="proveedor">
                </div>

            </fieldset>

            <!--Al tener d-grid y que solo haya un hijo autoamticamnete va a tomar todo el ancho disponible-->
            <div class="d-grid d-md-flex">
                <input class="btn btn-secondary fs-2 px-5 mt-5" type="submit" value="Enviar Formulario">
            </div>
        </form>
    </div>

</main>