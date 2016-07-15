<?php

session_start();
require_once("../model/klasaPojam.php");
require_once("../ukljuci/povezivanje2.php");

$broj_pojma = $_GET['br'];
$ovaj_pojam = new Oznaka($broj_pojma);
$broj_tagovanih_dok = count($ovaj_pojam->tagovani_dokumenti);
$svi_tagovi = array();

$ucitaj_od = isset($_GET['ucitaj_od']) ? $_GET['ucitaj_od'] : 0;						// default od početka
$ucitaj_do = isset($_GET['ucitaj_do']) ? $_GET['ucitaj_do'] : $broj_tagovanih_dok;		// default učitava sve
if($ucitaj_do > $broj_tagovanih_dok) $ucitaj_do = $broj_tagovanih_dok;					// da ne učitava preko postojećih

if($broj_tagovanih_dok>0) {
	for($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
		$tekuci_dokument = $ovaj_pojam->tagovani_dokumenti[$i];
		$ova_datoteka = new Datoteka($tekuci_dokument, 2);
		$ovaj_opis = $ova_datoteka->opis;
		$ovi_tagovi = $ova_datoteka->tagovi;

		if($ovi_tagovi) {
			for($brojac = 0; $brojac < count($ovi_tagovi); $brojac++) {
				// ako je unutra niz tagova pretresa ga
				if(is_array($ovi_tagovi[$brojac])){
					for($j = 0; $j < count($ovi_tagovi[$brojac]); $j++) {
						$svi_tagovi[] = $ovi_tagovi[$brojac][$j];
					} // kraj petlje
				} else {
					$svi_tagovi[] = $ovi_tagovi[$brojac];
				}
			} // kraj for
		} // kraj if


		echo "<p class='opisi'><i><a target='_blank' href='izvor.php?br=$tekuci_dokument&vrsta=2'>" . $ovaj_opis . "</a></i></p>";
	}	// kraj for

    $tagovi_dokumenata = json_encode($svi_tagovi);
    echo "<p class='prikupljeni_tagovi nevidljiv'>$tagovi_dokumenata</p>";

    if($ucitaj_do < $broj_tagovanih_dok) {
        echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još materijala se učitava...</p>';
    }

} else {
	echo "Nema pronađenih dokumenata za ovaj pojam. ";
}


?>
