<!doctype html>
<html lang="en">
  <head>
    <title>Jeu des drapeaux: apprendre en s'amusant</title>
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
        <h1 class="display-4" id="titre_accueil"> Jeu des drapeaux</h1>
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
          <a href="europe.html" class="nav-link disabled"> Europe</a>
        </li>
        <li class="nav-item "> 
          <a href="amerique.html" class="nav-link disabled"> Amérique</a>
        </li>
        <li class="nav-item"> 
          <a href="asie.html" class="nav-link disabled"> Asie</a>
        </li>
        <li class="nav-item"> 
          <a href="oceanie.html" class="nav-link disabled"> Océanie</a>
        </li>
      </ul>     
     </nav>
    <?php endif; ?> 
    
  </body>
</html>