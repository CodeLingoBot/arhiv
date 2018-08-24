<?php

require_once("../model/Odrednica.php");
require_once("../model/Dogadjaj.php");
require_once("../ukljuci/povezivanje.php");

$broj_pojma = $_GET['br'];
$ovaj_pojam = new Odrednica($broj_pojma);
$broj_tagovanih_hro = count($ovaj_pojam->tagovana_hronologija);		// svi zapisi koji postoje za ovaj pojam
$svi_tagovi = array();

$ucitaj_od = isset($_GET['ucitaj_od']) ? $_GET['ucitaj_od'] : 0;						// default od početka
$ucitaj_do = isset($_GET['ucitaj_do']) ? $_GET['ucitaj_do'] : $broj_tagovanih_hro;		// default učitava sve
if($ucitaj_do > $broj_tagovanih_hro) $ucitaj_do = $broj_tagovanih_hro;					// da ne učitava preko postojećih

if($broj_tagovanih_hro > 0) {
	for($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
		$tekuci_zapis = $ovaj_pojam->tagovana_hronologija[$i];
		$ova_datoteka = new Dogadjaj($tekuci_zapis);
		$ovaj_opis = $ova_datoteka->opis;
		$ovaj_datum = $ova_datoteka->datum;

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

		echo "<p class='zapisi'><a href='dogadjaj.php?br=$tekuci_zapis'><b>" . $ovaj_datum . "</b>. " . $ovaj_opis . "</a></p>";

	}	// kraj for petlje
    $tagovi_hronologije = json_encode($svi_tagovi);
    echo "<p class='prikupljeni_tagovi hide'>$tagovi_hronologije</p>";
    if($ucitaj_do < $broj_tagovanih_hro) {
        echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još materijala se učitava...</p>';
    }
} else {
	echo "Nema hronoloških zapisa za ovaj pojam. ";
}

?>
