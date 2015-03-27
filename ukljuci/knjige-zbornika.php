	<?php
		// podrazumeva vezu sa bazom, ne radi sam

		$upit_za_zbornike = "SELECT DISTINCT src FROM dokumenti ORDER BY src ASC;";
		$rezultat_za_zbornike = mysqli_query($konekcija, $upit_za_zbornike);

		echo "<option value=''></option>";
		
		while ($red_zbornika = mysqli_fetch_assoc($rezultat_za_zbornike)) {	

			$trenutna_knjiga = $red_zbornika['src'];
			$upit_za_naziv_knjige = "SELECT naziv_knjige FROM knjige WHERE broj_knjige='$trenutna_knjiga'; ";
			$naziv_trenutne_knjige = mysqli_fetch_assoc(mysqli_query($konekcija, $upit_za_naziv_knjige))['naziv_knjige'];
			
			echo "<option value='$trenutna_knjiga'>$naziv_trenutne_knjige</option>";
			
		}

	?>