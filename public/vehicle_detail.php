<?php
// public/vehicle_detail.php
// pagina amb la info d'un vehicle, el formulari per reservar i les reserves que te

// comprovem que hagi fet login (funcio de includes/session.php)
require_once '../includes/session.php';
comprovarLogin();

require_once '../config/db.php';
require_once '../models/vehicle.php';
require_once '../includes/functions.php';

// agafem l'id de la url (vehicle_detail.php?id=3)
$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

try {
    // busquem el vehicle (funcio de models/vehicle.php)
    $vehicle = getVehicle($pdo, $id);

    // si no existeix tornem al cataleg
    if (!$vehicle) {
        header("Location: cataleg.php");
        exit();
    }

    // reserves que te aquest vehicle i que encara no han acabat
    $sql = "SELECT * FROM reserva WHERE vehicle_id = :id AND estat = 'activa' AND data_fi >= :ara ORDER BY data_inici";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id, ':ara' => date('Y-m-d H:i')]);
    $reserves = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error en consultar la base de dades: " . $e->getMessage());
}

// missatge d'error que ens envia reserve.php per la url
$missatge_error = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] == 'camps_buits') {
        $missatge_error = "Has d'omplir les dues dates.";
    } elseif ($_GET['error'] == 'data_format') {
        $missatge_error = "El format de la data no és correcte.";
    } elseif ($_GET['error'] == 'data_passada') {
        $missatge_error = "No pots reservar en una data que ja ha passat.";
    } elseif ($_GET['error'] == 'data_ordre') {
        $missatge_error = "La data de fi ha de ser després de la d'inici.";
    } elseif ($_GET['error'] == 'massa_llarga') {
        $missatge_error = "Una reserva no pot durar més de 7 dies.";
    } elseif ($_GET['error'] == 'ocupat') {
        $missatge_error = "El vehicle ja està reservat en aquestes dates.";
    }
}

// data minima del formulari (ara), el datetime-local la vol amb una T al mig
$min = date('Y-m-d\TH:i');

require_once '../includes/header.php';
?>

<main class="site-main">
    <a href="cataleg.php" class="link-tornar">← Tornar al catàleg</a>

    <div class="detail-container">

        <!-- info del vehicle -->
        <article class="vehicle-card">
            <div class="vehicle-image-container">
                <img src="../assets/img/<?= e($vehicle['imatge_url']) ?>" alt="<?= e($vehicle['marca']) ?>">
            </div>
            <div class="vehicle-info">
                <span class="vehicle-brand"><?= e($vehicle['marca']) ?></span>
                <h1 class="vehicle-model"><?= e($vehicle['model']) ?></h1>

                <div class="vehicle-specs">
                    <span class="spec-item"><?= e($vehicle['tipus']) ?></span>
                    <span class="spec-item"><?= e($vehicle['categoria']) ?></span>
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
            </div>
        </article>

        <div class="detail-side">

            <!-- formulari de reserva -->
            <section class="main-container">
                <h2>Reserva aquest vehicle</h2>

                <?php if ($missatge_error != ""): ?>
                    <p class="missatge missatge-error"><?= $missatge_error ?></p>
                <?php endif; ?>

                <?php if (isset($_GET['reserva'])): ?>
                    <p class="missatge missatge-ok">Reserva feta correctament!</p>
                <?php endif; ?>

                <form action="reserve.php" method="POST" class="form-reserva">
                    <!-- input amagat amb l'id del vehicle per saber quin reservem -->
                    <input type="hidden" name="vehicle_id" value="<?= $vehicle['id'] ?>">
                    <div>
                        <label for="data_inici">Data i hora d'inici:</label>
                        <input type="datetime-local" id="data_inici" name="data_inici" min="<?= $min ?>" required>
                    </div>
                    <div>
                        <label for="data_fi">Data i hora de fi:</label>
                        <input type="datetime-local" id="data_fi" name="data_fi" min="<?= $min ?>" required>
                    </div>
                    <button type="submit" class="btn-detalls">Reservar</button>
                </form>
            </section>

            <!-- reserves que ja te el vehicle -->
            <section class="main-container">
                <h2>Pròximes reserves</h2>

                <?php if (count($reserves) == 0): ?>
                    <p>Aquest vehicle no té cap reserva, està lliure!</p>
                <?php else: ?>
                    <table class="taula-reserves">
                        <tr>
                            <th>Inici</th>
                            <th>Fi</th>
                            <th>Qui</th>
                        </tr>
                        <?php foreach ($reserves as $r): ?>
                            <tr>
                                <td><?= formatData($r['data_inici']) ?></td>
                                <td><?= formatData($r['data_fi']) ?></td>
                                <td>
                                    <?php
                                    // no ensenyem el nom dels altres usuaris, nomes si es teva
                                    if ($r['user_id'] == $_SESSION['user']['id']) {
                                        echo "Tu";
                                    } else {
                                        echo "Ocupat";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </section>

        </div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
