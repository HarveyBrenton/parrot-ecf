<?php
// Démarrer la session
session_start();
$_SESSION['loggedin'] = false;

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou une autre page appropriée
header("Location: ./index.php");
exit;
?>
