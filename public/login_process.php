<?php
// 1. Iniciem la sessió (sempre a dalt de tot)
session_start();

require_once '../config/db.php';

//COMPROVEM QUE ES PASSIN PER POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    if (empty($email) || empty($password)) {
        header("Location: login.php?error=camps_buits");
        exit();
    }

    try {
        // BUSQUEM PER CORREU
        $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        //verifiquem que existeixi i que la contrasenya coincideixi
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'rol' => ($user['role_id'] == 1) ? 'admin' : 'user'
            // ^ Si a la teva BDD el role_id de l'admin és un 1, aquí ho convertim al text 'admin' que busca el teu header
        ];

        $_SESSION['logged_in'] = true; // Mantendim aquesta per als dominis o bloquejos de pàgina

        // Redirigim a la pàgina principal
        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        // Si hi ha un error de base de dades
        die("Error en el procés de login: " . $e->getMessage());
    }

} else {
    // Si algú intenta entrar a aquest fitxer directament sense passar pel formulari
    header("Location: login.php");
    exit();
}
