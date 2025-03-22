<?php
session_start();
include("link.php");
include("fonctions.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $mail = trim($_POST["mail"]);
    $confirm_mail = trim($_POST["mail2"]);
    $mdp = trim($_POST["mdp"]);
    $confirm_mdp = trim($_POST["mdp2"]);
    $poste = trim($_POST["poste"]);
    $structure = trim($_POST["structure"]);
    $profil = trim($_POST["profil"]);

    if (empty($nom) || empty($prenom) || empty($mail) || empty($confirm_mail) || empty($mdp) || empty($confirm_mdp) || empty($poste) || empty($structure) || empty($profil)) {
        $error_message = "❌ Tous les champs sont obligatoires.";
    } elseif ($mail !== $confirm_mail) {
        $error_message = "❌ Les adresses e-mail ne correspondent pas.";
    } elseif ($mdp !== $confirm_mdp) {
        $error_message = "❌ Les mots de passe ne correspondent pas.";
    } elseif (strlen($mdp) < 8) {
        $error_message = "❌ Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $stmt = $con->prepare("SELECT id FROM users WHERE mail = ?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "❌ Cette adresse e-mail est déjà utilisée.";
        } else {
            $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO users (nom, prenom, mail, mdp, profil, poste, structure) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nom, $prenom, $mail, $hashed_password, $profil, $poste, $structure);
            
            if ($stmt->execute()) {
                $resultatEmail = envoyerEmailConfirmation($mail, $nom, $prenom);
                
                if ($resultatEmail === true) {
                    echo "✅ Inscription réussie ! Un email de confirmation a été envoyé.";
                } else {
                    echo "⚠️ Inscription réussie, mais erreur d'envoi d'email : " . $resultatEmail;
                }
                
                header("Location: attenteDeConfirmation.php");
                exit();
            } else {
                $error_message = "❌ Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="imgs/sonatrach.png">
    <style>
        body {
            background-color: #F2F4F7;
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            width: 450px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 100px auto;
            text-align: center;
        }
        .form-container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-row {
            display: flex;
            gap: 10px;
        }
        .form-element {
            flex: 1;
            height: 45px;
            border: 1px solid #D3D3D3;
            border-radius: 5px;
            padding-left: 15px;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .form-element:focus {
            border-color: #FF8500;
            box-shadow: 0 0 5px #FF8500;
            outline: none;
        }
        .form-button {
            width: 100%;
            height: 50px;
            background-color: #FF8500;
            color: white;
            border: none;
            font-weight: bold;
            font-size: 18px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .form-button:hover {
            background-color: white;
            color: #FF8500;
            border: 2px solid #FF8500;
        }
        .error-message {
            background-color: #ffdddd;
            color: red;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="imgs/Sonatrach.svg.png" style="width: 90px; position: absolute; left: 10px; top: 10px;">
        <form class="form-container" method="post">
            <h2>Créer un compte</h2>
            <hr>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"> <?php echo $error_message; ?> </div>
            <?php endif; ?>
            <div class="form-row">
                <input type="text" class="form-element" name="nom" placeholder="Nom" required>
                <input type="text" class="form-element" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="form-row">
                <input type="email" class="form-element" name="mail" placeholder="E-mail" required>
                <input type="email" class="form-element" name="mail2" placeholder="Confirmer e-mail" required>
            </div>
            <div class="form-row">
            <input type="password" class="form-element" name="mdp" placeholder="Mot de passe" required>
            <input type="password" class="form-element" name="mdp2" placeholder="Confirmer mot de passe" required>
            </div> <div class="form-row"> 
            <select class="form-element" name="profil" required>
                <option value="">Sélectionnez un profil</option>
                <option value="Technicien IT">Technicien IT</option>
                <option value="Gestionnaire de stock">Gestionnaire de stock</option>
                <option value="Cadre">Cadre</option>
            </select> </div>
            <div class="form-row">
            <input type="text" class="form-element" name="poste" placeholder="Poste" required>
            <input type="text" class="form-element" name="structure" placeholder="Structure" required></div>
            <button type="submit" class="form-button">S'inscrire</button>
            <p class="mt-3">Déjà un compte ? <a href="connexion.php">Connectez-vous</a></p>
        </form>
    </div>
</body>
</html>
