<?php
session_start();

// Effectuer la connexion à la base de données
include './config.php';

// Vérification des données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Validation des données
    if (!empty($first_name) && !empty($last_name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phone) && !empty($message)) {
        // Insertion des données dans la table "users" en utilisant une requête préparée
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, message) VALUES (:first_name, :last_name, :email, :phone, :message)");
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Les données ont été enregistrées avec succès
            $_SESSION['message'] = "Votre message a été envoyé.";
            header('Location: ./index.php');
            exit;
        } else {
            // Une erreur s'est produite lors de l'enregistrement des données
            $_SESSION['error'] = "Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer.";
            header('Location: ./vehicles.php');
            exit;
        }
    } else {
        // Les données du formulaire sont invalides
        echo "Veuillez remplir tous les champs du formulaire correctement.";
        header('Location: ./vehicles.php');
        exit;
    }
}
?>

