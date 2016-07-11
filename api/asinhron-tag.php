<?php

// proveriti da li id postoji u entia
// ako ne, izbaciti poruku

require_once("../ukljuci/povezivanje.php");
require_once("../ukljuci/povezivanje2.php");

$vrsta_materijala = $_GET['vrsta_materijala'];
$broj_entia = $_GET['broj_entia'];
$id = $_GET['id'];

$upit_za_proveru = "SELECT * FROM hr_int WHERE broj=$broj_entia AND vrsta_materijala=$vrsta_materijala AND zapis=$id";
$rezultat_provere = mysqli_query($konekcija, $upit_za_proveru);
$asinhron_upit = "INSERT INTO hr_int (vrsta_materijala,broj,zapis) VALUES ($vrsta_materijala, $broj_entia, $id)";

// ako nema taga taguje
if(mysqli_num_rows($rezultat_provere) == 0) {
	mysqli_query($konekcija, $asinhron_upit);

	$rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$broj_entia ");
	$naziv_taga = $rezultat_za_naziv->fetch_assoc()["naziv"];

	echo "<i class='crveno'>Tagovano! </i> <a href='pojam.php?br=$broj_entia'>$naziv_taga</a> <br>";
} else {
	echo "<i>Već je tagovano. </i><br>";
}

?>
