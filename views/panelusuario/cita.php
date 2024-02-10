<main class="container-xl  mt-5 p-5">
    <a href="/principal">Volver al incio</a>
    <div id="contenido" class="row">
        <div class="col-md-6 agregar-cita">
            <form id="nueva-cita">

                <legend class="mb-4">Datos del Paciente</legend>

                <div class="form-group row">
                    <label class="col-sm-4 col-lg-4 col-form-label" for="fecha">Fecha:</label>
                    <div class="col-sm-8 col-lg-8">
                        <input require type="date" id="fecha" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="">
                    </div>
                </div>

                <div id="horas" class="form-group row">
                    <label class="col-sm-4 col-lg-4 col-form-label" for="horaID">Seleccionar Hora</label>
                    <div class="col-sm-8 col-lg-8">
                        <select require id="horaID" class="form-select">
                            <option selected value="10">-- Seleccione --</option>
                        </select>
                    </div>
                </div>

                <div id="horas" class="form-group row">
                    <label class="col-sm-4 col-lg-4 col-form-label" for="mascota_id">Seleccionar Mascota</label>
                    <div class="col-sm-8 col-lg-8">
                        <select require id="mascota_id" class="form-select">
                            <option selected value="">-- Seleccione --</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-lg-4 col-form-label" for="motivo">Motivo Cita:</label>
                    <div class="col-sm-8 col-lg-8">
                        <textarea require id="motivo" class="form-control" rows="5" value=""></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <input class="btn btn-success w-100 d-block" type="submit" value="Crear Cita">
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <h2 id="administra" class="mb-4">Administra tus Citas</h2>
            <div class="table-responsive">
                <table class="table table-primary" id="tablaCitas">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div> <!--.row-->
</main><!--.container-->

<?php
include_once __DIR__ . '/modalCitas.php';
?>