/* Je défini des niveaux de jeu; facile: on affiche le nom du pays à localiser ainsi que les délimitations des pays sur la carte ; 
	moyen: on affiche que le nom du pays à localiser mais pas les délimitations des pays
	difficile: on affiche rien du tout (juste le drapeau à localiser) 
	facile: carte = Terrain_Background
	moyen et difficile: carte= Esri_wordl_imagery*/

//varaible globale pour le niveau
var niveau;
var map;
var sous_chaine_qst=document.getElementById("sous_chaine_phrase_qst");
function afficher_Polygone_juste(le_pays){
	$.post('ajax/recuperer_pays_geoJson.php',{pays:le_pays},function(data){
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
	L.geoJSON(parsedData,{ 
			style: polygone_bonne_reponse
		}).bindTooltip(pays,{ sticky:true}).addTo(map); 
}

//Cette fonction est appelée lorsque l'utilisateur choisit le niveau de jeu
function definirNiveau(le_niveau_choisi){
	niveau=le_niveau_choisi;
	document.getElementById("contenu_box").classList.add('invisible');
	document.getElementById("btn_commencer").classList.remove('invisible');
}

function afficher_Question(pays){
	if(this.niveau=='facile'){
		sous_chaine_qst.textContent=": "+pays+" ?";
	}else{
		sous_chaine_qst.textContent="ce pays ?";
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
	// Initialisation de la couche StamenWatercolor
	var Stamen_TerrainBackground = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain-background/{z}/{x}/{y}{r}.{ext}', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 18,
		ext: 'png'
	});
	var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 18,
		ext: 'png'
	});
	//La layer affichée dépends du niveau choisi 
	if(this.niveau=='facile'){
		map.addLayer(Stamen_TerrainBackground);
	}else{
		map.addLayer(Esri_WorldImagery);
	}
	
	//essai de polygone:
	var pays1='Egypte';
	afficher_Question(pays1);
	afficher_Polygone_juste(pays1);
	
}


