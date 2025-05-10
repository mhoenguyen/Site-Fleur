
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flower Website</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style.css"> 
<style>
    body {
        display: flex;
        align-items: center;
        min-height: 100vh;
        background: url(images/background.png) no-repeat;
        background-size: cover;
        background-position: center;
    }

    .container {
        width: 80%; 
        margin: auto; 
    }

    table {
        width: 100%; 
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.5); 
    }

    th, td {
        border: 2px solid transparent; 
        padding: 8px;
        text-align: center;
        color: black; 
    }

    th {
        background-color:pink;
    }

    tr:nth-child(even) {
        background-color: rgba(0, 128, 0, 0.3);
    }

    tr:nth-child(odd) {
        background-color: rgba(255, 192, 203, 0.3); 
    }

</style>
</head>
<body>

<header>
    <a href="#" class="logo">FleurBelle <span>.</span></a>

    <div class="icons">
        <a href="">Home</a>
        <a href="htmlllll.php">Panier</a>
        <a href="#produit">Produit</a>
        <a href="user.html">Connexion</a>
    </div>
</header>

<?php
session_start();
if (!isset($_SESSION['id_utilisateur'])) {
    // Redirigez l'utilisateur vers la page de connexion si ce n'est pas déjà fait
    header("Location: user.html");
    exit; // Assurez-vous de terminer le script après la redirection
}
$id_utilisateur = $_SESSION['id_utilisateur'];

$host = "localhost";
$user = "HamicheNarimane";
$mdp = "Hamichenarimane2024";
$bdd = "fleur";
$connexion = new mysqli($host, $user, $mdp, $bdd);

if ($connexion->connect_errno) {
    exit("Impossible de se connecter à la base de données '$bdd' à cause de l'erreur suivant : " . $connexion->connect_error . ".");
}

$requete = "SELECT id_produit, prix, Quantite  FROM panier WHERE id_utilisateur=$id_utilisateur";

$resultat = $connexion->query($requete);

if ($resultat->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h2 style='text-align: center;'>Panier</h2>";
    echo "<table>";
    echo "<tr><th>Produit</th><th>Prix</th><th>Quantité</th></tr>";

    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_produit"] . "</td>";
        echo "<td>" . $row["prix"] . "</td>";
        echo "<td>" . $row["Quantite"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    // Bouton pour passer la commande
    echo "<form action='commande.php' method='post'>";
    echo " <input type='submit' name='ajouter_panier' value='commande'  class='btn'>";
    echo "</form>";

    echo "</div>";
} else {
    echo "La table panier est vide.";
}

$connexion->close();
?>
</body>
</html>
