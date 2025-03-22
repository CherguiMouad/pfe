<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $marque = $_POST['marque'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $quantite = $_POST['quantite'];

    $sql = "UPDATE materiels SET nom = :nom, marque = :marque, type = :type, description = :description, quantite = :quantite WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':nom' => $nom,
        ':marque' => $marque,
        ':type' => $type,
        ':description' => $description,
        ':quantite' => $quantite
    ]);

    echo "success";
} else {
    echo "error";
}
?>