<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'employé est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['employee_token'])) {
    header("Location: ./login.php");
    exit;
}

include 'config.php';

// Traitement de l'ajout d'une voiture
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le formulaire d'ajout de voiture a été soumis
    if (isset($_POST['title'], $_POST['price'], $_POST['year'], $_POST['mileage'])) {
        // Validation et échappement des données
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
        $mileage = filter_var($_POST['mileage'], FILTER_SANITIZE_NUMBER_INT);

        // Vérifier si des fichiers ont été téléchargés
        $uploadedImages = [];
        for ($i = 0; $i < 3; $i++) {
            if (isset($_FILES['image'.$i]) && $_FILES['image'.$i]['error'] === UPLOAD_ERR_OK) {
                $image_tmp = $_FILES['image'.$i]['tmp_name'];
                $image_name = $_FILES['image'.$i]['name'];
                $image_mime = mime_content_type($image_tmp); // Validation du type MIME
                
                // Vérification du type MIME (exemple : image/jpeg)
                if (strpos($image_mime, 'image/') === 0) {
                    // Générer un nom de fichier unique
                    $unique_image_name = uniqid() . '.' . pathinfo($image_name, PATHINFO_EXTENSION);

                    // Déplacer le fichier téléchargé vers le répertoire de destination
                    $destination = 'assets/img/' . $unique_image_name;
                    if (move_uploaded_file($image_tmp, $destination)) {
                        $uploadedImages[] = $unique_image_name;
                    } else {
                        // Journaliser l'erreur au lieu de l'afficher
                        error_log("Erreur lors du téléchargement de l'image ".$i);
                    }
                } else {
                    // Type MIME non autorisé
                    error_log("Type MIME non autorisé pour l'image ".$i);
                }
            }
        }

        // Requête préparée pour l'insertion des données dans la base de données
        $stmt = $conn->prepare("INSERT INTO vehicles (title, price, year, mileage, image, image1, image2) VALUES (:title, :price, :year, :mileage, :image, :image1, :image2)");
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
        $stmt->bindValue(':mileage', $mileage, PDO::PARAM_INT);
        $stmt->bindValue(':image', $uploadedImages[0] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':image1', $uploadedImages[1] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':image2', $uploadedImages[2] ?? '', PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            // Rediriger vers le tableau de bord employee_dashboard.php avec un message de succès
            header("Location: ./employee_dashboard.php?success=1");
            exit;
        } else {
            // Journaliser l'erreur au lieu de l'afficher
            error_log("Erreur lors de l'insertion des données dans la base de données.");
        }
    } else {
        echo "Les données du formulaire sont incomplètes.";
    }
}



// Fonction pour approuver un avis
function approveReview($conn, $reviewId) {
    $stmt = $conn->prepare("UPDATE Reviews SET approved = 1 WHERE id = :reviewId");
    $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
    return $stmt->execute();
}

// Fonction pour rejeter un avis
function rejectReview($conn, $reviewId) {
    $stmt = $conn->prepare("DELETE FROM Reviews WHERE id = :reviewId");
    $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
    return $stmt->execute();
}

// Traitement de l'approbation ou du rejet d'un review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
    $reviewId = $_POST['review_id'];
    
    if (isset($_POST['approve'])) {
        if (approveReview($conn, $reviewId)) {
            header("Location: ./employee_dashboard.php?success=1");
            exit;
        } else {
            $errorMessage = "Erreur lors de l'approbation de l'avis.";
        }
    }
    
    if (isset($_POST['reject'])) {
        if (rejectReview($conn, $reviewId)) {
            header("Location: ./employee_dashboard.php?success=1");
            exit;
        } else {
            $errorMessage = "Erreur lors du rejet de l'avis.";
        }
    }
}


// Paramètres de pagination pour les avis existants
$reviewsPerPageExisting = 3; // Nombre d'avis existants à afficher par page

// Paramètres de pagination pour les nouveaux avis
$reviewsPerPageNew = 3; // Nombre de nouveaux avis à afficher par page

$pageExisting = isset($_GET['page_existing']) ? intval($_GET['page_existing']) : 1; // Page actuelle pour les avis existants
$pageNew = isset($_GET['page_new']) ? intval($_GET['page_new']) : 1; // Page actuelle pour les nouveaux avis

// Calculer l'indice de départ pour la requête SQL pour les avis existants
$startIndexExisting = ($pageExisting - 1) * $reviewsPerPageExisting;

// Calculer l'indice de départ pour la requête SQL pour les nouveaux avis
$startIndexNew = ($pageNew - 1) * $reviewsPerPageNew;


// Récupérer toutes les reviews existantes depuis la table Reviews
$stmt = $conn->prepare("SELECT * FROM Reviews");
$stmt->execute();
$existingReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les nouveaux reviews non approuvés depuis la table Reviews
$stmt = $conn->prepare("SELECT * FROM Reviews WHERE approved = 0");
$stmt->execute();
$newReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $conn->prepare("SELECT * FROM Reviews LIMIT :startIndex, :reviewsPerPage");
$stmt->bindParam(':startIndex', $startIndexExisting, PDO::PARAM_INT);
$stmt->bindParam(':reviewsPerPage', $reviewsPerPageExisting, PDO::PARAM_INT);
$stmt->execute();
$existingReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $conn->prepare("SELECT * FROM Reviews WHERE approved = 0 LIMIT :startIndex, :reviewsPerPage");
$stmt->bindParam(':startIndex', $startIndexNew, PDO::PARAM_INT);
$stmt->bindParam(':reviewsPerPage', $reviewsPerPageNew, PDO::PARAM_INT);
$stmt->execute();
$newReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);




