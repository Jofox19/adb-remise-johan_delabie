<?php
session_start(); // Démarrage de la session

if (isset($_SESSION['user_id'])) { // Vérifie si la clé 'user_id' existe dans la session
    session_unset(); // Supprime toutes les données de la session
    session_destroy(); // Détruit la session

    header("Location: index.php"); // Redirige vers la page d'accueil (index.php)
    exit(); // Arrête l'exécution du script
}
?>