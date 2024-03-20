<?php
// Connexion à la base de données
// il faut remplacer les infos de la bdd je n'ai pas
$host = "localhost";
$username = "username";
$password = "password";
$database = "nom_de_la_base_de_donnees";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Vérifie si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Validation du mot de passe avec ce qu'il a demandé
    if (!validerMotDePasse($mot_de_passe)) {
        echo "Le mot de passe doit contenir au moins 8 caractères, dont une majuscule et un chiffre.";
        exit;
    }

    // Hashage du mot de passe ( pour faire les petit point)
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Création d'un code d'activation unique
    $activation_code = md5(uniqid());

    // Insertion des données dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, activation_code) VALUES ('$nom', '$prenom', '$email', '$mot_de_passe_hash', '$activation_code')";

    if ($conn->query($sql) === TRUE) {
        // Envoi de l'email de confirmation
        $sujet = "Activation de votre compte";
        $message = "Bonjour $prenom,

Merci de vous être inscrit sur notre site ! Pour activer votre compte, veuillez cliquer sur le lien suivant :
http://votre-site.com/activate.php?code=$activation_code";

        mail($email, $sujet, $message);

        echo "Un email de confirmation a été envoyé à $email. Veuillez vérifier votre boîte de réception.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Fonction pour valider le mot de passe
function validerMotDePasse($mdp) {
    return preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $mdp);
}





?>
