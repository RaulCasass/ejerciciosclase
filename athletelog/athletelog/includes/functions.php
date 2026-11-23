<?php
declare(strict_types=1);

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function getSportsByCategory(array $sports, string $category): array
{
    $resultado = [];
    foreach ($sports as $key => $value) {
        if (isset($value['category']) && $value['category'] === $category) {
            $resultado[$key] = $value;
        }
    }
    return $resultado;
}

function requireLogin(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function validateTraining(array $input): array
{
    $errors = [];

    $date = trim($input['date'] ?? '');
    if ($date === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errors['date'] = 'La fecha es obligatoria y debe ser válida.';
    } elseif ($date > date('Y-m-d')) {
        $errors['date'] = 'La fecha no puede ser futura.';
    }

    $allowedTypes = ['Tecnica', 'Fuerza', 'Resistencia', 'Competencia', 'Recuperacion'];
    $type = $input['type'] ?? '';
    if (!in_array($type, $allowedTypes, true)) {
        $errors['type'] = 'Seleccione un tipo de sesión válido.';
    }

    $duration = filter_var($input['duration'] ?? '', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 5, 'max_range' => 360]
    ]);
    if ($duration === false) {
        $errors['duration'] = 'La duración debe estar entre 5 y 360 minutos.';
    }

    $rpe = filter_var($input['rpe'] ?? '', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 10]
    ]);
    if ($rpe === false) {
        $errors['rpe'] = 'El RPE debe ser un entero entre 1 y 10.';
    }

    $notes = trim($input['notes'] ?? '');
    if (mb_strlen($notes) > 200) {
        $errors['notes'] = 'Las sensaciones no pueden superar los 200 caracteres.';
    }

    $hasInjury = isset($input['has_injury']);
    $injuryText = trim($input['injury_text'] ?? '');
    if ($hasInjury && $injuryText === '') {
        $errors['injury'] = 'Debe describir la lesión o molestia indicada.';
    }

    return $errors;
}

function calculateLoad(int $duration, int $rpe): int
{
    return $duration * $rpe;
}

function ensureTrainingsCsv(string $file): bool
{
    $dir = dirname($file);
    if (!is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }

    if (!file_exists($file)) {
        $handle = @fopen($file, 'c+');
        if ($handle === false) {
            return false;
        }
        if (flock($handle, LOCK_EX)) {
            if (filesize($file) === 0) {
                fputcsv($handle, ['username', 'date', 'type', 'duration', 'rpe', 'notes', 'injury']);
            }
            flock($handle, LOCK_UN);
        }
        fclose($handle);
    }

    return is_readable($file);
}

function appendTrainingCsv(string $file, string $username, array $training): bool
{
    if (!ensureTrainingsCsv($file)) {
        return false;
    }

    $handle = @fopen($file, 'a');
    if ($handle === false) {
        return false;
    }

    $written = false;
    if (flock($handle, LOCK_EX)) {
        $row = [
            $username,
            (string)($training['date'] ?? ''),
            (string)($training['type'] ?? ''),
            (string)($training['duration'] ?? 0),
            (string)($training['rpe'] ?? 0),
            (string)($training['notes'] ?? ''),
            (string)($training['injury'] ?? 'Ninguna')
        ];
        $written = (fputcsv($handle, $row) !== false);
        flock($handle, LOCK_UN);
    }

    fclose($handle);
    return $written;
}

function readTrainings(string $file, string $username): array
{
    if (!ensureTrainingsCsv($file)) {
        return [];
    }

    $handle = @fopen($file, 'r');
    if ($handle === false) {
        return [];
    }

    $rows = [];
    if (flock($handle, LOCK_SH)) {
        $header = fgetcsv($handle);
        if (is_array($header) && count($header) > 0) {
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) !== count($header)) {
                    continue;
                }
                $assoc = array_combine($header, $data);
                if (is_array($assoc) && ($assoc['username'] ?? '') === $username) {
                    $assoc['duration'] = (int)($assoc['duration'] ?? 0);
                    $assoc['rpe'] = (int)($assoc['rpe'] ?? 0);
                    $assoc['load'] = calculateLoad($assoc['duration'], $assoc['rpe']);
                    $rows[] = $assoc;
                }
            }
        }
        flock($handle, LOCK_UN);
    }

    fclose($handle);
    return $rows;
}

function calculateTrainingStats(array $trainings): array
{
    $totalSessions = count($trainings);
    $totalMinutes = 0;
    $totalRpe = 0;
    $totalLoad = 0;

    foreach ($trainings as $t) {
        $duration = (int)($t['duration'] ?? 0);
        $rpe = (int)($t['rpe'] ?? 0);
        $totalMinutes += $duration;
        $totalRpe += $rpe;
        $totalLoad += isset($t['load']) ? (int)$t['load'] : calculateLoad($duration, $rpe);
    }

    return [
        'total_sessions' => $totalSessions,
        'total_minutes' => $totalMinutes,
        'avg_rpe' => $totalSessions > 0 ? round($totalRpe / $totalSessions, 1) : 0.0,
        'total_load' => $totalLoad
    ];
}

function summarizeByType(array $trainings): array
{
    $summary = [];
    foreach ($trainings as $t) {
        $type = (string)($t['type'] ?? 'Otro');
        if (!isset($summary[$type])) {
            $summary[$type] = [
                'sessions' => 0,
                'minutes' => 0
            ];
        }
        $summary[$type]['sessions']++;
        $summary[$type]['minutes'] += (int)($t['duration'] ?? 0);
    }
    return $summary;
}

function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function rotateCsrfToken(): string
{
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}

function clearCsrfToken(): void
{
    unset($_SESSION['csrf_token']);
}

function csrfField(): string
{
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
}

function verifyCsrfToken(?string $token): bool
{
    if (!is_string($token) || $token === '') {
        return false;
    }
    $stored = $_SESSION['csrf_token'] ?? '';
    if (!is_string($stored) || $stored === '') {
        return false;
    }
    return hash_equals($stored, $token);
}

function enforceCsrfToken(?string $token): void
{
    if (!verifyCsrfToken($token)) {
        http_response_code(403);
        echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>403 Forbidden</title></head><body>';
        echo '<h1>403 - Solicitud rechazada (Token CSRF no válido)</h1>';
        echo '<p>No se ha podido validar el origen de la petición.</p>';
        echo '</body></html>';
        exit;
    }
}