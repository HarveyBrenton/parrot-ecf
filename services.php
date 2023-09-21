<?php
session_start();

// Génération d'un identifiant unique sécurisé
$sessionId = bin2hex(random_bytes(16));

// Paramètres du cookie
$cookieName = "session_id";
$cookieValue = $sessionId;
$cookieExpiration = time() + (86400 * 30); // Durée de 30 jours
$cookiePath = "/";
$cookieDomain = "localhost";
$cookieSecure = true;
$cookieHttpOnly = true;

// Paramétrage du cookie
setcookie($cookieName, $cookieValue, $cookieExpiration, $cookiePath, $cookieDomain, $cookieSecure, $cookieHttpOnly);
?>

<?php include './header.php'; ?>

<section class="service-page-container">
<h1>Nos Services</h1>
    <div class="service-page">
        <div class="left-side">
            <img src="assets/img/reparation-carosserie.jpeg" alt="Réparation carrosserie" loading="lazy">
        </div>
        <div class="right-side">
            <h2>Réparation carrosserie</h2>
            <p>La réparation carrosserie est l'une de nos spécialités. Que votre véhicule ait subi des dommages mineurs ou majeurs, notre équipe de professionnels expérimentés est là pour redonner à votre voiture son aspect d'origine. Nous utilisons des techniques avancées et des équipements de pointe pour réparer les rayures, les bosses et les déformations de la carrosserie, afin que votre véhicule retrouve son allure impeccable.</p>
        </div>
    </div>

    <div class="service-page">
        <div class="left-side">
            <h2>Réparation mécanique</h2>
            <p>Notre équipe qualifiée est spécialisée dans la réparation mécanique de tous types de véhicules. Que ce soit pour des problèmes de moteur, de transmission, de système de freinage ou d'autres composants essentiels, nous avons les compétences nécessaires pour diagnostiquer et résoudre efficacement les problèmes mécaniques. Nous utilisons des pièces de qualité et suivons des normes strictes pour assurer des réparations durables et fiables, vous permettant de reprendre la route en toute confiance.</p>
        </div>
        <div class="right-side">
            <img src="assets/img/reparation-mecanique.jpeg" alt="Réparation mécanique" loading="lazy">
        </div>
    </div>

    <div class="service-page">
        <div class="left-side">
            <img src="assets/img/entretien-regulier.jpeg" alt="Entretien régulier" loading="lazy">
        </div>
        <div class="right-side">
            <h2>Entretien régulier</h2>
            <p>L'entretien régulier de votre véhicule est essentiel pour assurer sa performance, sa sécurité et sa durabilité à long terme. Chez Garage Parrot, nous proposons une gamme complète de services d'entretien régulier, tels que la vidange d'huile, le remplacement des filtres, la vérification des niveaux de liquide, l'inspection des freins et des pneus, et bien plus encore. Nous veillons à ce que votre véhicule soit maintenu dans un état optimal, ce qui contribue à prévenir les pannes coûteuses et à prolonger sa durée de vie.</p>
        </div>
    </div>
    <div class="contact-service">
        <h2>N'attendez plus</h2>
        <p>Contactez dès maintenant une équipe professionnelle à votre écoute 6/7.</p>
        <a href="./contact.php">Nous contacter</a>
    </div>
</section>

<?php include './footer.php'; ?>
