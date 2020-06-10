/* Je défini des niveaux de jeu; facile: on affiche le nom du pays à localiser ainsi que les délimitations des pays sur la carte ; 
	moyen: on affiche que le nom du pays à localiser mais pas les délimitations des pays
	difficile: on affiche rien du tout (juste le drapeau à localiser) 
	facile: carte = Terrain_Background
	moyen et difficile: carte= Esri_wordl_imagery*/
/* On initialise les requetes ajax a etres synchrones afin de pouvoir récuperer les informations*/

$.ajaxSetup({async: false});
//Variable utilisateur_connecte qui indique si l'utilisateur est connecté ou non
var utilisateur_connecte=document.getElementById("le_pseudo");
if(utilisateur_connecte!=null){
	utilisateur_connecte=utilisateur_connecte.innerHTML;
	utilisateur_connecte=utilisateur_connecte.trim();
}

console.log(utilisateur_connecte);
if(utilisateur_connecte==null){
	console.log("l'utilisateur == null mgl");
}else{
	console.log("l'utilisateur est: "+utilisateur_connecte);
}
//Variable utilisée a la fin de la partie, contient le score, pseudo et continent (pour enregistrer la partie)
var utilisateur_continent_score;
var essai=0;
//variable qui indique on joue dans quel continent:
var continent=document.getElementById('titre_continent').innerHTML;
//varaible globale pour le niveau
var niveau;
//variable pour manipuler la carte 
var map;
//variable pour les pays du questionnaire(tableau)
var pays_questions;
//Variable contenenant le nombre de questions (il y a 5 questions par questionnaire!)
var nb_qst=5;
//Variable contenant l'id de la phrase qui indique le nombre d'essais (nb clicks)
//var nombre_essais=document.getElementById("nombre_essais");
var vartest;
var varpays;
//Variable pour le polygone affiché
var polygones;
// variable pour l'indication "cliquez sur le pays"
var indication=document.getElementById("indication");
//Variables pour gérer le score
var score=document.getElementById("score_num");
var score_num=0; 
// Variable pour enlever la question lorsqu'on affiche les infos du pays
var question_ou_se_trouve=document.getElementById("question_ou_se_trouve");
/*Variable pour afficher le score final: */
var num_score_final=document.getElementById("num_score_final");
//Variables utilisées pour afficher les informations relatives au pays indiqué:
var pays_info=document.getElementById("nom_pays_info");
var population=document.getElementById("nombre_population_info");
var capitale=document.getElementById("pays_capitale_info");
var langue=document.getElementById("pays_langue_info");
var superficie=document.getElementById("pays_superficie_info");
//Varibale pour le son
var son_error = document.getElementById("audio_erreur");
/* Variable pour la fin de partie : rejouer, score final etc (c'est une div) */
var fin_partie=document.getElementById("fin_partie_recapitulatif");
var marker;
var popup = L.popup();
var bonne_reponse=0;
var son_success= document.getElementById("audio_success");
var num_pays_actuel=0;
var num_qst=1;
var btn_finir=document.getElementById("btn_finir");
var btn_passer=document.getElementById("btn_passer");
var btn_suivant=document.getElementById("btn_suivant");
var bloc_info=document.getElementById("info_pays");
/*Cette variable sert à afficher : ou se trouve ce pays ? (niveau moyen et difficile) ou : Ou se trouve la Tunisie par exemple (niveau facile)*/ 
var sous_chaine_qst=document.getElementById("sous_chaine_phrase_qst");
/*Variable pour le numéro de la question*/ 
var num_qst_elt=document.getElementById("num_qst");
/*var pour afficher l'image du drapeau du pays */ 
var img=document.getElementById("img_drapeau");

/* Les fonctions: */ 

//Cette fonction est appelée lorsque l'utilisateur choisit le niveau de jeu
function definirNiveau(le_niveau_choisi){
	niveau=le_niveau_choisi;
	document.getElementById("contenu_box").classList.add('invisible');
	document.getElementById("btn_commencer").classList.remove('invisible');
	indication.classList.remove('invisible');
}
//Fonction qui change le score
function set_score(the_score){
	score.innerHTML=score_num;
}
function onPolygoneClick(e) {
	//jouer_son_success();
	bonne_reponse=1;
	//var popup = L.popup();
	
	popup
	  .setLatLng(e.latlng)
	  .setContent("Correct ! Vous avez bien trouvé: "+ pays_questions[num_pays_actuel])
	  .openOn(map);
	  afficher_Polygone_juste(pays_questions[num_pays_actuel]);
	  setTimeout(function(){ 
		map.closePopup(); }, 2200);
	score_num+=20;
	set_score(score_num);
	pays_passer(1);
}

