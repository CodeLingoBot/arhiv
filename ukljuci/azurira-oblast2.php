<?php 

	if (!empty($nova_oblast)) {					// ako nova oblast nije prazna

		if ($nova_oblast != $oblast) {		// i ako nisu iste, menja
			$novi_upit = "UPDATE dokumenti SET oblast=$nova_oblast WHERE id='$dokument_id'; ";
		}

		mysqli_query($konekcija,$novi_upit);
	} // kraj unosa oblasti

