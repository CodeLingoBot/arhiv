	<?php
		
		include_once "povezivanje.php";
	
		$upit_za_vrste = "SELECT * FROM vrste_entia;";
		$rezultat_za_vrste = mysqli_query($konekcija, $upit_za_vrste);

		while ($red_vrste = mysqli_fetch_assoc($rezultat_za_vrste)) {

			$broj_vrste = $red_vrste['broj_vrste'];
			$naziv_vrste = $red_vrste['naziv_vrste'];
		
			echo "\t\t\t<option value='$broj_vrste'>$naziv_vrste</option>\n";	
		}
	?>
