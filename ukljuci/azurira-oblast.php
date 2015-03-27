<?php 

	if (!empty($nova_oblast)) {					// ako nova oblast nije prazna, ulazi
		
		if (!isset($oblast)) {					// ako stara ne postoji, upisuje
			$novi_upit = "INSERT INTO mesto (dokument_id, oblast) VALUES ($id, $nova_oblast); ";
		} 
		else {									// ako stara postoji i
			if ($nova_oblast != $oblast) {		// ako nisu iste stara i nova, menja
				$novi_upit = "UPDATE mesto SET oblast=$nova_oblast WHERE dokument_id='$id'; ";
			}
		}
		mysqli_query($konekcija,$novi_upit);
	} // kraj unosa oblasti

?>