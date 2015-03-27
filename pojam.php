<?php

// naci providnu loader ikonicu
// obavestenje na dnu ako ima jos da se ucitava
// da se (neke) slike učitavaju odmah, pre ajaxa
// 0 mesec staviti random ili na kraj

require_once("ukljuci/config.php");
require_once(ROOT_PATH . "ukljuci/klasaPojam.php");

if($_GET){
	$broj_oznake = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);
} else { $broj_oznake = 1; }

$ovaj_pojam = new Oznaka($broj_oznake);
$naslov = $ovaj_pojam->naziv;
$vrsta = $ovaj_pojam->vrsta;
$svi_tagovi = array();

// zaglavlje mora posle naslova  
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

?>

	<div class="sredina">
	
		<div class="gornji-odeljak">

			<div class="gore-levo">

				<?php 
					echo "<h1 id='naslov'>" . $ovaj_pojam->naziv . "</h1>"; 
					// mogućnost menjanja naziva za ulogovane korisnike
					if($ulogovan == true) {
						echo "<div type='submit' class='tag-dugme' onclick='promeniNaziv(this, $broj_oznake);'>Sačuvaj naziv</div><span></span>\n";
					}
					
					$broj_tagovanih_hro = count($ovaj_pojam->tagovana_hronologija);
					$broj_tagovanih_dok = count($ovaj_pojam->tagovani_dokumenti);
					$broj_tagovanih_fot = count($ovaj_pojam->tagovane_slike);
				?>		
				
				<p class="krasnopis siva-donja-crta">Za ovaj pojam je pronađeno <span><?php echo $broj_tagovanih_hro; ?></span> hronoloških zapisa, <span><?php echo $broj_tagovanih_dok; ?></span> dokumenata i <span><?php echo $broj_tagovanih_fot; ?></span> fotografija.</p>
                <script>
                    var broj_tagovanih_hro = <?php echo $broj_tagovanih_hro; ?>;
                    var broj_tagovanih_dok = <?php echo $broj_tagovanih_dok; ?>;
                    var broj_tagovanih_fot = <?php echo $broj_tagovanih_fot; ?>;
                </script>

			</div>
		
			<form action="<?php echo $_SERVER[PHP_SELF]; ?>" method="get" id="mali-formular">
			
				<label>Odrednica: </label><br>
				<div class="sugestije-okvir">
					<input class="unos-sirina2" id="tag" onkeyup="pokaziSugestije(this.value)" autocomplete="off" value="<?php echo $naslov; ?>">
					<div id="polje_za_sugestije"></div>
				</div>
				
				<br>
				<label>Br. odrednice: </label><br>
				<input class="unos-sirina2" type="number" name="br" id="br_oznake" value="<?php echo $broj_oznake; ?>"><br>
				<input type="submit" value="Izaberi"><br>			
			</form>
			
			<div class="clear"></div>

		</div>
		
			
		<div class="kolone kolona1" onscroll="ucitajJos(this)">
			<h2 class="naslov-odeljka">Hronologija </h2>
			<div id="hronologija">
				<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Hronološki zapisi se učitavaju...</p>
			</div>
		</div>
	
		<div class="kolone kolona2" onscroll="ucitajJos(this)">
			<h2 class="naslov-odeljka">Dokumenti </h2>
			<div id="dokumenti">
				<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Molimo sačekajte, dokumenti se učitavaju...</p>
			</div>
		</div>
		
		<div class="kolone fotografije" onscroll="ucitajJos(this)">
			<h2 class="naslov-odeljka">Fotografije </h2>
			<div id="fotografije">
				<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Istorijske fotografije se učitavaju...</p>	
			</div>
		</div>
	
		<div class="kolone tagovi">
			<h2 class="naslov-odeljka">Povezani pojmovi: </h2>
			<div id="tagovi">
				<p><img src="slike/ajax-loader.gif" alt="loading" /> Povezani pojmovi se generišu...</p>
			</div>			
		</div>
	
	</div>


<script>
"use strict";

var ucitano_odeljaka = 0;	
var broj_oznake = <?php echo $broj_oznake; ?>;

var hronologija_od = 0;
var hronologija_do = 50;
var dokumenti_od = 0;
var dokumenti_do = 50;
var fotografije_od = 0;
var fotografije_do = 40;

var svi_tagovi = [];
var dozvoljeno_ucitavanje = true;


window.onload = ucitavajPodatke;


