<?php 
    $numero_dado = rand(1, 6);
    $ruta_imagen = "img/dado_".$numero_dado.".svg";

    //calcular el mensaje de texto segun la tirada
    //con SWITCH

    switch(true){
        case ($numero_dado == 6):
            $mensaje = "Sale el numero mas grande. Tirada perfecta!";
            break;
        case ($numero_dado == 1):
            $mensaje = "Sale el numero mas pequeño. Peor tirada...";
            break;
        case ($numero_dado % 2 == 0):
            $mensaje = "Tirada PAR";
            break;
        case ($numero_dado % 2 == 1):
            $mensaje = "Tirada IMPAR";
            break;
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
    <?php require 'includes/navbar.php'; ?>

    <main class="contenedor">
        <h1>🎲 Ejercicio 2: Dado con mensaje</h1>
        <p class="concepto">Concepto practicado: <strong>if else if... y switch</strong></p>

        <p>Has sacado un <strong><?php echo $numero_dado; ?></strong></p>
        <img src="<?php echo $ruta_imagen; ?>" alt="Dado mostrando el número <?php echo $numero_dado; ?>" class="imagen-dado">
        <p class="mensaje"> <?php echo $mensaje; ?></p>
        <a href="ejercicio2.php" class="boton">🔄 Volver a tirar</a>
    </main>
</body>
</html>