<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['Nom'];
    $marque = $_POST['marque'];
    $type = $_POST['type'];
    $description = $_POST['discription'];
    $quantite = $_POST['Qauntite'];

    $sql = "INSERT INTO materiels (nom, marque, type, description, quantite) VALUES (:nom, :marque, :type, :description, :quantite)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':marque' => $marque,
        ':type' => $type,
        ':description' => $description,
        ':quantite' => $quantite
    ]);

    header('Location: index.php');
    exit();
}
?>