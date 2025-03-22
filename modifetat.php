<?php
// Connexion à la base de données
include("link.php");

// Vérifier si les données du formulaire sont envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $numero_serie = isset($_POST['numero_serie']) ? $_POST['numero_serie'] : null;
    $etat = isset($_POST['etat']) ? $_POST['etat'] : null;

    // Valider les données
    if ($numero_serie && $etat) {
        // Préparer la requête SQL pour mettre à jour l'état
        $sql = "UPDATE materiels SET etat = ? WHERE numero_serie = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $etat, $numero_serie);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "État mis à jour avec succès."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur lors de la mise à jour de l'état : " . $stmt->error]);
        }

        // Fermer la connexion
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Données manquantes."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée."]);
}

// Fermer la connexion à la base de données
$con->close();
?>