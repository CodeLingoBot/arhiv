<?php
	
	include_once "povezivanje2.php";

	$upit = "SELECT * FROM vrste_entia;";
	$rezultat = $mysqli->query($upit);

	while ($red_vrste = $rezultat->fetch_assoc()) {
		$broj_vrste = $red_vrste['broj_vrste'];
		$naziv_vrste = $red_vrste['naziv_vrste'];
		echo "<option value='$broj_vrste'>$naziv_vrste</option>\n";	
	}
?>
