<?php

class Datoteka {

	public $id, 
		$vrsta, 
		$datum,
		$dan,
		$mesec,
		$godina, 
		$opis, 
		$opis_jpg, 
		$izvor, 
		$url, 
		$relativ_url,
		$lokacija, 
		$oblast_prevedeno,
		$tagovi, 
		$sirovi_tagovi;

	public function __construct($id_unos, $vrsta_unos) {
	
		global $mysqli;
		$this->id = $id_unos;
		$upit_za_tagove = "SELECT * FROM hr_int WHERE vrsta_materijala = $vrsta_unos AND zapis = $id_unos; ";
	
		switch ($vrsta_unos) {

			/********* HRONOLOGIJA *******/				
			case 1:			
				$upit = "SELECT * FROM hr1 WHERE id = $id_unos ";
				$rezultat = $mysqli->query($upit);
				$red = $rezultat->fetch_assoc();

				// traži tagove
				if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
					while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
						$broj_taga = $red_za_tagove["broj"];
						$this->tagovi[] = $broj_taga;
					}
				} 

				// pravi datum
				$dan = $red["dd"];
				$mesec = $red["mm"];
				$godina = $red["yy"];
				$this->dan = $dan;
				$this->mesec = $mesec;
				$this->godina = $godina;
				$alter_dan = $dan ? $dan . ". " : "Tokom ";	// ako je neodređen dodaje reč bez tačke
				$this->datum = $alter_dan . $mesec . ". " . $godina;

				// prevodi oblast
				$oblast = $red["zona"]; 
				$upit_za_oblast = "SELECT naziv FROM mesta WHERE id='$oblast'; ";				
				$rezultat_za_oblast = $mysqli->query($upit_za_oblast);
				$red_za_oblast = $rezultat_za_oblast->fetch_assoc();
				$oblast_prevedeno = $red_za_oblast['naziv'];				

				// izvor
				$izvor = $red["izvor"]; 
				if($izvor == 1) {
					$this->izvor = "Izveštaji Komande srpske državne straže za okrug Moravski 1941-1944";
					$this->vrsta = "policijski izveštaj";
					$this->url = "http://znaci.net/00003/470.htm";
					$this->relativ_url = "/00003/470.htm";					
				} else {					
					$this->izvor = "Hronologija narodnooslobodilačkog rata 1941-1945";
					$this->vrsta = "hronološki zapis";
					$this->url = "http://znaci.net/00001/53.htm";
					$this->relativ_url = "/00001/53.htm";					
				}

				// sve ostalo

				$this->opis = $red["tekst"];				
				$this->lokacija = $oblast; 
				$this->oblast_prevedeno = $oblast_prevedeno ?: "nepoznata";
				$rezultat->close();
				$rezultat_za_tagove->close();
				break;

			/********* ZBORNICI DOKUMENATA *******/				
			case 2:

				// izvlači podatke iz dokumenata
				$upit = "SELECT * FROM dokumenti WHERE id = $id_unos ";
				$rezultat = $mysqli->query($upit);
				$red = $rezultat->fetch_assoc();
				
				// trazi zbornik
				$src = $red['src'];
				$broj_strane = $red['p'];
				$strana_pdf = $red['strana_pdf'] ?: $red['p'];
				$broj_knjige = $src % 100;			
				$broj_toma = $src / 100;
				$broj_toma = $broj_toma % 100;				
				$link = $broj_toma . "_" . $broj_knjige . ".pdf#page=" . $strana_pdf;

				// naziv zbornika
				$upit_za_naziv = "SELECT * FROM knjige WHERE broj_knjige = $src ";
				$rezultat_za_naziv = $mysqli->query($upit_za_naziv);
				$naziv_knjige = $rezultat_za_naziv->fetch_assoc()['naziv_knjige'];
								
				// trazi vreme
				$dan_izv = $red['dan_izv'];
				$mesec_izv = $red['mesec_izv'];
				$god_izv = $red['god_izv'];
				$this->dan = $dan_izv;
				$this->mesec = $mesec_izv;
				$this->godina = $god_izv;				
				$this->datum = $dan_izv . "." . $mesec_izv . ". " . $god_izv;				
				
