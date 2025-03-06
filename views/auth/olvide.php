<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email"></label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"        
        />
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">

    <div class="acciones">
        <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una aquí</a>
    </div>
</form>