<?php
declare(strict_types=1);

function getSportsByCategory(array $sports, string $category): array {
    $resultado = [];
    foreach ($sports as $key => $value) {
        if ($value['category'] === $category) {
            $resultado[$key] = $value;
        }
    }
    return $resultado;
}