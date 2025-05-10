<?php
session_start();
$id_utilisateur = $_SESSION['id_utilisateur'];
echo"<head>
    <title> Flower Website </title>
     <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
     <link rel='stylesheet' href='style.css'> 
</head>";

if(isset($_GET['motcle'])) {
    // Récupérer le terme de recherche depuis le formulaire
    $motcle = $_GET['motcle'];

    // Connexion à la base de données (à remplacer avec vos informations de connexion)
    $host="localhost";
    $user="HamicheNarimane";
    $mdp="Hamichenarimane2024";
    $bdd="fleur";
    $connexion = new mysqli($host, $user, $mdp, $bdd) ;

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    // Requête SQL pour rechercher les produits correspondant au terme de recherche
    $requete = "SELECT * FROM produit WHERE NomProduit LIKE '%$motcle%'";
    $resultat = $connexion->query($requete);

    // Vérifier s'il y a des résultats de recherche
    if ($resultat->num_rows > 0) {
        // Afficher les résultats de recherche
        echo "<h2 >Résultats de la recherche pour '$motcle'</h2>";
        while($row = $resultat->fetch_assoc()) {
            echo"  <div class='box' style='margin=150px'>
                <div class='content'>
                <h3>". $row['NomProduit'] ."</h3>
                <div class='price'>" . $row['PrixProduit'] . "</div>
                </div>
                <div class='icons'>
                    <!-- Formulaire pour ajouter au panier -->
                    <form action='panier.php' method='post'>
                        <input type='hidden' name='nom_produit' value=". $row['NomProduit'] .">
                        <input type='hidden' name='prix_produit' value=" . $row['PrixProduit'] . ">
                        <input type='submit' name='ajouter_panier' value='Ajouter au panier'  class='btn'>
                    </form>
                </div>
            </div>

        </div>";

            // Afficher  les commentaire du produit 
// Afficher les commentaires du produit
$sql = "SELECT * FROM commentaire WHERE nom_produit = '" . $row['NomProduit'] . "'";
$result = $connexion->query($sql);
while ($ligne = $result->fetch_assoc()) {
    echo "<p>Commentaire</p>";
    echo "<p>" . $ligne['Commentaire'] . "</p>";
}


        }
    } else {
        // Aucun résultat trouvé
        echo "<p>Aucun résultat trouvé pour '$motcle'.</p>";
    }

    // Fermer la connexion à la base de données
    $connexion->close();
}
?>
