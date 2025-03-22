<?php
session_start();
include("link.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $nouveau_mdp = $_POST["mdp"];

    // Vérifier si le token est valide et non expiré
    $stmt = $con->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expire > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hash_mdp = password_hash($nouveau_mdp, PASSWORD_BCRYPT);

        // Mettre à jour le mot de passe et supprimer le token
        $stmt = $con->prepare("UPDATE users SET mdp = ?, reset_token = NULL, reset_expire = NULL WHERE id = ?");
        $stmt->bind_param("si", $hash_mdp, $user["id"]);
        $stmt->execute();

        $_SESSION["message"] = "Mot de passe mis à jour ! Vous pouvez maintenant vous connecter.";
        header("Location: connexion.php");
        exit();
    } else {
        $_SESSION["message"] = "Lien invalide ou expiré.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
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

        <?php if (isset($_SESSION["message"])) { echo $_SESSION["message"]; unset($_SESSION["message"]); } ?>

        <form method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <div class="mb-3">
                <input type="password" name="mdp" class="form-control" placeholder="Nouveau mot de passe" required>
            </div>
            <button type="submit" class="btn btn-orange w-100">Réinitialiser</button>
        </form>

        <a href="connexion.php" class="d-block mt-3">Retour à la connexion</a>
    </div>
</body>
</html>