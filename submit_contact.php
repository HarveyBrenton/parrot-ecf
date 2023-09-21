<!--
session_start();
// Effectuer la connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "Harvey";
$dbname = "garage_parrot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');

    // Redirection vers une page d'erreur personnalisée ou affichage d'un message d'erreur convivial
    header('./Location: server_error.php');
    exit;
}

// Vérification des données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Validation des données
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {
        // Insertion des données dans la table "users"
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, message) VALUES (:first_name, :last_name, :email, :phone, :message)");
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Les données ont été enregistrées avec succès
            echo "Votre message a été envoyé.";
        } else {
            // Une erreur s'est produite lors de l'enregistrement des données
            echo "Une erreur s'est produite. Veuillez réessayer.";
        }
    } else {
        // Les données du formulaire sont invalides
        echo "Veuillez remplir tous les champs du formulaire.";
    }
}
-->


<?php
session_start();

// Effectuer la connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "garage_parrot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');

    // Redirection vers une page d'erreur personnalisée ou affichage d'un message d'erreur convivial
    header('Location: server_error.php');
    exit;
}

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

