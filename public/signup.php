<?php

require_once __DIR__ . '/../config/db.php';

$theme = $_COOKIE['theme'] ?? 'light';

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoShare Girona - Vehicles Elèctrics Compartits</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/main.js" defer></script>
</head>

<body data-theme="<?= htmlspecialchars($theme) ?>">

    <header class="site-header">
        <div class="header-container">
            <!-- Logo i Nom del projecte -->
            <a href="index.php" class="logo">
                ⚡ <span>EcoShare</span> Girona
            </a>

            <!-- Botó per canviar entre Mode Clar / Mode Fosc -->
            <button id="theme-toggle" class="btn-theme" title="Canviar tema">
                🌙
            </button>
        </div>
    </header>
    <main class="site-main">
        <div class="main-container">
            <h1 id="h1-Registrar-Sessio">Registrar <span>Usuari</span></h1>
            <form action="signup_process.php" method="POST">
                <div>
                    <label id="nom-label" for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div>
                    <label id="email-label" for="email">Correu Electrònic:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label id="password-label" for="password">Contrasenya:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button id="btn-Registrar-Sessio" type="submit">Registrar-se</button>
                <a href="login.php">Ja tens compte? Inicia sessió aquí</a>
            </form>
        </div>
    </main>

    <?php require_once '../includes/footer.php'; //Carrega el footer dins del context d'index.php ?>