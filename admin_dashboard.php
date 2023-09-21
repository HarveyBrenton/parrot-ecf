<?php
// Vérifier si l'administrateur est authentifié
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_token'])) {
    // Rediriger vers la page de connexion si l'administrateur n'est pas authentifié
    header("Location: ./login.php");
    exit;
}

include './config.php';

// Récupérer les services depuis la base de données
$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);


//SECTION SERVICE UPDATE
// Traitement des actions de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parcourir les services pour mettre à jour les informations
    foreach ($services as $service) {
        $serviceId = $service['id'];
        $newTitle = trim($_POST['title'][$serviceId]);
        $newDescription = trim($_POST['description'][$serviceId]);

        // Vérifier si un fichier a été téléchargé pour ce service
        if (isset($_FILES['image']['tmp_name'][$serviceId]) && !empty($_FILES['image']['tmp_name'][$serviceId])) {
            $file = $_FILES['image']['tmp_name'][$serviceId];
            $fileName = $_FILES['image']['name'][$serviceId];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $fileExtension;
            $filePath = 'assets/img/' . $newFileName;

            // Déplacer le fichier téléchargé vers le répertoire des téléchargements
            move_uploaded_file($file, $filePath);
            $newImage = $filePath;
        } else {
            // Conserver l'image existante si aucun fichier n'a été téléchargé
            $newImage = $service['image'];
        }

        // Effectuer les opérations de mise à jour des informations des services dans la base de données
        $updateStmt = $conn->prepare("UPDATE services SET title = :title, image = :image, description = :description WHERE id = :id");
        $updateStmt->bindParam(':title', $newTitle, PDO::PARAM_STR);
        $updateStmt->bindParam(':image', $newImage, PDO::PARAM_STR);
        $updateStmt->bindParam(':description', $newDescription, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $serviceId, PDO::PARAM_INT);
        $updateStmt->execute();
    }

    // Rediriger vers le tableau de bord avec un message de succès
    header("Location: ./admin_dashboard.php?success=1");
    exit;
}



//SECTION CREATION EMPLOYES
// Traitement du formulaire de création d'un employé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];

    // Effectuer les opérations d'insertion dans la base de données pour créer un nouvel employé
    $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, email) VALUES (:first_name, :last_name, :email)");
    $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Rediriger vers le tableau de bord avec un message de succès
    header("Location: ./admin_dashboard.php?success=1");
    exit;
}





//SECTION HOUR UPDATE
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

// Traitement du formulaire de modification des horaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monHours = htmlspecialchars($_POST['mon_hours']);
    $tueHours = htmlspecialchars($_POST['tue_hours']);
    $wedHours = htmlspecialchars($_POST['wed_hours']);
    $thuHours = htmlspecialchars($_POST['thu_hours']);
    $friHours = htmlspecialchars($_POST['fri_hours']);
    $satHours = htmlspecialchars($_POST['sat_hours']);
    $sunHours = htmlspecialchars($_POST['sun_hours']);

    // Effectuer les opérations de mise à jour des horaires dans la base de données
    $stmt = $conn->prepare("UPDATE opening_hours SET mon_hours = :mon, tue_hours = :tue, wed_hours = :wed, thu_hours = :thu, fri_hours = :fri, sat_hours = :sat, sun_hours = :sun WHERE id = 1");
    $stmt->bindParam(':mon', $monHours, PDO::PARAM_STR);
    $stmt->bindParam(':tue', $tueHours, PDO::PARAM_STR);
    $stmt->bindParam(':wed', $wedHours, PDO::PARAM_STR);
    $stmt->bindParam(':thu', $thuHours, PDO::PARAM_STR);
    $stmt->bindParam(':fri', $friHours, PDO::PARAM_STR);
    $stmt->bindParam(':sat', $satHours, PDO::PARAM_STR);
    $stmt->bindParam(':sun', $sunHours, PDO::PARAM_STR);
    $stmt->execute();

    // Rediriger vers le tableau de bord avec un message de succès
    header("Location: ./admin_dashboard.php?success=1");
    exit;
}


include './header.php'; 

?>


    <h1>Tableau de bord administrateur</h1>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Les modifications ont été enregistrées avec succès.</p>
    <?php endif; ?>



    <!--FORMULAIRE SERVICES-->
<div class="services-form-container">
    <h2>SERVICES</h2>
    <h3>Modifier les services</h3>
    <form method="POST" action="" enctype="multipart/form-data">
    <div class="services-container-admin">
        <?php foreach ($services as $service) : ?>
            <div class="service-admin">
                <input type="hidden" name="id[<?php echo $service['id']; ?>]" value="<?php echo $service['id']; ?>">
                <label for="title[<?php echo $service['id']; ?>]">Titre :</label>
                <input type="text" name="title[<?php echo $service['id']; ?>]" value="<?php echo htmlspecialchars($service['title']); ?>"><br>
                <label for="image[<?php echo $service['id']; ?>]">Image :</label>
                <input type="file" name="image[<?php echo $service['id']; ?>]"><br>
                <label for="description[<?php echo $service['id']; ?>]">Description :</label>
                <textarea name="description[<?php echo $service['id']; ?>]"><?php echo htmlspecialchars($service['description']); ?></textarea><br>
                <div class="btn-service-update">
                <button type="submit">Enregistrer les modifications</button>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </form>
</div>


    <!--SECTION ACCOUNT + HOUR-->
<div class="account-hour-container">
    <div class="global-section-container">
    <!--FORMULAIRE COMPTE EMPLOYE-->
    <div class="create-account-container">
        <h2>COMPTE EMPLOYE</h2>
        <h3>Créer un compte employé</h3>

<form method="POST" action="">
    <label for="last_name">Nom :</label>
    <input type="text" placeholder="Prénom" name="last_name"><br>
    <label for="first_name">Prénom :</label>
    <input type="text" placeholder="Prénom" name="first_name"><br>
    <label for="email">Email :</label>
    <input type="email" placeholder="Email" name="email"><br>
    <button type="submit">Créer</button>
</form>
</div>


    <!--FORMULAIRE HORAIRES-->
    <div class="updateHour-form-container">
    <h2>HORAIRES</h2>
    <h3>Modifier les horaires</h3>


    <form method="POST" action="">
        <label for="mon_hours">Lun. :</label>
        <input type="text" name="mon_hours" value="<?php echo htmlspecialchars($monHours); ?>"><br>

        <label for="tue_hours">Mar. :</label>
        <input type="text" name="tue_hours" value="<?php echo htmlspecialchars($tueHours); ?>"><br>

        <label for="wed_hours">Mer. :</label>
        <input type="text" name="wed_hours" value="<?php echo htmlspecialchars($wedHours); ?>"><br>

        <label for="thu_hours">Jeu. :</label>
        <input type="text" name="thu_hours" value="<?php echo htmlspecialchars($thuHours); ?>"><br>

        <label for="fri_hours">Ven. :</label>
        <input type="text" name="fri_hours" value="<?php echo htmlspecialchars($friHours); ?>"><br>

        <label for="sat_hours">Sam. :</label>
        <input type="text" name="sat_hours" value="<?php echo htmlspecialchars($satHours); ?>"><br>

        <label for="sun_hours">Dim. :</label>
        <input type="text" name="sun_hours" value="<?php echo htmlspecialchars($sunHours); ?>"><br>

        <button type="submit">Enregistrer</button>
    </form>
    </div>
    </div>
    </div>



    <!--FOOTER-->
    <?php include './footer.php' ?>