<footer>
<div class="footer-links">
  <h3>Liens rapides</h3>
  <ul>
    <li><a href="./index.php">Accueil</a></li>
    <li><a href="./services.php">Services</a></li>
    <li><a href="./vehicles.php">Véhicules d'occasion</a></li>
    <li><a href="./contact.php">Contact</a></li>
  </ul>
</div>


  <div class="footer-contact">
    <h3>Contact</h3>
    <ul>
      <li>Une équipe à votre écoute 6/7</li>
      <li>17 rue des Parrots, France</li>
      <li>Tel : 0123456789</li>
      <li>Email : parrot@mail.com</li>
    </ul>
  </div>


  <?php
// Inclure le fichier de configuration de la base de données
include './config.php';

// Récupérer les horaires depuis la base de données
$stmt = $conn->query("SELECT * FROM opening_hours LIMIT 1");
$openingHours = $stmt->fetch(PDO::FETCH_ASSOC);

// Définir les variables des horaires
$monHours = $openingHours['mon_hours'];
$tueHours = $openingHours['tue_hours'];
$wedHours = $openingHours['wed_hours'];
$thuHours = $openingHours['thu_hours'];
$friHours = $openingHours['fri_hours'];
$satHours = $openingHours['sat_hours'];
$sunHours = $openingHours['sun_hours'];
?>

<div class="footer-hours">
    <h3>Horaires d'ouverture</h3>
    <label>Lun. :</label>
    <span><?php echo $monHours; ?></span><br>

    <label>Mar. :</label>
    <span><?php echo $tueHours; ?></span><br>

    <label>Mer. :</label>
    <span><?php echo $wedHours; ?></span><br>

    <label>Jeu. :</label>
    <span><?php echo $thuHours; ?></span><br>

    <label>Ven. :</label>
    <span><?php echo $friHours; ?></span><br>

    <label>Sam. :</label>
    <span><?php echo $satHours; ?></span><br>

    <label>Dim. :</label>
    <span><?php echo $sunHours; ?></span><br>
</div>


</footer>

<script src="./filter.js"></script>
<script src="./script.js"></script>
</body>

