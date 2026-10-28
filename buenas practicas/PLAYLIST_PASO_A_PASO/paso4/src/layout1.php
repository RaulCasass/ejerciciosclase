<?php

declare(strict_types=1);

function renderHeader(string $title): string{

    $title = e($title);
    return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>($title)|Mi playlist</title>
            <link rel="stylesheet" href="/paso4/assets/css/styles.css">
        </head>
        <body>
        <header>
            <nav aria-label="Principal">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="sobre.php">Sobre mi</a></li>
                    <li><a href="contacta.php">Contacta</a></li>
                </ul>
            </nav>

        </header>
        <main>
    HTML;

}

function renderFooter(): string{
    $year = date('Y');

    return <<<HTML
    </main>

    <footer>
        <p>&copy; {$year} Mi web</p>
    </footer>
    </body>

    </html>

    HTML;
}











