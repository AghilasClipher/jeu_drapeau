<?php 
    /*Ce fichier récupère l'information de type geoJSON sur un pays spécifique 
    dont le nom est envoyé en POST */
    require_once '../Database.php';
    require_once '../fct.php';
    if(isset($_POST['pays_json'])){
        $pays=$_POST['pays_json'];
        $conn=connect_to_db();
        $sql = "SELECT Info_geo_json FROM pays WHERE Nom_pays = :le_pays";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':le_pays', $pays);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["Info_geo_json"];
    }elseif(isset($_POST['pays_url_img'])){
        $pays=$_POST['pays_url_img'];
        $conn=connect_to_db();
        $sql = "SELECT Url_image FROM pays WHERE Nom_pays = :le_pays";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':le_pays', $pays);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["Url_image"];
    }elseif(isset($_POST['continent_questionnaire'])){
        $continent=$_POST['continent_questionnaire'];
        $conn=connect_to_db();
        $num=rand(1,3);
        $sql = "SELECT Pays1,Pays2,Pays3,Pays4,Pays5 FROM questionnaires WHERE Continent = :le_continent and Num= :le_num";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':le_continent', $continent);
        $stmt->bindValue(':le_num', $num);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["Pays1"];
        echo "/";
        echo $row["Pays2"];
        echo "/";
        echo $row["Pays3"];
        echo "/";
        echo $row["Pays4"];
        echo "/";
        echo $row["Pays5"];
    }elseif(isset($_POST['pays_info'])){
        $pays=$_POST['pays_info'];
        $conn=connect_to_db();
        $sql = "SELECT Population,Capitale,Supérficie,Langue FROM pays WHERE Nom_pays = :le_pays";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':le_pays', $pays);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["Population"];
        echo "/";
        echo $row["Capitale"];
        echo "/";
        echo $row["Supérficie"];
        echo "/";
        echo $row["Langue"];
       
    }elseif(isset($_POST['fin_partie']) ){
        //On récupère le continent et le score
        $string=$_POST['fin_partie'];
        $infos=explode("/",$string);
        $utilisateur=$infos[0];
        $continent=$infos[1];
        $score_final=$infos[2];
        $conn=connect_to_db();
        $sql = "INSERT INTO historique (Pseudo,Continent,Score) VALUES (:pseudo,:continent,:score)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':pseudo', $utilisateur);
        $stmt->bindValue(':continent', $continent);
        $stmt->bindValue(':score', $score_final);
        $stmt->execute();
    }
?>