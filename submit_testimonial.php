<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'employé
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    // Rediriger l'utilisateur vers une page d'erreur ou de connexion
    header("Location: ./login.php");
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire et les nettoyer
    $name = htmlspecialchars($_POST['name']);
    $comment = htmlspecialchars($_POST['comment']);
    $rating = intval($_POST['rating']);

    // Valider les données

    // Insérer le témoignage dans la base de données
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "garage_parrot";

    try {
        $db = new PDO("mysql:host=$servername;dbname=$username", $dbUser, $dbPass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("INSERT INTO Reviews (rating, comment, reviewer_name) VALUES (:rating, :comment, :name)");
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        // Rediriger l'utilisateur vers la page d'accueil ou une page de confirmation
        header("Location: ./index.php");
        exit;
    } catch (PDOException $e) {
        // Gérer les erreurs de la base de données
        // Afficher un message d'erreur ou rediriger l'utilisateur vers une page d'erreur
        echo "Une erreur est survenue lors de l'insertion du témoignage : " . $e->getMessage();
        $errorSubmit = "Une erreur est survenue lors de l'insertion du témoignage : " . $e->getMessage() . PHP_EOL;
        error_log($errorSubmit, 3, 'erreurs.log');
    }
} else {
    // Rediriger l'utilisateur vers la page d'accueil ou une page d'erreur
    header("Location: ./index.php");
    exit;
}
?>
