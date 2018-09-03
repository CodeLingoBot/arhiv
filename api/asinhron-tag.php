<?php

require_once("../ukljuci/config.php");
require_once("../ukljuci/povezivanje.php");

$vrsta_materijala = $_GET['vrsta_materijala'];
$id_oznake = $_GET['broj_entia'];
$id = $_GET['id'];

$upit_za_proveru = "SELECT * FROM hr_int WHERE broj=$id_oznake AND vrsta_materijala=$vrsta_materijala AND zapis=$id";
$rezultat_provere = $mysqli->query($upit_za_proveru);
$upit = "INSERT INTO hr_int (vrsta_materijala,broj,zapis) VALUES ($vrsta_materijala, $id_oznake, $id)";

if($rezultat_provere->num_rows == 0) {
	$mysqli->query($upit);
	$rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$id_oznake ");
	$naziv_taga = $rezultat_za_naziv->fetch_assoc()["naziv"];
	$url = BASE_URL . "odrednica.php?br=$id_oznake";
	echo "<i class='crveno'>Tagovano! </i> <a href='$url'>$naziv_taga</a> <br>";
} else {
	echo "<i>Već je tagovano. </i><br>";
}

?>
