<?php 

	if (!empty($nova_pripadnost)) {						// ako nova pripadnost nije prazna
		
		if ($nova_pripadnost != $stara_pripadnost) {	// i ako nisu iste, menja
			$novi_upit_za_pripadnost = "UPDATE dokumenti SET pripadnost=$nova_pripadnost WHERE id='$dokument_id'; ";
		}

		mysqli_query($konekcija,$novi_upit_za_pripadnost);
	} // kraj unosa oblasti

?>