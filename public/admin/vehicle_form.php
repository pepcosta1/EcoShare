<?php
// public/admin/vehicle_form.php
// formulari per crear un vehicle nou o editar-ne un
// si la url porta ?id=3 es editar, si no es crear

$ruta = "../";

require_once '../../includes/session.php';
comprovarAdmin($ruta);

require_once '../../config/db.php';
require_once '../../models/vehicle.php';

// mirem si estem editant
$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

$error = "";

// valors per defecte del formulari (buits per un vehicle nou)
$vehicle = [
    'marca' => '',
    'model' => '',
    'categoria' => '',
    'tipus_id' => 1,
    'etiqueta' => '',
    'autonomia_electrica' => '',
    'maleter' => '',
    'preu_text' => '',
    'imatge_url' => '',
    'detalls_url' => ''
];

try {
    $tipus = getTipus($pdo);

    // si editem carreguem les dades del vehicle per omplir el formulari
    if ($id > 0) {
        $vehicle = getVehicle($pdo, $id);
        if (!$vehicle) {
            header("Location: vehicles.php");
            exit();
        }
    }

    // ---------- quan s'envia el formulari ----------
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // guardem el que ha escrit l'usuari, aixi si hi ha error no ho ha de tornar a escriure
        $vehicle['marca'] = trim($_POST['marca']);
        $vehicle['model'] = trim($_POST['model']);
        $vehicle['categoria'] = trim($_POST['categoria']);
        $vehicle['tipus_id'] = (int) $_POST['tipus_id'];
        $vehicle['etiqueta'] = trim($_POST['etiqueta']);
        $vehicle['autonomia_electrica'] = (int) $_POST['autonomia_electrica'];
        $vehicle['maleter'] = (int) $_POST['maleter'];
        $vehicle['preu_text'] = trim($_POST['preu_text']);
        $vehicle['imatge_url'] = trim($_POST['imatge_url']);
        $vehicle['detalls_url'] = trim($_POST['detalls_url']);

        // mirem que el tipus que ens envien existeixi a la taula tipus_vehicle
        $tipus_correcte = false;
        foreach ($tipus as $t) {
            if ($t['id'] == $vehicle['tipus_id']) {
                $tipus_correcte = true;
            }
        }

        // validacions
        if (empty($vehicle['marca']) || empty($vehicle['model'])) {
            $error = "La marca i el model són obligatoris.";
        } elseif (!$tipus_correcte) {
            $error = "El tipus de vehicle no és correcte.";
        } elseif ($vehicle['autonomia_electrica'] < 0 || $vehicle['maleter'] < 0) {
            $error = "L'autonomia i el maleter no poden ser negatius.";
        }

        // si han pujat una imatge la guardem a assets/img
        if ($error == "" && isset($_FILES['imatge']) && $_FILES['imatge']['error'] == 0) {
            $nom_fitxer = basename($_FILES['imatge']['name']);
            $extensio = strtolower(pathinfo($nom_fitxer, PATHINFO_EXTENSION));

            // nomes deixem pujar imatges
            if ($extensio != 'png' && $extensio != 'jpg' && $extensio != 'jpeg' && $extensio != 'webp') {
                $error = "La imatge ha de ser png, jpg o webp.";
            } elseif ($_FILES['imatge']['size'] > 2 * 1024 * 1024) {
                $error = "La imatge no pot pesar més de 2 MB.";
            } elseif (@getimagesize($_FILES['imatge']['tmp_name']) === false) {
                // getimagesize mira si de veritat es una imatge (no nomes l'extensio)
                // la @ amaga l'avis que dona php quan el fitxer no es una imatge
                $error = "El fitxer no és una imatge.";
            } else {
                // posem time() davant del nom perque no es xafi amb una altra imatge que es digui igual
                $nom_nou = time() . "_" . $nom_fitxer;
                move_uploaded_file($_FILES['imatge']['tmp_name'], "../../assets/img/" . $nom_nou);
                $vehicle['imatge_url'] = $nom_nou;
            }
        }

        // si no hi ha cap error guardem
        if ($error == "") {
            $dades = [
                ':marca' => $vehicle['marca'],
                ':model' => $vehicle['model'],
                ':categoria' => $vehicle['categoria'],
                ':tipus_id' => $vehicle['tipus_id'],
                ':etiqueta' => $vehicle['etiqueta'],
                ':autonomia_electrica' => $vehicle['autonomia_electrica'],
                ':maleter' => $vehicle['maleter'],
                ':preu_text' => $vehicle['preu_text'],
                ':imatge_url' => $vehicle['imatge_url'],
                ':detalls_url' => $vehicle['detalls_url']
            ];

            if ($id > 0) {
                editarVehicle($pdo, $id, $dades);
                header("Location: vehicles.php?editat=ok");
            } else {
                crearVehicle($pdo, $dades);
                header("Location: vehicles.php?creat=ok");
            }
            exit();
        }
    }

} catch (PDOException $e) {
    die("Error amb la base de dades: " . $e->getMessage());
}

