<?php
// Connexion à la base de données
include("link.php");

// Requête pour récupérer les matériels
$query = "SELECT * FROM groupes_materiel";
$result = mysqli_query($con, $query);

// Vérification des erreurs
if (!$result) {
    die("Erreur dans la requête : " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion Matériel IT</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    /* Styles CSS */
    body {
      background: url('imgs/bg.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      height: 100vh;
      padding-top: 60px;
      font-family: "Open Sans", sans-serif;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      z-index: -1;
    }

    .navbar {
      background-color: #343A40;
      padding: 0;
      height: 60px;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }

    .navbar .container {
      height: 60px;
      display: flex;
      align-items: center;
    }

    .navbar-brand {
      font-size: 16px;
      padding: 0 15px;
      height: 60px;
      display: flex;
      align-items: center;
    }

    .navbar .nav-link {
      font-size: 16px;
      padding: 10px 15px;
      height: 60px;
      display: flex;
      align-items: center;
      transition: background 0.3s, transform 0.2s;
      border-radius: 4px;
    }

    .navbar .nav-link:hover {
      background-color: #E67E22;
      transform: scale(1.05);
    }

    /* Style pour le bouton de déconnexion */
    .btn-logout {
      background-color: transparent;
      border: none;
      color: white;
      transition: background-color 0.3s, color 0.3s;
      padding: 10px 15px;
      border-radius: 4px;
    }

    .btn-logout:hover {
      background-color: #dc3545; /* Rouge */
      color: white;
    }

    .container-main {
      margin-top: 40px;
      display: flex;
      justify-content: center;
      z-index: 1;
    }

    .content-box {
      width: 100%;
      max-width: 1100px;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
      z-index: 10;
    }

    .action-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      flex-wrap: wrap;
      gap: 10px;
    }

    .search-bar {
      border: 1px solid #E67E22;
      border-radius: 25px;
      padding: 8px 15px;
      flex: 1;
      min-width: 250px;
    }

    .btn-orange {
      background-color: #E67E22;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 14px;
      transition: all 0.3s ease-in-out;
    }

    .btn-orange:hover {
      background-color: #D35400;
      transform: translateY(-2px);
    }

    .btn-danger {
      padding: 6px 12px;
      border-radius: 5px;
      transition: all 0.3s ease-in-out;
      font-size: 14px;
    }

    .btn-danger:hover {
      background-color: #c0392b;
      transform: translateY(-2px);
    }

    .btn-group {
      display: flex;
      gap: 5px;
    }

    .table {
      border-radius: 10px;
      overflow: hidden;
    }

    .table thead {
      background-color: #E67E22;
      color: white;
    }

    .table tbody tr:hover {
      background-color: #f8d7a8 !important;
      transition: background 0.3s ease-in-out;
    }

    .is-invalid {
      border: 2px solid red !important;
      background-color: #ffebeb;
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }

    .search-container {
      max-width: 1100px;
      width: 100%;
    }

    .input-group-text {
      background-color: #E67E22;
      color: white;
      border: none;
    }

    .search-bar {
      width: 100%;
      border: 1px solid #E67E22;
      border-left: none;
      border-radius: 0 25px 25px 0;
    }

    .btn-details:hover {
        box-shadow: 0 4px 8px rgba(230, 126, 34, 0.5);
    }

    .btn-details:focus {
        box-shadow: 0 4px 8px rgba(230, 126, 34, 0.5);
    }

    .search-bar:focus {
        box-shadow: 0 0 8px rgba(230, 126, 34, 0.5);
        border-color: #E67E22;
    }

    footer {
      background-color: #343A40;
      color: white;
      padding: 20px 0;
      margin-top: 40px;
    }

    footer img {
      width: 100px;
      height: auto;
    }

    footer a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }

    footer a:hover {
      color: #E67E22;
    }

    footer a i {
    transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    footer a:hover i {
        transform: scale(1.2);
        color: #E67E22;
    }

    .page-header {
      margin-bottom: 20px;
      text-align: center;
    }

    .page-header h1 {
      font-size: 2.5rem;
      color: #343A40;
      margin-bottom: 10px;
    }

    .page-header p {
      font-size: 1.1rem;
      color: #666;
    }
    /* Animation pour le modal */
@keyframes slideInUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal.fade .modal-dialog {
    animation: slideInUp 0.3s ease-out; /* Appliquer l'animation */
}

/* Optionnel : Ajouter une transition pour la fermeture */
.modal.fade:not(.show) .modal-dialog {
    transform: translateY(100%);
    opacity: 0;
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}
/* Styles pour le modal */
.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    background-color: #ffffff;
}

.modal-header {
    background-color: #E67E22; /* Couleur orange */
    color: white;
    border-bottom: none;
    padding: 20px;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.modal-header .modal-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.modal-header .btn-close {
    color: white;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.modal-header .btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 20px;
    background-color: #f9f9f9;
    color: #333;
}

.modal-footer {
    border-top: none;
    padding: 15px 20px;
    background-color: #f9f9f9;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}

/* Styles pour les boutons dans le modal */
.modal-footer .btn {
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.modal-footer .btn-primary {
    background-color: #E67E22;
    border: none;
}

.modal-footer .btn-primary:hover {
    background-color: #D35400;
    transform: translateY(-2px);
}

.modal-footer .btn-secondary {
    background-color: #6c757d;
    border: none;
}

.modal-footer .btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

/* Styles pour le tableau */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #E67E22;
    color: white;
}

.table tr:hover {
    background-color: #f8f9fa;
}

/* Styles pour le formulaire de sélection d'état */

/* Styles pour les titres et textes */
h5 {
    color: #E67E22;
    margin-bottom: 15px;
}

 modal.p {
    color: #555;
    line-height: 1.6;
}
  </style>
</head>
<body>
  <div class="overlay"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
      <div class="container">
          <!-- Logo ou marque à gauche -->
          <a class="navbar-brand text-white" href="index.php"><i class="fas fa-home" style="margin-right:5px"></i> Accueil</a>

          <!-- Bouton de menu pour les écrans mobiles -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
              <span class="navbar-toggler-icon"><i class="fas fa-bars" style="color:white;"></i></span>
          </button>

          <!-- Contenu de la navbar aligné à gauche -->
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                      <a class="nav-link text-white" href="demandes.php"><i class="fas fa-file-alt" style="margin-right:5px"></i> Demandes</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link text-white" href="utilisateurs.php"><i class="fas fa-users" style="margin-right:5px"></i> Utilisateurs</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link text-white" href="materiel.php"><i class="fas fa-laptop" style="margin-right:5px"></i> Matériel</a>
                  </li>
              </ul>

              <!-- Bouton de déconnexion seul à droite -->
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                      <a class="nav-link text-white btn-logout" href="logout.php"><i class="fas fa-sign-out-alt" style="margin-right:5px"></i> Déconnexion</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>

  <!-- Contenu principal -->
  <div class="container container-main">
      <div class="content-box">
          <!-- Titre et description -->
          <div class="page-header">
              <h1 style="color: #E67E22;">Gestion du Matériel IT</h1>
              <p>Bienvenue sur la plateforme de gestion du matériel informatique. Consultez, recherchez et gérez les équipements disponibles.</p>
          </div>

          <!-- Barre d'action -->
          <div class="action-bar">
              <div class="input-group search-container">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                  </div>
                  <input type="text" id="searchUser" class="form-control search-bar" placeholder="Rechercher matériel">
              </div>
          </div>

          <!-- Tableau -->
          <table class="table mt-3">
              <thead>
                  <tr>
                      <th>Nom</th>
                      <th>Marque</th>
                      <th>Type</th>
                      <th>Disponible</th>
                      <th>Affectée</th>
                      <th>Hors service</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                      <td><?php echo $row["nom"]; ?></td>
                      <td><?php echo $row["marque"]; ?></td>
                      <td><?php echo $row["type"]; ?></td>
                      <td><?php echo $row["quantite_disponible"]; ?></td>
                      <td><?php echo $row["quantite_affectee"]; ?></td>
                      <td><?php echo $row["quantite_en_panne"]; ?></td>
                      <td>
                          <div class="btn-group">
                              <button class="btn btn-orange btn-details" 
                                  data-id="<?php echo $row['id']; ?>" 
                                  data-toggle="modal" data-target="#detailsModal">
                                  <i class="fas fa-info-circle"></i> Détails
                              </button>
                          </div>
                      </td>
                  </tr>
                  <?php } ?>
                  <?php if (mysqli_num_rows($result) == 0) {
                      echo "<tr><td colspan='7' class='text-center'>Aucun matériel trouvé</td></tr>";
                  } ?>
              </tbody>
          </table>
      </div>
  </div>

<!-- Modal pour afficher les détails -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel"style="color:white;">Détails du matériel</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenu rempli dynamiquement -->
            </div>
            <div id="modalMessage" class="alert" style="display: none;"></div> <!-- Zone de message -->
        </div>
    </div>
</div>

  <!-- Footer -->
  <footer class="text-center py-4">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-md-4 mb-3">
                  <img src="imgs/sonatrach (1).png" alt="Logo Sonatrach" class="img-fluid" style="max-width: 100px;">
                  <p class="mt-2">Gestion Matériel IT</p>
              </div>
              <div class="col-md-4 mb-3">
                  <h5>Contactez-nous</h5>
                  <p><i class="fas fa-phone"></i> +213 123 456 789</p>
                  <p><i class="fas fa-envelope"></i> contact@sonatrach.com</p>
              </div>
              <div class="col-md-4">
                  <h5>Suivez-nous</h5>
                  <a href="#" class="text-white mx-2"><i class="fab fa-facebook"></i></a>
                  <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
                  <a href="#" class="text-white mx-2"><i class="fab fa-linkedin"></i></a>
                  <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
              </div>
          </div>
          <hr class="border-light">
          <p class="mb-0">&copy; 2025 SONATRACH. Tous droits réservés.</p>
      </div>
  </footer>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function () {
        // Fonction pour actualiser les détails du matériel
        function refreshMaterialDetails(id) {
            fetch('get_details.php?id=' + id)
                .then(response => response.text())
                .then(data => {
                    $('#modalBody').html(data); // Mettre à jour le contenu du modal
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des détails :', error);
                    $('#modalBody').html("<p class='text-danger'>Erreur lors de la récupération des détails.</p>");
                });
        }

        // Gérer la soumission du formulaire de modification d'état
        $(document).on('change', '.form-select-etat', function () {
            const form = $(this).closest('form'); // Récupérer le formulaire parent
            const formData = form.serialize(); // Sérialiser les données du formulaire
            const numero_serie = form.find('input[name="numero_serie"]').val(); // Récupérer le numéro de série

            // Envoyer les données via AJAX
            $.ajax({
                type: "POST",
                url: "modifetat.php", // Fichier de traitement
                data: formData,
                success: function (response) {
                    const result = JSON.parse(response); // Parser la réponse JSON
                    const message = result.message; // Récupérer le message
                    const status = result.status; // Récupérer le statut

                    // Afficher le message dans la zone dédiée
                    const modalMessage = $("#modalMessage");
                    modalMessage.removeClass("alert-success alert-danger"); // Réinitialiser les classes
                    if (status === "success") {
                        modalMessage.addClass("alert-success").text(message).show();

                        // Actualiser les détails du matériel après la mise à jour
                        const id = $('.btn-details.active').data('id'); // Récupérer l'ID du matériel
                        refreshMaterialDetails(id); // Recharger les détails
                    } else {
                        modalMessage.addClass("alert-danger").text(message).show();
                    }

                    // Masquer le message après 3 secondes
                    setTimeout(function () {
                        modalMessage.hide();
                    }, 3000);
                },
                error: function (xhr, status, error) {
                    console.error("Erreur AJAX :", error);
                    $("#modalMessage").addClass("alert-danger").text("Une erreur s'est produite lors de la mise à jour de l'état.").show();
                }
            });
        });

        // Relier les écouteurs d'événements aux boutons "Détails"
        $('.btn-details').on('click', function () {
            const id = $(this).data('id'); // Récupérer l'ID du matériel
            $(this).addClass('active'); // Marquer le bouton comme actif
            refreshMaterialDetails(id); // Charger les détails dans le modal
        });

        // Écouter les saisies dans la barre de recherche
        $("#searchUser").keyup(function () {
            let query = $(this).val(); // Récupérer le terme de recherche

            // Envoyer une requête AJAX à recherchermateriel.php
            $.ajax({
                type: "POST",
                url: "recherchermateriel.php",
                data: { search: query }, // Envoyer le terme de recherche
                success: function (response) {
                    // Mettre à jour le tableau avec les résultats
                    $("tbody").html(response);

                    // Relier les écouteurs d'événements aux nouveaux boutons "Détails"
                    $('.btn-details').on('click', function () {
                        const id = $(this).data('id'); // Récupérer l'ID du matériel
                        $(this).addClass('active'); // Marquer le bouton comme actif
                        refreshMaterialDetails(id); // Charger les détails dans le modal
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Erreur AJAX :", error);
                }
            });
        });

        // Actualiser la page lorsque le modal est fermé
        $('#detailsModal').on('hidden.bs.modal', function () {
            location.reload(); // Recharger la page
        });
    });
  </script>
</body>
</html>