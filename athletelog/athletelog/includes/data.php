<?php
declare(strict_types=1);

$sports = [
    'running' => [
        'name' => 'Running',
        'category' => 'individual',
        'unit' => 'km'
    ],
    'cycling' => [
        'name' => 'Ciclismo',
        'category' => 'individual',
        'unit' => 'km'
    ],
    'swimming' => [
        'name' => 'Natación',
        'category' => 'individual',
        'unit' => 'metros'
    ],
    'crossfit' => [
        'name' => 'CrossFit',
        'category' => 'individual',
        'unit' => 'minutos'
    ],
    'football' => [
        'name' => 'Fútbol',
        'category' => 'equipo',
        'unit' => 'minutos'
    ],
    'basketball' => [
        'name' => 'Baloncesto',
        'category' => 'equipo',
        'unit' => 'minutos'
    ]
];

$levels = [
    'beginner' => 'Iniciación',
    'regional' => 'Regional',
    'national' => 'Nacional',
    'elite' => 'Élite'
];

$users = [
    'admin' => [
        'name' => 'Administrador',
        'password_hash' => password_hash('Admin1234*', PASSWORD_DEFAULT),
        'sport' => 'running'
    ],
    'athlete1' => [
        'name' => 'Carlos Pérez',
        'password_hash' => password_hash('Password123!', PASSWORD_DEFAULT),
        'sport' => 'cycling'
    ],
    'athlete2' => [
        'name' => 'Laura Gómez',
        'password_hash' => password_hash('SecurePass789#', PASSWORD_DEFAULT),
        'sport' => 'swimming'
    ]
];