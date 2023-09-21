<!--AJOUT DU COOKIES + HEAD-->
<?php include './cookies.php'; ?>
<?php include './header.php'; ?>


  <!-- Bannière principale -->
  <section id="accueil">
    <div class="banner">
        <img class="banner-img" src="assets/img/banniere.jpeg" alt="Image du Garage" loading="lazy">
        <div class="banner-content">
            <h1 class="banner-title">Garage V. Parrot</h1>
            <p class="banner-subtitle">+ de 15 Ans d'Excellence en Réparation et Vente de Voitures d'Occasion</p>
            <a href="./contact.php">Nous contacter</a>
        </div>
    </div>
</section>

<!-- Section des services -->
<?php
// Récupérer les services depuis la base de données
include './config.php';
$stmt = $conn->query("SELECT * FROM services");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="services">
  <h2>Nos Services</h2>
  <div class="services">
    <?php foreach ($services as $service) : ?>
      <div class="service">
      <a href="/services.php">
        <div class="service-img">
        <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
        </div>
        <h3><?php echo htmlspecialchars($service['title']); ?></h3>
        <p><?php echo htmlspecialchars($service['description']); ?></p>
      </div></a>
    <?php endforeach; ?>
  </div>
</section>

<!-- Section des véhicules d'occasion -->
<?php
include './config.php';
// Exécution de la requête SQL
try {
    // Sélectionnez toutes les voitures
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');
}
?>

<section class="vehicle-list">
  <h2>Véhicules d'occasion</h2>
  <div class="vehicles">
    <?php foreach (array_slice($vehicles, 0, 3) as $vehicle): ?>
      <div class="vehicle"><a href="./details.php?id=<?php echo $vehicle['id']; ?>" class="detail-link">
        <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['title']; ?>"></a>
        <div class="text-content">
        <h3><?php echo $vehicle['title']; ?></h3>
        <p>Prix: <?php echo $vehicle['price']; ?> €<br>
        Année: <?php echo $vehicle['year']; ?><br>
        Kilométrage: <?php echo $vehicle['mileage']; ?> km</p>
        <a href="./details.php?id=<?php echo $vehicle['id']; ?>" class="detail-link">+ Détails</a><br>
        <a href="./contactId.php?id=<?php echo $vehicle['id']; ?>" class="detail-link">+ Contact</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="all-cars">
  <a href="./vehicles.php">Tout voir</a>
  </div>
</section>

<div class="separator-index"></div>

<?php
include './config.php';

// Récupérer les avis approuvés depuis la table Reviews
$stmt = $conn->prepare("SELECT * FROM Reviews WHERE approved = 1");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Section d'affichage des avis -->
<div class="reviews-title">
<h2>Avis clients</h2>
  <p>Découvrez ce que les clients disent de nous</p>
  <hr class="line-reviews-section"/>
</div>

<section class="reviews-container">
<!-- Section d'ajout d'un avis -->
<div class="add-review">
  <div class="container-reviews">
  <form method="POST" action="./add_review.php">
  <h2>Ajouter un commentaire</h2>
    <div class="form-group group-form-rate">
      <label for="rating">Note</label>
      <select name="rating" required class="select-rating">
        <option value="">Sélectionnez une note</option>
        <?php for ($i = 1; $i <= 5; $i++) : ?>
          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
      </select>
    </div>

    <div class="form-group group-form-name">
      <label for="reviewer_name">Nom</label>
      <input type="text" placeholder="Nom" name="reviewer_name" required>
    </div>

    <div class="form-group">
      <label for="comment">Commentaire :</label>
      <textarea placeholder="Votre commentaire ici" name="comment" required></textarea>
    </div>

    <div class="form-group btn-form-submit">
      <input type="submit" value="Ajouter">
    </div>
  </form>
  </div>
</div>

<!-- Swiper -->
<div class="testimonial-container">
  <div class="swiper-container">
    <div class="swiper my-swiper">
      <div class="swiper-wrapper">
        <?php if (!empty($reviews)) : ?>
          <?php foreach ($reviews as $review) : ?>
            <div class="swiper-slide swiper-slide-background" style="width: 30rem; height: 100%;">
              <div class="testimonial-box testimonial-card">
                <img src="/assets/img/quote.webp" alt="Citation" class="quote" loading="lazy">
                <div class="testimonial-content">
                  <div class="testimonial-details">
                    <div class="img-box">
                      <img src="/assets/img/logo-garage.png" alt="Logo Garage" />
                    </div>
                    <h3><?php echo htmlspecialchars($review['reviewer_name']); ?><br>
                      <span class="verified">Avis vérifié</span><span class="verified-note"> <?php echo htmlspecialchars($review['rating']); ?>/5</span>
                    </h3>
                  </div>
                  <p><?php echo htmlspecialchars($review['comment']); ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <div class="swiper-slide">
            <p>Aucun avis.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="swiper-pagination"></div>
  </div>
</div>
</section>

<!--AJOUT DU FOOTER-->
<?php include './footer.php'; ?>
