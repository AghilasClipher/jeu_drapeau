<?php
   require 'Database.php';
   include_once 'fct.php';
    init_session();
    $conn=connect_to_db();
    
    //Afin de déconnecter l'utilisateur
    if(isset($_GET["action"]) && !empty($_GET["action"] && $_GET["action"]="logout")){
      clean_session();
      echo "<script> Swal.fire({
        title: 'Déconnecté',
        icon: 'success',
        confirmButtonText: 'OK'
      }); </script>";
      //header('Location: index.php');
    }

    //Lorsque l'utilisateur clique sur le bouton de connexion
    if(isset($_POST["btn_valider_co"])){
        //on vérifie si les chammps sont complets.
      if(isset($_POST["pseudo_co"]) && !empty($_POST["pseudo_co"]) && isset($_POST["password_co"]) && !empty($_POST["password_co"])){
            $username=$_POST["pseudo_co"]; 
            $password=$_POST["password_co"]; 
            $sql="Select Pseudo,Password,User_admin from utilisateurs where Pseudo=:pseudo";
            $req = $conn->prepare($sql);
            $req->bindValue(':pseudo', $username);
            $req->execute();
            // Si la requete ne retourne aucune ligne, alors le pseudo n'existe pas dans la BD !
            if($req->rowCount()==0){
                echo "<script> Swal.fire({
                    title: 'Pseudo incorrect',
                    icon: 'error',
                    text: 'Réessayez',
                    confirmButtonText: 'OK'
                  }); </script>";
            }
            while($row = $req->fetch()) {
              
              if(password_verify($password,$row['Password'])){
                $_SESSION['username']=$row['Pseudo'];
                $_SESSION['admin']=$row['User_admin'];
                echo "<script>
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 1500,
                  timerProgressBar: true,
                  onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                });
                Toast.fire({
                  icon: 'success',
                  title: 'Vous êtes connecté !'
                }); </script> "; 
                
              }
              else{
                  $_SESSION['deco']='true';
                  echo "<script> Swal.fire({
                    title: 'Mot de passe incorrect',
                    icon: 'error',
                    confirmButtonText: 'OK'
                  }); </script>";
                
              }
            }
       }
     }
     //en PHP, on affiche en faisant: <?php echo $variable > qui equivaut a <?= $title > . 
?>