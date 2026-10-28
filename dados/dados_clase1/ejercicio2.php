<?php
    require 'includes/navbar.php';
    echo "Estoy en el ejercicio 2";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Tirada de dado</h1>

    <?php
    $dado = rand(1, 6);

    echo "Has sacado un: $dado";

    if ($dado === 6) {
        echo " Tirada perfecta!";
    } elseif ($dado === 1) {
        echo " Peor tirada posible!";
    } elseif ($dado % 2 === 0) {
        echo " El número es par";
    } else {
        echo " El número es impar";
    }

    ?>

</body>
</html>