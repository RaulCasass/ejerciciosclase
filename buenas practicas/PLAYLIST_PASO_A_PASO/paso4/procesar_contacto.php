<?php

declare(strict_types=1);require_once __DIR__ . '/src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacta.php');
    exit;
}

$nombre   = trim($_POST['nombre'] ?? '');
$email    = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');

renderHeader('Gracias');
?>

<h1>Datos de contacto</h1>

<ul>
    <li>Nombre: <?= e($nombre) ?></li>
    <li>Email: <?= e($email) ?></li>
    <li>Teléfono: <?= e($telefono) ?></li>
</ul>

<p>Contactaremos contigo en la menor brevedad posible</p>

<?php
renderFooter();
?>