function ucitavajPodatke(){
	ucitaj("hronologija", "alatke/ajax-hronologija.php", broj_oznake, hronologija_od, hronologija_do);
	ucitaj("dokumenti", "alatke/ajax-dokumenti.php", broj_oznake, dokumenti_od, dokumenti_do);
	ucitaj("fotografije", "alatke/ajax-fotografije.php", broj_oznake, fotografije_od, fotografije_do);
}


function ucitaj(element, url, br, ucitaj_od, ucitaj_do) {
	var xmlhttp=new XMLHttpRequest();
    var target = document.getElementById(element);
    var prvo_dete = target.children[0];
	xmlhttp.open("GET", url+"?br="+br+"&ucitaj_od="+ucitaj_od+"&ucitaj_do="+ucitaj_do, true);
	xmlhttp.send();

	xmlhttp.onreadystatechange=function() { 	                                    // radi u povratku
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {

            if(prvo_dete.className == "ucitavac") target.removeChild(prvo_dete);    // uklanja prvi loader

            var ucitavaci = $(".ucitavac");
            for(var i=0; i<ucitavaci.length; i++) {                                 // sakriva potonje učitavače
                ucitavaci[0].className = "nevidljiv";
            }

			target.innerHTML += xmlhttp.responseText;                               // dodaje tekst
			prikupljajTagove();
            dozvoljeno_ucitavanje = true;
		} // kraj ako uspe
	} // kraj povratnih radnji
} // kraj ucitaj


function ucitajJos(ovo){
    if(dozvoljeno_ucitavanje) {

        if(ovo.children[1].id == "hronologija") {
            if(hronologija_do < broj_tagovanih_hro){        // ako je ostalo materijala
                hronologija_od = hronologija_do;            // nastavlja gde je stao
                hronologija_do += 100;                       // pomera gornju granicu
                ucitaj("hronologija", "alatke/ajax-hronologija.php", broj_oznake, hronologija_od, hronologija_do);
                dozvoljeno_ucitavanje = false;  // obustavlja dalje ucitavanje dok ne stignu podaci
            }
        }
        if(ovo.children[1].id == "dokumenti") {
            if(dokumenti_do < broj_tagovanih_dok) {
                dokumenti_od = dokumenti_do;             // nastavlja gde je stao
                dokumenti_do += 100;                       // pomera gornju granicu
                ucitaj("dokumenti", "alatke/ajax-dokumenti.php", broj_oznake, dokumenti_od, dokumenti_do);
                dozvoljeno_ucitavanje = false;  // obustavlja dalje ucitavanje dok ne stignu podaci
            }
        }
        if(ovo.children[1].id == "fotografije") {
            if(fotografije_do < broj_tagovanih_fot) {
                fotografije_od = fotografije_do;             // nastavlja gde je stao
                fotografije_do += 40;                       // pomera gornju granicu
                ucitaj("fotografije", "alatke/ajax-fotografije.php", broj_oznake, fotografije_od, fotografije_do);
                dozvoljeno_ucitavanje = false;  // obustavlja dalje ucitavanje dok ne stignu podaci
            }
        }
    }
}


function prikupljajTagove(){
	ucitano_odeljaka++;
	if(ucitano_odeljaka >= 3) {
		var prikupljeni_tagovi = $('.prikupljeni_tagovi');      // hvata sve tagove iz skrivenih polja

		for (var i = 0; i < prikupljeni_tagovi.length; i++) {
			var ovi_tagovi = JSON.parse(prikupljeni_tagovi[i].innerHTML);
            // dodaje ove tagove u sve tagove
            Array.prototype.push.apply(svi_tagovi, ovi_tagovi);
            //console.log(svi_tagovi);
		}
		var pasirani_tagovi = JSON.stringify(svi_tagovi);
		vratiSortirano("tagovi", "alatke/ajax-tagovi.php", pasirani_tagovi, broj_oznake);	
	}
}


function vratiSortirano(element, url, tagovi, broj_oznake){
	var pozadinska_veza = new XMLHttpRequest();	
	pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			document.getElementById(element).innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("POST", url, true);
	pozadinska_veza.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	pozadinska_veza.send("tagovi=" + tagovi + "&broj_oznake=" + broj_oznake);
}
</script>

<?php if($ulogovan == true) { // menja opis ?>
<script>document.getElementById('naslov').contentEditable = true;</script>
<?php } // kraj ulogovan ?>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
