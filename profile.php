<?php
session_start();

if (isset($_SESSION['admin_token'])) {
    // Redirection vers la page de profil ou de tableau de bord
        header("Location: ./admin_dashboard.php");
        exit;
    } else if (isset($_SESSION['employee_token'])) {
        header("Location: ./employee_dashboard.php");
        exit;
    } else {
    header("Location: ./login_form.php");
    exit;
}
?>
