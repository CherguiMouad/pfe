<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Utilisateurs</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Arrière-plan avec flou */
    body {
      background: url('imgs/bg.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      height: 100vh;
      padding-top: 60px;
    }
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      z-index: 0;
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
    
    /* Conteneur principal */
    .container-main {
      display: flex;
      justify-content: flex-start;
      z-index: 10;
      margin-top: 50px;
      margin-left: 10px;
    }
    .content-box {
      width: 100%;
      max-width: 1500px;
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
  </style>
</head>
<body>
  <div class="overlay"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
      <div class="container">
          <a class="navbar-brand text-white" href="index.php"><i class="fas fa-home" style="margin-right:5px"></i> Accueil</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
              <span class="navbar-toggler-icon"><i class="fas fa-bars" style="color:white;" ></i></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                      <a class="nav-link text-white" href="demandes.php"><i class="fas fa-file-alt" style="margin-right:5px"></i> Demandes</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link text-white" href="utilisateurs.php"><i class="fas fa-users" style="margin-right:5px"></i> Utilisateurs</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
  <div class="container container-main">
<div class="content-box"><p>fkzefezkfkezfkezkfekfkefkekfekfkekfekfkefkekf</p></div>


  </div>  
