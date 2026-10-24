<?php
// public/reserve.php
// aqui arriba el formulari de vehicle_detail.php i es guarda la reserva

// comprovem que hagi fet login (funcio de includes/session.php)
require_once '../includes/session.php';
comprovarLogin();

require_once '../config/db.php';
require_once '../models/vehicle.php';
require_once '../includes/functions.php';

//comprovem que es passi per POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $vehicle_id = (int) $_POST['vehicle_id'];
    $data_inici = $_POST['data_inici'];
    $data_fi = $_POST['data_fi'];

    // si hi ha algun error tornem a la pagina del vehicle
    $tornar = "vehicle_detail.php?id=" . $vehicle_id;

    if (empty($data_inici) || empty($data_fi)) {
        header("Location: $tornar&error=camps_buits");
        exit();
    }

    // strtotime passa la data a segons, aixi podem comparar-les
    // si la data no es valida retorna false
    $inici = strtotime($data_inici);
    $fi = strtotime($data_fi);

    if ($inici === false || $fi === false) {
        header("Location: $tornar&error=data_format");
        exit();
    }

    // el input datetime-local envia la data aixi: 2026-10-25T10:00
    // la tornem a escriure amb date() perque a la bbdd quedi sempre igual: 2026-10-25 10:00
    $data_inici = date('Y-m-d H:i', $inici);
    $data_fi = date('Y-m-d H:i', $fi);

    // no es pot reservar en el passat (el min del html es pot treure amb l'inspector)
    if ($inici < time()) {
        header("Location: $tornar&error=data_passada");
        exit();
    }

    // la data de fi ha de ser despres de la d'inici
    if ($fi <= $inici) {
        header("Location: $tornar&error=data_ordre");
        exit();
    }

    // maxim 7 dies (7 dies * 24 hores * 60 minuts * 60 segons)
    if ($fi - $inici > 7 * 24 * 60 * 60) {
        header("Location: $tornar&error=massa_llarga");
        exit();
    }

    try {
        // mirem que el vehicle existeixi (funcio de models/vehicle.php)
        $vehicle = getVehicle($pdo, $vehicle_id);

        if (!$vehicle) {
            header("Location: cataleg.php");
            exit();
        }

        // mirem si el vehicle ja esta reservat en aquestes hores
        // es solapen si l'altra reserva comença abans que acabi la meva i acaba despres que comenci la meva
        $sql = "SELECT * FROM reserva WHERE vehicle_id = :vehicle_id AND estat = 'activa'
                AND data_inici < :data_fi AND data_fi > :data_inici";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':vehicle_id' => $vehicle_id,
            ':data_inici' => $data_inici,
            ':data_fi' => $data_fi
        ]);
        $ocupat = $stmt->fetch();

        if ($ocupat) {
            header("Location: $tornar&error=ocupat");
            exit();
        }

        // si tot esta be guardem la reserva
        $sql = "INSERT INTO reserva (user_id, vehicle_id, data_inici, data_fi) VALUES (:user_id, :vehicle_id, :data_inici, :data_fi)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $_SESSION['user']['id'],
            ':vehicle_id' => $vehicle_id,
            ':data_inici' => $data_inici,
            ':data_fi' => $data_fi
        ]);

        header("Location: $tornar&reserva=ok");
        exit();

    } catch (PDOException $e) {
        die("Error en guardar la reserva: " . $e->getMessage());
    }

} else {
    // si algu entra directament el tornem al cataleg
    header("Location: cataleg.php");
    exit();
}
