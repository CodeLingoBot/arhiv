<?php
	
	include_once "povezivanje.php";

	$upit_vrste = "SELECT * FROM vrste_entia;";
	$rezultat_vrste = $mysqli->query($upit_vrste);

	while ($red_vrste = $rezultat_vrste->fetch_assoc()) {
		$broj_vrste = $red_vrste['broj_vrste'];
		$naziv_vrste = $red_vrste['naziv_vrste'];
		echo "<option value='$broj_vrste'>$naziv_vrste</option>\n";	
	}
?>
