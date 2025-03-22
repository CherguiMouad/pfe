<?php
session_start();
include("link.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $mail = trim($_POST["mail"]);
    $confirm_mail = trim($_POST["mail2"]);
    $poste = trim($_POST["poste"]);
    $structure = trim($_POST["structure"]);
    $profil = trim($_POST["profil"]);
    $mdp = trim($_POST["mdp"]);
    $confirm_mdp = trim($_POST["mdp2"]);

    // Vérifier que l'ID est bien présent
    if (empty($id)) {
        echo "<p class='text-danger'>❌ ID utilisateur manquant.</p>";
        exit;
    }

    // Vérifier si tous les champs sont remplis
    if (empty($nom) || empty($prenom) || empty($mail) || empty($confirm_mail) || empty($poste) || empty($structure) || empty($profil)) {
        echo "<p class='text-danger'>❌ Tous les champs sont obligatoires.</p>";
    } elseif ($mail !== $confirm_mail) {
        echo "<p class='text-danger'>❌ Les e-mails ne correspondent pas.</p>";
    } else {
        // Vérifier si l'email appartient à un autre utilisateur
        $stmt = $con->prepare("SELECT id FROM users WHERE mail = ? AND id != ?");
        $stmt->bind_param("si", $mail, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p class='text-danger'>❌ Cette adresse e-mail est déjà utilisée par un autre utilisateur.</p>";
        } else {
            // Construire la requête SQL pour la mise à jour
            if (!empty($mdp) || !empty($confirm_mdp)) {
                if ($mdp !== $confirm_mdp) {
                    echo "<p class='text-danger'>❌ Les mots de passe ne correspondent pas.</p>";
                    exit;
                } elseif (strlen($mdp) < 8) {
                    echo "<p class='text-danger'>❌ Le mot de passe doit contenir au moins 8 caractères.</p>";
                    exit;
                } else {
                    $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);
                    $stmt = $con->prepare("UPDATE users SET nom=?, prenom=?, mail=?, mdp=?, profil=?, poste=?, structure=? WHERE id=?");
                    $stmt->bind_param("sssssssi", $nom, $prenom, $mail, $hashed_password, $profil, $poste, $structure, $id);
                }
            } else {
                // Mise à jour sans modifier le mot de passe
                $stmt = $con->prepare("UPDATE users SET nom=?, prenom=?, mail=?, profil=?, poste=?, structure=? WHERE id=?");
                $stmt->bind_param("ssssssi", $nom, $prenom, $mail, $profil, $poste, $structure, $id);
            }

            // Exécuter la requête de mise à jour
            if ($stmt->execute()) {
                echo "<p class='text-success'>✅ Utilisateur mis à jour avec succès.</p>";
            } else {
                echo "<p class='text-danger'>❌ Erreur lors de la mise à jour.</p>";
            }
        }
        $stmt->close();
    }
}
?>
