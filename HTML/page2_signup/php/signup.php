<?php
include("connexion_database.php");

// Validation du mot de passe 
if (!validerMotDePasse($mdp)) {
    echo "Le mot de passe doit contenir au moins 8 caractères, dont une majuscule et un chiffre.";
    exit;
}

$username = $_GET['username'];
$mdp = $_GET['password'];
$mail = $_GET['mail'];

// Préparer et exécuter la requête SQL d'insertion
$requete = $conn->prepare("INSERT INTO data (username, mdp, mail) VALUES (?, ?, ?)");
$requete->bind_param("sss", $username, $mdp, $mail);
$requete->execute();

// Fermer la connexion à la base de données
$requete->close();
$conn->close();

// Fonction pour valider le mot de passe
function validerMotDePasse($mdp) {
    return preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $mdp);
}

?>

