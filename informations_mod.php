<?php 
  include_once 'informationsphp.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Informations de mon profil</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <!-- Feuille de style CSS template-->
    <link rel="stylesheet" href=css/accueil.css>
    <!-- Feuille de style CSS-->
    <link rel="stylesheet" href=css/informations.css>
  </head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <div class="row" id="titre_et_connexion">
      <div class="col-sm-8">
        <h1 class="display-4" id="titre_accueil"> FlagEducation </h1>
      </div>
      <!-- Si l'utilisateur est connecté, on affiche un message de bienvenue, sinon, on affiche le formulaire de connexion (pseudo et mdp) -->
      <?php include_once "templates/bienvenue_or_formulaire_co.php"; ?>
    </div>
    <?php include_once "templates/navbar_loggedin.php" ?>
    <div id="bloc_profil" class="d-flex justify-content-center">
      <div id="sous_bloc">
        <h1 id="titre_profil"> Profil</h1>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Informations</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Statistiques</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Historique de jeu</a>
          </li>
        </ul>
        <div class="tab-content " id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <table class="table table-dark ">
              <tr>
                <td>Pseudo</td>
                <td><input name="pseudo" class="form-control" type="text" value="<?= htmlspecialchars($_SESSION["username"]) ?>"></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><input name="email" class="form-control" type="text" value="<?= htmlspecialchars($_SESSION["email"]) ?>"></td>
              </tr>
              <tr>
                <td>Pays</td>
                <td><input readonly class="form-control" type="text" value="<?= htmlspecialchars($_SESSION["pays"]) ?>"></td>
              </tr>
              <tr>
                <td> Date d'inscription</td>
                <td><input readonly class="form-control"  type="text" value="<?= htmlspecialchars($_SESSION["date_inscription"]) ?> "></td>
              </tr>
            </table>
            <div  class="d-flex justify-content-center">
                <a href="informations_mod" class="btn btn-info" role="button">Link Button</a>
        <button class="btn btn-warning" name="modifier">Modifier</button>
        </div>
          </div>

          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
          <table class="table table-dark">
              <tr>
                <td>Parties jouées</td>
                <td><?= htmlspecialchars($_SESSION["nb_parties"]) ?></td>
              </tr>
              <tr>
                <td>Score moyen</td>
                <td> Le score</td>
              </tr>
            </table>
          </div>
        </div>
        
      </div>

    </div>

    





    </body>
</html>
    