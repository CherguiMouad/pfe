

<?php
session_start();
include("link.php");

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
        echo "<p class='text-danger'>❌ Tous les champs sont obligatoires.</p>";
    } elseif ($mail !== $confirm_mail) {
        echo "<p class='text-danger'>❌ Les e-mails ne correspondent pas.</p>";
    } elseif ($mdp !== $confirm_mdp) {
        echo "<p class='text-danger'>❌ Les mots de passe ne correspondent pas.</p>";
    } elseif (strlen($mdp) < 8) {
        echo "<p class='text-danger'>❌ Le mot de passe doit contenir au moins 8 caractères.</p>";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $con->prepare("SELECT id FROM users WHERE mail = ?");
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p class='text-danger'>❌ Cette adresse e-mail est déjà utilisée.</p>";
        } else {
            // Hasher le mot de passe
            $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO users (nom, prenom, mail, mdp, profil, poste, structure) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nom, $prenom, $mail, $hashed_password, $profil, $poste, $structure);

            if ($stmt->execute()) {
                echo "<p class='text-success'>✅ Utilisateur ajouté avec succès.</p>";
            } else {
                echo "<p class='text-danger'>❌ Erreur lors de l'inscription.</p>";
            }
        }
        $stmt->close();
    }
}
?>
