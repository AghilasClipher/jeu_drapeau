<?php 
    require 'fct.php';
    require 'Database.php';
    init_session();
    //On ne peut pas accéder à la page d'inscription si on est déja connecté. 
    if(is_logged()){
        header('Location:index.php');
    }
    $conn=connect_to_db();
    if(isset($_POST["btn_sinscrire"])){
      $pseudo = !empty($_POST["pseudo_reg"]) ? trim($_POST["pseudo_reg"]) : null;
      $password= $_POST["password_reg"];
      $pays=$_POST["selection_pays"];
      $email=$_POST["email"];
      // On verifie si les inputs pour l'inscription sont vides
      if(empty($pseudo) || empty($password) || empty($pays) || empty($email)){
        if(!empty($pseudo) && (!empty($email))){
          $_SESSION['inscription']='empty';
          $_SESSION['pseudo_inscription']=$pseudo;
          $_SESSION['email_inscription']=$email;
          header("Location:inscription.php");
          exit();
        }
        elseif(!empty($pseudo)){
          $_SESSION['inscription']='empty';
          $_SESSION['pseudo_inscription']=$pseudo;
          header("Location:inscription.php");

          exit();
        }
        else{
          header("Location:inscription.php");
          exit();
        }
      
      }
      elseif(strlen($pseudo)>25){
        $_SESSION['inscription']='pseudolg';
          $_SESSION['email_inscription']=$email;
        header("Location:inscription.php");
        exit();
      }
      //On vérifie d'abord si le pseudo du joueur existe déja dans la BD. Dans ce cas, l'inscription est impossible car le pseudo est unique. 
      $sql = "SELECT COUNT(Pseudo) AS num FROM utilisateurs WHERE Pseudo = :username";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':username', $pseudo);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      // Si on rentre dans le if, alors le pseudo est indisponible. 
      if($row["num"]>0){
        $_SESSION['inscription']='pseudoindispo';
        $_SESSION['email_inscription']=$email;
        $_SESSION['pseudo_inscription']=$pseudo;
        header("Location:inscription.php");
        exit();
      }
      // Ensuite, on vérfie si le mail existe déja.. (même traitement que pseudo indisponible)
      $sql = "SELECT COUNT(Email) AS num FROM utilisateurs WHERE Email = :email";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row["num"]>0){
        $_SESSION['inscription']='emailindispo';
        $_SESSION['pseudo_inscription']=$pseudo;
        $_SESSION['email_inscription']=$email;
        header("Location:inscription.php");
        exit();
      }
      // Ensuite, on vérifie la longueur du mot de passe (au moins 8 caractères)
      if(strlen($password)<8 || strlen($password)>30){
        $_SESSION['inscription']='mdp_pb';
        $_SESSION['pseudo_inscription']=$pseudo;
        $_SESSION['email_inscription']=$email;
        header("Location:inscription.php");
        exit();
      }
      // à partir d'ici, c'est bon !
      $passwordHash = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO utilisateurs (Pseudo,Email,Pays,Date_inscription,User_admin,Password) VALUES (:pseudo,:email, :pays,NULL,0,:password)";
      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':pseudo', $pseudo);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':pays', $_POST["selection_pays"]);
      $stmt->bindValue(':password',$passwordHash);
      $_SESSION['pseudo_inscription']=$pseudo;
 
      //On execute et on insère le nouveau compte
      $result = $stmt->execute();
      
    
      //If the signup process is successful.
      if($result){
        $_SESSION['pseudo_inscription']=$pseudo;
        $_SESSION['inscription']='success';
        header("Location:inscription.php");
        
      }
    }
?>