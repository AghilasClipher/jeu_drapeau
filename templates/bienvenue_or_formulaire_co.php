<?php 
    include_once 'fct.php';
?>
<?php if(is_logged()): ?>
         <div class="col-sm-4" id="bienvenue_user">
           <p id="msg_bienvenue" class="text-right font-italic"> Bienvenue <span id="le_pseudo"> <?= htmlspecialchars($_SESSION['username']) ?> </span>! </p>
         </div>
      <?php else: ?>
      <div class="col-sm-4" id="formulaire_co">
        <form  method="post">
          <div class="form-row">
            <div class="col">
             <input type="text" id="pseudo_co" class="form-control" placeholder="Pseudo" name="pseudo_co">
             <small id="inscription">
              <a href="inscription.php"> Inscrivez-vous</a>
             </small>
            </div>
            <div class="col">
              <input type="password" id="password_co" class="form-control" placeholder="Mot de passe" name="password_co">
              <small id="mdp_oubli"> 
                <a href="mdp_oubli.html"> Mot de passe oublié ?</a>
              </small>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary" name="btn_valider_co"> Connexion</button>
            </div>
          </div>
        </form>
      </div>
<?php endif; ?>