require_once '../../includes/header.php';
?>

<main class="site-main">
    <section class="main-container admin-form">
        <a href="vehicles.php" class="link-tornar">← Tornar a la llista</a>

        <?php if ($id > 0): ?>
            <h1>Editar <span>vehicle</span></h1>
        <?php else: ?>
            <h1>Nou <span>vehicle</span></h1>
        <?php endif; ?>

        <?php if ($error != ""): ?>
            <p class="missatge missatge-error"><?= $error ?></p>
        <?php endif; ?>

        <!-- enctype multipart/form-data es necessari per poder pujar fitxers -->
        <form method="POST" enctype="multipart/form-data" class="form-reserva">
            <div>
                <label for="marca">Marca *</label>
                <input type="text" id="marca" name="marca" value="<?= e($vehicle['marca']) ?>" required>
            </div>
            <div>
                <label for="model">Model *</label>
                <input type="text" id="model" name="model" value="<?= e($vehicle['model']) ?>" required>
            </div>
            <div>
                <label for="tipus_id">Tipus *</label>
                <select id="tipus_id" name="tipus_id">
                    <?php foreach ($tipus as $t): ?>
                        <option value="<?= $t['id'] ?>" <?php if ($t['id'] == $vehicle['tipus_id']) echo "selected"; ?>>
                            <?= e($t['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="categoria">Categoria (SUV, e-Bike...)</label>
                <input type="text" id="categoria" name="categoria" value="<?= e($vehicle['categoria']) ?>">
            </div>
            <div>
                <label for="etiqueta">Etiqueta DGT</label>
                <input type="text" id="etiqueta" name="etiqueta" value="<?= e($vehicle['etiqueta']) ?>">
            </div>
            <div>
                <label for="autonomia_electrica">Autonomia (km)</label>
                <input type="number" id="autonomia_electrica" name="autonomia_electrica" min="0" value="<?= e($vehicle['autonomia_electrica']) ?>">
            </div>
            <div>
                <label for="maleter">Maleter (litres)</label>
                <input type="number" id="maleter" name="maleter" min="0" value="<?= e($vehicle['maleter']) ?>">
            </div>
            <div>
                <label for="preu_text">Preu (text)</label>
                <input type="text" id="preu_text" name="preu_text" value="<?= e($vehicle['preu_text']) ?>">
            </div>
            <div>
                <label for="imatge">Imatge (png, jpg o webp, màxim 2 MB)</label>
                <?php if ($vehicle['imatge_url'] != ""): ?>
                    <img src="../../assets/img/<?= e($vehicle['imatge_url']) ?>" alt="" class="admin-img">
                <?php endif; ?>
                <input type="file" id="imatge" name="imatge" accept=".png,.jpg,.jpeg,.webp">
                <!-- si no pugen cap imatge nova es queda la que hi havia -->
                <input type="hidden" name="imatge_url" value="<?= e($vehicle['imatge_url']) ?>">
            </div>
            <div>
                <label for="detalls_url">Web del fabricant</label>
                <input type="url" id="detalls_url" name="detalls_url" value="<?= e($vehicle['detalls_url']) ?>">
            </div>

            <button type="submit" class="btn-detalls">Guardar</button>
        </form>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
