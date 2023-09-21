<!--AJOUT DU COOKIES + HEAD-->
<?php include './cookies.php';
include './header.php';

// Connexion à la base de données
include './config.php';

// Récupération des véhicules non filtrés
try {
  $stmt = $conn->prepare("SELECT * FROM vehicles");
  $stmt->execute();
  $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
  error_log($errorLog, 3, 'erreurs.log');
}
?>

    <div class="header-vehicles">
        <h1>Nos véhicules d'occasion</h1>
    </div>
    <section class="filter-section-container">
        <div class="filter-section">
            <div class="filter-container">
                <div class="filter-content">
                    <h2>Kilométrage</h2>
                </div>
                <div class="mileage-input">
                    <div class="mileage-field">
                        <label for="mileage-input-min">Min</label>
                        <input type="number" id="mileage-input-min" class="mileage-input-min" value="0">
                        <span class="mileage-symbol">km</span>
                    </div>
                    <div class="separator">-</div>
                    <div class="mileage-field">
                        <label for="mileage-input-max">Max</label>
                        <input type="number" id="mileage-input-max" class="mileage-input-max" value="200000">
                        <span class="mileage-symbol">km</span>
                    </div>
                </div>
                <div class="mileage-slider">
                    <div class="progress"></div>
                </div>
                <div class="mileage-range-input">
                    <input type="range" id="mileage-range-min" class="mileage-range-min" min="0" max="200000" value="0">
                    <input type="range" id="mileage-range-max" class="mileage-range-max" min="0" max="200000" value="200000">
                </div>
            </div>
        
        <!-- Prix Range Slider -->
        <div class="filter-container">
        <div class="filter-content">
                <h2>Prix</h2>
            </div>
            <div class="price-input">
                <div class="price-field">
                    <label for="price-input-min">Min</label>
                    <input type="number" id="price-input-min" class="price-input-min" value="0">
                    <span class="currency-symbol">€</span>
                </div>
                <div class="separator">-</div>
                <div class="price-field">
                    <label for="input-max">Max</label>
                    <input type="number" id="price-input-max" class="price-input-max" value="150000">
                    <span class="currency-symbol">€</span>
                </div>
            </div>
            <div class="price-slider">
                <div class="progress"></div>
            </div>
            <div class="price-range-input">
                <input type="range" id="price-range-min" class="price-range-min" min="0" max="150000" value="0">
                <input type="range" id="price-range-max" class="price-range-max" min="0" max="150000" value="150000">
            </div>
        </div>
        
        <!-- Années Range Slider -->
        <div class="filter-container">
        <div class="filter-content">
                <h2>Années</h2>
            </div>
            <div class="year-input">
                <div class="year-field">
                    <label for="year-input-min">Min</label>
                    <input type="number" id="year-input-min" class="year-input-min" value="2000">
                </div>
                <div class="separator">-</div>
                <div class="year-field">
                    <label for="year-input-max">Max</label>
                    <input type="number" id="year-input-max" class="year-input-max" value="2023">
                </div>
            </div>
            <div class="year-slider">
                <div class="progress"></div>
            </div>
            <div class="year-range-input">
                <input type="range" id="year-range-min" class="year-range-min" min="2000" max="2023" value="2000">
                <input type="range" id="year-range-max" class="year-range-max" min="2000" max="2023" value="2023">
            </div>
            </div>
        </div>
    </section>

    <section class="vehicle-list">
        <div id="results-container" class="vehicles"></div>
    </section>

<!-- FOOTER -->
<script>
const vehicles = <?php echo json_encode($vehicles); ?>;
</script>

<?php include './footer.php'; ?>