				// traži tagove
				if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
					while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
						$broj_taga = $red_za_tagove["broj"];
						$this->tagovi[] = $broj_taga;
					}
				} 
				
				// prevodi oblast
				$oblast = $red["oblast"]; 
				$upit_za_oblast = "SELECT naziv FROM mesta WHERE id='$oblast'; ";				
				$rezultat_za_oblast = $mysqli->query($upit_za_oblast);
				$red_za_oblast = $rezultat_za_oblast->fetch_assoc();
				$oblast_prevedeno = $red_za_oblast['naziv'];					
				
				// dodaje sve ostalo
				$this->lokacija = $red['oblast']; 
				$this->oblast_prevedeno = $oblast_prevedeno ?: "nepoznata";
				$this->opis = $red["opis"];
				$this->vrsta = "dokument";				
				$this->izvor = "Zbornik dokumenata i podataka o narodnooslobodilačkom ratu, <i>$naziv_knjige</i>, tom $broj_toma (strana $broj_strane.)";
				$this->url = "http://znaci.net/zb/4_" . $link;	
				$this->relativ_url = "/zb/4_" . $link;	
				$this->broj_strane = $strana_pdf;	
				
				$rezultat->close();
				$rezultat_za_tagove->close();
				$rezultat_za_naziv->close();
				break;

			/********* FOTOGRAFIJE *******/	
			case 3:
				$upit = "SELECT * FROM fotografije WHERE inv = $id_unos ";
				$rezultat = $mysqli->query($upit);
				$red = $rezultat->fetch_assoc();	

				// prevodi oblast
				$oblast = $red["oblast"]; 
				$upit_za_oblast = "SELECT naziv FROM mesta WHERE id='$oblast'; ";				
				$rezultat_za_oblast = $mysqli->query($upit_za_oblast);
				$red_za_oblast = $rezultat_za_oblast->fetch_assoc();
				$oblast_prevedeno = $red_za_oblast['naziv'];

				$this->datum = $red["datum"] != "0000-00-00" ? $red["datum"] : "1941-1945";
				$this->vrsta = "fotografija";
				$this->opis = $red["opis"] ?: "Nije unet. ";
				$this->opis_jpg = $red["opis_jpg"];
				$this->lokacija = $oblast;
				$this->oblast_prevedeno = $oblast_prevedeno ?: "nepoznata";				
				$this->izvor = "Muzej revolucije naroda Jugoslavije";
				$this->url = "http://www.znaci.net/images/".$this->id.".jpg";
				$this->relativ_url = "/images/".$this->id.".jpg";

				// traži tagove
				if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
					while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
						$broj_taga = $red_za_tagove["broj"];
						$this->tagovi[] = $broj_taga;
					}
				} 

				break;

			/********* NEMAČKI DOKUMENTI *******/				
			case 4:
				$this->vrsta = "nemački dokument";
				$this->datum = "";
				$this->opis = "";
				$this->izvor = "National Archives and Records Administration, Washington, D.C.";
				$this->url = "http://znaci.net/NARA/T78.php";
				$this->lokacija = ""; 
				$this->tagovi = ""; 
				$this->sirovi_tagovi = "";
				break;
				
			/********* KNJIGE *******/				
			case 5:
				$this->vrsta = "knjiga sa naučnim aparatom";
				$this->datum = "";
				$this->opis = "";
				$this->izvor = "";
				$this->url = "";
				$this->lokacija = ""; 
				$this->tagovi = ""; 
				$this->sirovi_tagovi = "";
				break;
			case 6:
				$this->vrsta = "knjiga sećanja";
				$this->datum = "";
				$this->opis = "";
				$this->izvor = "";
				$this->url = "";
				$this->lokacija = ""; 
				$this->tagovi = ""; 
				$this->sirovi_tagovi = "";
				break;
			case 7:
				$this->vrsta = "romansirana istorijska literatura";
				$this->datum = "";
				$this->opis = "";
				$this->izvor = "";
				$this->url = "";
				$this->lokacija = ""; 
				$this->tagovi = ""; 
				$this->sirovi_tagovi = "";
				break;
			default:
				$this->vrsta = "nepoznato ";
				$this->datum = "Nepoznat (unesi datum / ako postoji isprvi datum)";
				$this->opis = "Datoteka ne poseduje originalan opis (unesi opis)"; 
				$this->izvor = "Originalni izvor ove datoteke je nepoznat (unesi izvor)";
				$this->url = "http://www.znaci.net/";
				$this->lokacija = "Lokacija nastanka je nepoznata (unesi lokaciju)"; 
				$this->tagovi = "Još uvek nema tagova za ovu odrednicu (unesi tag)"; 
				break;
		}
		
	}	// kraj konstrukta


	public function pokaziInfo() {
		print "<p> Ova datoteka je $this->vrsta </p>";
	}

	public function podesiVrstu($vrsta_unos) {
		$this->vrsta = $vrsta_unos;
	}
	
	public function podesiDatum($datum_unos) {
		$this->datum = $datum_unos;
	}

}	// kraj klase Datoteka
