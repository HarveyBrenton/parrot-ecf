<?php
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
    header('Location: ./server_error.php');
    exit;
}
?>