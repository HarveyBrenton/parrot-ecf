<?php
// Effectuer la connexion à la base de données
include './config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');

    // Redirection vers une page d'erreur personnalisée
    header('Location: ./server_error.php');
    exit;
}


// Récupérer les valeurs du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Vérifier l'administrateur
$stmt = $conn->prepare("SELECT * FROM admin WHERE email = :email LIMIT 1");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$adminResult = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'administrateur est authentifié
if ($adminResult && password_verify($password, $adminResult['password'])) {
    // Authentification réussie en tant qu'administrateur
    // Générer et stocker le jeton d'authentification
    session_start();
    $_SESSION['admin_token'] = bin2hex(random_bytes(32));

    // redirection dashboard admin
    header("Location: ./admin_dashboard.php");
    exit;
}

// Vérifier l'employé
$stmt = $conn->prepare("SELECT * FROM employees WHERE email = :email LIMIT 1");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$employeeResult = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'employé est authentifié
if ($employeeResult && password_verify($password, $employeeResult['password'])) {
    // Authentification réussie en tant qu'employé
    // Générer et stocker le jeton d'authentification
    session_start();
    $_SESSION['employee_token'] = bin2hex(random_bytes(32));

    // redirection dashboard
    header("Location: ./employee_dashboard.php");
    exit;
} else {
    // Si l'authentification a échoué : redirection login
    header("Location: ./login.php?error=1");
    exit;
}

?>
