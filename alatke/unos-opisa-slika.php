<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<?php
set_time_limit(0);
	
// preraditi u korisničku skriptu za prepoznavanje obrazaca u struni
// tipa unesi text, unesi obrazac, podeli po obrascu

require("../ukljuci/povezivanje.php");

$sadrzaj = file_get_contents('opisi-slika.txt');
$svi_opisi = [];

$dom = new DOMDocument();
$dom->loadHTML('<?xml encoding="UTF-8">' . $sadrzaj);
$dom->preserveWhiteSpace = false;
$dom->encoding = 'UTF-8';
$body = $dom->getElementsByTagName('body');

$cist_sadrzaj = htmlspecialchars($body->item(0)->nodeValue);
$broj_znakova = strlen($cist_sadrzaj);

for($i=0; $i <= $broj_znakova; $i++) {

	// nalazi obrazac
	if($cist_sadrzaj[$i]=="b") {
	
		if($cist_sadrzaj[$i+1]=="r") {

			if($cist_sadrzaj[$i+2]==".") {

				// dodaje tekući opis u niz
				$svi_opisi[] = $tekuci_opis;
				$tekuci_opis = "";
				
			}
		
		}

	}

	$tekuci_opis = $tekuci_opis . $cist_sadrzaj[$i+3];

}

$svi_opisi[] = $tekuci_opis; // dodaje poslednji opis


$broj_opisa = count($svi_opisi);

for($j=1; $j < $broj_opisa; $j++) {
	
	$svi_opisi[$j] = str_replace("Inv.br.", "", $svi_opisi[$j]);
	$svi_opisi[$j] = str_replace("Iav.br.", "", $svi_opisi[$j]);
	$svi_opisi[$j] = str_replace("Inv#br»", "", $svi_opisi[$j]);
	$svi_opisi[$j] = str_replace("Inv.to-.", "", $svi_opisi[$j]);
	$svi_opisi[$j] = str_replace("Inv.br#", "", $svi_opisi[$j]);
	$svi_opisi[$j] = str_replace("Irr.br.", "", $svi_opisi[$j]);
	$svi_opisi[$j] = str_replace("lEv.br.", "", $svi_opisi[$j]);
	
	$svi_opisi[$j] = trim($svi_opisi[$j]);
	
	if(is_numeric($svi_opisi[$j][0])){			// nalazi prvi broj
		
		$brojac = 0;
		$tekuci_broj = "";
		
		// hvata cifre redom dok ih ima
		while(is_numeric($svi_opisi[$j][$brojac])) {
			$tekuci_broj = $tekuci_broj . $svi_opisi[$j][$brojac];
			$brojac++;
		}
		
		// nalazi četvorocifren broj, izbacuje ga iz strune, ubacuje u varijablu
		if(strlen($tekuci_broj) >= 4){
			
			$svi_opisi[$j] = str_replace($tekuci_broj, "", $svi_opisi[$j]);
			$svi_opisi[$j] = trim($svi_opisi[$j]);	
		}		

	}	// kraj uzimanja broja

	//echo "<p>" . $tekuci_broj . ") " . $svi_opisi[$j] . "</p>\n\n";	// prikazuje ceo opis	

	// upit da upise opis u bazu gde tekuci_broj = inv
		// ako ima slike i ako nema opisa, upisuje opis
		// izbacuje iz niza ono sto je upisano
		// štampa ono što je preostalo

	$upit_za_slike = "SELECT * FROM fotografije WHERE inv=$tekuci_broj";
	
	$red_za_slike = mysqli_fetch_assoc(mysqli_query($konekcija, $upit_za_slike));
	$inv = $red_za_slike['inv'];
	$opis = $red_za_slike['opis'];
	
	if($inv) {
		//echo "<p>Inv.br. " . $tekuci_broj . "\n" . $svi_opisi[$j] . "</p>\n\n";
	
		$unos_za_opise = "UPDATE fotografije SET opis='$svi_opisi[$j]' WHERE inv='$tekuci_broj';";
		mysqli_query($konekcija, $unos_za_opise);
		
		echo $unos_za_opise . "<br>";
	}
	
}



?>

</body>
</html>
