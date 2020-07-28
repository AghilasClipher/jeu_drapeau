<!doctype html>
<html lang="fr">
  <head>
    <title>GeoGamingPro - Océanie: drapeaux</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Apprendre et découvrir les pays et les drapeaux de l'Océanie avec une carte géographique.">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <!-- Script utilisé pour le sweet alert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Les fichiers css puis js concernant la carte avec Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <!-- Feuille de style CSS-->
    <link rel="stylesheet" href=styles/continent.css>
    <!-- Le script pour l'affichage des questions drapeaux -->
  
  </head>
  <body id="body_oceanie">
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    
    
    <!-- inclusion de jquery pour les requetes ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php
        include_once 'fct.php';
         init_session();
         include_once 'connexionphp.php';
         ?>
    <div class="row" id="titre_et_connexion">
      <div class="col-sm-8">
        <h1 class="display-4 titres titre_oceanie" id="titre_continent">Océanie</h1>
      </div>
      <!-- Si l'utilisateur est connecté, on affiche un message de bienvenue, sinon, on affiche le formulaire de connexion (pseudo et mdp) -->
      <?php include_once 'templates/bienvenue_or_formulaire_co.php'; ?>
    </div>
      <!-- Si l'utilisateur est connecté, on affiche la navbar correspondante -->
      <?php if(is_logged()): ?>
      <?php include_once 'templates/navbar_loggedin.php'; ?>
      <?php else: ?>
        <?php header('Location:index.php'); ?>
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

      <div class="d-flex justify-content-center" id="box_carte_jeu">
          <div  id="map" class="invisible"> </div>
          <div class="justify-content-center" id="box_jeu">
              <div class="justify-content-center invisible" id="fin_partie_recapitulatif">
                <div class="text-center" id="fin_partie_bloc">
                  <p id="score_final"> Score final: <span id="num_score_final"> </span>  /100</p>
                  <a class="btn btn-success" href="oceanie.php" role="button">Rejouer</a>
                  <a class="btn btn-dark" href="index.php" role="button">Revenir à l'accueil</a>
                </div>
              </div>
              <div class="text-center">
              <button type="button" id="btn_commencer"  class="btn btn-dark invisible les_niveaux1" onclick="commencerJeu()">Commencer</button>
              </div>
              <div class="text-center">
                <p class="invisible" id="indication"> Cliquez sur le pays correspondant sur la carte </p>
              </div>
            <!-- Cette div est utilisée pour afficher la question et l'image du drapeau -->
            <div class="container invisible" id="questions_score_count">
              <div class="row text-center" id="la_question_et_le_score">
                <div class="col-sm">
                  <p class= "score_qst" id="qst_cnt"> Question: <span id="num_qst"> 1</span>/5 </p>
                </div>
                <div class="col-sm">
                  <p class="score_qst" id="score_cnt"> Score: <span id="score_num">0</span> </p>
                </div>
              </div>
              <div class="row text-center" id="phrase_question">
                <div class="col-sm">
                  <p id="question_ou_se_trouve" class="text-center"> Où se trouve <span id="sous_chaine_phrase_qst"> </span> </p>
                </div>
              </div>
              <div class="row text-center" id="img_pays">
                <div class="col-sm" id="bloc_img_pays">
                  <!-- height 125 et w 250 -->
                  <img src="images/continent_afrique/continent.jpg" id="img_drapeau" width="250" height="150" alt="Image du drapeau du pays">
                  <p class=" invisible les_infos" id="info_pays"><span id="nom_pays_info"> Lepays </span> <br> <br>
                    Population: <span id="nombre_population_info">  </span> <br> 
                    Capitale: <span id="pays_capitale_info">  </span> <br>
                    Superficie: <span id="pays_superficie_info">  </span> <br>
                    Langue(s): <span id="pays_langue_info">  </span> <br>
                  </p>
                </div>
              </div>
              <div class="row text-center">
                <div class="col-sm">
                  <button type="button" class="btn btn-success btn_passer btn-lg invisible" id="btn_finir" onclick="finir()">Finir</button>
                  <button type="button" class="btn btn-danger btn_passer" id="btn_passer" onclick="pays_passer(0)">Passer</button>
                  <button type="button" class="btn btn-success btn_passer invisible" id="btn_suivant" onclick="pays_suivant()">Suivant</button>
                </div>
                
              </div>
            </div>
            <div id="contenu_box">
            
              <div id="question_pour_joueur" class="text-center">
                  <p id="choisir_niveau"> Choisir votre niveau </p>
              </div>
              <div id="option_niveau">
                <div class="text-center">
                  <button type="button" class="btn btn-warning les_niveaux1" onclick="definirNiveau('facile')">Facile</button>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-warning les_niveaux23" onclick="definirNiveau('moyen')">Moyen</button>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-warning les_niveaux23" onclick="definirNiveau('difficile')" >Difficile</button>
                </div>
              <div>
            </div>
          </div>
      </div>
      
      <script src="scripts/afrique_carte.js" type="text/javascript"> </script>
      
    

  </body>
</html>