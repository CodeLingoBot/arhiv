	<?php
		// podrazumeva vezu sa bazom, ne radi sam

		$upit = "SELECT DISTINCT src FROM dokumenti ORDER BY src ASC;";
		$rezultat = $mysqli->query($upit);

		echo "<option value=''></option>";
		
		while ($red_zbornika = $rezultat->fetch_assoc()) {	
			$trenutna_knjiga = $red_zbornika['src'];
			$upit_za_naziv_knjige = "SELECT naziv_knjige FROM knjige WHERE broj_knjige='$trenutna_knjiga'; ";
			$naziv_trenutne_knjige = $mysqli->query($upit_za_naziv_knjige)->fetch_assoc()['naziv_knjige'];
			echo "<option value='$trenutna_knjiga'>$naziv_trenutne_knjige</option>";
		}

	?>