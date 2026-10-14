<?php
//config/db.php


try {
    //creem la conexio a la base de dades
    $pdo = new PDO('sqlite:' . __DIR__ . '/../database.sqlite');


    // configurem perque retorni en vermell els errors de la base de dades
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // fem que ens retorni arrays asociatius per defecte
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // active les claus foranes
    $pdo->exec("PRAGMA foreign_keys = ON;");


} catch (Exception $e) {
    die('Error de connexió a la base de dades: ' . $e->getMessage());
}
