<?php
session_start();
$id_utilisateur = $_SESSION['id_utilisateur'];

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

// Sélection des produits dans le panier de l'utilisateur
$requete_panier = "SELECT id_produit, Quantite FROM panier WHERE id_utilisateur=$id_utilisateur";
$resultat_panier = $connexion->query($requete_panier);

if ($resultat_panier->num_rows > 0) {
    // Début de la transaction pour assurer l'intégrité des données
    $connexion->begin_transaction();

    try {
        // Parcourir chaque produit dans le panier
        while ($row = $resultat_panier->fetch_assoc()) {
            $id_produit = $row['id_produit'];
            $quantite = $row['Quantite'];
            $prix=$row['prix'];

            // Insérer les produits dans la table "commande" avec la date de commande
            $requete_insert_commande = "INSERT INTO commande (produit, Quantite, id_utilisateur, date_commande,prix) VALUES ('$id_produit', $quantite, $id_utilisateur, NOW(),'prix')";
            $connexion->query($requete_insert_commande);

            // Supprimer les produits du panier
            $requete_suppression_panier = "DELETE FROM panier WHERE id_utilisateur=$id_utilisateur AND id_produit='$id_produit'";
            $connexion->query($requete_suppression_panier);
        }

        // Valider la transaction si tout s'est bien passé
        $connexion->commit();
        
        // Rediriger l'utilisateur après avoir passé la commande
        header("Location: resume.php");
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction et afficher un message d'erreur
        $connexion->rollback();
        echo "Une erreur s'est produite : " . $e->getMessage();
    }
} else {
    echo "Le panier de l'utilisateur est vide.";
}

// Fermer la connexion à la base de données
$connexion->close();
?>
