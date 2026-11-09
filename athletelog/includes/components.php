<?php
declare(strict_types=1);

$app_name = APP_NAME;

function renderSportsTable(array $sports): string{
    $html = '<table>';
    $html .= '<tr><th>Nombre</th><th>Categoria</th><th>Unidad</th></tr>';
    
    foreach ($sports as $sport){
        $html .= '<tr>'
            . '<td>' . e($sport['name']) . '</td>'
            . '<td>' . e($sport['unit']) . '</td>'
            . '</tr>';
    }

    return $html . '</table>';
}

function renderMensajeBienvenida(): string
{
    return <<<HTML
    <h2>Bienvenido a {$app_name}</h2>
        <p>AthleteLog es tu diario de entrenamiento para deportistas de competición.
        Porque el progreso no depende de entrenar mucho, sino de entrenar con método.</p>
    <ul>
        <li>Regístrate e indica tu deporte, tu nivel y tus días de entrenamiento.</li>
        <li>Anota cada sesión: deporte, duración y sensaciones.</li>
        <li>Consulta tu historial para ver tu evolución.</li>
        <li>Ajusta tus preferencias para usar la app a tu manera.</li>
    </ul>
    HTML;
}