<?php
$servername = "localhost";
$username = "data_admin";
$password = "vitrygtr";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$username = $_GET['username'];
$mdp = $_GET['password'];

// Préparer et exécuter la requête SQL d'insertion
$requete = $connexion->prepare("INSERT INTO `data` (`username`, `password`) VALUES (?, ?)");
$requete->bind_param("ss", $username, $mdp);
$requete->execute();

// Fermer la connexion à la base de données
$requete->close();
$connexion->close();
?>
