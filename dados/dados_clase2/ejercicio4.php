<?php
/*simula un numero de tiradas y guardando cada resultado en un array y muestra estadisticas con array_sum, max, min*/
require 'includes/navbar.php';

$historial=[];
$cantidad_tiradas=rand(1,20);
$i = 0;

while ($i <= $cantidad_tiradas){
    $historial[$i]=rand(1,6);
    $i++;
}
echo "<pre>";
var_dump($historial);
echo "</pre>";

//calculo de estadisticas
$suma = array_sum($historial);
$min = min($historial);
$max = max($historial);

echo "La suma total es $suma, el minimo es $min y el sueldo es de $max"; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <link rel="stylesheet" herf="css/estilos.css">
</head>
<body>
    <main class="contenedor">
        <table>
            <tr>
            <th>tirada</th>
            <th>valor</th>
</tr>
<?php 
    $contador = 1;
    foreach($historial as $tirada){
        echo "<tr>
        <td> $contador </td>
        <td> $tirada </td>
        </tr>
        ";
        $contador++;
    }
?>
        </table>
        <table>
            <tr>
                <th>SUMA</th>
                <th>MIN</th>
                <th>MAX</th>
            </tr>
            <tr>
                <td><?php echo $suma?></td>
                <td><?php echo $min?></td>
                <td><?php echo $max?></td>
            </tr>
        </table>
    </main>
</body>
</html>