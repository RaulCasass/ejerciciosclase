<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido. Use POST.';
    exit;
}

enforceCsrfToken($_POST['csrf_token'] ?? null);

$csvFile = __DIR__ . '/data/trainings.csv';
$username = (string)$_SESSION['user']['username'];
$index = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

if ($index !== false && file_exists($csvFile)) {
    $handle = @fopen($csvFile, 'c+');
    if ($handle !== false) {
        if (flock($handle, LOCK_EX)) {
            $allRows = [];
            while (($row = fgetcsv($handle)) !== false) {
                $allRows[] = $row;
            }
            if (!empty($allRows)) {
                $header = array_shift($allRows);
                $userMatchCount = 0;
                $keptRows = [$header];

                foreach ($allRows as $r) {
                    if (($r[0] ?? '') === $username) {
                        if ($userMatchCount !== $index) {
                            $keptRows[] = $r;
                        }
                        $userMatchCount++;
                    } else {
                        $keptRows[] = $r;
                    }
                }

                ftruncate($handle, 0);
                rewind($handle);
                foreach ($keptRows as $kr) {
                    fputcsv($handle, $kr);
                }
            }
            flock($handle, LOCK_UN);
        }
        fclose($handle);
    }
}

header('Location: history.php');
exit;