include './header.php';
?>


    <h1>Tableau de bord</h1>
    <?php if (isset($_GET['success'])): ?>
    <p style="color: green; text-align: center; font-weight: 700; font-size: 1.5rem;">Action effectuée avec succès !</p>
<?php endif; ?>


    <!--FORMULAIRE Véhicules d'occasions-->
    <section class="dashboardEmployee-main">
        <div class="dashboardEmployee-container">
            <div class="addVehicule-employee">
                <h2>Véhicules d'occasions</h2>
                <h3>Ajouter une voiture</h3>
                <div>
                <form method="POST" action="" class="addVehicule-form" enctype="multipart/form-data">
                <label for="title">Titre :</label>
                <input type="text" name="title" required><br>

                <label for="price">Prix :</label>
                <input type="text" name="price" required><br>

                <label for="year">Année :</label>
                <input type="text" name="year" required><br>

                <label for="mileage">Kilométrage :</label>
                <input type="text" name="mileage" required><br>

                <label for="image">Image 1 :</label>
                <input type="file" name="image" required><br>

                <label for="image1">Image 2 :</label>
                <input type="file" name="image1"><br>

                <label for="image2">Image 3 :</label>
                <input type="file" name="image2"><br>

                <input type="submit" value="Ajouter la voiture">
            </form>
            </div>
    </div>


    <div class="separator-section"></div>


    <!--FORMULAIRE avis clients-->
    <div class="gestionReview-employee">
        <h2>Gestion des avis clients</h2>

<div class="existing-reviews">
    <h3>Avis existants</h3>
    <?php
    if (!empty($existingReviews)) {
        foreach ($existingReviews as $review) {
            echo '<div class="existing-review-container">';
            echo "<p><strong>Note :</strong> " . htmlspecialchars($review['rating']) . "</p>";
            echo "<p><strong>Commentaire :</strong> " . htmlspecialchars($review['comment']) . "</p>";
            echo "<p><strong>Nom de l'auteur :</strong> " . htmlspecialchars($review['reviewer_name']) . "</p>";
            echo "<hr>";
            echo '</div>';
        }
    } else {
        echo "Aucun avis existant.";
    }
    ?>
   <!--PAGINATION AVIS EXISTANT-->
<div class="pagination">
    <?php
    // Calculer le nombre total de pages pour les avis existants
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM Reviews");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalPagesExisting = ceil($result['total'] / $reviewsPerPageExisting);

    // Afficher les liens de pagination pour les avis existants
for ($i = 1; $i <= $totalPagesExisting; $i++) {
    // Inclure le paramètre de page actuelle
    $isActive = ($i === $pageExisting) ? 'active' : ''; // Ajoutez une classe 'active' pour la page actuelle
    echo '<a href="?page_existing=' . $i . '" class="' . $isActive . '">' . $i . '</a>';
}

    ?>
</div>

</div>

<div class="new-reviews">
    <h2>Nouveaux Avis</h2>
    <?php
    if (!empty($newReviews)) {
        foreach ($newReviews as $review) {
            echo '<div class="new-review-container">';
            echo "<p><strong>Note :</strong> " . htmlspecialchars($review['rating']) . "</p>";
            echo "<p><strong>Commentaire :</strong> " . htmlspecialchars($review['comment']) . "</p>";
            echo "<p><strong>Nom de l'auteur :</strong> " . htmlspecialchars($review['reviewer_name']) . "</p>";
            echo '<form method="POST" action="./employee_dashboard.php">';
            echo '<input type="hidden" name="review_id" class="new-review-name" value="' . htmlspecialchars($review['id']) . '">';
            echo '<input type="submit" name="approve" class="new-review-approve" value="Approuver">';
            echo '<input type="submit" name="reject" class="new-review-reject" value="Rejeter">';
            echo '</form>';
            echo "</div>";
        }
    } else {
        echo "Aucun nouvel avis à examiner.";
    }
    ?>
<!--PAGINATION NOUVEAUX AVIS-->
<div class="pagination">
    <?php
    // Calculer le nombre total de pages pour les nouveaux avis
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM Reviews WHERE approved = 0");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalPagesNew = ceil($result['total'] / $reviewsPerPageNew);

    // Afficher les liens de pagination pour les nouveaux avis
for ($i = 1; $i <= $totalPagesNew; $i++) {
    // Inclure le paramètre de page actuelle
    $isActive = ($i === $pageNew) ? 'active' : ''; // Ajoutez une classe 'active' pour la page actuelle
    echo '<a href="?page_new=' . $i . '" class="' . $isActive . '">' . $i . '</a>';
}

    ?>
</div>

</div>

<?php
if (isset($errorMessage)) {
    echo "<p style='color: red;'>$errorMessage</p>";
}
?>

        </div>
        </div>
    </section>



    <!--FOOTER-->
    <?php include './footer.php' ?>