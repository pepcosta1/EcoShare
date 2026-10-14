<?php
// public/signup_process.php


require_once __DIR__ . '/../config/db.php';

//Comprovem que les dades s'hagin enviat per POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nom) || empty($email) || empty($password)) {
        die("Si usplau, omple tots els camps obligatoris.");
    }

    //xifrem per hash la contrasenya
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    try {
        // prepearem la consula, posem a rol_id 2 com a default que es l'usuari.
        $sql = "INSERT INTO user (nom, email, password, role_id) VALUES (:nom, :email, :password, :role_id)";
        $stmt = $pdo->prepare($sql);

        // Executem passant els paràmetres de forma segura
        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':password' => $password_hash,
            ':role_id' => 2
        ]);

        //si tot ok s'envia a la pagina de login amb el parametre de regisre ok perque la pagina login.php sapiga que a anat tot bé.
        header("Location: login.php?registre=ok");
        exit;

    } catch (PDOException $e) {
        // Si el correu ja existeix la bbdd llançara un error de uniqe.
        if ($e->getCode() == 23000 || str_contains($e->getMessage(), 'UNIQUE')) {
            die("Aquest correu electrònic ja està registrat.");
        } else {
            die("Error en registrar l'usuari: " . $e->getMessage());
        }
    }
} else {
    //si es vol entrar sense validar ni registrar es fa fora i es rediregeix a signup.php
    header("Location: signup.php");
    exit;
}
