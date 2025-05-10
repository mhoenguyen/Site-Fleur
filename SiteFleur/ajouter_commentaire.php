<?php
// Assurez-vous que la session est démarrée pour accéder à $_SESSION
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    // Redirigez l'utilisateur vers la page de connexion si ce n'est pas déjà fait
    header("Location: user.html");
    exit; // Assurez-vous de terminer le script après la redirection
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $id_utilisateur = $_SESSION['id_utilisateur'];
    $id_produit = $_POST['id_produit'];
    $commentaire = $_POST['commentaire'];
    $note = $_POST['rating']; // Récupérer la valeur de la note depuis le formulaire

    // Connectez-vous à votre base de données (assurez-vous d'ajuster les paramètres de connexion)
    $mysqli = new mysqli("localhost", "HamicheNarimane", "Hamichenarimane2024", "fleur");

    // Vérifiez la connexion à la base de données
    if ($mysqli->connect_error) {
        die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
    }

    // Préparez et exécutez la requête SQL pour insérer le commentaire dans la table des commentaires
    $sql = "INSERT INTO commentaire (id_utilisateur, nom_produit, commentaire, note) VALUES ('$id_utilisateur', '$id_produit','$commentaire','$note')";

    if ($mysqli->query($sql) === TRUE) {
        echo"produi est ".$id_produit;
        echo "Le commentaire et la note ont été ajoutés avec succès.";
    } 
     else {
        echo "Erreur lors de l'ajout du commentaire et de la note: " . $stmt->error;
    }

    // Fermez la déclaration et la connexion à la base de données

} else {
    // Redirigez l'utilisateur vers la page appropriée s'il tente d'accéder à ce script directement sans soumettre le formulaire
    header("Location: ");
    exit; // Assurez-vous de terminer le script après la redirection
}
?>
