<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
requireLogin();

$pageTitle = "Preferencias - " . APP_NAME;

$cookiePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
if ($cookiePath === '' || $cookiePath === '.') {
    $cookiePath = '/';
} else {
    $cookiePath .= '/';
}

$visits = isset($_COOKIE['visits']) ? (int)$_COOKIE['visits'] + 1 : 1;
setcookie('visits', (string)$visits, [
    'expires' => time() + (86400 * 30),
    'path' => $cookiePath,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enforceCsrfToken($_POST['csrf_token'] ?? null);

    if (isset($_POST['reset'])) {
        $pastOptions = [
            'expires' => time() - 3600,
            'path' => $cookiePath,
            'httponly' => true,
            'samesite' => 'Lax'
        ];
        setcookie('theme', '', $pastOptions);
        setcookie('weight_unit', '', $pastOptions);
        setcookie('show_tips', '', $pastOptions);
        header('Location: preferences.php?reset=1');
        exit;
    }

    $theme = $_POST['theme'] ?? 'light';
    $weightUnit = $_POST['weight_unit'] ?? 'kg';
    $showTips = isset($_POST['show_tips']) ? '1' : '0';

    $cookieOptions = [
        'expires' => time() + (86400 * 30),
        'path' => $cookiePath,
        'httponly' => true,
        'samesite' => 'Lax'
    ];

    if (in_array($theme, ['light', 'dark'], true)) {
        setcookie('theme', $theme, $cookieOptions);
    }
    if (in_array($weightUnit, ['kg', 'lb'], true)) {
        setcookie('weight_unit', $weightUnit, $cookieOptions);
    }
    setcookie('show_tips', $showTips, $cookieOptions);

    header('Location: preferences.php?saved=1');
    exit;
}

$currentTheme = $_COOKIE['theme'] ?? 'light';
$currentWeight = $_COOKIE['weight_unit'] ?? 'kg';
$currentTips = !isset($_COOKIE['show_tips']) || $_COOKIE['show_tips'] === '1';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="container">
    <h2>Preferencias de Usuario</h2>

    <?php if (isset($_GET['saved'])): ?>
        <div class="alert alert-success">Preferencias actualizadas correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['reset'])): ?>
        <div class="alert alert-info">Preferencias restablecidas a los valores por defecto.</div>
    <?php endif; ?>

    <form action="preferences.php" method="POST" class="form">
        <div class="form-group">
            <label>Tema de la interfaz:</label>
            <div class="radio-group">
                <label><input type="radio" name="theme" value="light" <?php echo ($currentTheme === 'light') ? 'checked' : ''; ?>> Claro</label>
                <label><input type="radio" name="theme" value="dark" <?php echo ($currentTheme === 'dark') ? 'checked' : ''; ?>> Oscuro</label>
            </div>
        </div>

        <div class="form-group">
            <label for="weight_unit">Unidad de peso:</label>
            <select id="weight_unit" name="weight_unit">
                <option value="kg" <?php echo ($currentWeight === 'kg') ? 'selected' : ''; ?>>Kilogramos (kg)</option>
                <option value="lb" <?php echo ($currentWeight === 'lb') ? 'selected' : ''; ?>>Libras (lb)</option>
            </select>
        </div>

        <div class="form-group checkbox-single">
            <label>
                <input type="checkbox" name="show_tips" value="1" <?php echo $currentTips ? 'checked' : ''; ?>>
                Mostrar consejos de entrenamiento en la home
            </label>
        </div>

        <?php echo csrfField(); ?>

        <button type="submit" class="btn-submit">Guardar preferencias</button>
        <button type="submit" name="reset" value="1" class="btn-submit btn-secondary">Restablecer preferencias</button>
    </form>

    <p class="visits-counter">Visitas registradas: <strong><?php echo $visits; ?></strong></p>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>