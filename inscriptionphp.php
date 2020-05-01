<?php 
    require 'fct.php';
    require 'Database.php';
    init_session();
    //On ne peut pas accéder à la page d'inscription si on est déja connecté. 
    if(is_logged()){
        header('Location:accueil_jeu.php');
    }
    $conn=connect_to_db();
    if(isset($_POST["btn_sinscrire"])){
      $username = !empty($_POST["pseudo_reg"]) ? trim($_POST["pseudo_reg"]) : null;
      $password= $_POST["password_reg"];
      $pays=$_POST["selection_pays"];
      $email=$_POST["email"];
      // On verifie si les inputs pour l'inscription sont vides
      if(empty($username) || empty($password) || strcmp("Choisir votre pays",$pays)==0 || empty($email)){
        header("Location:inscription.php?inscription=empty");
        exit();
      }
      elseif(strlen($username)>15){
        header("Location:inscription.php?inscription=pseudolg&email=$email");
        exit();
      }
      $sql = "SELECT COUNT(Pseudo) AS num FROM utilisateurs WHERE Pseudo = :username";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':username', $username);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row["num"]>0){
        header("Location:inscription.php?inscription=pseudoindispo&email=$email");
        exit();
      }
      $passwordHash = password_hash($_POST["password_reg"], PASSWORD_BCRYPT);
      $sql = "INSERT INTO utilisateurs (Pseudo,Email,Pays,Date_inscription,User_admin,Password) VALUES (:pseudo,:email, :pays,NULL,0,:password)";
      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':pseudo', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':pays', $_POST["selection_pays"]);
      $stmt->bindValue(':password',$passwordHash);
      
 
      //Execute the statement and insert the new account.
      $result = $stmt->execute();
    
      //If the signup process is successful.
      if($result){
        //What you do here is up to you!
        header("Location:inscription.php?inscription=success");
      }
    }
?>