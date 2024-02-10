<main class="container-xl">
    <a href="/principal">Volver al incio</a>
    <h2 class="text-center"><?php echo $titulo; ?></h2>
    <div class="table-responsive">
        <table class="table table-primary" id="tablaMascotas">
            <thead>
                <tr>
                    <th scope="col-md-4">Nombre</th>
                    <th scope="col-md-4">Especie</th>
                    <th scope="col-md-4">Nacimiento</th>
                    <th scope="col-md-4">Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>

<?php
include_once __DIR__ . '/modalMascotas.php';
?>