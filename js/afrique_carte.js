/* Je défini des niveaux de jeu; facile: on affiche le nom du pays à localiser ainsi que les délimitations des pays sur la carte ; 
	moyen: on affiche que le nom du pays à localiser mais pas les délimitations des pays
	difficile: on affiche rien du tout (juste le drapeau à localiser) 
	facile: carte = Terrain_Background
	moyen et difficile: carte= Esri_wordl_imagery*/

//varaible globale pour le niveau
var niveau;
//variable pour manipuler la carte 
var map;
//variable pour les pays du questionnaire(tableau)
var pays_questions=["Algérie","Namibie","Madagascar","Egypte","Mali"];
//Variable pour le polygone affiché
var polygone;
/*Cette variable sert à afficher : ou se trouve ce pays ? (niveau moyen et diff) ou : Ou se trouve la Tunisie par exemple (niveau facile)*/ 
var sous_chaine_qst=document.getElementById("sous_chaine_phrase_qst");
/*var pour afficher l'image du drapeau du pays */ 
var img=document.getElementById("img_drapeau");

function afficher_Polygone_juste(le_pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays_json:le_pays},function(data){
		console.log(data);
		afficher_Polygone2(data,le_pays);
	});
}
function afficher_Polygone2(geoJsonObjUnparsed,pays){
	
	var parsedData=JSON.parse(geoJsonObjUnparsed);
	console.log("iciiii");
	console.log(parsedData);
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
	$.post('ajax/recuperer_pays_geoJson.php',{pays_url_img:pays},function(data){
		afficher_Image(data);
	});
}
function afficher_Image(url_img){
	img.src=url_img;
}
// Fonction principale du jeu: 
function jouer(){
	var length_qst=pays_questions.length;
	var i;
	var pays_actuel;
	for(i=0;i<1;i++){
		pays_actuel=pays_questions[i];
		afficher_Question(pays_actuel);
		afficher_Polygone_juste(pays_actuel);
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
	map = new L.Map('map', {
		center: [8.968256, 18.245741],
		minZoom: 2,
		maxZoom: 7,
		zoom: 3,
		maxBounds: bornes,
		maxBoundsViscosity: 1.0
	});
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
	jouer();
	/* traitement à faire : on récupère les 5 pays du questionnaire 
	puis on fais le traitement: on affiche la question (avec le drapeau) puis ensuite 
	on fais la verification .. puis on affiche la reponse avec polygone vert ou polygone rouge */

 	
	
}


