// c la partie qu gere le fait de rajouter un produit au panier 
<?php
// Assurez-vous que la session est démarrée pour accéder à $_SESSION
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    // Redirigez l'utilisateur vers la page de connexion si ce n'est pas déjà fait
    header("Location: user.html");
    exit; // Assurez-vous de terminer le script après la redirection
}

$host = "localhost";
$user = "HamicheNarimane";
$mdp = "Hamichenarimane2024";
$bdd = "fleur";

$idcon = new mysqli($host, $user, $mdp, $bdd);
if ($idcon->connect_errno) {
    exit("Impossible de se connecter à la base de données '$bdd' à cause de l'erreur suivante : " . $idcon->connect_error . ".");
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ajouter_panier'])) {
    $nomProduit = $_POST['nom_produit']; // Récupération du nom du produit
    $prixProduit = $_POST['prix_produit']; // Récupération du prix du produit
    
    // Récupérez l'ID de l'utilisateur à partir de la session
    $id_utilisateur = $_SESSION['id_utilisateur'];
    // Requête SQL pour récupérer la quantité en stock du produit
    $requete_stock_produit = "SELECT stock FROM produit WHERE NomProduit = '$nomProduit'";
    $resultat_stock_produit = $idcon->query($requete_stock_produit);

    if ($resultat_stock_produit->num_rows > 0) {
    // Récupérer la quantité en stock du produit
        $quantite_stock = $resultat_stock_produit->fetch_assoc()['stock'];

    // Vérifier si la quantité en stock est suffisante
       if ($quantite_stock > 0) {
        // Le produit est en stock, vous pouvez l'ajouter au panier ou mettre à jour la quantité existante
         // Requête SQL pour vérifier si le produit est déjà dans le panier de cet utilisateur
         $requete_verif_produit = "SELECT * FROM panier WHERE id_produit = '$nomProduit' AND id_utilisateur = $id_utilisateur";
         $resultat_verif_produit = $idcon->query($requete_verif_produit);

         if ($resultat_verif_produit->num_rows > 0) {
        // Le produit est déjà dans le panier de cet utilisateur, mettez à jour la quantité
             $quantite_actuelle = $resultat_verif_produit->fetch_assoc()['Quantite'];
             $quantite = $quantite_actuelle + 1;
             $prixTotal = $prixProduit * $quantite;

             $requete_update_quantite = "UPDATE panier SET Quantite = $quantite, prix = $prixTotal WHERE id_produit = '$nomProduit' AND id_utilisateur = $id_utilisateur";
             if ($idcon->query($requete_update_quantite) === TRUE) {
                 echo "Quantité mise à jour dans le panier avec succès.";
                  // Mettre à jour le stock dans la table des produits
                 $nouveau_stock = $quantite_stock - $quantite;
                 $requete_update_stock = "UPDATE produit SET stock = $nouveau_stock WHERE NomProduit = '$nomProduit'";
                 $resultat_update_stock = $idcon->query($requete_update_stock);
                 header("Location: acceuil.html");

             }
             else {
            echo "Erreur lors de la mise à jour de la quantité dans le panier : " . $idcon->error;
             }
          } 
       else { //si le produit nest pas dans le panier 
        // Le produit n'est pas encore dans le panier de cet utilisateur, ajoutez-le
        $quantite = 1; 
        $prixTotal = $prixProduit * $quantite;

        $requete_ajout_produit = "INSERT INTO panier (id_produit, prix, Quantite, id_utilisateur) VALUES ('$nomProduit',$prixTotal, $quantite,  $id_utilisateur)";
        if ($idcon->query($requete_ajout_produit) === TRUE) {
             // Mettre à jour le stock dans la table des produits
             $nouveau_stock = $quantite_stock - $quantite;
             $requete_update_stock = "UPDATE produit SET stock = $nouveau_stock WHERE NomProduit = '$id_produit'";
             $resultat_update_stock = $idcon->query($requete_update_stock);
            header("Location: acceuil.html");

        } 
        else {
            echo "Erreur lors de l'ajout du produit au panier : " . $idcon->error;
        }
        }
    } 
    else {
        // Afficher un message d'erreur si la quantité en stock est insuffisante
        echo "Le produit est en rupture de stock.";
    }
}
 else {
    // Afficher un message d'erreur si le produit n'est pas trouvé dans la table des produits
    echo "Le produit n'a pas été trouvé dans la base de données.";
}

}

$idcon->close();
?>
