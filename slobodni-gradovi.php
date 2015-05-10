<?php

include_once "ukljuci/povezivanje2.php";

$dan = $_GET['dan'] ? $mysqli->real_escape_string($_GET['dan']) : date("d"); 
$mesec = $_GET['mesec'] ? $mysqli->real_escape_string($_GET['mesec']) : date("m"); 
$godina = $_GET['godina'] ? $mysqli->real_escape_string($_GET['godina']) : 1943; 

$dan_rata = 10497 + strtotime($godina . "-" . $mesec . "-" . $dan) / 86400;

$upit_za_gradove = sprintf("SELECT * FROM entia WHERE vrsta=2;");

if ($rezultat_za_gradove = $mysqli->query($upit_za_gradove)) {
	
	$broj_redova = $rezultat_za_gradove->num_rows;
	$podaci_za_grad = [];
	$gradovi = [];
	
	while ($red_za_gradove = $rezultat_za_gradove->fetch_assoc()) {
		$podaci_za_grad[] = $grad_id = $red_za_gradove['id'];
		$podaci_za_grad[] = $naziv = $red_za_gradove['naziv'];
		$podaci_za_grad[] = $kord_x = $red_za_gradove['n'];
		$podaci_za_grad[] = $kord_y = $red_za_gradove['e'];

		$slobodan = 2;	// podrazumeva da nije slobodan
		
		// nalazi dal je slobodan
		$upit_s = "SELECT * FROM eventu WHERE ko=$grad_id order by kadyy,kadmm,kadd";
		$rezultat_s = $mysqli->query($upit_s);
		
		while($red_s = $rezultat_s->fetch_assoc()){

			$dan_akcije = 10497 + strtotime($red_s['kadyy'] . "-" . $red_s['kadmm'] . "-" . $red_s['kadd']) / 86400;

			if($dan_akcije > $dan_rata) {break;}
			$slobodan = $red_s['sta'];			
		}

		$podaci_za_grad[] = $slobodan;
		$gradovi[] = $podaci_za_grad;
		unset($podaci_za_grad);	

	}

	$rezultat_za_gradove->free();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Slobodni gradovi</title>
	<meta charset="UTF-8">
	
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3b-uV5ICacRP0WbW3RKOL9aNu32PUW44"></script>
	<script src="js/markeri_sa_nazivima.js"></script>

    <style>
	html, body {
		margin:0;
		border:0;
		width: 100%;
	}
	#mesto-za-mapu {
		width: 100%;
		height: 700px;
	}
	.nazivi {
		color: red;
		background-color: white;
		font-family: "Lucida Grande", "Arial", sans-serif;
		font-size: 10px;
		font-weight: bold;
		text-align: center;
		border: 2px solid black;
		white-space: nowrap;
	}
    .gm-style-iw a {
        color:red;
    }
    </style>

    <script>

	var gradovi = <?php echo json_encode($gradovi); ?>;

	function postaviMapu() {
	
		var opcijeMape = {
			zoom: 7,
			minZoom: 6,
			maxZoom: 9,
			center: new google.maps.LatLng(43.8, 18.5),
			scrollwheel: false,
			mapTypeControl: false,
			scaleControl: false,
			streetViewControl: false,
			overviewMapControl: false,
			
			panControl: true,
			panControlOptions: {
				position: google.maps.ControlPosition.RIGHT_TOP
			},
			
			zoomControl: true,
			zoomControlOptions: {
				position: google.maps.ControlPosition.RIGHT_TOP
			},	

			mapTypeId: google.maps.MapTypeId.TERRAIN,
			types: ['(regions)'],
			styles: [
			  {
				"featureType": "administrative",
				"stylers": [
				  { "visibility": "off" }
				]
			  },{
				"featureType": "road",
				"stylers": [
				  { "visibility": "off" }
				]
			  },{
				"featureType": "poi",
				"stylers": [
				  { "visibility": "off" }
				]
			  },{
				"featureType": "landscape",
				"stylers": [
				  { "visibility": "off" }
				]
			  },{
				"featureType": "transit",
				"stylers": [
				  { "visibility": "off" }
				]
			  },{
				"featureType": "water",
				"elementType": "labels",
				"stylers": [
				  { "visibility": "off" }
				]
			  },{
				"featureType": "water",
				"elementType": "geometry.fill",
				"stylers": [
				  { "color": "#CCF0F6" }
				]
			  }
			]
		};	// kraj opcija mape

		var mapa = new google.maps.Map(document.getElementById('mesto-za-mapu'), opcijeMape);
		var prozorce = new google.maps.InfoWindow(), marker, i;
		
		for( i = 0; i < gradovi.length; i++ ) {

			var geografski_polozaj = new google.maps.LatLng(gradovi[i][2], gradovi[i][3]);

			// ako je grad slobodan
			if(gradovi[i][4]==1) {
			
				var marker = new MarkerWithLabel({
					position: geografski_polozaj,
					map: mapa,
					title: gradovi[i][1],
					icon: {
						path: google.maps.SymbolPath.CIRCLE,
						scale: 4,
						strokeWeight: 2,
						fillOpacity: 1,
						strokeColor: '#FF0000',
						fillColor: '#FF0000'
					},
					labelContent: gradovi[i][1],
					//labelAnchor: new google.maps.Point(22, 0), //smešta naziv
					labelClass: "nazivi", // CSS klasa za natpise
					labelStyle: {opacity: 0.75}
				});

				// prikazuje sadržaj u prozorcetu na klik
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
                        var naziv_grada = gradovi[i][1];
                        var id_grada = gradovi[i][0];
                        var url = 'pojam.php?br=' + id_grada;
                        prozorce.setContent("<a href=" + url + " target='_blank'><h3>" + naziv_grada + " u oslobodilačkom ratu </h3><img src='slike/ustanak.jpg' height='200'></a>");
						prozorce.setPosition(geografski_polozaj); 	// ne radi
						prozorce.open(mapa, marker);
					}
				})(marker, i));
				
				// zatvara prozorcice
				google.maps.event.addListener(mapa, 'click', (function(marker, i) {
					return function() {
						prozorce.close();
					}
				})(marker, i));

				
			}	// kraj ako su slobodni
		
		}	// kraj for postavlja markere
		
	}	// kraj postaviMapu

    </script>
</head>

<body onload="postaviMapu()">

    <div id="mesto-za-mapu"></div>
	
</body>
</html>
<?php $mysqli->close(); ?>
