<?php
session_start();

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations d'identification du formulaire de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Se connecter à la base de données (modifier ces informations selon votre configuration)
    $host="localhost";
    $user="HamicheNarimane";
    $mdp="Hamichenarimane2024";
    $bdd="fleur";
    $conn = new mysqli($host, $user, $mdp, $bdd) ;

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Préparer la requête SQL pour rechercher l'utilisateur dans la base de données
    $sql = "SELECT id_utilisateur, mdp FROM utilisateur WHERE nom = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Utilisateur trouvé, vérifier le mot de passe
        $row = $result->fetch_assoc();
        if ($password===$row["mdp"]) {
            // Authentification réussie, définir la session de l'utilisateur
            $_SESSION['id_utilisateur'] = $row["id_utilisateur"];

            // Rediriger l'utilisateur vers une page de succès ou l'endroit où il était avant de se connecter
            header("Location: acceuil.html"); // Remplacez index.php par votre page principale
            exit();
        } else {
            // Informer l'utilisateur que le mot de passe est incorrect
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        // L'utilisateur n'existe pas dans la base de données, proposer l'inscription
        echo "Utilisateur non trouvé. Veuillez vous inscrire.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
