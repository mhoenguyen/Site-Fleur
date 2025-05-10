<?php
// Vérifier si le formulaire de suppression de compte a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST["username"];
    $password = $_POST["password"];

    $host="localhost";
    $user="HamicheNarimane";
    $mdp="Hamichenarimane2024";
    $bdd="fleur";
    $conn = new mysqli($host, $user, $mdp, $bdd) ;

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Préparer et exécuter la requête SQL pour supprimer l'utilisateur de la base de données
    $sql = "DELETE FROM utilisateur WHERE nom='$username' AND mdp='$password'";
    if ($conn->query($sql) === TRUE) {
        echo "Compte supprimé avec succès !";
        header("Location: user.html");

    } else {
        echo "Erreur lors de la suppression du compte : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
