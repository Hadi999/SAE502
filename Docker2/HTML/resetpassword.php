<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
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
                <div class="col-md-6 text-center mb-5"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(images/logo.jpg);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Reset Password</h3>
                                </div>
                            </div>
                            <form action="reset_password_process.php" method="post" class="signin-form">
                                <div class="form-group mt-3">
                                    <input type="password" class="form-control" name="old_password" required>
                                    <label class="form-control-placeholder" for="old_password">Ancien mot de passe</label>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="password" class="form-control" name="new_password" required>
                                    <label class="form-control-placeholder" for="new_password">Nouveau mot de passe</label>
                                </div>
                                <div class="form-group mt-3">
                                    <input type="password" class="form-control" name="confirm_password" required>
                                    <label class="form-control-placeholder" for="confirm_password">Confirmer le mot de passe</label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Réinitialisé mot de passe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>


<?php
include("connexion_database.php");

$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];
$username = $_GET['username'];

// Vérifiez si le vieux mot de passe correspond avant de réinitialiser
$sql = "SELECT * FROM data WHERE username=? AND mdp=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $username, $oldPassword);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0 && $newPassword === $confirmPassword) {
    // Vérifiez la complexité du nouveau mot de passe
    if (validerMotDePasse($newPassword)) {
        // Mettez à jour le mot de passe dans la base de données
        $updateSql = "UPDATE data SET mdp=? WHERE username=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $newPassword, $username);
        $updateStmt->execute();
        header("Location: Accueil.html");
    } else {
        echo "Le nouveau mot de passe ne répond pas aux critères de complexité.";
    }
} else {
    echo "Ancien mot de passe invalide ou les mots de passe ne correspondent pas.";
}

$stmt->close();
$conn->close();

// Fonction pour valider la complexité du mot de passe
function validerMotDePasse($password) {
    // Vérifiez si le mot de passe a au moins 12 caractères, un spécial, une majuscule et un chiffre
    return strlen($password) >= 12 && preg_match('/[!@#$%^&*(),.?":{}|<>A-Z0-9]/', $password) &&
           preg_match('/[A-Z]/', $password) && preg_match('/[0-9]/', $password);
}
?>
