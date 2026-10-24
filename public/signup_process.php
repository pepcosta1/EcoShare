<?php
// public/signup_process.php


require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/user.php';

//Comprovem que les dades s'hagin enviat per POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // en lloc de fer die() tornem al formulari amb l'error a la url
    if (empty($nom) || empty($email) || empty($password)) {
        header("Location: signup.php?error=camps_buits");
        exit;
    }

    // la contrasenya ha de tenir minim 6 caracters
    if (strlen($password) < 6) {
        header("Location: signup.php?error=password_curta");
        exit;
    }

    // si el correu ja existeix no el deixem registrar
    if (getUserByEmail($pdo, $email)) {
        header("Location: signup.php?error=correu_repetit");
        exit;
    }

    try {
        // la funcio crearUser fa el hash de la contrasenya i posa el rol 2 (usuari)
        crearUser($pdo, $nom, $email, $password);

        //si tot ok s'envia a la pagina de login amb el parametre de regisre ok perque la pagina login.php sapiga que a anat tot bé.
        header("Location: login.php?registre=ok");
        exit;

    } catch (PDOException $e) {
        die("Error en registrar l'usuari: " . $e->getMessage());
    }
} else {
    //si es vol entrar sense validar ni registrar es fa fora i es rediregeix a signup.php
    header("Location: signup.php");
    exit;
}
