<?php 

	if (is_numeric($novi_dan)) {						// ako nova vrednost nije prazna

		if ($novi_dan != $stari_dan) {					// i ako nisu iste stara i nova, menja
			$novi_upit = "UPDATE dokumenti SET dan_izv = $novi_dan WHERE id='$dokument_id'; ";
		}

		mysqli_query($konekcija,$novi_upit);			// učini to!
	} // kraj unosa dana

	if (is_numeric($novi_mesec)) {
		
		if ($novi_mesec != $stari_mesec) {
			$novi_upit2 = "UPDATE dokumenti SET mesec_izv=$novi_mesec WHERE id='$dokument_id'; ";
		}

		mysqli_query($konekcija,$novi_upit2);
	} // kraj unosa meseca

	if (is_numeric($nova_godina)) {

		if ($nova_godina != $stara_godina) {
			$novi_upit3 = "UPDATE dokumenti SET god_izv=$nova_godina WHERE id='$dokument_id'; ";
		}

		mysqli_query($konekcija,$novi_upit3);
	} // kraj unosa godine

