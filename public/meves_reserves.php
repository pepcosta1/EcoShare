<?php
// public/meves_reserves.php
// llista de les reserves de l'usuari, les pendents es poden cancel·lar

// comprovem que hagi fet login (funcio de includes/session.php)
require_once '../includes/session.php';
comprovarLogin();

require_once '../config/db.php';
require_once '../includes/functions.php';

try {
    // agafem les reserves de l'usuari de la sessio amb la marca i model del vehicle
    $sql = "SELECT reserva.*, vehicles.marca, vehicles.model FROM reserva
            JOIN vehicles ON reserva.vehicle_id = vehicles.id
            WHERE reserva.user_id = :user_id
            ORDER BY reserva.data_inici DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $_SESSION['user']['id']]);
    $reserves = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error en consultar la base de dades: " . $e->getMessage());
}

// la data d'ara per saber si una reserva ja ha passat
$ara = date('Y-m-d H:i');

require_once '../includes/header.php';
?>

<main class="site-main">
    <section class="main-container reserves-container">
        <h1>Les meves <span>reserves</span></h1>

        <!-- missatges que envia cancel_reserve.php -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'no_trobada'): ?>
            <p class="missatge missatge-error">No s'ha trobat la reserva.</p>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'ja_comencada'): ?>
            <p class="missatge missatge-error">No pots cancel·lar una reserva que ja ha començat.</p>
        <?php endif; ?>

        <?php if (isset($_GET['cancel'])): ?>
            <p class="missatge missatge-ok">Reserva cancel·lada correctament.</p>
        <?php endif; ?>

        <?php if (count($reserves) == 0): ?>
            <p>Encara no has fet cap reserva. <a href="cataleg.php">Mira el catàleg</a></p>
        <?php else: ?>
            <table class="taula-reserves">
                <tr>
                    <th>Vehicle</th>
                    <th>Inici</th>
                    <th>Fi</th>
                    <th>Estat</th>
                    <th></th>
                </tr>
                <?php foreach ($reserves as $r): ?>
                    <?php
                    // mirem en quin estat esta la reserva
                    if ($r['estat'] == 'cancel·lada') {
                        $estat = "Cancel·lada";
                        $classe = "estat-cancellada";
                    } elseif ($r['data_fi'] < $ara) {
                        $estat = "Finalitzada";
                        $classe = "estat-finalitzada";
                    } elseif ($r['data_inici'] <= $ara) {
                        $estat = "En curs";
                        $classe = "estat-encurs";
                    } else {
                        $estat = "Pendent";
                        $classe = "estat-pendent";
                    }
                    ?>
                    <tr>
                        <td><a href="vehicle_detail.php?id=<?= $r['vehicle_id'] ?>"><?= e($r['marca']) ?> <?= e($r['model']) ?></a></td>
                        <td><?= formatData($r['data_inici']) ?></td>
                        <td><?= formatData($r['data_fi']) ?></td>
                        <td><span class="estat <?= $classe ?>"><?= $estat ?></span></td>
                        <td>
                            <?php if ($estat == "Pendent"): ?>
                                <!-- es fa amb un form POST perque cancel·lar modifica la bbdd -->
                                <form action="cancel_reserve.php" method="POST" onsubmit="return confirm('Segur que vols cancel·lar la reserva?');">
                                    <input type="hidden" name="reserva_id" value="<?= $r['id'] ?>">
                                    <button type="submit" class="btn-cancelar">Cancel·lar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>
