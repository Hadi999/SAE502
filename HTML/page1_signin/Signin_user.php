<?php
include("connexion_database.php");

$username = $_GET['username'];
$mdp = $_GET['password'];
$mail = $_GET['mail'];

//Vérification des données dans la base de données
if (!empty($username) AND !empty($mdp) AND !empty($mail)){
    $search=$conn->prepare('SELECT * FROM data WHERE username=? AND mdp=? AND mail=?');
    $search->execute(array($username, $mdp, $mail));
    $found=$search->rowCount();
    //echo $found; 

    if ($found==1){
        header('location:'); //METTRE LA PAGE APRES AUTHENTIFICATION DE L'UTILISATEUR
    }
    else{
    echo "Des informations ne sont pas correct"; //Peut etre mit sous forme de pop up sur la page HTML
    }
}
else{
    echo "Les champs ne sont pas complet";
}
$search->close();
$found->close();
$conn->close();

?>
