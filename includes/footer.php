<?php
// si la pagina no ha definit $ruta (login i signup no fan servir el header) la deixem buida
if (!isset($ruta)) {
    $ruta = "";
}
?>
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <a href="<?= $ruta ?>index.php" class="footer-logo">⚡ <span>EcoShare</span> Girona</a>
            <p>Plataforma de mobilitat sostenible i vehicles elèctrics compartits a la ciutat de Girona.</p>
        </div>
        <div class="footer-links">
            <h3>Navegació</h3>
            <ul>
                <li><a href="<?= $ruta ?>index.php">Inici</a></li>
                <li><a href="<?= $ruta ?>cataleg.php">Catàleg de vehicles</a></li>
                <li><a href="<?= $ruta ?>login.php">Iniciar sessió</a></li>
            </ul>
        </div>
        <div class="footer-contact">
            <h3>Contacte</h3>
            <p>📍 Girona, Catalunya</p>
            <p>✉️ suport@ecosharegirona.cat</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© EcoShare Girona. Tots els drets reservats.</p>
        <!-- les fotos de Wikimedia Commons demanen citar l'autor i la llicencia -->
        <p class="footer-credits">
            Algunes imatges de vehicles són de
            <a href="https://commons.wikimedia.org" target="_blank">Wikimedia Commons</a>
            (Diego Delso, JustAnotherCarDesigner, Endoro i Alexander Migl) amb llicència
            <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.ca" target="_blank">CC BY-SA 4.0</a>.
        </p>
    </div>
</footer>
</body>

</html>