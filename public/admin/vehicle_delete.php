<?php
// public/admin/vehicle_delete.php
// esborra un vehicle (nomes admins i nomes per POST)

$ruta = "../";

require_once '../../includes/session.php';
comprovarAdmin($ruta);

require_once '../../config/db.php';
require_once '../../models/vehicle.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = (int) $_POST['id'];

    try {
        // les reserves d'aquest vehicle s'esborren soles pel ON DELETE CASCADE de la taula reserva
        esborrarVehicle($pdo, $id);

        header("Location: vehicles.php?esborrat=ok");
        exit();

    } catch (PDOException $e) {
        die("Error en esborrar el vehicle: " . $e->getMessage());
    }

} else {
    header("Location: vehicles.php");
    exit();
}
