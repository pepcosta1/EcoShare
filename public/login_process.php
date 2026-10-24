<?php
// 1. Iniciem la sessió (sempre a dalt de tot)
require_once '../includes/session.php';

require_once '../config/db.php';
require_once '../models/user.php';

//COMPROVEM QUE ES PASSIN PER POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    if (empty($email) || empty($password)) {
        header("Location: login.php?error=camps_buits");
        exit();
    }

    try {
        // BUSQUEM PER CORREU (funcio de models/user.php)
        $user = getUserByEmail($pdo, $email);

        // si no existeix l'usuari tornem al login
        if (!$user) {
            header("Location: login.php?error=credencials");
            exit();
        }

        // password_verify compara la contrasenya amb el hash de la bbdd
        if (!password_verify($password, $user['password'])) {
            header("Location: login.php?error=credencials");
            exit();
        }

        // canviem l'id de la sessio quan fa login (session fixation)
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'rol' => ($user['role_id'] == 1) ? 'admin' : 'user'
        ];

        $_SESSION['logged_in'] = true;

        // Redirigim a la pàgina principal
        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        // Si hi ha un error de base de dades
        die("Error en el procés de login: " . $e->getMessage());
    }

} else {
    // Si algú intenta entrar sense iniciar sessio
    header("Location: login.php");
    exit();
}
