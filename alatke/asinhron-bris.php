<?php

require("../ukljuci/povezivanje.php");

$vrsta_materijala = $_GET['vrsta_materijala'];
$broj_entia = $_GET['broj_entia'];
$id = $_GET['id'];

$upit_za_proveru = "SELECT * FROM hr_int WHERE broj=$broj_entia AND zapis=$id";
$rezultat_provere = mysqli_query($konekcija, $upit_za_proveru);
$asinhron_upit = "DELETE FROM hr_int WHERE vrsta_materijala='$vrsta_materijala' AND broj='$broj_entia' AND zapis='$id'; ";

if(mysqli_num_rows($rezultat_provere) != 0) {
	mysqli_query($konekcija, $asinhron_upit);
	echo "<i>Obrisano! </i><br>";
} else {
	echo "<i>Već je obrisano. </i><br>";
}

?>