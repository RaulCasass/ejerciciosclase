<?php 
    echo "<h4>Arrays asociativos: clave => valor</h4>";
    $zara = [
    123 => [
      'nombre' => 'Camisa a cuadros',
      'precio' => 29.95,
      'sexo' => 'Hombre'
    ],
    234 => [
      'nombre' => 'Falda manga',
      'precio' => 19.95,
      'sexo' => 'Mujer'
    ],
    345 => [
      'nombre' => 'Bolso minúsculo',
      'precio' => 50,
      'sexo' => 'Mujer'
    ]
    ];

    echo $zara[345]['precio'] . "<br>";

    // ================================
    echo "<h4>Arrays asociativos: clave => valor</h4>";
    $empleados = [
    'Juan' => 34,
    'Luisa' => 56
    ];

    $empleados['Manolo'] = 99;

    echo $empleados['Manolo'];

    // ================================
    $frase = 'En un lugar de la mancha';
    $arrayDeFrase = preg_split('/[\s,]+/', $frase);
    echo $arrayDeFrase[2];
    // "lugar"
    var_dump($arrayDeFrase);

    // ================================
    $palabra = 'abcdef';
    $palabra[2] = 'Z';
    echo $palabra . "<br>";

    // ================================
    // Array de partida
    $planetas = ['Marte', 'Tierra', 'Venus'];
    $masPlanetas = ['Mercurio', 'Saturno'];
    $planeta = 'Jupiter';

    // Añadimos 'Mercurio'
    $nuevosPlanetas = [...$planetas, $planeta, ...$masPlanetas];

    // Vemos el resultado
    echo "Numero total de planetas: " . count($nuevosPlanetas); 
    echo "<h4>Funcion var_dump con pre</h4>";
    echo "<pre>";
    var_dump($nuevosPlanetas);
    echo "</pre>";

    unset($nuevosPlanetas[1]);
    echo "Numero total de planetas: " . count($nuevosPlanetas); 
    echo "<h4>Funcion var_dump con pre</h4>";
    echo "<pre>";
    var_dump($nuevosPlanetas);
    echo "</pre>";

    // ================================
    // Array de partida
    $planetas = ['Marte', 'Tierra', 'Venus'];
    $masPlanetas = ['Mercurio', 'Saturno'];
    // Añadimos 'Mercurio'
    $nuevosPlanetas = array_merge($planetas, $masPlanetas);

    // Vemos el resultado
    echo "<h4>Funcion var_dump con pre</h4>";
    echo "<pre>";
    var_dump($nuevosPlanetas);
    echo "</pre>";

    // ================================
    $planetas[] = 'Marte';
    $planetas[] = 'Tierra';
    $planetas[] = 'Venus';

    echo "<h4>Funcion var_dump con pre</h4>";
    echo "<pre>";
    var_dump($planetas);
    echo "</pre>";

    // ================================
    $dias = [];
    $meses = [];

    $semana = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
        'Domingo'
    ];

    echo "<h4>Funcion print_r con pre</h4>";
    echo "<pre>";
    print_r($semana);
    echo "</pre>";

    // ================================
    echo "<h4>Funcion var_dump con pre</h4>";
    echo "<pre>";
    var_dump($semana);
    echo "</pre>";

    // ================================
    echo "$semana[0] <br>"; // Lunes
    echo "$semana[3] <br>"; // Jueves
    echo "$semana[6] <br>"; // Domingo
?>