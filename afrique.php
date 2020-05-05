<!doctype html>
<html lang="en">
  <head>
    <title>Afrique: drapeaux</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     
     <!-- Script utilisé pour le sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Les fichiers css puis js concernant la carte avec Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <!-- Feuille de style CSS-->
    <link rel="stylesheet" href=css/continent.css>
    <!-- Le script pour l'affichage des questions drapeaux -->
    <script defer src="js/afrique_jeu.js"> </script>
  </head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <?php
       //commentaire php ! 
        include_once 'fct.php';
         init_session();
         include_once 'templates/connexionphp.php';
         ?>
    <div class="row" id="titre_et_connexion">
      <div class="col-sm-8">
        <h1 class="display-4 titres" id="titre_afrique"> Afrique</h1>
      </div>
      <!-- Si l'utilisateur est connecté, on affiche un message de bienvenue, sinon, on affiche le formulaire de connexion (pseudo et mdp) -->
      <?php include_once 'templates/bienvenue_or_formulaire_co.php'; ?>
    </div>
      <!-- Si l'utilisateur est connecté, on affiche la navbar correspondante -->
      <?php if(is_logged()): ?>
      <?php include_once 'templates/navbar_loggedin.php'; ?>
      <?php else: ?>
          <nav class="navbar bg-dark navbar-dark navbar-expand-sm" id="navbar_continents_profil"> 
            <ul class="navbar-nav">
              <li class="nav-item "> 
               <a href="index.php" class="nav-link"> Accueil</a>
              </li>
              <li class="nav-item "> 
               <a href="inscription.php" class="nav-link" title="Jouez sans limite !"> S'inscrire</a>
              </li> 
            </ul>
         </nav>
      <?php endif; ?>
      <div class="container-fluid" id="box_carte_jeu">
        <div class="row">
          <div class="coll-sm" id="map"></div>
          <div class="coll-sm" id="box_jeu">
              <div class=row id="rang_btn">
                <div class="controls">
                  <button type="button" class="btn btn-primary btn-lg jouer-btn">Jouer</button>
                  <button type="button" class="btn btn-primary btn-lg suivant-btn">Suivant</button>          
                </div>
              </div>
          </div>
        </div>
      </div>
      
      <script src="js/afrique_carte.js"> </script>
      
    

  </body>
</html>
