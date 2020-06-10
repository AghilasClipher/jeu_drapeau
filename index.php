<!doctype html>
<html lang="en">
  <head>
    <title>GeoEducation: apprendre en s'amusant</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Feuille de style CSS-->
    <link rel="stylesheet" href=css/accueil.css>

    <!-- Script utilisé pour le sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
  </head>
  <body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

     <!-- Le fichier suivant permet de traiter les données entrées dans les champs de connexion -->
     <?php 
      include_once 'connexionphp.php';
      ?>
    <div class="row" id="titre_et_connexion">
      <div class="col-sm-8">
        <h1 class="display-4" id="titre_accueil"> GeoEducation </h1>
      </div>

      <!-- Si l'utilisateur est connecté, on affiche un message de bienvenue, sinon, on affiche le formulaire de connexion (pseudo et mdp) -->
      <?php include_once 'templates/bienvenue_or_formulaire_co.php'; ?>
    </div>

    <!-- Cette partie est pour la barre de navigation, afin de choisir sur quel continent on joue et gérer son compte-->
    <?php if(is_logged()): ?>
      <?php include_once 'templates/navbar_loggedin.php'; ?>
    <!-- Etant donné que ici l'utilisateur n'est pas connecté, on désactive les boutons pour les autres continents -->
    <?php else: ?>
      <nav class="navbar bg-dark navbar-dark navbar-expand-sm" id="navbar_continents_profil"> 
      <ul class="navbar-nav">
        <li class="nav-item "> 
          <a href="index.php" class="nav-link"> Accueil</a>
        </li>
        <li class="nav-item "> 
          <a href="inscription.php" class="nav-link" title="Débloquez les autres continents !"> S'inscrire</a>
        </li>
        <li class="nav-item "> 
          <a href="afrique.php" class="nav-link" title="Jouez sans inscription !"> Afrique</a>
        </li>
        <li class="nav-item"> 
          <a href="europe.php" class="nav-link disabled"> Europe</a>
        </li>
        <li class="nav-item "> 
          <a href="amerique.php" class="nav-link disabled"> Amérique</a>
        </li>
        <li class="nav-item"> 
          <a href="asie.php" class="nav-link disabled"> Asie</a>
        </li>
        <li class="nav-item"> 
          <a href="oceanie.php" class="nav-link disabled"> Océanie</a>
        </li>
        <li class="nav-item"> 
          <a href="monde.php" class="nav-link disabled"> Monde</a>
        </li>
      </ul>     
     </nav>
    <?php endif; ?>
    <div class="container box_menu_modes">
      <div class="row ">
        <div class="col">
          <p id="jouez_gratuit" class="text-center"> Jouez et découvrez les pays gratuitement ! </p>
        </div>
      </div>
      <div class="row">
        <div class="d-flex justify-content-center col col_cont text-center">
          <a href="afrique.php">
            <img class="photos_continent" src="images/afrique_continent.png" alt="Jeu-Afrique">
            <p class="text-center text_continent"> Afrique </p>
          </a>
        </div>
        <div class="d-flex justify-content-center col col_cont text-center">
          <a href="europe.php">
            <img class="photos_continent" src="images/europe_continent.png" alt="Jeu-Europe">
            <p class="text-center text_continent"> Europe </p>
          </a>
        </div>
        <div class="d-flex justify-content-center col col_cont text-center">
          <a href="asie.php">
            <img class="photos_continent" src="images/asie_continent.png" alt="Jeu-Asie">
            <p class="text-center text_continent"> Asie </p>
          </a>
        </div>
      </div>
      <br>
        <div class="row">
          <div class="d-flex justify-content-center col col_cont text-center">
            <a href="oceanie.php">
              <img class="photos_continent" src="images/oceanie_continent.jpg" alt="Jeu-Océanie">
              <p class="text-center text_continent"> Océanie </p>
            </a>
          </div>
          <div class="d-flex justify-content-center col col_cont text-center">
            <a href="amerique.php">
              <img class="photos_continent" src="images/amerique_continent.jpg" alt="Jeu-Amérique">
              <p class="text-center text_continent"> Amérique </p>
            </a>
          </div>
          <div class="d-flex justify-content-center col col_cont text-center">
            <a href="monde.php">
              <img class="photos_continent " src="images/monde_continent.jpg" alt="Jeu-Monde">
              <p class="text-center text_continent"> Monde </p>
            </a>
          </div>
        </div>
      
    </div>
    
  </body>
</html>