<main class="container-xl my-5 text-center">
    <h2>CREAR CITA</h2>
    <form id="nuevaCitaAD">

        <legend class="mb-4">Datos del Paciente</legend>

        <div class="form-group row">
            <label class="col-sm-4 col-lg-4 col-form-label" for="fecha">Usuario:</label>
            <div class="col-sm-8 col-lg-8">
                <input require type="text" id="usuarioAD" class="form-control">
                <ul id="listado-usuarios" class="nav"></ul>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-lg-4 col-form-label" for="fecha">Fecha:</label>
            <div class="col-sm-8 col-lg-8">
                <input require type="date" id="fechaAD" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="">
            </div>
        </div>

        <div id="horas" class="form-group row">
            <label class="col-sm-4 col-lg-4 col-form-label" for="horaID">Seleccionar Hora</label>
            <div class="col-sm-8 col-lg-8">
                <select require id="horaIDAD" class="form-select">
                    <option selected value="10">-- Seleccione --</option>
                </select>
            </div>
        </div>

        <div id="horas" class="form-group row">
            <label class="col-sm-4 col-lg-4 col-form-label" for="mascota_id">Seleccionar Mascota</label>
            <div class="col-sm-8 col-lg-8">
                <select require id="mascota_idAD" class="form-select">
                    <option selected value="">-- Seleccione --</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-lg-4 col-form-label" for="motivo">Motivo Cita:</label>
            <div class="col-sm-8 col-lg-8">
                <textarea require id="motivoAD" class="form-control" rows="5" value=""></textarea>
            </div>
        </div>

        <div class="form-group">
            <input class="btn btn-success w-50" type="submit" value="Crear Cita">
        </div>
    </form>
    <h2><?php echo $titulo; ?></h2>

    <div class="row col-md-10 d-flex justify-content-center">
        <label class="col-sm-6 col-lg-6 col-form-label" for="fecha">Fecha:</label>
        <div class="col-sm-4 col-lg-4">
            <input require type="date" id="fechaAdmin" class="form-control" value="">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-primary" id="tablaConsultasAd">
            <thead>
                <tr>
                    <th scope="col">USUARIO</th>
                    <th scope="col">MASCOTA</th>
                    <th scope="col">HORA</th>
                    <th scope="col">MOTIVO</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</main>

<?php
include_once __DIR__ . '/modalCitasAD.php';
?>