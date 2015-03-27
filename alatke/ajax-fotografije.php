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
$broj_tagovanih_slika = count($ovaj_pojam->tagovane_slike);
$svi_tagovi = array();

$ucitaj_od = isset($_GET['ucitaj_od']) ? $_GET['ucitaj_od'] : 0;						// default od početka
$ucitaj_do = isset($_GET['ucitaj_do']) ? $_GET['ucitaj_do'] : $broj_tagovanih_slika;		// default učitava sve
if($ucitaj_do > $broj_tagovanih_slika) $ucitaj_do = $broj_tagovanih_slika;					// da ne učitava preko postojećih


// ako ima tagovanih slika, učitaj od-do
if($broj_tagovanih_slika > 0) {
	for($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
		$tekuca_slika = $ovaj_pojam->tagovane_slike[$i];
		$ova_datoteka = new Datoteka($tekuca_slika, 3);
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
		
		
		echo "<a target='_blank' href='izvor.php?br=$tekuca_slika&vrsta=3'><img class='slike' src='../images/$tekuca_slika.jpg'></a>";
	}	// kraj for
    $tagovi_fotografija = json_encode($svi_tagovi);
    echo "<p class='prikupljeni_tagovi nevidljiv'>$tagovi_fotografija</p>";

    if($ucitaj_do < $broj_tagovanih_slika) {
        echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još materijala se učitava...</p>';
    }

} else {
	echo "Nema pronađenih fotografija za ovaj pojam. ";
}

?>
