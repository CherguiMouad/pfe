<?php
session_start();
include("link.php");
include("fonctions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["mail"]);

    // Vérifier si l'email existe
    $stmt = $con->prepare("SELECT id FROM users WHERE mail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Générer un token unique
        $token = bin2hex(random_bytes(32));

        // Stocker le token en base de données avec expiration 1h
        $stmt = $con->prepare("UPDATE users SET reset_token = ?, reset_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE mail = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Envoyer l'email de réinitialisation
        $reset_link = "localhost/pfe/reinitialiser_mdp.php?token=$token";
        envoyerEmailReinitialisation($email, $reset_link);

        $_SESSION["message"] = "Un email de réinitialisation a été envoyé.";
    } else {
        $_SESSION["message"] = "Aucun compte trouvé avec cet email.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #F2F4F7; }
        .container { max-width: 400px; margin-top: 100px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px lightgray; }
        .btn-orange { background-color: #FF8500; color: white; border: none; }
        .btn-orange:hover { background-color: #e67300; }
        .form-control:focus {
    border-color: #FF8500 !important;
    box-shadow: 0 0 8px #FF8500 !important;
    outline: none !important;
}
    </style>
</head>
<body>
    <div class="container text-center">
        <h2 class="text-primary">Réinitialisation du mot de passe</h2>
        <p>Entrez votre email et nous vous enverrons un lien.</p>
        
        <?php if (isset($_SESSION["message"])) { echo $_SESSION["message"]; unset($_SESSION["message"]); } ?>

        <form method="post">
            <div class="mb-3">
                <input type="email" name="mail" class="form-control" placeholder="Entrez votre email" required>
            </div>
            <button type="submit" class="btn btn-orange w-100">Envoyer</button>
        </form>

        <a href="connexion.php" class="d-block mt-3">Retour à la connexion</a>
    </div>
</body>
</html>

