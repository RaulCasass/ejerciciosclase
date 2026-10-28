<?php
    $formularioEnviado = isset($_POST['calcular']);
    if($formularioEnviado){
        $numeroemails = 0;
        $precioTotal = 0;
        if(is_int($_POST['$numeroemails'])){
            $numeroemails = $_POST['numeroemails'];
        }else{
            echo "Valor no nummerico";
        }
        $seguro = $_POST['seguro'];

        if($numeroemails > 0 && $numeroemails <= 2000){
            $precioTotal = 0;
        }elseif($numeroemails >= 20001 && $numeroemails <= 10000){
            $precioTotal = $numeroemails * 0.7;
        }elseif($numeroemails >= 100001){
            $precioTotal = $numeroemails * 0.2;
        }

        if($seguro == 1){
            $precioTotal = $precioTotal + (0.1 * $numeroemails);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-size: 20px;
        }
        table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  font-size: 20px;
}
    </style>
</head>
<body>
    <h1>Actividad 1</h1>
    <table>
        <tr>
            <td>De</td>
            <td>A</td>
            <td>Precio</td>
        </tr>
        <tr>
            <td>0</td>
            <td>2000</td>
            <td>0€</td>
        </tr>
        <tr>
            <td>2001</td>
            <td>10000</td>
            <td>0.7€ unidad</td>
        </tr>
        <tr>
            <td>10001</td>
            <td>Infinito</td>
            <td>0.2€ unidad</td>
        </tr>
    </table>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <p>
            <label for="numeroemails">Numero de emails que enviaras:</label>
            <input type="number" name="numeroemails" min="1" max="10000000"> 
            <br>
            <input type="checkbox" name="seguro" value="1">
            <label for="seguro">Quiero el seguro por 0.1€</label>
            <br>
            <input type="submit" value="calcular">
        </p>
    </form>
    <?php if($formularioEnviado): ?>
    <h3>Total de precio: <?= $precioTotal ?></h3>
    <?php endif ?>
</body>
</html>