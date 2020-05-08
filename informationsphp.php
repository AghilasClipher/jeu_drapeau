<?php 
    include_once 'fct.php';
    include_once 'Database.php';
    init_session();
    //On ne peut pas accéder à la page du profil si on est pas connecté. 
    if(!is_logged()){
        header('Location:index.php');
    }
    //On va récupérer les informations de l'utilisateur connecté. 
    $pseudo=$_SESSION["username"];
    $conn=connect_to_db();
    $sql = "SELECT *  FROM utilisateurs WHERE Pseudo = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $pseudo);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $nb_lignes_retournees=$stmt->rowCount();

    // Si la requete ne renvoie rien ou plus de 2 lignes (impossible car pseudo unique !!), il y a un pb, donc on renvoie l'utilisateur à l'accueil
    if($nb_lignes_retournees==0 || $nb_lignes_retournees>1){
        header("Location:index.php");
        exit();
    }
    $_SESSION["email"]=$row["Email"];
    $_SESSION["pays"]=$row["Pays"];
    $_SESSION["date_inscription"]=$row["Date_inscription"];
    $_SESSION["nb_parties"]=$row["Nb_parties"];
?>