// Fonction qui vérifie si l'utilisateur a cliqué sur le bon pays 
function verifier_click_polygone(pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_json:pays},function(data){
		//afficher_Polygone2_juste(data,le_pays);
		var parsedData=JSON.parse(data);
		var polygone_bonne_reponse={
				opacity: 0,
				fillOpacity: 0
			};
		polygone=L.geoJSON(parsedData,{ 
				style: polygone_bonne_reponse
			});
		polygone.addTo(map);
		});
		polygone.on('click',onPolygoneClick);
		//console.log("on est dans verifier click");
		
}
function afficher_Polygone_juste(le_pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_json:le_pays},function(data){
		var parsedData=JSON.parse(data);
		var polygone_bonne_reponse={
				color: 'green'
			};
		polygone=L.geoJSON(parsedData,{ 
				style: polygone_bonne_reponse
			}).bindTooltip(le_pays,{ sticky:true});
		polygone.addTo(map);
		});
}
function afficher_Polygone_faux(le_pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_json:le_pays},function(data){
		var parsedData=JSON.parse(data);
		var polygone_bonne_reponse={
				color: 'red'//,
				//opacity: 0,
				//fillOpacity: 0
			};
		polygone=L.geoJSON(parsedData,{ 
				style: polygone_bonne_reponse
			}).bindTooltip(le_pays,{ sticky:true});
		polygone.addTo(map);
		});
}
/*Fonction recuperer_questionnaire qui récupère un questionnaire de la BD */
function recuperer_questionnaire(continent){
	$.post('ajax/recuperer_pays_geoJson.php',{continent_questionnaire:continent},function(data){
		pays_questions=data.split("/");
	});
}
/* Fonction mapSetCenterZoom qui recentre la carte.. on l'utilise après que l'utilisateur a répondu à une question 
	(par exemple si il a du zoomer pour cliquer sur un petit pays) */
function mapSetCenterZoom(){
	if(continent=='Afrique'){
		map.setView(new L.LatLng(1.7977763688582644, 21.27796756249998), 3);
	}else if(continent=='Europe'){
		map.setView(new L.LatLng(49.49554798943879,16.126002843750005), 3);
	}else if(continent=='Océanie'){
		map.setView(new L.LatLng(-24.7761086,134.755), 3);
	}else if(continent=='Asie'){
		map.setView(new L.LatLng(37.807909628196015,81.99704000585936), 3);
	}else if(continent=='Amérique'){
		map.setView(new L.LatLng(19.4326296, -99.1331785), 3);
	}else if(continent=='Monde'){
		map.setView(new L.LatLng(21.420847,39.826869),2);
	}
}
// Fonction pour afficher le texte de la question (dépends du niveau)
function afficher_Question(pays){
	if(this.niveau=='facile'){
		sous_chaine_qst.textContent=": "+pays+" ?";
	}else{
		sous_chaine_qst.textContent="ce pays ?";
	}
	//On change le numéro de la question
	num_qst_elt.innerHTML=num_qst;
	$.post('ajax/recuperer_pays_geoJson.php',{pays_url_img:pays},function(data){
		img.src=data;
	});
	console.log("on est dans afficher question:"+pays_questions[num_pays_actuel]);
	
	verifier_click_polygone(pays_questions[num_pays_actuel]);
}


// Fonction qui lance la question suivant du questionnaire
function lancer_Questions(){
	afficher_Question(pays_questions[num_pays_actuel]);
	
}
/*Lorsque l'utilisateur ne sait pas ou se trouve un pays, il peut décider de passer, on affiche donc les infos relatives au pays 
  et on affiche le polygone du pays de couleur rouge
*/
function pays_passer(success){
	console.log("num pays actuel: "+num_pays_actuel+" pays actuel est:"+pays_questions[num_pays_actuel]+" dans debut de pays_passer");
	bonne_reponse=1;
	question_ou_se_trouve.classList.add('invisible');
	btn_passer.classList.add("invisible");
	//Si on arrive à la dernière question, on affiche pas le bouton suivant (logique)
	if(num_pays_actuel<4){
		btn_suivant.classList.remove("invisible");
	}else{
		btn_finir.classList.remove('invisible');
	}
	img.classList.add("invisible");
	bloc_info.classList.remove("invisible");
	if (success==0){
		afficher_Polygone_faux(pays_questions[num_pays_actuel]);
		afficher_info_pays(pays_questions[num_pays_actuel]);
		//num_pays_actuel++;
	}else{
		afficher_info_pays(pays_questions[num_pays_actuel]);
		
		//num_pays_actuel++;
	}
}
/* fonction qui affiche les infos sur un pays (capitale, etc) */ 
function afficher_info_pays(pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_info:pays},function(data){
		var les_infos=data.split('/');
		pays_info.innerHTML=pays_questions[num_pays_actuel];
		population.innerHTML=les_infos[0];
		capitale.innerHTML=les_infos[1];
		superficie.innerHTML=les_infos[2];
		langue.innerHTML=les_infos[3];
	});
}
function pays_suivant(){
	map.closePopup();
	//popup.closePopup();
	console.log("dans pays_suivant, popup vaut: "+popup);
	mapSetCenterZoom();
	//polygone.closePopup();
	essai=0;
	bonne_reponse=0;
	num_pays_actuel++;
	question_ou_se_trouve.classList.remove('invisible');
	btn_suivant.classList.add("invisible");
	btn_passer.classList.remove("invisible");
	bloc_info.classList.add("invisible");
	img.classList.remove("invisible");
	//num_pays_actuel++;
	num_qst++;
	lancer_Questions();
	if(num_qst==6){
		btn_passer.classList.add("invisible");
		return;
	}
}
function jouer_son_success(){
	son_success.play();
}
function jouer_son_erreur(){
	son_error.sound=0.0;
    son_error.play();
}

