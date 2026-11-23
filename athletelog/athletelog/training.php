<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
requireLogin();

$pageTitle = "Nuevo Entrenamiento - " . APP_NAME;
$csvFile = __DIR__ . '/data/trainings.csv';
$username = (string)$_SESSION['user']['username'];

$errors = [];
$fileError = '';
$savedMessage = '';

$date = date('Y-m-d');
$type = '';
$duration = '';
$rpe = '';
$notes = '';
$hasInjury = false;
$injuryText = '';

$sessionTypes = [
    'Tecnica' => 'Técnica',
    'Fuerza' => 'Fuerza',
    'Resistencia' => 'Resistencia',
    'Competencia' => 'Competición',
    'Recuperacion' => 'Recuperación'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    enforceCsrfToken($_POST['csrf_token'] ?? null);

    $date = trim($_POST['date'] ?? '');
    $type = $_POST['type'] ?? '';
    $duration = trim($_POST['duration'] ?? '');
    $rpe = trim($_POST['rpe'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    $hasInjury = isset($_POST['has_injury']);
    $injuryText = trim($_POST['injury_text'] ?? '');

    $errors = validateTraining($_POST);

    if (empty($errors)) {
        $durInt = (int)$duration;
        $rpeInt = (int)$rpe;

        $trainingItem = [
            'date' => $date,
            'type' => $type,
            'duration' => $durInt,
            'rpe' => $rpeInt,
            'load' => calculateLoad($durInt, $rpeInt),
            'notes' => $notes,
            'injury' => $hasInjury ? $injuryText : 'Ninguna'
        ];

        if (appendTrainingCsv($csvFile, $username, $trainingItem)) {
            $savedMessage = 'Entrenamiento guardado en el historial.';
            $type = '';
            $duration = '';
            $rpe = '';
            $notes = '';
            $injuryText = '';
            $hasInjury = false;
        } else {
            $fileError = 'No se ha podido escribir en el fichero de entrenamientos. Revisa los permisos de la carpeta data/.';
        }
    }
}

$userTrainings = readTrainings($csvFile, $username);
if (empty($userTrainings) && !file_exists($csvFile)) {
    $fileError = 'No se ha podido acceder al fichero data/trainings.csv.';
}

$stats = calculateTrainingStats($userTrainings);

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="container">
    <h2>Registrar Sesión de Entrenamiento</h2>

    <?php if ($fileError !== ''): ?>
        <div class="alert alert-error">
            <p><?php echo e($fileError); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($savedMessage !== ''): ?>
        <div class="alert alert-success">
            <p><?php echo e($savedMessage); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="training.php" method="POST" class="form" novalidate>
        <div class="form-group">
            <label for="date">Fecha:</label>
            <input type="date" id="date" name="date" value="<?php echo e($date); ?>">
        </div>

        <div class="form-group">
            <label>Tipo de sesión:</label>
            <div class="radio-group">
                <?php foreach ($sessionTypes as $k => $v): ?>
                    <label>
                        <input type="radio" name="type" value="<?php echo e($k); ?>" <?php echo ($type === $k) ? 'checked' : ''; ?>>
                        <?php echo e($v); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="duration">Duración (minutos, 5-360):</label>
            <input type="number" id="duration" name="duration" value="<?php echo e((string)$duration); ?>">
        </div>

        <div class="form-group">
            <label for="rpe">Esfuerzo Percibido (RPE 1-10):</label>
            <input type="number" id="rpe" name="rpe" min="1" max="10" value="<?php echo e((string)$rpe); ?>">
        </div>

        <div class="form-group">
            <label for="notes">Sensaciones (máx. 200 caracteres):</label>
            <textarea id="notes" name="notes" rows="3"><?php echo e($notes); ?></textarea>
        </div>

        <div class="form-group checkbox-single">
            <label>
                <input type="checkbox" name="has_injury" value="1" <?php echo $hasInjury ? 'checked' : ''; ?>>
                ¿Has tenido alguna lesión o molestia?
            </label>
        </div>

        <div class="form-group">
            <label for="injury_text">Descripción de molestia (si aplica):</label>
            <input type="text" id="injury_text" name="injury_text" value="<?php echo e($injuryText); ?>">
        </div>

        <?php echo csrfField(); ?>

        <button type="submit" class="btn-submit">Guardar Entrenamiento</button>
    </form>

    <hr class="divider">

    <h3>Tus Entrenamientos Guardados</h3>
    <?php if ($stats['total_sessions'] === 0): ?>
        <p>No hay entrenamientos registrados todavía.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Duración</th>
                    <th>RPE</th>
                    <th>Carga</th>
                    <th>Sensaciones</th>
                    <th>Molestia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userTrainings as $tr): ?>
                    <tr>
                        <td><?php echo e((string)$tr['date']); ?></td>
                        <td><?php echo e($sessionTypes[$tr['type']] ?? (string)$tr['type']); ?></td>
                        <td><?php echo e((string)$tr['duration']); ?> min</td>
                        <td><?php echo e((string)$tr['rpe']); ?></td>
                        <td><?php echo e((string)$tr['load']); ?></td>
                        <td><?php echo e((string)$tr['notes']); ?></td>
                        <td><?php echo e((string)$tr['injury']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="stats-box">
            <h4>Estadísticas Globales</h4>
            <p><strong>Total de sesiones:</strong> <?php echo $stats['total_sessions']; ?></p>
            <p><strong>Minutos totales:</strong> <?php echo $stats['total_minutes']; ?> min</p>
            <p><strong>RPE medio:</strong> <?php echo $stats['avg_rpe']; ?></p>
            <p><strong>Carga total acumulada:</strong> <?php echo $stats['total_load']; ?></p>
        </div>
    <?php endif; ?>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>