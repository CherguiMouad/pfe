<?php
session_start();
include("link.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    if (empty($id)) {
        echo "<p class='text-danger'>❌ ID utilisateur invalide.</p>";
        exit;
    }

    // Vérifier si l'utilisateur existe
    $stmt = $con->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<p class='text-danger'>❌ L'utilisateur n'existe pas.</p>";
    } else {
        // Supprimer l'utilisateur
        $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "✅ Utilisateur supprimé avec succès.";
        } else {
            echo " ❌ Erreur lors de la suppression.s";
        }
    }
    $stmt->close();
}
?>