/*Fonction finir, appelée après que l'utilisateur ai cliqué sur le bouton finir
 (on affiche le récapitulatif de la partie et on l'enregistre dans la BD si il est connecté) */
function finir(){
	mapSetCenterZoom();
	document.getElementById("questions_score_count").classList.add('invisible');
	num_score_final.innerHTML=score_num;
	fin_partie.classList.remove("invisible");
	if(utilisateur_connecte!=null){
		utilisateur_continent_score=utilisateur_connecte;
		utilisateur_continent_score=utilisateur_continent_score.concat("/",continent,"/",score_num);
		console.log(utilisateur_continent_score);
		$.post('ajax/recuperer_pays_geoJson.php',{fin_partie:utilisateur_continent_score}); 
	}
	

}
/*Fonction principale du jeu, on initialise la map et on set le zoom*/
function commencerJeu(niveau){
	//On change la couleur du background
	document.getElementById("btn_commencer").classList.add('invisible');
	indication.classList.add('invisible');
	document.getElementById("box_jeu").style.backgroundColor="#1E90FF";
	document.getElementById("questions_score_count").classList.remove('invisible');
	// bornes pour empecher la carte de "dériver" trop loin...
	var northWest = L.latLng(42.841047, -31.676134);
	var southEast = L.latLng(-42.158951, 77.495741);
	var bornes = L.latLngBounds(northWest, southEast);
	// Initialisation de la carte et association avec la div
	document.getElementById("map").classList.remove('invisible');
	document.getElementById("contenu_box").classList.add('invisible');
	//on crée la carte, et on la centre sur le continent correspondant 
	if(continent=='Afrique'){
		map = new L.Map('map', {
			center: [1.7977763688582644, 21.27796756249998],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			zoomSnap:0,
			zoomDelta:0.5,
			heelPxPerZoomLevel: 30,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Amérique'){
		map = new L.Map('map', {
			center: [19.4326296, -99.1331785],
			minZoom: 2,
			maxZoom: 7,
			zoom: 2,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Asie'){
		map = new L.Map('map', {
			center: [37.807909628196015,81.99704000585936],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Océanie'){
		map = new L.Map('map', {
			center: [-24.7761086,134.755],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Europe'){
		map = new L.Map('map', {
			center: [49.49554798943879,16.126002843750005],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			zoomSnap:0.5,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Monde'){
		map = new L.Map('map', {
			center: [21.420847,39.826869],
			minZoom: 1,
			maxZoom: 7,
			zoom: 2,
			zoomSnap:0.5,
			maxBoundsViscosity: 1.0
		});
	}
	//La layer affichée dépends du niveau choisi 
	if(this.niveau=='facile' || this.niveau=='moyen'){
		var Stamen_TerrainBackground = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain-background/{z}/{x}/{y}{r}.{ext}', {
			attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			subdomains: 'abcd',
			minZoom: 0,
			maxZoom: 18,
			ext: 'png'
		});
		map.addLayer(Stamen_TerrainBackground);
	}else{
			var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
			attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
			subdomains: 'abcd',
			minZoom: 0,
			maxZoom: 18,
			ext: 'png'
		});
		map.addLayer(Esri_WorldImagery);
	}
	//On change la forme du curseur
	document.getElementById('map').style.cursor = 'crosshair';
	var popup=L.popup();
	function onMapClick(e) {
		essai++;
		var essais_restants=3-essai;
		if(marker){
			map.removeLayer(marker);
		}
		if(essai==3 && bonne_reponse==0){
			pays_passer(0);
		}
		if(bonne_reponse==0 && essai<3){
			marker=L.marker(e.latlng).addTo(map);
			if(niveau=='facile'){
				marker.bindPopup(pays_questions[num_pays_actuel]+": il vous reste "+essais_restants+" essai(s).");
			}else{
				marker.bindPopup("Il vous reste "+essais_restants+" essai(s).");
			}
			
			marker.openPopup();
			setTimeout(function(){ 
						marker.closePopup(); }, 2250);
			setTimeout(function(){ 
							map.removeLayer(marker); }, 3500);
		}
				
		
		
		console.log(essai);
		//jouer_son_erreur();
	}
	// Association Evenement/Fonction handler
	map.on('click', onMapClick);

	//On récupère le questionnaire du continent 
	recuperer_questionnaire(continent);
	//On lance les questions
	lancer_Questions();
	
	/* traitement à faire : on récupère les 5 pays du questionnaire 
	puis on fais le traitement: on affiche la question (avec le drapeau) puis ensuite 
	on fais la verification .. puis on affiche la reponse avec polygone vert ou polygone rouge */
 	console.log("paysquestions dans fin script vaut"+pays_questions);
	
}
