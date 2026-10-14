<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

            <!-- Menú de navegació -->
            <nav class="main-nav">
                <ul>
                    <li><a href="../public/index.php">Inici</a></li>
                    <li><a href="../public/cataleg.php">Catàleg</a></li>

                    <?php if (isset($_SESSION['user'])): ?>
                        <!-- Opcions per a usuaris autenticats -->
                        <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                            <li><a href="../public/vehicle.php" class="nav-admin">🛠️ Gestió Admin</a></li>
                        <?php endif; ?>

                        <li><a href="logout.php" class="btn-link">Tancar sessió</a></li>
                    <?php else: ?>
                        <!-- Opcions per a visitants no logats -->
                        <li><a href="login.php" class="btn-login">Iniciar sessió</a></li>
                    <?php endif; ?>
                    <li class="user-info">👤 <?= htmlspecialchars($_SESSION['user']['nom']) ?></li>
                </ul>
            </nav>

            <!-- Botó per canviar entre Mode Clar / Mode Fosc -->
            <button id="theme-toggle" class="btn-theme" title="Canviar tema">
                🌙
            </button>
        </div>
    </header>