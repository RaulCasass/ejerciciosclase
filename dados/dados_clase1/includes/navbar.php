<?php 
    $opciones_menu = [
        'index.php' => 'Indice',
        'ejercicio1.php' => '1. Dado simple',
        'ejercicio2.php' => '2. Dado con mensajes',
        'ejercicio3.php' => '3. Doble dado'
    ];
?>

    <nav class="navbar">
        <span class="navbar_titulo">Practicas PHP . Dado Virtual</span>
        <ul class="navbar-menu">
            <li><a href="index.php"><?=$opciones_menu['index.php']?></a></li>
            <li><a href="ejercicio1.php"><?=$opciones_menu['ejercicio1.php']?></a></li>
            <li><a href="ejercicio2.php"><?php echo $opciones_menu['ejercicio2.php']?></a></li>
            <li><a href="ejercicio3.php"><?php echo $opciones_menu['ejercicio3.php']?></a></li>
        </ul>
    </nav>

