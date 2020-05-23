<?php 
    /*Ce fichier récupère l'information de type geoJSON sur un pays spécifique 
    dont le nom est envoyé en POST */
    require_once '../Database.php';
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
    }elseif(isset($_POST['pays_questionnaire'])){
        $continent=$_POST['pays_questionnaire'];
        $conn=connect_to_db();
        $sql = "SELECT Pays1,Pays2 FROM questionnaires WHERE Continent = :le_continent";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':le_continent', $continent);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["Pays1"];
        echo "/";
        echo $row["Pays2"];
       
    }
?>