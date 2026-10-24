<?php
// public/cancel_reserve.php
// cancel·la una reserva de l'usuari (no l'esborrem, li canviem l'estat)

// comprovem que hagi fet login (funcio de includes/session.php)
require_once '../includes/session.php';
comprovarLogin();

require_once '../config/db.php';
require_once '../includes/functions.php';

// nomes per POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reserva_id = (int) $_POST['reserva_id'];

    try {
        // busquem la reserva pero nomes si es de l'usuari que esta logejat
        // aixi si algu canvia l'id del input hidden no pot cancel·lar la d'un altre
        $sql = "SELECT * FROM reserva WHERE id = :id AND user_id = :user_id AND estat = 'activa'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $reserva_id,
            ':user_id' => $_SESSION['user']['id']
        ]);
        $reserva = $stmt->fetch();

        if (!$reserva) {
            header("Location: meves_reserves.php?error=no_trobada");
            exit();
        }

        // si ja ha començat no es pot cancel·lar
        if ($reserva['data_inici'] <= date('Y-m-d H:i')) {
            header("Location: meves_reserves.php?error=ja_comencada");
            exit();
        }

        // fem UPDATE i no DELETE perque aixi queda guardat l'historial
        $stmt = $pdo->prepare("UPDATE reserva SET estat = 'cancel·lada' WHERE id = :id");
        $stmt->execute([':id' => $reserva_id]);

        header("Location: meves_reserves.php?cancel=ok");
        exit();

    } catch (PDOException $e) {
        die("Error en cancel·lar la reserva: " . $e->getMessage());
    }

} else {
    header("Location: meves_reserves.php");
    exit();
}
