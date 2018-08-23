<?php

require_once("../ukljuci/povezivanje.php");
require_once("../ukljuci/povezivanje2.php");

$vrsta_materijala = $_GET['vrsta_materijala'];
$id_oznake = $_GET['broj_entia'];
$id = $_GET['id'];

$upit_za_proveru = "SELECT * FROM hr_int WHERE broj=$id_oznake AND vrsta_materijala=$vrsta_materijala AND zapis=$id";
$rezultat_provere = mysqli_query($konekcija, $upit_za_proveru);
$upit = "INSERT INTO hr_int (vrsta_materijala,broj,zapis) VALUES ($vrsta_materijala, $id_oznake, $id)";

// ako nema taga taguje
if(mysqli_num_rows($rezultat_provere) == 0) {
	mysqli_query($konekcija, $upit);
	$rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$id_oznake ");
	$naziv_taga = $rezultat_za_naziv->fetch_assoc()["naziv"];
	echo "<i class='crveno'>Tagovano! </i> <a href='pojam.php?br=$id_oznake'>$naziv_taga</a> <br>";
	echo $upit;
} else {
	echo "<i>Već je tagovano. </i><br>";
}

?>
