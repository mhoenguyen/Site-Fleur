<?php
session_start();
$id_utilisateur = $_SESSION['id_utilisateur'];

// Connexion à la base de données (à remplacer avec vos informations de connexion)
$host="localhost";
$user="HamicheNarimane";
$mdp="Hamichenarimane2024";
$bdd="fleur";
$connexion = new mysqli($host, $user, $mdp, $bdd);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

// Requête SQL pour récupérer les détails des commandes du client
$requete_commandes = "SELECT id_commande, produit, Quantite, date_commande
                     FROM commande 
                     WHERE id_utilisateur = $id_utilisateur";
$resultat_commandes = $connexion->query($requete_commandes);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résumé des commandes</title>
    <style>
            table {
        width: 100%; 
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.5); 
    }
         th, td {
        border: 2px solid whitesmoke; 
        padding: 8px;
        text-align: center;
        color: black; 
    }
    </style>
</head>
<body style=" background-color: rgb(255, 205, 227);">
    <h1>Résumé des commandes</h1>
    <table>
        <tr>
            <th>Commande</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Date</th>
        </tr>
        <?php
        if ($resultat_commandes->num_rows > 0) {
            while ($row = $resultat_commandes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_commande'] . "</td>";
                echo "<td>" . $row['produit'] . "</td>";
                echo "<td>" . $row['Quantite'] . "</td>";
                echo "<td>" . $row['date_commande'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucune commande trouvée.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$connexion->close();
?>
