<?php
// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST["username"];
    $password = $_POST["password"];
    $adresse = $_POST["adresse"];

    // Connectez-vous à votre base de données (remplacez les valeurs par les vôtres)
    $host="localhost";
    $user="HamicheNarimane";
    $mdp="Hamichenarimane2024";
    $bdd="fleur";
    $conn = new mysqli($host, $user, $mdp, $bdd) ;

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Préparer et exécuter la requête SQL pour insérer l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateur (nom, mdp, adresse) VALUES ('$username', '$password', '$adresse')";
    if ($conn->query($sql) === TRUE) {
        header("Location: acceuil.html");
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
