<?php
require_once '../includes/header.php'; // Carga el header
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 1. Importamos tu conexión ya existente
// (Asegúrate de que en db.php tu variable de conexión se llame $db o $conn)
require_once '../config/db.php';

// 2. Comprobar si el usuario ha hecho clic en algún filtro de categoría
$categoria_filtrada = isset($_GET['categoria']) ? $_GET['categoria'] : '';

try {
    // 3. Preparar la consulta según el filtro (reutilizando tu conexión $db)
    if (!empty($categoria_filtrada)) {
        $sql = "SELECT * FROM vehicles WHERE categoria = :categoria";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':categoria', $categoria_filtrada, PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM vehicles";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>

<main class="site-main">
    <!-- Botones de filtro adaptados a tus archivos actuales -->
    <!-- <div class="filter-buttons" style="margin-bottom: 20px; text-align: center;">
        <a href="cataleg.php" class="btn-filtre">Todos</a>
        <a href="cataleg.php?categoria=cotxe" class="btn-filtre">Coches</a>
        <a href="cataleg.php?categoria=bicicleta" class="btn-filtre">Bicicletas</a>
        <a href="cataleg.php?categoria=moto" class="btn-filtre">Motos</a>
    </div>-->

    <div class="vehicle-container">
        <?php if (count($vehicles) > 0): ?>
            <?php foreach ($vehicles as $vehicle): ?>
                <card class="vehicle-card">
                    <div class="vehicle-image-container">
                        <!-- Corregimos la ruta dinámicamente apuntando a tu carpeta assets -->
                        <img src="../assets/img/<?php echo htmlspecialchars($vehicle['imatge_url']); ?>"
                            alt="<?php echo htmlspecialchars($vehicle['marca'] . ' ' . $vehicle['model']); ?>"
                            class="vehicle-img">
                    </div>

                    <div class="vehicle-info">
                        <span class="vehicle-brand"><?php echo htmlspecialchars($vehicle['marca']); ?></span>
                        <h2 class="vehicle-model"><?php echo htmlspecialchars($vehicle['model']); ?></h2>

                        <div class="vehicle-specs">
                            <?php if (!empty($vehicle['etiqueta'])): ?>
                                <span class="spec-item">Etiqueta <?php echo htmlspecialchars($vehicle['etiqueta']); ?></span>
                            <?php endif; ?>

                            <?php if (!empty($vehicle['autonomia_electrica'])): ?>
                                <span class="spec-item"><?php echo htmlspecialchars($vehicle['autonomia_electrica']); ?>
                                    Autonomía</span>
                            <?php endif; ?>

                            <?php if (!empty($vehicle['maleter'])): ?>
                                <span class="spec-item"><?php echo htmlspecialchars($vehicle['maleter']); ?> Maletero</span>
                            <?php endif; ?>

                            <?php if (!empty($vehicle['tipus'])): ?>
                                <span class="spec-item"><?php echo htmlspecialchars($vehicle['tipus']); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="vehicle-price-container">
                            <span class="price-label">Precio al contado</span>
                            <span class="vehicle-price"><?php echo htmlspecialchars($vehicle['preu_text']); ?></span>
                        </div>

                        <a href="<?php echo htmlspecialchars($vehicle['detalls_url']); ?>" class="btn-detalls" target="_blank"
                            rel="noopener noreferrer">Ver detalles del modelo</a>
                    </div>
                </card>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">No se ha encontrado ningún vehículo en esta categoría.</p>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../includes/footer.php'; // Carga el footer ?>