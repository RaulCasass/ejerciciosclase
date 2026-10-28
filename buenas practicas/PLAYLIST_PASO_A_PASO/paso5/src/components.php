<?php

declare(strict_types=1);

function renderSongList(array $songs): string{
    $html = '<ul>';
    foreach($songs as $song){
        $html .= '<li>' . e($song['title']) . ' - ' . e($song['artist'])
                . ' (' . e($song['minutes']) . ' min)</Li>';
    }

    return $html . '</ul>';
}

// Devuelve en HTML el formulario de contactos
function renderContactForm(array $datos): string{
    $nombre = e($datos['nombre'] ?? '');
    $email = e($datos['email'] ?? '');
    $telefono = e($datos['telefono'] ?? '');

    $html = <<<HTML
        <form action="procesar_contacto.php" method="POST">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" id="nombre" name="nombre">
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </p>
            <p>
                <label for="telefono">Telefono : </label>
                <input type="tel" id="telefono" name="telefono">
            </p>
                <button type="submit">Enviar</button>

        </form>


    HTML;

    return $html;
}
?>