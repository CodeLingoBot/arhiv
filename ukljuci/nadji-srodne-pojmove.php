<?php

// funkcija vraća niz koji sadrzi tri niza (broj_preklapanja, id_pojmova, nazive_pojmova)

function nadjiSrodnePojmove($pojam, $konekcija)
	{
	$niz_brojeva_veza = array();
	$niz_entia = array();

	$upit_dele_zapis = "
		SELECT hr_int.broj as broj1, hr_int_1.broj as broj2, hr_int.zapis
		FROM `hr_int` INNER JOIN hr_int AS hr_int_1 
		ON hr_int.zapis = hr_int_1.zapis 
		WHERE hr_int.broj = $pojam AND hr_int.broj <> hr_int_1.broj 
		ORDER BY broj2;
	";

	$rezultat_dele_zapis = mysqli_query($konekcija, $upit_dele_zapis);
	$broj_veza = 0;
	$indeks = 0;
	
	$red_dele_zapis = mysqli_fetch_assoc($rezultat_dele_zapis);
	$prethodni = $red_dele_zapis['broj2'];
	
	while ($red_dele_zapis = mysqli_fetch_assoc($rezultat_dele_zapis))
		{
		$novi = $red_dele_zapis['broj2'];
		if ($novi == $prethodni)
			{
			$broj_veza++;
			}
		  else
			{
			$indeks++;
			$niz_brojeva_veza[$indeks] = $broj_veza + 1 + ($prethodni / 10000);
			$niz_entia[$indeks] = $prethodni;
			$broj_veza = 0;
			$prethodni = $novi;
			}
		}

	$niz_indeksa = array_keys($niz_brojeva_veza);
	shuffle($niz_brojeva_veza);		// za poredjano koristiti sort()	

	$xx = 0;
	for ($ii = count($niz_brojeva_veza); $ii > - 1; $ii--)
		{
		$novi_niz_brojeva_veza[$xx] = $niz_brojeva_veza[$ii];
		$xx++;
		}

	for ($ii = 1; $ii < count($novi_niz_brojeva_veza); $ii++)
		{
		$broj_preklapanja = intval($novi_niz_brojeva_veza[$ii]);
		$skim_num = intval(10000 * $novi_niz_brojeva_veza[$ii] - 10000 * $broj_preklapanja);
		$skim_upit = "SELECT * FROM entia WHERE id=" . $skim_num . ";";
		$skim_rzlt = mysqli_query($konekcija, $skim_upit);
		$skim_red = mysqli_fetch_assoc($skim_rzlt);
		$skim_id = $skim_red['id'];
		$skim_naziv = $skim_red['naziv'];
		
		$brojevi_preklapanja[] = $broj_preklapanja;
		$id_pojmova[] = $skim_id;
		$nazivi_pojmova[] = $skim_naziv;
		}
	
	$spisak_preklapanja[] = $brojevi_preklapanja;
	$spisak_preklapanja[] = $id_pojmova;
	$spisak_preklapanja[] = $nazivi_pojmova;

	return $spisak_preklapanja;
	}

?>
