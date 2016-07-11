<?php

session_start(); 
require_once("../ukljuci/klasaPojam.php");
require_once("../ukljuci/povezivanje2.php");

$ulogovan = false;
if($_SESSION["nadimak"] == "gost" || $_COOKIE["nadimak"] == "gost") {
	$ulogovan = true;
} 

$broj_pojma = $_GET['br'];
$ovaj_pojam = new Oznaka($broj_pojma);
$broj_tagovanih_hro = count($ovaj_pojam->tagovana_hronologija);		// svi zapisi koji postoje za ovaj pojam		
$svi_tagovi = array();

$ucitaj_od = isset($_GET['ucitaj_od']) ? $_GET['ucitaj_od'] : 0;						// default od početka
$ucitaj_do = isset($_GET['ucitaj_do']) ? $_GET['ucitaj_do'] : $broj_tagovanih_hro;		// default učitava sve
if($ucitaj_do > $broj_tagovanih_hro) $ucitaj_do = $broj_tagovanih_hro;					// da ne učitava preko postojećih

if($broj_tagovanih_hro > 0) {
	for($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
		$tekuci_zapis = $ovaj_pojam->tagovana_hronologija[$i];
		$ova_datoteka = new Datoteka($tekuci_zapis, 1);
		$ovaj_opis = $ova_datoteka->opis;
		$ovaj_datum = $ova_datoteka->datum;

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

		echo "<p class='zapisi'><a target='_blank' href='izvor.php?br=$tekuci_zapis&vrsta=1'><b>" . $ovaj_datum . "</b>. " . $ovaj_opis . "</a>\n";

		// pravi dugmice za ajax tagove i brisanje
		if($ulogovan == true) {
			echo "<br><span class='tag-dugme' onclick='pozadinskiBrisi(this, 1, $broj_pojma, $tekuci_zapis)'>Obriši tag </span><span></span>\n";	
		}
		echo "</p>";

	}	// kraj for petlje
    $tagovi_hronologije = json_encode($svi_tagovi);
    echo "<p class='prikupljeni_tagovi nevidljiv'>$tagovi_hronologije</p>";
    if($ucitaj_do < $broj_tagovanih_hro) {
        echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još materijala se učitava...</p>';
    }
} else {
	echo "Nema hronoloških zapisa za ovaj pojam. ";
}

?>
