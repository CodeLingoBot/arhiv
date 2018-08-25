<?php

require_once("../model/Odrednica.php");
require_once("../model/Dokument.php");
require_once("../ukljuci/povezivanje.php");

$broj_pojma = $_GET['br'];
$ovaj_pojam = new Odrednica($broj_pojma);
$broj_tagovanih_dok = count($ovaj_pojam->dokumenti);
$svi_tagovi = array();

$ucitaj_od = isset($_GET['ucitaj_od']) ? $_GET['ucitaj_od'] : 0;
$ucitaj_do = isset($_GET['ucitaj_do']) ? $_GET['ucitaj_do'] : $broj_tagovanih_dok;
if($ucitaj_do > $broj_tagovanih_dok) $ucitaj_do = $broj_tagovanih_dok;

if($broj_tagovanih_dok>0) {
	for($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
		$tekuci_dokument = $ovaj_pojam->dokumenti[$i];
		$ova_datoteka = new Dokument($tekuci_dokument, 2);
		$ovaj_opis = $ova_datoteka->opis;
		$ovi_tagovi = $ova_datoteka->tagovi;

		if($ovi_tagovi) {
			for($brojac = 0; $brojac < count($ovi_tagovi); $brojac++) {
				if(is_array($ovi_tagovi[$brojac])){
					for($j = 0; $j < count($ovi_tagovi[$brojac]); $j++) {
						$svi_tagovi[] = $ovi_tagovi[$brojac][$j];
					} // kraj petlje
				} else {
					$svi_tagovi[] = $ovi_tagovi[$brojac];
				}
			} // kraj for
		} // kraj if

		echo "<p class='opisi'><i><a href='dokument.php?br=$tekuci_dokument'>" . $ovaj_opis . "</a></i></p>";
	}	// kraj for

    $tagovi_dokumenata = json_encode($svi_tagovi);
    echo "<p class='prikupljeni_tagovi hide'>$tagovi_dokumenata</p>";

    if($ucitaj_do < $broj_tagovanih_dok) {
        echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još materijala se učitava...</p>';
    }

} else {
	echo "Nema pronađenih dokumenata za ovaj pojam. ";
}

?>
