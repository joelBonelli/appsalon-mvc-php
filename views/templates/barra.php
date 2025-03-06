<div class="barra">
    <p class="parr">Hola: <?php echo $nombre ?? ''; ?></p>

    <a class="boton" href="/logout" class="boton">Cerrar Sesión</a>
</div>

<?php 
if ($_SESSION['admin']) { ?>
 
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>



 <?php } ?>