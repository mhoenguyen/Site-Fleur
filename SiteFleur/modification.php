<?php
// Connexion à la base de données
$host="localhost";
$user="HamicheNarimane";
$mdp="Hamichenarimane2024";
$bdd="fleur";
$conn = new mysqli($host, $user, $mdp, $bdd) ;

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];
$newUsername = $_POST['username2'];
$newPassword = $_POST['password2'];
$newAddress = $_POST['adresse2'];

// Requête SQL pour mettre à jour les données du compte utilisateur
$sql = "UPDATE utilisateur SET nom = '$newUsername', mdp = '$newPassword', adresse = '$newAddress' WHERE nom = '$username' AND mdp = '$password'";

if ($conn->query($sql) === TRUE) {
    echo "Les données du compte ont été mises à jour avec succès.";
} else {
    echo "Erreur lors de la mise à jour des données du compte: " . $conn->error;
}

// Fermeture de la connexion
$conn->close();
?>
