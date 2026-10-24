<?php

require_once __DIR__ . '/../includes/session.php';

// si ja esta logejat no te sentit que es registri
if (estaLogejat()) {
    header("Location: index.php");
    exit();
}

// aqui no hi ha el header, per aixo carreguem functions.php per tenir getTema() i e()
require_once __DIR__ . '/../includes/functions.php';

$theme = getTema();

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

<body data-theme="<?= e($theme) ?>">

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

            <!-- errors que envia signup_process.php -->
            <?php if (isset($_GET['error']) && $_GET['error'] == 'camps_buits'): ?>
                <p class="missatge missatge-error">Si us plau, omple tots els camps.</p>
            <?php endif; ?>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'password_curta'): ?>
                <p class="missatge missatge-error">La contrasenya ha de tenir mínim 6 caràcters.</p>
            <?php endif; ?>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'correu_repetit'): ?>
                <p class="missatge missatge-error">Aquest correu electrònic ja està registrat.</p>
            <?php endif; ?>
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
                    <input type="password" id="password" name="password" minlength="6" required>
                </div>
                <button id="btn-Registrar-Sessio" type="submit">Registrar-se</button>
                <a href="login.php">Ja tens compte? Inicia sessió aquí</a>
            </form>
        </div>
    </main>

    <?php require_once '../includes/footer.php'; //Carrega el footer dins del context d'index.php ?>