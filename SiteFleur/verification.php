<?php
$host="localhost";
$user="HamicheNarimane";
$mdp="Hamichenarimane2024";
$bdd="fleur";
$idcon = new mysqli($host, $user, $mdp, $bdd) ;
 if ( $idcon->connect_errno ) { 
    exit("Impossible de se connecter à la base de données
'$bdd' à cause de l'erreur suivant : " . $idcon->connect_error . "."
) ; }
 else {
 echo "Connecté à la base '$bdd' sur le serveur '$host'.";
 $idcon->close();
 } ;

