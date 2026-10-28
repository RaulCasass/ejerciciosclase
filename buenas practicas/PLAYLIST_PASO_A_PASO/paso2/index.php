<?php 
    $songs = require __DIR__ . '/data/songs.php';
?>
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
    <?php foreach ($songs as $song): ?>
        <p><?= $song ['title'] ?> - <?= $song ['artist'] ?> (<?= $song ['minutes'] ?> min)</p>
    <?php endforeach; ?>
    <footer>2026 Mi web</footer>
</body>
</html>