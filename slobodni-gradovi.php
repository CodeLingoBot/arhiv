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
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3b-uV5ICacRP0WbW3RKOL9aNu32PUW44"></script>
	  <script defer src="js/libs/markerwithlabel.js"></script>
    <script defer src="js/postavi-mapu.js"></script>
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
     window.onload = function() {
       postaviMapu(<?php echo json_encode($gradovi); ?>);
     }
    </script>
</head>

<body>

    <div id="mesto-za-mapu"></div>

</body>
</html>
<?php $mysqli->close(); ?>
