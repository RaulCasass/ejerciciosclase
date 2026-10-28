<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav><a href="index.php">Inicio</a> | <a href="sobre.php">Sobre mi</a></nav>
    <h1>Mi playlist</h1>
    <?php
    $songs = ['Blinding Lights', 'As it was', 'Flowers'];
    foreach($songs as $song){
        echo "<p>$song</p>";
    }
    ?>
    <footer>@ 2026 Mi web</footer>
</body>
</html>