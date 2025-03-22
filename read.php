<?php
require 'config.php';

$sql = "SELECT * FROM materiels";
$stmt = $conn->query($sql);
$materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>