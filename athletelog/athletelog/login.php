<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = "Login - " . APP_NAME;
$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enforceCsrfToken($_POST['csrf_token'] ?? null);

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Usuario o contraseña incorrectos.';
    } else {
        if (isset($users[$username]) && password_verify($password, $users[$username]['password_hash'])) {
            session_regenerate_id(true);
            rotateCsrfToken();

            $_SESSION['user'] = [
                'username' => $username,
                'name' => $users[$username]['name'],
                'sport' => $users[$username]['sport']
            ];

            header('Location: training.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="container">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <p><?php echo e($error); ?></p>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST" class="form">
        <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" value="<?php echo e($username); ?>">
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
        </div>

        <?php echo csrfField(); ?>

        <button type="submit" class="btn-submit">Entrar</button>
    </form>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>