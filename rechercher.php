<?php
include("link.php");

if (isset($_POST["search"])) {
    $search = trim($_POST["search"]);

    // Requête SQL avec LIKE pour rechercher dans plusieurs colonnes
    $stmt = $con->prepare("SELECT * FROM users WHERE nom LIKE ? OR prenom LIKE ? OR mail LIKE ? OR poste LIKE ?");
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nom']} {$row['prenom']}</td>
                    <td>{$row['mail']}</td>
                    <td>{$row['poste']} du {$row['structure']}</td>
                    <td>{$row['profil']}</td>
                    <td>
                     ?>       <button class="btn btn-orange btn-edit" 
    data-id='  $row['id'] >' 
    data-nom=" $row['nom'] >" 
    data-prenom="  $row['prenom'] >" 
    data-mail="  $row['mail'] >" 
    data-profil="echo $row['profil'] >" 
    data-poste=" echo $row['poste'] >" 
    data-structure=" echo $row['structure']; >"
    data-toggle="modal" data-target="#editUserModal">
    Modifier
</button>
                        <button class='btn btn-danger btn-sm btn-delete' data-id='{$row['id']}'>✖</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>Aucun utilisateur trouvé</td></tr>";
    }
    $stmt->close();
}
?>
