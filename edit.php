<?php
// Inclure le fichier de connexion à la base de données
require 'config.php';

// Récupérer les matériels depuis la base de données
$sql = "SELECT * FROM materiels";
$stmt = $conn->query($sql);
$materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Matériel IT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* Votre CSS existant */
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="sonatrach-logo-4600AE738C-seeklogo.com.png" alt="Logo" width="70" height="90">
            </a>
            <button type="button" class="btn btn-outline-secondary">Déconnexion</button>
        </div>
    </nav>

    <div class="container">
        <div class="row pt-4">
            <!-- Affichage des messages de succès ou d'erreur -->
            <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['erreur'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['erreur']); ?>
                </div>
            <?php } ?>

            <!-- Formulaire pour ajouter un matériel -->
            <form action="create.php" method="POST" class="form-horizontal col-md-6 pt-4">
                <h2>Ajouter un matériel</h2>
                <!-- Votre formulaire existant -->
            </form>
        </div>

        <!-- Liste des matériels -->
        <div class="row pt-4">
            <h2>Liste de matériels</h2>
            <table class="table table-striped mt-3" id="table-materiels">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Marque</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Quantité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materiels as $materiel): ?>
                        <tr id="row-<?php echo $materiel['id']; ?>">
                            <td><?php echo htmlspecialchars($materiel['id']); ?></td>
                            <td><input type="text" name="nom" value="<?php echo htmlspecialchars($materiel['nom']); ?>" class="form-control" disabled></td>
                            <td><input type="text" name="marque" value="<?php echo htmlspecialchars($materiel['marque']); ?>" class="form-control" disabled></td>
                            <td>
                                <select name="type" class="form-control" disabled>
                                    <option value="Ordinateur" <?php echo ($materiel['type'] == 'Ordinateur') ? 'selected' : ''; ?>>Ordinateur</option>
                                    <option value="Écran" <?php echo ($materiel['type'] == 'Écran') ? 'selected' : ''; ?>>Écran</option>
                                    <option value="Clavier" <?php echo ($materiel['type'] == 'Clavier') ? 'selected' : ''; ?>>Clavier</option>
                                    <option value="Imprimante" <?php echo ($materiel['type'] == 'Imprimante') ? 'selected' : ''; ?>>Imprimante</option>
                                    <option value="Routeur" <?php echo ($materiel['type'] == 'Routeur') ? 'selected' : ''; ?>>Routeur</option>
                                    <option value="Serveur" <?php echo ($materiel['type'] == 'Serveur') ? 'selected' : ''; ?>>Serveur</option>
                                </select>
                            </td>
                            <td><textarea name="description" class="form-control" disabled><?php echo htmlspecialchars($materiel['description']); ?></textarea></td>
                            <td><input type="number" name="quantite" value="<?php echo htmlspecialchars($materiel['quantite']); ?>" class="form-control" disabled></td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit" data-id="<?php echo $materiel['id']; ?>">Modifier</button>
                                <button class="btn btn-success btn-sm btn-update" data-id="<?php echo $materiel['id']; ?>" style="display: none;">Mettre à jour</button>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="<?php echo $materiel['id']; ?>">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center py-5 mt-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 mb-2">
                    <img src="sonatrach-logo-4600AE738C-seeklogo.com.png" alt="Logo" width="90">
                    <p class="mt-1 text-black">Gestion Matériel IT</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold text-black">Contactez-nous</h5>
                    <p class="mb-1 text-black"><i class="bi bi-telephone-fill"></i> +213 123 456 789</p>
                    <p class="text-black"><i class="bi bi-envelope-fill"></i> contact@sonatrach.com</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold text-black">Suivez-nous</h5>
                    <a href="#" class="text-black fs-4 mx-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-black fs-4 mx-2"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-black fs-4 mx-2"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="text-black fs-4 mx-2"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <hr class="border-light">
            <p class="mb-0 text-black">&copy; 2025 SONATRACH. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("table-materiels");

            // Activer l'édition d'une ligne
            table.addEventListener("click", function (event) {
                if (event.target.classList.contains("btn-edit")) {
                    const row = event.target.closest("tr");
                    const inputs = row.querySelectorAll("input, textarea, select");
                    inputs.forEach(input => input.disabled = false);

                    // Afficher le bouton "Mettre à jour"
                    event.target.style.display = "none";
                    row.querySelector(".btn-update").style.display = "inline-block";
                }
            });

            // Mettre à jour une ligne
            table.addEventListener("click", function (event) {
                if (event.target.classList.contains("btn-update")) {
                    const row = event.target.closest("tr");
                    const id = event.target.getAttribute("data-id");

                    // Récupérer les valeurs modifiées
                    const nom = row.querySelector("input[name='nom']").value;
                    const marque = row.querySelector("input[name='marque']").value;
                    const type = row.querySelector("select[name='type']").value;
                    const description = row.querySelector("textarea[name='description']").value;
                    const quantite = row.querySelector("input[name='quantite']").value;

                    // Envoyer les données via AJAX
                    fetch("update.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `id=${id}&nom=${nom}&marque=${marque}&type=${type}&description=${description}&quantite=${quantite}`,
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert("Matériel mis à jour avec succès");
                        location.reload(); // Recharger la page pour afficher les modifications
                    })
                    .catch(error => console.error("Erreur :", error));
                }
            });
        });
    </script>
</body>
</html>