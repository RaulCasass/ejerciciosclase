<?php
// ¿Se ha enviado el formulario?
$formularioEnviado = isset($_POST['enviar']);

// Recuperamos los datos (cadena vacía si no existen).
$nombre = '';
$email  = '';

if ($formularioEnviado) {
    $nombre = $_POST['name'];
    $email  = $_POST['email'];
}
echo ($_SERVER['PHP_SELF']);
var_dump($_REQUEST);

$nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : "";

if(isset($_REQUEST['nombre'])){
    $nombre = $_REQUEST['nombre'];
}else{
    $nombre = '';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario PHP</title>
</head>
<body>

    <h1>Formulario</h1>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

        <p>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($nombre) ?>">
        </p>

        <p>
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
        </p>
        <input type="hidden" name="maquina-enigma" value="149">
        <button type="submit" name="enviar" value="1">Enviar</button>

    </form>

    <?php if ($formularioEnviado): ?>
        <hr>
        <h2>Resultado</h2>
        <p>Bienvenido, <strong><?= htmlspecialchars($nombre) ?></strong></p>
        <p>Tu e-mail es: <strong><?= htmlspecialchars($email) ?></strong></p>
    <?php endif; ?>

</body>
</html>




