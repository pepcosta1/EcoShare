<?php
// models/user.php
// consultes SQL de la taula user

// busca un usuari pel correu, si no el troba retorna false
function getUserByEmail($pdo, $email)
{
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch();
}

// crea un usuari nou amb la contrasenya ja xifrada
// el role_id 2 es el d'usuari normal
function crearUser($pdo, $nom, $email, $password)
{
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO user (nom, email, password, role_id) VALUES (:nom, :email, :password, 2)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':email' => $email,
        ':password' => $password_hash
    ]);
}
