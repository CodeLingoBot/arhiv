	<?php

	$upit_za_postojece_pripadnosti = "SELECT DISTINCT strana FROM pripadnost ORDER BY strana ASC;";
	$rezultat_za_postojece_pripadnosti = mysqli_query($konekcija, $upit_za_postojece_pripadnosti);

	echo "<option value=''></option>";
	
	while ($red_postojece_pripadnosti = mysqli_fetch_assoc($rezultat_za_postojece_pripadnosti)) {	

		$id_postojece_pripadnosti = $red_postojece_pripadnosti['strana'];

		// prevodi
		$upit_za_prevod_pripadnosti = "SELECT strana FROM pripadnosti WHERE id='$id_postojece_pripadnosti' ";
		$rezultat_za_prevod_pripadnosti = mysqli_query($konekcija, $upit_za_prevod_pripadnosti);
		$red_prevoda_pripadnosti = mysqli_fetch_assoc($rezultat_za_prevod_pripadnosti);
		$naziv_postojece_pripadnosti = $red_prevoda_pripadnosti['strana'];
		
		echo "\n\t\t\t\t<option value='$id_postojece_pripadnosti'>$naziv_postojece_pripadnosti</option>";

	}
	?>