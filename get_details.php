<?php
echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Matériel</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure le fichier CSS externe -->
    <style>
        /* Styles supplémentaires */
        .form-select-etat {
            appearance: none;
            background-color: #fff;
            border: 1px solid #E67E22;
            border-radius: 5px;
            padding: 8px 30px 8px 10px;
            font-size: 14px;
            color: #343A40;
            cursor: pointer;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%23E67E22\'%3e%3cpath d=\'M7 10l5 5 5-5z\'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }
    </style>
</head>
<body>';
// Connexion à la base de données
include "link.php";

// Vérifier si l'ID est spécifié dans l'URL
if (!isset($_GET['id'])) {
    echo "<p class='text-danger'>ID non spécifié</p>";
    exit;
}

// Récupérer et valider l'ID
$id = intval($_GET['id']);

// Récupérer les informations du modèle
$sql = "SELECT nom, marque, type, description FROM groupes_materiel WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si le modèle existe
if ($result->num_rows == 0) {
    echo "<p class='text-danger'>Aucun matériel trouvé</p>";
    exit;
}

// Récupérer les données du modèle
$model = $result->fetch_assoc();

// Afficher les informations du modèle
echo "<h5 class='fw-bold'>" . htmlspecialchars($model['nom']) . " - " . htmlspecialchars($model['marque']) . " (" . htmlspecialchars($model['type']) . ")</h5>";
echo "<p><strong>Description :</strong> " . nl2br(htmlspecialchars($model['description'])) . "</p>";

// Récupérer la liste des matériels du même modèle
$sql = "SELECT numero_serie, etat, id_emplacement FROM materiels WHERE id_groupe = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier s'il y a des matériels associés
if ($result->num_rows > 0) {
    echo "<table class='table table-bordered mt-3'>
            <thead class='table-light'>
                <tr>
                    <th>Numéro de série</th>
                    <th>État</th>
                    <th>Emplacement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";

    // Afficher chaque matériel
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['numero_serie']) . "</td>
                <td>" . htmlspecialchars($row['etat']) . "</td>
                <td>" . htmlspecialchars($row['id_emplacement']) . "</td>
                <td>
                    <form method='POST' class='form-etat' data-numero-serie='" . htmlspecialchars($row['numero_serie']) . "'>
                        <input type='hidden' name='numero_serie' value='" . htmlspecialchars($row['numero_serie']) . "'>
                        <select name='etat' class='form-select-etat'>
                            <option value='Disponible' " . ($row['etat'] == 'Disponible' ? 'selected' : '') . ">Disponible</option>
                            <option value='En panne' " . ($row['etat'] == 'En panne' ? 'selected' : '') . ">En panne</option>
                            <option value='Affecté' " . ($row['etat'] == 'Affecté' ? 'selected' : '') . ">Affecté</option>
                        </select>
                    </form>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p class='text-warning'>Aucun matériel enregistré pour ce modèle.</p>";
}

// Fermer la connexion à la base de données
$con->close();
?>