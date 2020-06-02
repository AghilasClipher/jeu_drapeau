/* Je défini des niveaux de jeu; facile: on affiche le nom du pays à localiser ainsi que les délimitations des pays sur la carte ; 
	moyen: on affiche que le nom du pays à localiser mais pas les délimitations des pays
	difficile: on affiche rien du tout (juste le drapeau à localiser) 
	facile: carte = Terrain_Background
	moyen et difficile: carte= Esri_wordl_imagery*/
//variable qui indique on joue dans quel continent:
$.ajaxSetup({async: false});
var continent=document.getElementById('titre_continent').innerHTML;
var continent2=document.getElementById('titre_continent').innerHTML;
console.log(continent);
//varaible globale pour le niveau
var niveau;
//variable pour manipuler la carte 
var map;
//variable pour les pays du questionnaire(tableau)
var pays_questions=["Algérie","Australie","Madagascar","Namibie","Egypte"];
//Variable contenenant le nombre de questions
var nb_qst=5;
var vartest;
var varpays;
//Variable pour le polygone affiché
var polygone;
var pays_actuel;
var num_pays_actuel=0;
var num_qst=1;
var btn_suivant=document.getElementById("btn_suivant");
/*Cette variable sert à afficher : ou se trouve ce pays ? (niveau moyen et diff) ou : Ou se trouve la Tunisie par exemple (niveau facile)*/ 
var sous_chaine_qst=document.getElementById("sous_chaine_phrase_qst");
/*Variable pour le num de la question*/ 
var num_qst_elt=document.getElementById("num_qst");
/*var pour afficher l'image du drapeau du pays */ 
var img=document.getElementById("img_drapeau");
function onPolygoneClick(e) {
	var popup = L.popup();
	popup
	  .setLatLng(e.latlng)
	  .setContent("bg sahbi ta clik sur dz")
	  .openOn(map);
}
function verifier_is_inside_polygone(pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_json:pays},function(data){
		verifier_is_inside_polygone2(data);
	});
}
function verifier_is_inside_polygone2(geoJsonpoly){
	var parsedData=JSON.parse(geoJsonpoly);
	var polygone_bonne_reponse={
		color: 'green'
	   };
	polygone=L.geoJSON(parsedData,{ 
		style: polygone_bonne_reponse
	}).addTo(map);
	polygone.on('click',onPolygoneClick);
}
function afficher_Polygone_juste(le_pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_json:le_pays},function(data){
		afficher_Polygone2_juste(data,le_pays);
	});
}
function afficher_Polygone2_juste(geoJsonObjUnparsed,pays){
	
	var parsedData=JSON.parse(geoJsonObjUnparsed);
	var polygone_bonne_reponse={
			color: 'green'
		   };
	polygone=L.geoJSON(parsedData,{ 
			style: polygone_bonne_reponse
		}).bindTooltip(pays,{ sticky:true});
	polygone.addTo(map);
}
function enlever_Polygone(){
	map.removeLayer(polygone);
}
//Fonction recuperer_questionnaire qui récupère un questionnaire
function recuperer_questionnaire(continent){
	//$.ajaxSetup({async: false});
	$.post('ajax/recuperer_pays_geoJson.php',{continent_questionnaire:continent},function(data){
		console.log("varpays vaut"+varpays);
		varpays=data.split("/");
		console.log(typeof varpays);
		console.log("varpays vaut"+varpays);
		console.log("varpays[1]="+varpays[1]+"varpays[2]="+varpays[2]+"varpays[4]="+varpays[4]);
	});
}
//Cette fonction est appelée lorsque l'utilisateur choisit le niveau de jeu
function definirNiveau(le_niveau_choisi){
	niveau=le_niveau_choisi;
	document.getElementById("contenu_box").classList.add('invisible');
	document.getElementById("btn_commencer").classList.remove('invisible');
}
// Fonction pour afficher le texte de la question (dépends du niveau)
function afficher_Question(pays){
	if(this.niveau=='facile'){
		sous_chaine_qst.textContent=": "+pays+" ?";
	}else{
		sous_chaine_qst.textContent="ce pays ?";
	}
	num_qst_elt.innerHTML=num_qst;
	//$.ajaxSetup({async: false});
	$.post('ajax/recuperer_pays_geoJson.php',{pays_url_img:pays},function(data){
		//console.log(vartest);
		afficher_Image(data);
		vartest=data;
		//console.log(vartest);
	});
}
function afficher_Question2(pays){
	if(this.niveau=='facile'){
		sous_chaine_qst.textContent=": "+pays+" ?";
	}else{
		sous_chaine_qst.textContent="ce pays ?";
	}
	num_qst_elt.innerHTML=num_qst;
	$.ajax({'type':"POST",
			'url':"ajax/recuperer_pays_geoJson.php",
			'data':{'pays_url_img':"pays"},
			'success':function(data){
				vartest=data;
				afficher_Image(data);
			},

	});
}
function afficher_Image(url_img){
	img.src=url_img;
}
// Fonction principale du jeu:
//Fonction pour récuperer les pays du questionnaire: les mets dans un array 

