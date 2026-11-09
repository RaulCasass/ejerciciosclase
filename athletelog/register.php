<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = "Registro - AthleteLog";

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
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
    } elseif ($password !== $password_confirm) {
        $errors['password_confirm'] = 'Las contraseñas no coinciden.';
    }

    if ($age === '' || !filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 16, 'max_range' => 60]])) {
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
            <p><?php echo $successMessage; ?></p>
            <ul>
                <li><strong>Nombre:</strong> <?php echo htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Usuario:</strong> <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Edad:</strong> <?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Deporte:</strong> <?php echo htmlspecialchars($sports[$mainSport]['name'], ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Nivel:</strong> <?php echo htmlspecialchars($levels[$level], ENT_QUOTES, 'UTF-8'); ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST" class="form">
        <div class="form-group">
            <label for="fullname">Nombre completo:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'); ?>">
            <?php if (isset($errors['fullname'])): ?>
                <span class="error-text"><?php echo $errors['fullname']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
            <?php if (isset($errors['username'])): ?>
                <span class="error-text"><?php echo $errors['username']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-text"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <span class="error-text"><?php echo $errors['password']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirm">Repetir contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm">
            <?php if (isset($errors['password_confirm'])): ?>
                <span class="error-text"><?php echo $errors['password_confirm']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="age">Edad:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars((string)$age, ENT_QUOTES, 'UTF-8'); ?>">
            <?php if (isset($errors['age'])): ?>
                <span class="error-text"><?php echo $errors['age']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="main_sport">Deporte principal:</label>
            <select id="main_sport" name="main_sport">
                <option value="">-- Seleccione --</option>
                <?php foreach ($sports as $key => $sportData): ?>
                    <option value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($mainSport === $key) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($sportData['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['main_sport'])): ?>
                <span class="error-text"><?php echo $errors['main_sport']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Nivel competitivo:</label>
            <div class="radio-group">
                <?php foreach ($levels as $key => $labelName): ?>
                    <label>
                        <input type="radio" name="level" value="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($level === $key) ? 'checked' : ''; ?>>
                        <?php echo htmlspecialchars($labelName, ENT_QUOTES, 'UTF-8'); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (isset($errors['level'])): ?>
                <span class="error-text"><?php echo $errors['level']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Días de entrenamiento:</label>
            <div class="checkbox-group">
                <?php 
                $daysOfWeek = [
                    'lunes' => 'Lunes', 'martes' => 'Martes', 'miercoles' => 'Miércoles',
                    'jueves' => 'Jueves', 'viernes' => 'Viernes', 'sabado' => 'Sábado', 'domingo' => 'Domingo'
                ];
                foreach ($daysOfWeek as $dayKey => $dayLabel): 
                    $isChecked = in_array($dayKey, $trainingDays, true);
                ?>
                    <label>
                        <input type="checkbox" name="training_days[]" value="<?php echo htmlspecialchars($dayKey, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                        <?php echo htmlspecialchars($dayLabel, ENT_QUOTES, 'UTF-8'); ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (isset($errors['training_days'])): ?>
                <span class="error-text"><?php echo $errors['training_days']; ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group checkbox-single">
            <label>
                <input type="checkbox" name="terms" value="1" <?php echo $terms ? 'checked' : ''; ?>>
                Acepto el tratamiento de mis datos
            </label>
            <?php if (isset($errors['terms'])): ?>
                <span class="error-text"><?php echo $errors['terms']; ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit">Registrarse</button>
    </form>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>