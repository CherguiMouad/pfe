<?php
session_start();
include("link.php");

$error_message = ""; // Initialisation du message d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = trim($_POST["mail"]);
    $mdp = trim($_POST["mdp"]);

    if (!empty($mail) && !empty($mdp)) {
        // Vérifier si l'utilisateur existe
        $stmt = $con->prepare("SELECT id, nom, prenom, mdp, profil FROM users WHERE mail = ?");
        if (!$stmt) {
            die("Erreur de requête : " . $con->error);
        }
        
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Vérification du mot de passe haché
            if (password_verify($mdp, $user["mdp"])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["nom"] = $user["nom"];
                $_SESSION["prenom"] = $user["prenom"];
                $_SESSION["mail"] = $mail;

               
             
                    header("Location: utilisateurs.php");
                
                exit();
            } else {
                $error_message = "❌ Mot de passe incorrect.";
            }
        } else {
            $error_message = "❌ Aucun utilisateur trouvé avec cet email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="imgs\sonatrach (2).png">
    <style>
        body {
            background: url('imgs/bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
        }
        .login-container {
            width: 400px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .form-element {
            width: 100%;
            height: 50px;
            border: 1px solid #D3D3D3;
            border-radius: 5px;
            padding-left: 15px;
            margin-top: 10px;
            transition: border-color 0.3s;
        }
        .form-element:focus {
            border-color: #FF8500;
            box-shadow: 0 0 5px #FF8500;
            outline: none;
        }
        .form-button {
            width: 100%;
            height: 50px;
            border-radius: 5px;
            background-color: #FF8500;
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }
        .form-button:hover {
            background-color: white;
            color: #FF8500;
            border: 2px solid #FF8500;
        }
        .error-message {
            color: red;
            font-size: 16px;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <img src="imgs/Sonatrach.svg.png" style="width: 80px; margin-bottom: 20px;">
            <h2 style="color: #FF8500; font-weight: bold;">Connexion</h2>
            <p class="subtitle">Veuillez entrer vos informations pour accéder à votre compte.</p>
            <form method="post">
                <input type="email" class="form-element" name="mail" placeholder="Adresse E-mail" required>
                <input type="password" class="form-element" name="mdp" placeholder="Mot de passe" required>
                
                <?php if (!empty($error_message)): ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php endif; ?>
                
                <button type="submit" class="form-button">Se connecter</button>
                <a href="mdp_oublie.php" style="display: block; margin-top: 10px;">Mot de passe oublié ?</a>
            </form>
        </div>
    </div>
</body>
</html>
