<?php

declare(strict_types=1);

function e(string|int|float $value): string{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}