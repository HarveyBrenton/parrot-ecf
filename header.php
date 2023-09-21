<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Parrot</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@200&display=swap" rel="stylesheet">
    <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./filter.js"></script>
    <script src="./menu.js"></script>
    <script src="./script.js"></script>


</head>
<body>
<header>
    <!--HTML NAV CODE-->
<div class="logo">
    <a href="./index.php">
        <img src="assets\img\logo-garage.png" alt="Garage V. Parrot Logo">
    </a>
</div>
<input type="checkbox" id="check">
<label for="check" class="icons">
    <i class='bx bx-menu' id="menu-icon"></i>
    <i class='bx bx-x' id="close-icon"></i>
</label>

<nav class="navbar">
        <a href="./index.php" style="--i:0;">Accueil</a>
        <a href="./services.php" style="--i:1;">Services</a>
        <a href="./vehicles.php" style="--i:2;">Véhicules d'occasion</a>
        <a href="./contact.php" style="--i:3;">Contact</a>
<!--<span class="login"</nav>>-->
    <!--<nav class="navbarAccount">-->
    <a href="profile.php">Mon compte</a>
    <?php
    // SE CONNECTER ACCOUNT
    $indexUrl = "./index.php";
    $loginFormUrl = "./login_form.php";

    if (isset($_SESSION['admin_token']) || isset($_SESSION['employee_token'])) {
        // Utilisateur connecté, afficher le bouton "Se déconnecter"
        echo '<a href="./logout.php" style="--i:4;">Se déconnecter</a>';
    } else {
        // Utilisateur non connecté, afficher le bouton "Se connecter"
        echo '<a href="' . $loginFormUrl . '" style="--i:5;">Se connecter</a>';
    }
    ?>
<!--/<span>-->
</nav>
</header>
