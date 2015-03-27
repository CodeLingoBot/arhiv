<?php

require_once("../ukljuci/povezivanje.php");

$slog = filter_input(INPUT_GET, 'pocetno', FILTER_SANITIZE_STRING);
$vrsta_entia = filter_input(INPUT_GET, 'vrsta_entia', FILTER_SANITIZE_NUMBER_INT);

$upit_za_pojmove = "SELECT * FROM entia WHERE vrsta=$vrsta_entia AND naziv LIKE '%$slog%' LIMIT 15;";
$rezultat_za_pojmove = mysqli_query($konekcija, $upit_za_pojmove);

$i = 0;
while($red_za_pojmove = mysqli_fetch_assoc($rezultat_za_pojmove)){
	$id = $red_za_pojmove['id'];
	$naziv = $red_za_pojmove['naziv'];
	$pojmovi[$i][] = $naziv;
	$pojmovi[$i][] = $id;
	$i ++;
}

if ($slog != "") {

	echo "<ul id='lista_predloga'>";
	foreach($pojmovi as $par_pojmova) {
		echo "<li class='predlozi' onclick='izaberiOznaku(this)'>" . $par_pojmova[0]."</li><li class='nevidljiv'>$par_pojmova[1]</li>";
	}
	echo "</ul>";
}

?>
