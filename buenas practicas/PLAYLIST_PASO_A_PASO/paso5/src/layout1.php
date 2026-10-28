<?php

declare(strict_types=1);

function renderHeader(string $title): string{
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= e($title) ?> | <?= e(APP_NAME) ?></title>
            <link rel="stylesheet" href="/paso4/assets/css/styles.css">
        </head>
        <body>
        <header>
            <nav>
                <ul>
                <?php foreach(APP_MENU as $file => $label): ?>
                        <li><a href="<?= e($file) ?>"> <?= e($label) ?></a></li>
                <?php endforeach; ?>
                </ul>
            </nav>

        </header>
        <main>
    <?php

}

function renderFooter(): string{
    $year = date('Y');

    return <<<HTML
    </main>

    <footer>
        <p>&copy; {$year} Mi web - Autor: <?= e(APP_OWNER) ?></p>
    </footer>
    </body>

    </html>

    HTML;
}











