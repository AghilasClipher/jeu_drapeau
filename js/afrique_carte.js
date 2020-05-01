// bornes pour empecher la carte StamenWatercolor de "dériver" trop loin...
var northWest = L.latLng(42.841047, -31.676134);
var southEast = L.latLng(-42.158951, 77.495741);
var bornes = L.latLngBounds(northWest, southEast);
// Initialisation de la couche StamenWatercolor
var Stamen_TerrainBackground = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain-background/{z}/{x}/{y}{r}.{ext}', {
    attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	subdomains: 'abcd',
	minZoom: 0,
	maxZoom: 18,
	ext: 'png'
});
// Initialisation de la carte et association avec la div
var map = new L.Map('map', {
				center: [8.968256, 18.245741],
				minZoom: 2,
		        maxZoom: 7,
				zoom: 3,
                maxBounds: bornes,
                maxBoundsViscosity: 1.0
			});
			//var map = L.map('maDiv').setView([48.858376, 2.294442],5);
            // Affichage de la carte
map.addLayer(Stamen_TerrainBackground);


