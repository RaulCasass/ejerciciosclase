<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = "Registro - " . APP_NAME;

$errors = [];
$successMessage = '';

$fullname = '';
$username = '';
$email = '';
$age = '';
$mainSport = '';
$level = '';
$trainingDays = [];
$terms = false;

$daysOfWeek = [
    'lunes' => 'Lunes',
    'martes' => 'Martes',
    'miercoles' => 'Miércoles',
    'jueves' => 'Jueves',
    'viernes' => 'Viernes',
    'sabado' => 'Sábado',
    'domingo' => 'Domingo'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enforceCsrfToken($_POST['csrf_token'] ?? null);

    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $age = trim($_POST['age'] ?? '');
    $mainSport = $_POST['main_sport'] ?? '';
    $level = $_POST['level'] ?? '';
    $trainingDays = $_POST['training_days'] ?? [];
    $terms = isset($_POST['terms']);

    if ($fullname === '' || mb_strlen($fullname) < 3 || mb_strlen($fullname) > 50) {
        $errors['fullname'] = 'El nombre completo debe tener entre 3 y 50 caracteres.';
    }

    if ($username === '' || !preg_match('/^[a-zA-Z0-9_]{4,15}$/', $username)) {
        $errors['username'] = 'El usuario debe tener entre 4 y 15 caracteres (letras, números y guiones bajos).';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo electrónico no es válido.';
    }

    if ($password === '' || mb_strlen($password) < 8) {
        $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif ($password !== $passwordConfirm) {
        $errors['password_confirm'] = 'Las contraseñas no coinciden.';
    }

    if ($age === '' || filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 16, 'max_range' => 60]]) === false) {
        $errors['age'] = 'La edad debe estar comprendida entre 16 y 60 años.';
    }

    if ($mainSport === '' || !array_key_exists($mainSport, $sports)) {
        $errors['main_sport'] = 'Debe seleccionar un deporte principal válido.';
    }

    if ($level === '' || !array_key_exists($level, $levels)) {
        $errors['level'] = 'Debe seleccionar un nivel competitivo válido.';
    }

    if (!is_array($trainingDays) || count($trainingDays) === 0) {
        $errors['training_days'] = 'Debe marcar al menos un día de entrenamiento.';
    } else {
        foreach ($trainingDays as $d) {
            if (!array_key_exists($d, $daysOfWeek)) {
                $errors['training_days'] = 'Se ha seleccionado un día no válido.';
                break;
            }
        }
    }

    if (!$terms) {
        $errors['terms'] = 'Debe aceptar el tratamiento de sus datos.';
    }

    if (empty($errors)) {
        $successMessage = '¡Registro validado correctamente!';
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="container">
    <h2>Registro de Deportista</h2>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <p><strong><?php echo e($successMessage); ?></strong></p>
            <ul>
                <li><strong>Nombre:</strong> <?php echo e($fullname); ?></li>
                <li><strong>Usuario:</strong> <?php echo e($username); ?></li>
                <li><strong>Email:</strong> <?php echo e($email); ?></li>
                <li><strong>Edad:</strong> <?php echo e($age); ?></li>
                <li><strong>Deporte:</strong> <?php echo e($sports[$mainSport]['name']); ?></li>
                <li><strong>Nivel:</strong> <?php echo e($levels[$level]); ?></li>
                <li><strong>Días:</strong> <?php echo e(implode(', ', array_map(fn($d) => $daysOfWeek[$d], $trainingDays))); ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST" class="form" novalidate>
        <div class="form-group">
            <label for="fullname">Nombre completo:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo e($fullname); ?>">
            <?php if (isset($errors['fullname'])): ?>
                <span class="error-text"><?php echo e($errors['fullname']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" value="<?php echo e($username); ?>">
            <?php if (isset($errors['username'])): ?>
                <span class="error-text"><?php echo e($errors['username']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo e($email); ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-text"><?php echo e($errors['email']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <span class="error-text"><?php echo e($errors['password']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirm">Repetir contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm">
            <?php if (isset($errors['password_confirm'])): ?>
                <span class="error-text"><?php echo e($errors['password_confirm']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="age">Edad:</label>
            <input type="number" id="age" name="age" value="<?php echo e((string)$age); ?>">
            <?php if (isset($errors['age'])): ?>
                <span class="error-text"><?php echo e($errors['age']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="main_sport">Deporte principal:</label>
            <select id="main_sport" name="main_sport">
                <option value="">-- Seleccione --</option>
                <?php foreach ($sports as $key => $sportData): ?>
                    <option value="<?php echo e($key); ?>" <?php echo ($mainSport === $key) ? 'selected' : ''; ?>>
                        <?php echo e($sportData['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['main_sport'])): ?>
                <span class="error-text"><?php echo e($errors['main_sport']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Nivel competitivo:</label>
            <div class="radio-group">
                <?php foreach ($levels as $key => $labelName): ?>
                    <label>
                        <input type="radio" name="level" value="<?php echo e($key); ?>" <?php echo ($level === $key) ? 'checked' : ''; ?>>
                        <?php echo e($labelName); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (isset($errors['level'])): ?>
                <span class="error-text"><?php echo e($errors['level']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Días de entrenamiento:</label>
            <div class="checkbox-group">
                <?php foreach ($daysOfWeek as $dayKey => $dayLabel):
                    $isChecked = is_array($trainingDays) && in_array($dayKey, $trainingDays, true);
                ?>
                    <label>
                        <input type="checkbox" name="training_days[]" value="<?php echo e($dayKey); ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                        <?php echo e($dayLabel); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (isset($errors['training_days'])): ?>
                <span class="error-text"><?php echo e($errors['training_days']); ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group checkbox-single">
            <label>
                <input type="checkbox" name="terms" value="1" <?php echo $terms ? 'checked' : ''; ?>>
                Acepto el tratamiento de mis datos
            </label>
            <?php if (isset($errors['terms'])): ?>
                <span class="error-text"><?php echo e($errors['terms']); ?></span>
            <?php endif; ?>
        </div>

        <?php echo csrfField(); ?>

        <button type="submit" class="btn-submit">Registrarse</button>
    </form>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>