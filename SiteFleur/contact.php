<?php
$host = "localhost";
$user = "HamicheNarimane";
$mdp = "Hamichenarimane2024";
$bdd = "fleur";
$connexion = new mysqli($host, $user, $mdp, $bdd);


$nom= $_POST['nom'];
$mail=$_POST['mail'];
$tel=$_POST['phone'];
$mess =$_POST['mess'];



$sql = "INSERT INTO commentaire (`nom`, `email`, `numero`, `Message`) VALUES ('$nom', '$mail', '$tel', '$mess');";

$requestTry = mysqli_query($connexion,$sql);

if($requestTry)
{
    echo "Message Envoyé";
}

?> 
