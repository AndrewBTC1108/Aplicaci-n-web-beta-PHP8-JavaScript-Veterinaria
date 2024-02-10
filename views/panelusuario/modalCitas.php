<!-- Modal de Actualizar Mascotas -->
<div class="modal fade" id="modalActualizarCita" tabindex="-1" aria-labelledby="modalActualizarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActualizarLabel">Modificar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenido del formulario se agregará aquí -->
                <form id="nueva-cita">

                    <legend class="mb-4">Datos del Paciente</legend>

                    <div class="form-group row">
                        <label class="col-sm-4 col-lg-4 col-form-label" for="fecha">Fecha:</label>
                        <div class="col-sm-8 col-lg-8">
                            <input type="date" id="fechaModal" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="">
                        </div>
                    </div>

                    <div id="horas" class="form-group row">
                        <label class="col-sm-4 col-lg-4 col-form-label" for="horaID">Seleccionar Hora</label>
                        <div class="col-sm-8 col-lg-8">
                            <select id="horaIDModal" class="form-select">
                                <option selected value="">-- Seleccione --</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>