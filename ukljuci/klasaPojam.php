<?php

include_once "povezivanje2.php";
include_once "klasaIzvor.php";

// foreach loop za nizove

class Oznaka {

	// proglašava atribute klase (this->naziv)
	public 
		$id_taga, 
		$naziv, 
		$vrsta, 
		$tagovana_hronologija = [], 
		$tagovani_dokumenti = [], 
		$tagovane_slike = [];

	public function __construct($id_unos) {
	
		global $mysqli;
	
		// traži naziv i vrstu
		$rezultat_za_entia = $mysqli->query("SELECT * FROM entia WHERE id=$id_unos ");
		$naziv_taga = $rezultat_za_entia->fetch_assoc()["naziv"];
		$vrsta_entia = $rezultat_za_entia->fetch_assoc()["vrsta"];

		$upit_za_hronologiju = "SELECT hr_int.zapis, hr1.dd, hr1.mm, hr1.yy 
		FROM hr1 INNER JOIN hr_int
		ON hr1.id = hr_int.zapis 
		WHERE hr_int.broj = $id_unos AND hr_int.vrsta_materijala = 1
		ORDER BY hr1.yy,hr1.mm,hr1.dd; ";
		
		$upit_za_dokumente = "SELECT hr_int.zapis, dokumenti.dan_izv, dokumenti.mesec_izv, dokumenti.god_izv 
		FROM dokumenti INNER JOIN hr_int
		ON dokumenti.id = hr_int.zapis 
		WHERE hr_int.broj = $id_unos AND hr_int.vrsta_materijala = 2
		ORDER BY dokumenti.god_izv,dokumenti.mesec_izv,dokumenti.dan_izv; ";
		
		$upit_za_fotke = "SELECT zapis FROM hr_int WHERE broj = $id_unos AND vrsta_materijala = 3";

		if($rezultat_za_hronologiju = $mysqli->query($upit_za_hronologiju)) {
			while($red_za_hronologiju = $rezultat_za_hronologiju->fetch_assoc()) {
				$zapis = $red_za_hronologiju["zapis"];
				$this->tagovana_hronologija[] = $zapis; 
			}
			$rezultat_za_hronologiju->close();
		}

		if($rezultat_za_dokumente = $mysqli->query($upit_za_dokumente)) {
			while($red_za_dokumente = $rezultat_za_dokumente->fetch_assoc()) {
				$zapis2 = $red_za_dokumente["zapis"];
				$this->tagovani_dokumenti[] = $zapis2; 
			}
			$rezultat_za_dokumente->close();
		}

		if($rezultat_za_fotke = $mysqli->query($upit_za_fotke)) {
			while($red_za_fotke = $rezultat_za_fotke->fetch_assoc()) {
				$zapis3 = $red_za_fotke["zapis"];
				$this->tagovane_slike[] = $zapis3; 
			}
			$rezultat_za_fotke->close();
		}
		
		$this->id_taga = $id_unos;
		$this->naziv = $naziv_taga;
		$this->vrsta = $vrsta_entia;

	}	// kraj konstrukta

}	// kraj klase Oznaka

