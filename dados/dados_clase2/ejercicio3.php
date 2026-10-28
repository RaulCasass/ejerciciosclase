<?php 
    //$ruta_imagen = "img/dado_".$numero_dado.".svg";
    $suma_total = 0;
    $tiradas = [];
    $mensaje = "";
    for ($i=0; $i <= 1; $i++) { 
        $numero_dado = rand(1,6);
        $tiradas[$i] = $numero_dado;
        $suma_total = $suma_total + $numero_dado;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2 - Dado con mensaje</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <?php 
        require 'includes/navbar.php';
        $ruta_imagen = "img/dado_".$numero_dado.".svg";
    ?>

    <main class="contenedor">
        <h1>🎲 Ejercicio 3: Dado doble</h1>
        <p class="concepto">Concepto practicado: <strong>for y foreach</strong></p>
        <?php
            foreach ($tiradas as $tirada) {
                $ruta_imagen = "img/dado_".$tirada.".svg"; 
                echo "<img src= '$ruta_imagen' alt= 'Dado $tirada'>";
            }
        ?>

        <p>Suma total de la tiradas: <?php echo $suma_total; ?></p>
        <?php
            if($suma_total == 2){
                $mensaje = '<p class="mensaje-min">Has hecho la peor tirada...</p>';
            }elseif($suma_total == 12){
                $mensaje = '<p class="mensaje-max">Has hecho la mejor tirada!</p>';
            }
            echo $mensaje;
        ?>
        <a href="ejercicio3.php" class="boton">🔄 Volver a tirar</a>
    </main>
</body>
</html>