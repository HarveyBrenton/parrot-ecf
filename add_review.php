<?php
include './config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les données du formulaire
  $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
  $reviewerName = isset($_POST['reviewer_name']) ? $_POST['reviewer_name'] : '';
  $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

  // Valider et sécuriser les données du formulaire si nécessaire

  // Insertion des données dans la table Reviews
  $stmt = $conn->prepare("INSERT INTO Reviews (rating, reviewer_name, comment) VALUES (:rating, :reviewerName, :comment)");
  $stmt->bindParam(':rating', $rating);
  $stmt->bindParam(':reviewerName', $reviewerName);
  $stmt->bindParam(':comment', $comment);
  $stmt->execute();

  // Redirection vers la page d'accueil ou une autre page appropriée
  header("Location: ./index.php");
  exit;
} else {
  // Redirection en cas d'accès direct à ce fichier sans soumission du formulaire
  header("Location: ./index.php");
  exit;
}
