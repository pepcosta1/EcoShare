<?php
// la sessio es comprova abans del header, perque si ja s'ha enviat html el header("Location") no funciona
// comprovem que hagi fet login (funcio de includes/session.php)
require_once '../includes/session.php';
comprovarLogin();

require_once '../config/db.php';
require_once '../models/vehicle.php';

// mirem si s'ha clicat algun filtre (cataleg.php?tipus=1)
$tipus_filtrat = 0;
if (isset($_GET['tipus'])) {
    $tipus_filtrat = (int) $_GET['tipus'];
}

try {
    // les funcions son de models/vehicle.php
    // si $tipus_filtrat es 0 retorna tots els vehicles
    $vehicles = getVehicles($pdo, $tipus_filtrat);

    // els tipus per fer els botons del filtre
    $tipus_vehicles = getTipus($pdo);

} catch (PDOException $e) {
    die("Error en consultar la base de dades: " . $e->getMessage());
}

require_once '../includes/header.php';
?>

<main class="site-main">

    <!-- botons per filtrar per tipus -->
    <div class="filter-buttons">
        <a href="cataleg.php" class="btn-filtre">Tots</a>
        <?php foreach ($tipus_vehicles as $t): ?>
            <a href="cataleg.php?tipus=<?= $t['id'] ?>" class="btn-filtre"><?= e($t['nom']) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="vehicle-container">
        <?php if (count($vehicles) == 0): ?>
            <p>No s'ha trobat cap vehicle d'aquest tipus.</p>
        <?php endif; ?>

        <?php foreach ($vehicles as $vehicle): ?>
            <article class="vehicle-card">
                <div class="vehicle-image-container">
                    <img src="../assets/img/<?= e($vehicle['imatge_url']) ?>" alt="<?= e($vehicle['marca']) ?>" class="vehicle-img">
                </div>

                <div class="vehicle-info">
                    <span class="vehicle-brand"><?= e($vehicle['marca']) ?></span>
                    <h2 class="vehicle-model"><?= e($vehicle['model']) ?></h2>

                    <div class="vehicle-specs">
                        <span class="spec-item"><?= e($vehicle['tipus']) ?></span>

                        <!-- l'etiqueta pot ser "0" (zero emissions) per aixo no fem servir empty() -->
                        <?php if ($vehicle['etiqueta'] != "" && $vehicle['etiqueta'] != "No cal"): ?>
                            <span class="spec-item">Etiqueta <?= e($vehicle['etiqueta']) ?></span>
                        <?php endif; ?>

                        <?php if ($vehicle['autonomia_electrica'] > 0): ?>
                            <span class="spec-item"><?= e($vehicle['autonomia_electrica']) ?> km d'autonomia</span>
                        <?php endif; ?>

                        <?php if ($vehicle['maleter'] > 0): ?>
                            <span class="spec-item"><?= e($vehicle['maleter']) ?> L de maleter</span>
                        <?php endif; ?>
                    </div>

                    <div class="vehicle-price-container">
                        <span class="price-label">Preu</span>
                        <span class="vehicle-price"><?= e($vehicle['preu_text']) ?></span>
                    </div>

                    <a href="vehicle_detail.php?id=<?= $vehicle['id'] ?>" class="btn-detalls">Veure i reservar</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
