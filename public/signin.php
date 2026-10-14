<?php

$theme = $_COOKIE['theme'] ?? 'light';

?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoShare Girona - Vehicles Elèctrics Compartits</title>
    <!-- Carreguem el fitxer de CSS principal -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Carreguem el JS en mode defer perquè no bloquegi la càrrega de l'HTML -->
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
            <h1 id="h1-Iniciar-Sessio">Iniciar <span>Sessió</span></h1>
            <form action="login_process.php" method="POST">
                <div>
                    <label id="label-email-label" for="email">Correu Electrònic:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label id="label-password-label" for="password">Contrasenya:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button id="btn-Iniciar-Sessio" type="submit">Iniciar Sessió</button>
                <a href="signup.php">No tens compte? Registra't aquí</a>
            </form>
        </div>
    </main>
    <?php require_once '../includes/footer.php'; //Carrega el footer dins del context d'index.php ?>