function lancer_Questions(){
	afficher_Question(pays_questions[num_pays_actuel]);
	//afficher_Polygone_juste(pays_questions[num_pays_actuel]);
}
function pays_suivant(){
	num_pays_actuel++;
	num_qst++;
	//enlever_Polygone();
	lancer_Questions();
	if(num_qst==5){
		btn_suivant.classList.add("invisible");
		return;
	}
}
function commencerJeu(niveau){
	//On change la couleur du background
	document.getElementById("btn_commencer").classList.add('invisible');
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
			center: [8.968256, 18.245741],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			//maxBounds: bornes,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Amérique'){
		map = new L.Map('map', {
			center: [19.4326296, -99.1331785],
			minZoom: 2,
			maxZoom: 7,
			zoom: 2,
			//maxBounds: bornes,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Asie'){
		map = new L.Map('map', {
			center: [37.807909628196015,81.99704000585936],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			//maxBounds: bornes,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Océanie'){
		map = new L.Map('map', {
			center: [-24.7761086,134.755],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			//maxBounds: bornes,
			maxBoundsViscosity: 1.0
		});
	}else if(continent=='Europe'){
		map = new L.Map('map', {
			center: [49.49554798943879,16.126002843750005],
			minZoom: 2,
			maxZoom: 7,
			zoom: 3,
			//maxBounds: bornes,
			maxBoundsViscosity: 1.0
		});
	}
	//La layer affichée dépends du niveau choisi 
	if(this.niveau=='facile'){
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
	document.getElementById('map').style.cursor = 'crosshair';
	var popup=L.popup();
	verifier_is_inside_polygone("Algérie");
	function onMapClick(e) {
		popup.setLatLng(e.latlng)
				.setContent("Hello click détecté sur la carte !<br/> " + e.latlng.toString())
				.openOn(map);
	}
	// Association Evenement/Fonction handler
	//map.on('click', onMapClick);

	//polygone.on('click',onPolygoneClick);
	//jouer();
	//recuperer_Pays("Afrique");
	lancer_Questions();
	
	/* traitement à faire : on récupère les 5 pays du questionnaire 
	puis on fais le traitement: on affiche la question (avec le drapeau) puis ensuite 
	on fais la verification .. puis on affiche la reponse avec polygone vert ou polygone rouge */
	recuperer_questionnaire(continent);
 	console.log("varpays vaut"+varpays);
	
}


/*function recuperer_Pays(continent){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_questionnaire:continent},function(data){
		jouer(data);
	});
}
//Fonction utilisée par recuperer_Pays
function jouer(lespays){
	//console.log(lespays);
	this.pays_questions=lespays.split('/');
	var length_qst=pays_questions.length;
	afficher_Question(pays_questions[num_pays_actuel]);
	afficher_Polygone_juste(pays_questions[0]);
	afficher_Polygone_juste(pays_questions[1]);
	enlever_Polygone();
	//pays_questions[indice]=lepays;
}*/