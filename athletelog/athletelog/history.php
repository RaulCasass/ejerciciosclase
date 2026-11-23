<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
requireLogin();

$csvFile = __DIR__ . '/data/trainings.csv';
$username = (string)$_SESSION['user']['username'];

$sessionTypes = [
    'Tecnica' => 'Técnica',
    'Fuerza' => 'Fuerza',
    'Resistencia' => 'Resistencia',
    'Competencia' => 'Competición',
    'Recuperacion' => 'Recuperación'
];

$userTrainings = readTrainings($csvFile, $username);

if (isset($_GET['download']) && $_GET['download'] === '1') {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="historial_' . preg_replace('/[^a-zA-Z0-9_-]/', '', $username) . '.csv"');

    $out = fopen('php://output', 'w');
    if ($out !== false) {
        fputcsv($out, ['date', 'type', 'duration', 'rpe', 'load', 'notes', 'injury']);
        foreach ($userTrainings as $tr) {
            fputcsv($out, [
                $tr['date'] ?? '',
                $tr['type'] ?? '',
                $tr['duration'] ?? 0,
                $tr['rpe'] ?? 0,
                $tr['load'] ?? 0,
                $tr['notes'] ?? '',
                $tr['injury'] ?? ''
            ]);
        }
        fclose($out);
    }
    exit;
}

$pageTitle = "Historial - " . APP_NAME;
$selectedType = $_GET['type'] ?? '';
if (!array_key_exists($selectedType, $sessionTypes)) {
    $selectedType = '';
}

$filteredTrainings = $userTrainings;
if ($selectedType !== '') {
    $filteredTrainings = array_values(array_filter(
        $userTrainings,
        fn(array $row): bool => ($row['type'] ?? '') === $selectedType
    ));
}

usort($filteredTrainings, function (array $a, array $b): int {
    return strcmp((string)($b['date'] ?? ''), (string)($a['date'] ?? ''));
});

$stats = calculateTrainingStats($filteredTrainings);
$typeSummary = summarizeByType($userTrainings);

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="container">
    <h2>Historial de Entrenamientos de <?php echo e((string)$_SESSION['user']['name']); ?></h2>

    <div style="margin-bottom: 1.5rem;">
        <a href="history.php?download=1" class="btn-submit" style="display: inline-block; width: auto; text-decoration: none;">
            Descargar mi historial (CSV)
        </a>
    </div>

    <form action="history.php" method="GET" class="form" style="margin-bottom: 1.5rem;">
        <div class="form-group">
            <label for="type">Filtrar por tipo de sesión:</label>
            <select id="type" name="type">
                <option value="">Todos los tipos</option>
                <?php foreach ($sessionTypes as $k => $v): ?>
                    <option value="<?php echo e($k); ?>" <?php echo ($selectedType === $k) ? 'selected' : ''; ?>>
                        <?php echo e($v); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn-submit" style="width: auto;">Aplicar filtro</button>
    </form>

    <?php if (empty($filteredTrainings)): ?>
        <p>No hay entrenamientos para mostrar con el filtro seleccionado.</p>
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
                <?php foreach ($filteredTrainings as $tr): ?>
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
            <h4>Estadísticas (vista actual)</h4>
            <p><strong>Total de sesiones:</strong> <?php echo $stats['total_sessions']; ?></p>
            <p><strong>Minutos totales:</strong> <?php echo $stats['total_minutes']; ?> min</p>
            <p><strong>RPE medio:</strong> <?php echo $stats['avg_rpe']; ?></p>
            <p><strong>Carga total acumulada:</strong> <?php echo $stats['total_load']; ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($typeSummary)): ?>
        <h3 style="margin-top: 2rem;">Resumen por Tipo de Sesión (Total del usuario)</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Sesiones</th>
                    <th>Minutos totales</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($typeSummary as $typeKey => $item): ?>
                    <tr>
                        <td><?php echo e($sessionTypes[$typeKey] ?? $typeKey); ?></td>
                        <td><?php echo (int)$item['sessions']; ?></td>
                        <td><?php echo (int)$item['minutes']; ?> min</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>