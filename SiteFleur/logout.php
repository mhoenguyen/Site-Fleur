<?php
// Démarrez la session
session_start();
$id_utilisateur = $_SESSION['id_utilisateur'];


// Déconnectez l'utilisateur en supprimant toutes les données de session
session_unset();
session_destroy();

// Redirigez l'utilisateur vers la page de connexion ou une autre page de votre choix
header("Location: connexion.php");
exit();
?>
