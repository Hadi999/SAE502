
<!DOCTYPE html>
<html lang="en">
<head>
<title>Sign UP</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-6 text-center mb-5">
</div>
</div>
<div class="row justify-content-center">
<div class="col-md-7 col-lg-5">
<div class="wrap">
<div class="img" style="background-image: url(images/logo.jpg);"></div>
<div class="login-wrap p-4 p-md-5">
<div class="d-flex">
<div class="w-100">
<h3 class="mb-4">Sign UP</h3>
</div>
<div class="w-100">
</div>
</div>
<form method="GET" action="" class="signin-form">   <!-- Lien vers la page php -->
<div class="form-group mt-3">
<input type="text" class="form-control" name ="username" required>
<label class="form-control-placeholder" for="username">Username</label>
</div>

<div class="form-group mt-3">
    <input type="text" class="form-control" name ="mail" required>
    <label class="form-control-placeholder" for="mail">Mail</label>
</div>

<div class="form-group">
<input id="password-field" type="password" class="form-control" name="password" required>
<label class="form-control-placeholder" for="password">Password</label>
<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
<div class="form-group">
<button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Sign Up</button> <!-- ################################################################################# -->
</div>
<div class="form-group d-md-flex">
<!-- <div class="w-50 text-left">
<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
<input type="checkbox" checked>
<span class="checkmark"></span>
</label>
</div> -->
<div class="text-center">
<a href="forgotpassword.php">Forgot Password</a>
</div>
</div>
</form>
<p class="text-center"><a href="signin.php">Sign In</a></p>  <!-- ################################################################################# -->
</div>
</div>
</div>
</div>
</div>
</section>
<!-- <script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"843c3b672ff9d64e","b":1,"version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
-->
</body>
</html>


<?php
include("connexion_database.php");

$Message_succes = "";
$Message_erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])) {
    // Vérifie si les variables existent avant leur utilisation
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    $mdp = isset($_GET['password']) ? $_GET['password'] : '';
    $mail = isset($_GET['mail']) ? $_GET['mail'] : '';

    // Fonction pour valider le mot de passe
    function validerMotDePasse($mdp) {
        return preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $mdp);
    }

    // Validation du mot de passe 
    if (!empty($username) && !empty($mdp) && !empty($mail) && validerMotDePasse($mdp)) {
        // Préparer et exécuter la requête SQL d'insertion
        $requete = $conn->prepare("INSERT INTO data (username, mdp, mail) VALUES (?, ?, ?)");
        $requete->bind_param("sss", $username, $mdp, $mail);
        $requete->execute();

        // Fermer la connexion à la base de données
        $requete->close();
        $conn->close();

        $Message_succes = "Inscription réussie ! Vous allez être redirigé vers la page de connexion.";
        echo "<script>alert('$Message_succes');</script>";
        echo "<script>setTimeout(function() { window.location.href = 'signin.php'; }, 100);</script>";
    } else {
        // Message d'erreur s'affiche si le mot de passe n'est pas aux normes
        $Message_erreur = "Le mot de passe doit contenir au moins 8 caractères, dont une majuscule et un chiffre.";
        echo "<script>alert('$Message_erreur');</script>";
    }
}
?>









