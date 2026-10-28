<?php

declare(strict_types=1);

function renderHeader(string $title): void{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= e($title) ?> | Mi playlist</title>
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>
      <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="sobre.php">Sobre mi</a></li>
            </ul>
        </nav>
      </header>
      <main>
        <?php  
}

function renderFooter(): void{
    ?>
      </main>
      <footer>2026 Mi web</footer>
    </body>
    </html>
    <?php
}












