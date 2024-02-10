<main class="container-xl">
    <h2 class="auth__heading"><?php echo $titulo ;?></h2>
    <p class="auth__texto">Tu cuenta DevWebcamp</p>

    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if(isset($alertas['exito'])) {?>
        <div class="acciones--centrar">
            <a href="/login" class="acciones__enlace">Iniciar Sesion</a>
        </div>
    <?php }?>

</main>