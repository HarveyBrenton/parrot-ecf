<?php
session_start();
// Génération d'un identifiant unique sécurisé
$sessionId = bin2hex(random_bytes(16));

// Paramètres du cookie
$cookieName = "session_id";
$cookieValue = $sessionId;
$cookieExpiration = time() + (86400 * 30); //Durée de 30 jours
$cookiePath = "/";
$cookieDomain = "localhost";
$cookieSecure = false; // false pour le développement local
$cookieHttpOnly = true;

// Paramétrage du cookie
setcookie($cookieName, $cookieValue, $cookieExpiration, $cookiePath, $cookieDomain, $cookieSecure, $cookieHttpOnly);
?>