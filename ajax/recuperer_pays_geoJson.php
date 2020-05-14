<?php 
    /*Ce fichier récupère l'information de type geoJSON sur un pays spécifique 
    dont le nom est envoyé en POST */
    require_once '../Database.php';
    if(isset($_POST['pays'])){
        $pays=$_POST['pays'];
        $conn=connect_to_db();
        $sql = "SELECT Info_geo_json FROM pays WHERE Nom_pays = :le_pays";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':le_pays', $pays);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["Info_geo_json"];
    }
?>