<?php
declare(strict_types=1);

$currentTheme = $_COOKIE['theme'] ?? 'light';
$themeClass = ($currentTheme === 'dark') ? 'theme-dark' : 'theme-light';

if (!defined('APP_NAME')) {
    define('APP_NAME', 'AthleteLog');
}
if (!isset($pageTitle)) {
    $pageTitle = APP_NAME;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars((string)$pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body class="<?php echo htmlspecialchars($themeClass, ENT_QUOTES, 'UTF-8'); ?>">