<?php
declare(strict_types=1);
$currentScript = basename($_SERVER['PHP_SELF']);

$navItems = [
    'index.php' => 'Inicio',
    'register.php' => 'Registro',
    'login.php' => 'Login',
    'training.php' => 'Nuevo entrenamiento',
    'history.php' => 'Historial',
    'preferences.php' => 'Preferencias',
];
?>
<nav class="navbar">
    <div class="nav-brand">AthleteLog</div>
    <ul class="nav-links">
        <?php foreach ($navItems as $file => $label): ?>
            <?php $activeClass = ($currentScript === $file) ? 'active' : ''; ?>
            <li><a href="<?php echo htmlspecialchars($file, ENT_QUOTES, 'UTF-8'); ?>" class="<?php echo $activeClass; ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>