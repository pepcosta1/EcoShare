<?php
require_once '../includes/session.php';

// si ja esta logejat el redirigim a index.php, no pot estar aqui.
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
    <!-- Carreguem el fitxer de CSS principal -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Carreguem el JS en mode defer perquè no bloquegi la càrrega de l'HTML -->
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
            <h1 id="h1-Iniciar-Sessio">Iniciar <span>Sessió</span></h1>
            <!-- missatges que venen de login_process.php i signup_process.php -->
            <?php if (isset($_GET['error'])): ?>
                <p class="missatge missatge-error">Correu o contrasenya incorrectes.</p>
            <?php endif; ?>
            <?php if (isset($_GET['registre'])): ?>
                <p class="missatge missatge-ok">Compte creat correctament! Ja pots iniciar sessió.</p>
            <?php endif; ?>
            <form action="login_process.php" method="POST">
                <div>
                    <label id="email-label" for="email">Correu Electrònic:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label id="password-label" for="password">Contrasenya:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button id="btn-Iniciar-Sessio" type="submit">Iniciar Sessió</button>
                <a href="signup.php">No tens compte? Registra't aquí</a>
            </form>
        </div>
    </main>
    <?php require_once '../includes/footer.php'; //Carrega el footer dins del context d'index.php ?>