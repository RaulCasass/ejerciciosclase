<?php
declare(strict_types=1);
$currentScript = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isset($_SESSION['user']);
?>
<nav class="navbar">
    <div class="nav-brand">AthleteLog</div>
    <ul class="nav-links">
        <li><a href="index.php" class="<?php echo ($currentScript === 'index.php') ? 'active' : ''; ?>">Inicio</a></li>
        
        <?php if (!$isLoggedIn): ?>
            <li><a href="register.php" class="<?php echo ($currentScript === 'register.php') ? 'active' : ''; ?>">Registro</a></li>
            <li><a href="login.php" class="<?php echo ($currentScript === 'login.php') ? 'active' : ''; ?>">Login</a></li>
        <?php else: ?>
            <li class="nav-greeting">Hola, <?php echo htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8'); ?></li>
            <li><a href="training.php" class="<?php echo ($currentScript === 'training.php') ? 'active' : ''; ?>">Nuevo entrenamiento</a></li>
            <li><a href="history.php" class="<?php echo ($currentScript === 'history.php') ? 'active' : ''; ?>">Historial</a></li>
            <li><a href="preferences.php" class="<?php echo ($currentScript === 'preferences.php') ? 'active' : ''; ?>">Preferencias</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        <?php endif; ?>
    </ul>
</nav>