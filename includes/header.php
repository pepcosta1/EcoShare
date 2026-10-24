<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/functions.php';
$theme = getTema();

// $ruta serveix per les pagines de la carpeta admin/
// alla abans d'incloure el header posem $ruta = "../"; perque els enllaços pugin una carpeta
if (!isset($ruta)) {
    $ruta = "";
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoShare Girona - Vehicles Elèctrics Compartits</title>
    <link rel="stylesheet" href="<?= $ruta ?>../assets/css/style.css">
    <script src="<?= $ruta ?>../assets/js/main.js" defer></script>
</head>

<body data-theme="<?= e($theme) ?>">

    <header class="site-header">
        <div class="header-container">
            <a href="<?= $ruta ?>index.php" class="logo">
                ⚡ <span>EcoShare</span> Girona
            </a>

            <nav class="main-nav">
                <ul>
                    <li><a href="<?= $ruta ?>index.php">Inici</a></li>
                    <li><a href="<?= $ruta ?>cataleg.php">Catàleg</a></li>

                    <?php if (estaLogejat()): ?>
                        <!-- Opcions per a usuaris -->
                        <li><a href="<?= $ruta ?>meves_reserves.php">Les meves reserves</a></li>
                        <?php if (esAdmin()): ?>
                            <li><a href="<?= $ruta ?>admin/vehicles.php" class="nav-admin">🛠️ Gestió Admin</a></li>
                        <?php endif; ?>

                        <li><a href="<?= $ruta ?>logout.php" class="btn-link">Tancar sessió</a></li>
                        <li class="user-info">👤 <?= e($_SESSION['user']['nom']) ?></li>
                    <?php else: ?>
                        <!-- Opcions per a visitants -->
                        <li><a href="<?= $ruta ?>login.php" class="btn-login">Iniciar sessió</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <button id="theme-toggle" class="btn-theme" title="Canviar tema">
                🌙
            </button>
        </div>
    </header>
