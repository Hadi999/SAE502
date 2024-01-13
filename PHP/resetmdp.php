<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset_email'])) {

        // Réinitialisation du mot de passe
        $reset_email = $_POST['reset_email'];

        // Vérifiez si l'email existe dans la base de données
        $result = $conn->query("SELECT * FROM utilisateurs WHERE email = '$reset_email'");

        if ($result->num_rows > 0) {
            // Générez un jeton unique pour la réinitialisation de mot de passe
            $reset_token = md5(uniqid());

            // Enregistrez le jeton dans la base de données
            $conn->query("UPDATE utilisateurs SET reset_token = '$reset_token' WHERE email = '$reset_email'");





            // Envoi de l'email avec le lien de réinitialisation
            $sujet = "Réinitialisation de mot de passe";
            $message = "Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant :
            http://votre-site.com/reset-password.php?token=$reset_token";

            mail($reset_email, $sujet, $message);

            echo "Un email de réinitialisation a été envoyé à $reset_email. Veuillez vérifier votre boîte de réception.";
        } else {
            echo "Cet email n'est pas enregistré dans notre système.";
        }
    } elseif (isset($_GET['token'])) {



        // Confirmation de la réinitialisation du mot de passe
        $reset_token = $_GET['token'];

        // Vérifiez si le jeton est valide dans la base de données
        $result = $conn->query("SELECT * FROM utilisateurs WHERE reset_token = '$reset_token'");

        if ($result->num_rows > 0) {
            // Affichez le formulaire pour la saisie du nouveau mot de passe ici
            echo "Veuillez saisir votre nouveau mot de passe.";

            
            // Mettre à jour le mot de passe dans la base de données
        } else {
            echo "Le lien de réinitialisation de mot de passe est invalide.";
        }
    }
}
?>

