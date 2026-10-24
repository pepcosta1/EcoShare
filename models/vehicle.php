<?php
// models/vehicle.php
// consultes SQL de la taula vehicles (CRUD)

// tots els vehicles amb el nom del tipus
// si $tipus_id es mes gran que 0 nomes els d'aquell tipus
function getVehicles($pdo, $tipus_id = 0)
{
    if ($tipus_id > 0) {
        $sql = "SELECT vehicles.*, tipus_vehicle.nom AS tipus FROM vehicles
                JOIN tipus_vehicle ON vehicles.tipus_id = tipus_vehicle.id
                WHERE vehicles.tipus_id = :tipus_id
                ORDER BY vehicles.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tipus_id' => $tipus_id]);
    } else {
        $sql = "SELECT vehicles.*, tipus_vehicle.nom AS tipus FROM vehicles
                JOIN tipus_vehicle ON vehicles.tipus_id = tipus_vehicle.id
                ORDER BY vehicles.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    return $stmt->fetchAll();
}

// un vehicle pel seu id, si no existeix retorna false
function getVehicle($pdo, $id)
{
    $sql = "SELECT vehicles.*, tipus_vehicle.nom AS tipus FROM vehicles
            JOIN tipus_vehicle ON vehicles.tipus_id = tipus_vehicle.id
            WHERE vehicles.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

// tots els tipus (Cotxe, Moto...) per als filtres i el select del formulari
function getTipus($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM tipus_vehicle ORDER BY id");
    $stmt->execute();
    return $stmt->fetchAll();
}

// crea un vehicle nou. $dades es l'array amb els camps del formulari
function crearVehicle($pdo, $dades)
{
    $sql = "INSERT INTO vehicles (marca, model, categoria, tipus_id, etiqueta, autonomia_electrica, maleter, preu_text, imatge_url, detalls_url)
            VALUES (:marca, :model, :categoria, :tipus_id, :etiqueta, :autonomia_electrica, :maleter, :preu_text, :imatge_url, :detalls_url)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($dades);
}

// edita un vehicle que ja existeix
function editarVehicle($pdo, $id, $dades)
{
    $sql = "UPDATE vehicles SET marca = :marca, model = :model, categoria = :categoria, tipus_id = :tipus_id,
            etiqueta = :etiqueta, autonomia_electrica = :autonomia_electrica, maleter = :maleter,
            preu_text = :preu_text, imatge_url = :imatge_url, detalls_url = :detalls_url
            WHERE id = :id";
    $dades[':id'] = $id;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($dades);
}

// esborra un vehicle (les seves reserves tambe s'esborren pel ON DELETE CASCADE)
function esborrarVehicle($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM vehicles WHERE id = :id");
    $stmt->execute([':id' => $id]);
}
