<?php
include("link.php");
$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);

session_start();

if (!$result) {
    die("Erreur dans la requête : " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Utilisateurs</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

  <style>
    /* Arrière-plan avec flou */
    

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
    
    /* Navbar fixée */
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
    
    /* Conteneur principal */
    .container-main {
      margin-top: 40px;
      display: flex;
      justify-content: center;
      z-index: 1;
    }
    .content-box {
      width: 100%;
      max-width: 900px;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
      z-index: 10;
    }

    /* Barre d'action */
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

    /* Boutons */
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

    /* Tableau stylé */
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
    max-width: 675px; /* Augmentation de la largeur */
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
          <!-- Barre d'action -->
          <div class="action-bar">
          <div class="input-group search-container">
    <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
    </div>
    <input type="text" id="searchUser" class="form-control search-bar" placeholder="Rechercher profils">
</div>

              <a href="#" class="btn btn-orange" data-toggle="modal" data-target="#addUserModal">
                  <i class="fas fa-user-plus"></i> Ajouter utilisateur
              </a>
          </div>

          <!-- Tableau -->
          <table class="table mt-3">
              <thead>
                  <tr>
                      <th>Utilisateur</th>
                      <th>Email</th>
                      <th>Poste</th>
                      <th>Profil</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                      <td><?php echo $row["nom"] . " " . $row["prenom"]; ?></td>
                      <td><?php echo $row["mail"]; ?></td>
                      <td><?php echo $row["poste"] . " du " . $row["structure"]; ?></td>
                      <td><?php echo $row["profil"]; ?></td>
                      <td>
                          <div class="btn-group">
                          <button class="btn btn-orange btn-edit" 
    data-id="<?php echo $row['id']; ?>" 
    data-nom="<?php echo $row['nom']; ?>" 
    data-prenom="<?php echo $row['prenom']; ?>" 
    data-mail="<?php echo $row['mail']; ?>" 
    data-profil="<?php echo $row['profil']; ?>" 
    data-poste="<?php echo $row['poste']; ?>" 
    data-structure="<?php echo $row['structure']; ?>"
    data-toggle="modal" data-target="#editUserModal">
    Modifier
</button>

                             
                                  <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id']; ?>">✖</button>
                            
                          </div>
                      </td>
                  </tr>
                  <?php } ?>
                  <?php if (mysqli_num_rows($result) == 0) {
                      echo "<tr><td colspan='5' class='text-center'>Aucun utilisateur trouvé</td></tr>";
                  } ?>
              </tbody>
          </table>
      </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Ajouter un utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <input type="text" class="form-control mb-2" name="nom" placeholder="Nom" required>
                    <input type="text" class="form-control mb-2" name="prenom" placeholder="Prénom" required>
                    <input type="email" class="form-control mb-2" name="mail" placeholder="E-mail" required>
                    <input type="email" class="form-control mb-2" name="mail2" placeholder="Confirmer e-mail" required>
                    <input type="password" class="form-control mb-2" name="mdp" placeholder="Mot de passe" required>
                    <input type="password" class="form-control mb-2" name="mdp2" placeholder="Confirmer mot de passe" required>
                    <select class="form-control mb-2" name="profil" required>
                        <option value="">Sélectionnez un profil</option>
                        <option value="Technicien IT">Technicien IT</option>
                        <option value="Gestionnaire de stock">Gestionnaire de stock</option>
                        <option value="Cadre">Cadre</option>
                    </select>
                    <input type="text" class="form-control mb-2" name="poste" placeholder="Poste" required>
                    <input type="text" class="form-control mb-2" name="structure" placeholder="Structure" required>

                    <!-- Zone d'affichage des messages -->
                    <div id="responseMessage"></div>

                    <button type="submit" class="btn btn-orange btn-block">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modifier un utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId" name="id">
                    <input type="text" class="form-control mb-2" id="editNom" name="nom" placeholder="Nom" required>
                    <input type="text" class="form-control mb-2" id="editPrenom" name="prenom" placeholder="Prénom" required>
                    <input type="email" class="form-control mb-2" id="editMail" name="mail" placeholder="E-mail" required>
                    <input type="email" class="form-control mb-2" id="editMail2" name="mail2" placeholder="Confirmer e-mail" required>
                    <input type="password" class="form-control mb-2" id="editMdp" name="mdp" placeholder="Nouveau mot de passe">
                    <input type="password" class="form-control mb-2" id="editMdp2" name="mdp2" placeholder="Confirmer mot de passe">
                    <select class="form-control mb-2" id="editProfil" name="profil" required>
                        <option value="">Sélectionnez un profil</option>
                        <option value="Technicien IT">Technicien IT</option>
                        <option value="Gestionnaire de stock">Gestionnaire de stock</option>
                        <option value="Cadre">Cadre</option>
                    </select>
                    <input type="text" class="form-control mb-2" id="editPoste" name="poste" placeholder="Poste" required>
                    <input type="text" class="form-control mb-2" id="editStructure" name="structure" placeholder="Structure" required>

                    <div id="editResponseMessage"></div>

                    <button type="submit" class="btn btn-orange btn-block">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
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

<script>
  // ajouter
    $(document).ready(function () {
        $("#addUserForm").submit(function (e) {
            e.preventDefault(); // Empêche le rechargement de la page
            $.ajax({
                type: "POST",
                url: "ajouterutilisateur.php",
                data: $(this).serialize(),
                success: function (response) {
                    $("#responseMessage").html(response); // Affiche le message
                    $("#addUserForm")[0].reset(); // Réinitialise le formulaire
                    setTimeout(() => { location.reload(); }, 2000); // Recharge la page après 2s
                }
            });
        });
    });
    $(document).ready(function () {
        $("#addUserForm").submit(function (e) {
            e.preventDefault(); // Empêcher le rechargement

            // Effacer les erreurs précédentes
            $(".error-message").remove();
            $(".is-invalid").removeClass("is-invalid");

            $.ajax({
                type: "POST",
                url: "modifierutilisateur.php",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.includes("Erreur")) {
                        // Affichage des erreurs
                        $("#responseMessage").html('<div class="alert alert-danger">' + response + '</div>');
                    } else {
                        $("#responseMessage").html('<div class="alert alert-success">Utilisateur ajouté avec succès !</div>');
                        $("#addUserForm")[0].reset();
                        setTimeout(() => { location.reload(); }, 2000);
                    }
                }
            });
        });

        // Vérification des champs à la saisie
        $("input, select").on("input", function () {
            if ($(this).val().trim() !== "") {
                $(this).removeClass("is-invalid");
                $(this).next(".error-message").remove();
            }
        });
    });
  
   //modifier
    $(document).ready(function () {
        // Remplir le modal avec les données de l'utilisateur
        $(document).on("click", ".btn-edit", function () {
            $("#editUserId").val($(this).data("id"));
            $("#editNom").val($(this).data("nom"));
            $("#editPrenom").val($(this).data("prenom"));
            $("#editMail").val($(this).data("mail"));
            $("#editMail2").val($(this).data("mail"));
            $("#editProfil").val($(this).data("profil"));
            $("#editPoste").val($(this).data("poste"));
            $("#editStructure").val($(this).data("structure"));
            $("#editResponseMessage").html(""); // Effacer les messages
        });

        // Envoyer la modification via AJAX
        $("#editUserForm").submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "modifierutilisateur.php",
                data: $(this).serialize(),
                success: function (response) {
                    $("#editResponseMessage").html(response);
                    if (response.includes("✅")) {
                        setTimeout(() => { location.reload(); }, 2000);
                    }
                }
            });
        });
    });

</script>
 
<script>
  //supprimer
    $(document).ready(function () {
        $(document).on("click", ".btn-delete", function () {
            let userId = $(this).data("id");
            
            if (confirm("⚠️ Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.")) {
                $.ajax({
                    type: "POST",
                    url: "supprimer.php",
                    data: { id: userId },
                    success: function (response) {
                        alert(response);
                        if (response.includes("✅")) {
                            setTimeout(() => { location.reload(); }, 1000);
                        }
                    }
                });
            }
        });
    });
</script>
<script>
  //recherche :
    $(document).ready(function () {
        $("#searchUser").keyup(function () {
            let query = $(this).val();

            $.ajax({
                type: "POST",
                url: "rechercher.php",
                data: { search: query },
                success: function (response) {
                    $("tbody").html(response);
                }
            });
        });
    });
</script>
</body>
</html>