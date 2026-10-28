<?php
    require 'includes/navbar.php';
    echo "Estoy en el ejercicio 3";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Dado Doble</h1>

    <?php
    $resultados = [];
    $suma_total = 0;

    for ($i = 0; $i < 2; $i++) {
        $dado = rand(1, 6);
        $resultados[] = $dado;
        $suma_total += $dado;
    }

    foreach ($resultados as $dado) {
        echo "<img src='img/dado_$dado.svg' alt='$dado' width='60'> ";
    }

    echo "Suma total: $suma_total";

    if ($suma_total == 12) {
        echo " Maxima puntuacion!";
    } else if ($suma_total == 2) {
        echo " Minima puntuacion!";
    }
    ?>

</body>
</html>