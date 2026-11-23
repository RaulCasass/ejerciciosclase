<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = "Inicio - AthleteLog";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="container">
    <section class="hero">
        <h1>Bienvenido a AthleteLog</h1>
        <p>El progreso no depende de entrenar mucho, sino de entrenar con método.</p>
    </section>

    <section class="sports-preview">
        <h2>Deportes Disponibles</h2>
        
        <?php 
        $individualSports = getSportsByCategory($sports, 'individual');
        $teamSports = getSportsByCategory($sports, 'equipo');
        ?>

        <h3>Deportes Individuales</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Deporte</th>
                    <th>Unidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($individualSports as $sport): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sport['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($sport['unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Deportes de Equipo</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Deporte</th>
                    <th>Unidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teamSports as $sport): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sport['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($sport['unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>