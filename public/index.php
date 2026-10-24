<?php
// si no ha fet login el porta a login.php (funcio de includes/session.php)
require_once '../includes/session.php';
comprovarLogin();

require_once '../includes/header.php'; // Carrega el header dins del context d'index.php ?>
<main class="landing-main">

    <!-- 1. Benvinguda principal -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Hola, <span><?= e($_SESSION['user']['nom'] ?? 'Usuari/a') ?></span>! Benvingut/da a
                EcoShare Girona</h1>
            <p>La plataforma de mobilitat sostenible i vehicles elèctrics compartits de la teva ciutat. Mou-te de manera
                neta, ràpida i sense complicacions.</p>
            <div class="hero-buttons">
                <a href="cataleg.php" class="btn-primary">Reserva un Vehicle Ara ⚡</a>
            </div>
        </div>
    </section>

    <!-- 2. Com funciona -->
    <section class="features-section">
        <h2>Com funciona <span>EcoShare</span>?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>1. Cerca al Catàleg</h3>
                <p>Explora els cotxes, motos i patinets elèctrics disponibles a Girona en temps real.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>2. Fes la teva Reserva</h3>
                <p>Tria el vehicle que millor s'adapti a les teves necessitats i selecciona l'horari.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌱</div>
                <h3>3. Mou-te Sostenible</h3>
                <p>Desbloqueja el vehicle, condueix cap al teu destí i ajuda a reduir les emissions a la ciutat.</p>
            </div>
        </div>
    </section>

    <!-- 3. SECCIÓ D'ESTADÍSTIQUES-->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <span class="stat-number">100%</span>
                <span class="stat-label">Flota Elèctrica</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">0%</span>
                <span class="stat-label">Emissions de CO₂</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">Girona</span>
                <span class="stat-label">La teva àrea de servei</span>
            </div>
        </div>
    </section>

</main>
<?php require_once '../includes/footer.php'; //Carrega el footer dins del context d'index.php ?>