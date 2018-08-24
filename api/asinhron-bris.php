<?php

require_once("../ukljuci/povezivanje.php");

$vrsta_materijala = $_GET['vrsta_materijala'];
$broj_entia = $_GET['broj_entia'];
$id = $_GET['id'];

$upit_za_proveru = "SELECT * FROM hr_int WHERE broj=$broj_entia AND zapis=$id";
$rezultat_provere = $mysqli->query($upit_za_proveru);

if($rezultat_provere->num_rows != 0) {
	$upit = "DELETE FROM hr_int WHERE vrsta_materijala='$vrsta_materijala' AND broj='$broj_entia' AND zapis='$id'; ";
	$mysqli->query($upit);
	echo "<i>Obrisano! </i><br>";
} else {
	echo "<i>Već je obrisano. </i><br>";
}

?>