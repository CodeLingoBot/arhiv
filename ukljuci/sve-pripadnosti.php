<select name="nova_pripadnost" id="nova_pripadnost">

	<?php

	$upit_za_sve_pripadnosti = "SELECT * FROM `pripadnosti` ORDER BY `id` ASC;";
	$rezultat_za_sve_pripadnosti = mysqli_query($konekcija, $upit_za_sve_pripadnosti);

	while($red_sve_pripadnosti = mysqli_fetch_assoc($rezultat_za_sve_pripadnosti)){

		$id_pripadnosti = $red_sve_pripadnosti['id'];
		$naziv_pripadnosti = $red_sve_pripadnosti['strana'];
		
		echo "\t<option value='$id_pripadnosti'>$naziv_pripadnosti</option>\n";

	}
	?>

</select>