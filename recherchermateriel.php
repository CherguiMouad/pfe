<?php
// Connexion à la base de données
include("link.php");

// Vérifier si le terme de recherche est envoyé
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']); // Sécuriser la recherche

    // Requête SQL pour rechercher les matériels
    $query = "SELECT * FROM groupes_materiel 
              WHERE nom LIKE '%$search%' 
              OR marque LIKE '%$search%' 
              OR type LIKE '%$search%'";
    $result = mysqli_query($con, $query);

    // Vérifier s'il y a des résultats
    if (mysqli_num_rows($result) > 0) {
        // Générer le HTML pour les résultats
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['nom']}</td>
                    <td>{$row['marque']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['quantite_disponible']}</td>
                    <td>{$row['quantite_affectee']}</td>
                    <td>{$row['quantite_en_panne']}</td>
                    <td>
                        <div class='btn-group'>
                            <button class='btn btn-orange btn-details' 
                                    data-id='{$row['id']}' 
                                    data-toggle='modal' data-target='#detailsModal'>
                                <i class='fas fa-info-circle'></i> Détails
                            </button>
                        </div>
                    </td>
                  </tr>";
        }
    } else {
        // Aucun résultat trouvé
        echo "<tr><td colspan='7' class='text-center'>Aucun matériel trouvé</td></tr>";
    }
} else {
    // Si aucun terme de recherche n'est envoyé
    echo "<tr><td colspan='7' class='text-center'>Veuillez entrer un terme de recherche</td></tr>";
}

// Fermer la connexion
mysqli_close($con);
?>