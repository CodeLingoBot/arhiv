<?php 

	if (is_numeric($novi_dan)) {							// ako nova vrednost nije prazna, ulazi
		
		if (!isset($stari_dan)) {						// ako stara vrednost ne postoji, upisuje
			$novi_upit = "INSERT INTO vreme (dokument_id, dan_izv) VALUES ($id, $novi_dan); ";
		} 
		else {											// ako stara vrednost postoji i
			if ($novi_dan != $stari_dan) {				// ako nisu iste stara i nova, menja
				$novi_upit = "UPDATE vreme SET dan_izv = $novi_dan WHERE dokument_id='$id'; ";
			}
		}
		mysqli_query($konekcija,$novi_upit);			// učini to!
	} // kraj unosa dana

	if (is_numeric($novi_mesec)) {
		
		if (!isset($stari_mesec)) {
			$novi_upit2 = "INSERT INTO vreme (dokument_id, mesec_izv) VALUES ($id, $novi_mesec); ";
		} 
		else {
			if ($novi_mesec != $stari_mesec) {
				$novi_upit2 = "UPDATE vreme SET mesec_izv=$novi_mesec WHERE dokument_id='$id'; ";
			}
		}
		mysqli_query($konekcija,$novi_upit2);
	} // kraj unosa meseca

	if (is_numeric($nova_godina)) {

		if (!isset($stara_godina)) {
			$novi_upit3 = "INSERT INTO vreme (dokument_id, god_izv) VALUES ($id, $nova_godina); ";
		} 
		else {
			if ($nova_godina != $stara_godina) {
				$novi_upit3 = "UPDATE vreme SET god_izv=$nova_godina WHERE dokument_id='$id'; ";
			}
		}
		mysqli_query($konekcija,$novi_upit3);
	} // kraj unosa godine

?>