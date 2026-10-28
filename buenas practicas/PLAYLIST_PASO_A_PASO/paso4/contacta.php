<?php

declare(strict_types=1);

require_once __DIR__ . '/src/bootstrap.php';

echo renderHeader('Contacta');
?>

<h1>Contacta con nosotros</h1>

<p>Rellena el siguiente formulario para que podamos contactar contigo</p>

<?php
    echo renderContactForm([]);
?>

<!-- <form action="procesar_contacto.php" method="POST">
    <p>
        <label for="nombre">Nombre: </label>
        <input type="text" id="nombre" name="nombre" required>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </p>
    <p>
        <label for="telefono">Telefono : </label>
        <input type="tel" id="telefono" name="telefono" required>
    </p>
        <button type="submit">Enviar</button>

</form> -->

<?php

    echo renderFooter();
?>