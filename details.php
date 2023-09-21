<?php
session_start();

include './config.php';

// Vérifier si l'identifiant du véhicule est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Rediriger l'utilisateur vers une page d'erreur ou une liste de véhicules
    header('Location: ./index.php');
    exit();
}

// Récupérer l'identifiant du véhicule depuis l'URL
$vehicleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$vehicleId) {
    // Rediriger l'utilisateur vers une page d'erreur ou une liste de véhicules
    header('Location: ./index.php');
    exit();
}

try {
    // Préparer et exécuter la requête SQL pour récupérer les détails du véhicule
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        // Rediriger l'utilisateur
        header('Location: ./index.php');
        exit();
    }
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des détails du véhicule : ' . $e->getMessage());
    header('Location: ./vehicles.php');
}

try {
    // Préparer et exécuter la requête SQL pour récupérer les équipements du véhicule
    $stmt = $conn->prepare("SELECT equipment_name FROM vehicle_equipment WHERE vehicle_id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $equipment = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des équipements du véhicule : ' . $e->getMessage());
    // Gérer l'erreur d'une manière appropriée (par exemple, afficher un message d'erreur)
}

try {
    // Préparer et exécuter la requête SQL pour récupérer les caractéristiques du véhicule
    $stmt = $conn->prepare("SELECT feature_name, feature_value FROM vehicle_features WHERE vehicle_id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des caractéristiques du véhicule : ' . $e->getMessage());
    // Gérer l'erreur d'une manière appropriée (par exemple, afficher un message d'erreur)
}







// Récupérer l'ID de la voiture depuis l'URL
if (isset($_GET['id'])) {
    $carId = $_GET['id'];

    // Récupération du titre correspondant à l'ID
    try {
        $stmt = $conn->prepare("SELECT title FROM vehicles WHERE id = :carId");
        $stmt->bindParam(':carId', $carId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $carTitle = $result['title'];
            // Utiliser $carTitle
        } else {
            
            header("Location: ./index.php");
            exit();
        }
    } catch (PDOException $e) {
        $errorLog = 'Erreur lors de la récupération du titre du véhicule : ' . $e->getMessage() . PHP_EOL;
        error_log($errorLog, 3, 'erreurs.log');

        header("Location: ./index.php");
        exit();
    }
} else {
    
    header("Location: ./index.php");
    exit();
}

// Récupération des véhicules non filtrés
try {
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');
    // Rediriger vers une page d'erreur en cas d'erreur de requête
    header("Location: ./error.php");
    exit();
}


//Récupérer le nom du modèle de voiture
$carModel = $carTitle;


// Fermer la connexion à la base de données
$conn = null;
?>
<?php include './header.php'; ?>

<div class="detail-title">
<h1>Détails du véhicule - <?php echo $vehicle['title']; ?></h1>
</div>

<section class="vehicle-global-details">
<div class="img-container-details">
    <div class="img-details"><img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['title']; ?>"></div>
    <div class="img-details"><img src="<?php echo $vehicle['image1']; ?>" alt="<?php echo $vehicle['title']; ?>"></div>
</div>

<div class="car-details-info">
    <p>Prix : <?php echo $vehicle['price']; ?> €</p>
    <p>Année : <?php echo $vehicle['year']; ?></p>
    <p>Kilométrage : <?php echo $vehicle['mileage']; ?> km</p>
</div>
</section>

<section class="equipement-detail-container">
<h2>Équipements</h2>
<div class="ul-container">
    <ul>
        <?php foreach ($equipment as $item) : ?>
            <li><?php echo $item; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</section>

<section class="features-detail-container">
<h2>Caractéristiques</h2>
<div class="table-container">
    <table>
        <?php foreach ($features as $feature) : ?>
            <tr>
                <td><?php echo $feature['feature_name']; ?></td>
                <td><?php echo $feature['feature_value']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</section>



        <section class="contactId-container">
    <!-- Formulaire de contact -->
    
    <div class="contact-form">
    <form action="./submit_contact.php" method="POST">
        <h2>Formulaire de contact</h2>
            <div class="contact-details-title">
                <h1><?php echo $carModel; ?></h1>
                <p>Notre équipe reviendra rapidement vers vous concernant cette voiture.</p>
            </div>
        <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
        
        <div class="form-group">
            <label for="first_name">Nom* :</label>
            <input type="text" name="first_name" id="first_nameID" required>
        </div>

        <div class="form-group">
            <label for="last_name">Prénom* :</label>
            <input type="text" name="last_name" id="last_nameID" required>
        </div>
        
        <div class="form-group">
            <label for="email">Adresse e-mail* :</label>
            <input type="email" name="email" id="emailID" required>
        </div>

        <div class="form-group">
            <label for="phone">Numéro de téléphone* :</label>
            <input type="tel" name="phone" id="phoneID" required>
        </div>

        <div class="form-group">
        <label for="message">Message* :</label>
        <textarea name="message" id="messageID" required></textarea>
        </div>

        <button type="submit">Envoyer</button>
    </form>
</div>

        </section>

<?php 
include './footer.php';
?>
