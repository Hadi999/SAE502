<?php
include("connexion_database.php");

$username = $_GET['username'];
$mdp = $_GET['password'];
$mail = $_GET['mail'];

// Préparer et exécuter la requête SQL d'insertion
$requete = $conn->prepare("INSERT INTO data (username, password,mail) VALUES (?, ?, ?)");
$requete->bind_param("sss", $username, $mdp, $mail);
$requete->execute();

// Fermer la connexion à la base de données
$requete->close();
$conn->close();
?>

