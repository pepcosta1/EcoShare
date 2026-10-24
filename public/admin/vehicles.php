<?php
// public/admin/vehicles.php
// llista de tots els vehicles per l'administrador (editar i esborrar)

// estem dins de admin/ per aixo totes les rutes pugen una carpeta
$ruta = "../";

// nomes hi poden entrar els admins (funcio de includes/session.php)
require_once '../../includes/session.php';
comprovarAdmin($ruta);

require_once '../../config/db.php';
require_once '../../models/vehicle.php';

try {
    $vehicles = getVehicles($pdo);
} catch (PDOException $e) {
    die("Error en consultar la base de dades: " . $e->getMessage());
}

require_once '../../includes/header.php';
?>

<main class="site-main">
    <section class="main-container admin-container">
        <div class="admin-capcalera">
            <h1>Gestió de <span>vehicles</span></h1>
            <a href="vehicle_form.php" class="btn-detalls">+ Nou vehicle</a>
        </div>

        <!-- missatges que envien vehicle_form.php i vehicle_delete.php -->
        <?php if (isset($_GET['creat'])): ?>
            <p class="missatge missatge-ok">Vehicle creat correctament.</p>
        <?php endif; ?>
        <?php if (isset($_GET['editat'])): ?>
            <p class="missatge missatge-ok">Vehicle editat correctament.</p>
        <?php endif; ?>
        <?php if (isset($_GET['esborrat'])): ?>
            <p class="missatge missatge-ok">Vehicle esborrat correctament.</p>
        <?php endif; ?>

        <?php if (count($vehicles) == 0): ?>
            <p>No hi ha cap vehicle.</p>
        <?php else: ?>
            <table class="taula-reserves">
                <tr>
                    <th>ID</th>
                    <th>Imatge</th>
                    <th>Vehicle</th>
                    <th>Tipus</th>
                    <th>Preu</th>
                    <th></th>
                </tr>
                <?php foreach ($vehicles as $v): ?>
                    <tr>
                        <td><?= $v['id'] ?></td>
                        <td><img src="../../assets/img/<?= e($v['imatge_url']) ?>" alt="" class="admin-img"></td>
                        <td><?= e($v['marca']) ?> <?= e($v['model']) ?></td>
                        <td><?= e($v['tipus']) ?></td>
                        <td><?= e($v['preu_text']) ?></td>
                        <td class="admin-accions">
                            <a href="vehicle_form.php?id=<?= $v['id'] ?>" class="btn-editar">Editar</a>

                            <!-- esborrar per POST, no amb un enllaç -->
                            <form action="vehicle_delete.php" method="POST" onsubmit="return confirm('Segur que vols esborrar aquest vehicle? També s\'esborraran les seves reserves.');">
                                <input type="hidden" name="id" value="<?= $v['id'] ?>">
                                <button type="submit" class="btn-cancelar">Esborrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
