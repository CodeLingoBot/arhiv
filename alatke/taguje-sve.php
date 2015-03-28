<?php

	// još jedan eliminator

	$naslov = "Taguje sve!";
	require_once("../ukljuci/config.php");
	include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

	if (!$_SESSION['nadimak'] && !$_COOKIE['nadimak']) {
		echo "<p>Morate biti <a href='../prijava.php'>prijavljeni</a> da biste pristupili administriranju.</p>";
		
	} else {	// prikazuje stranicu
?>
	
<style>
a {
	text-decoration: none;
	color:inherit;
}
.crveno {
	color:red;
}
.upozorenje {
	background:LightCoral;
}
.kao-dugme{
	display:inline-block;
	background:#eee;
	padding:0 2px;
	margin-right:4px;
	border:1px solid #999;
}
.odeljak_opis {
	margin:10px 0;
}
p {
	margin-bottom:4px;
}

.nevidljiv {
	display:none;
}

img {
	width:100px;
}

.sugestije-okvir {
    display: inline-block;
}

#lista_predloga {
    margin: 0;
    padding: 0;
    list-style: none;
    display: none;
	min-width:200px;
}

.sugestije-okvir:hover #lista_predloga {
    display: block;
    position: absolute;
}

.predlozi {
    display: block;
    position: relative;
    border-top: 1px solid #ffffff;
    padding: 5px;
	background: rgb(250,250,250);
    margin-left: 1px;
    white-space: nowrap;
	min-width:200px;
}
.predlozi:hover {
    background: #eee;
}

.oblast {
	width:25px;
	background:#eee;
	text-align:right;
	margin-left:5px;
}
.prazno {
	min-height:200px;
}
#prikazi {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
	padding: 10px;
}
</style>

<div class="sredina">

	<h1>Masovno taguje</h1>

<?php

	// ne menjati nazive varijabli zbog ajaxa!
	$tag = $_POST['tag'];
	$broj_entia = $_POST['id_oznake'];
	$obrazac = $_POST['obrazac'] ?: " ";
	$dodatni_obrazac = $_POST['dodatni_obrazac'] ?: " ";
	$dodatni_obrazac2 = $_POST['dodatni_obrazac2'] ?: " ";
	$eliminator = $_POST['eliminator'];
	$eliminator2 = $_POST['eliminator2'];
	$eliminator3 = $_POST['eliminator3'];	
	$vrsta_entia = $_POST['vrsta_entia'] ?: 0;
	$vrsta_materijala = $_POST['vrsta_materijala'] ?: 1;
	if($vrsta_materijala == 1) {$naziv_tabele = "hr1";} 
	if($vrsta_materijala == 2) {$naziv_tabele = "dokumenti";}
	if($vrsta_materijala == 3) {$naziv_tabele = "fotografije";}
	$trazena_oblast = $_POST['trazena_oblast'];
	$izabrana_oblast = $_POST['izabrana_oblast'];

	// salje upit i lista rezultate
	$rezultat = mysqli_query($konekcija, "SELECT * FROM $naziv_tabele ; ");
	$ukupno_dokumenata = mysqli_num_rows($rezultat);
	$pocni_od = $_POST['pocni_od'] ?: 1;
	$prikazi_do = $_POST['prikazi_do'] ?: 200;
	
	// pravi tagove
	$pravi_tag = "INSERT INTO znaci.entia (naziv, vrsta, rang) VALUES ('$tag', $vrsta_entia, 1);";
	
	if($_POST['napravi_tag']) {	
		if(trim($tag) != "") {
			$rezultat_provere = mysqli_query($konekcija, "SELECT id FROM entia WHERE naziv='$tag' ");
			
			if(mysqli_num_rows($rezultat_provere) == 0) {
				
				mysqli_query($konekcija,$pravi_tag);
				$broj_taga = mysqli_insert_id($konekcija);
				echo "<p>Napravio sam tag. </p>\n";	
				
			} else {
				
				$red_provere = mysqli_fetch_assoc($rezultat_provere);
				$broj_taga = $red_provere['id'];				
				echo "<p>Tag već postoji. </p>\n";
			}

		echo "<script>var broj_taga = $broj_taga;</script>\n";

		} else {
			echo "<p>Tag je prazan. </p>\n";
		}
	}
	
?>
	
	<form method="post" action="<?php $_SERVER[PHP_SELF]; ?>">

		Izaberi oznaku: <div class="sugestije-okvir">
			<input name="tag" id="tag" onkeyup="pokaziSugestije(this.value, vrsta_entia.value)" autocomplete="off" value="<?php echo $tag; ?>">
			
			<div id="polje_za_sugestije"></div>
		</div>
		
		vrstu oznake
		<select name="vrsta_entia" id="vrsta_entia">
			<option value='0'>jedinice</option>
			<option value='2'>gradovi</option>
			<option value='3'>ličnosti</option>
			<option value='4'>operacije</option>
			<option value='5'>zločini</option>
			<option value='6'>teme</option>
			<option value='7'>organizacije</option>
		</select>
		<script>vrsta_entia.value="<?php echo $vrsta_entia; ?>";</script>
		
		<span>id oznake</span>
		<input name="id_oznake" id="id_oznake" type="number" value="<?php echo $broj_entia; ?>">
		
		ili <input type="submit" name="napravi_tag" value="Napravi oznaku">
		<br>
		<br>
		
		Traženi obrazac: <input name="obrazac" value="<?php echo $obrazac; ?>">
		oblast: 
		<select name="trazena_oblast" id="trazena_oblast">
	
			<?php include "../ukljuci/postojece-oblasti.php"; ?>
		
		</select>
		<script>trazena_oblast.value="<?php echo $trazena_oblast; ?>";</script>

		materijal: 
		<select name="vrsta_materijala" id="vrsta_materijala">
			<option value='1'>Hronologija</option>
			<option value='2'>Dokumenti</option>
			<option value='3'>Fotografije</option>
		</select>
		<script>vrsta_materijala.value="<?php echo $vrsta_materijala; ?>";</script>		
		<br>
		<br>

		dodatni uslov: <input name="dodatni_obrazac" value="<?php echo $dodatni_obrazac; ?>">	
		dodatni uslov2: <input name="dodatni_obrazac2" value="<?php echo $dodatni_obrazac2; ?>">
		<br>
		<br>

		eliminator: <input name="eliminator" value="<?php echo $eliminator; ?>">
		eliminator2: <input name="eliminator2" value="<?php echo $eliminator2; ?>">
		eliminator3: <input name="eliminator3" value="<?php echo $eliminator3; ?>">		
		<br>
		<br>

		Počni od: <input type="number" name="pocni_od" value="<?php echo $pocni_od; ?>">
		prikaži do: <input type="number" name="prikazi_do" value="<?php echo $prikazi_do; ?>">
		<input type="submit" name="trazi" id="prikazi" value="Prikaži materijal"><br>
		<br>
		<br>
		
		<div class="prazno">

<?php

	$obrazac = "/" . $obrazac . "/i";
	
	if($prikazi_do>$ukupno_dokumenata){
		$prikazi_do = $ukupno_dokumenata;
	}
	
	// ogranicava prikazivanje rezultata
	$brojac = 1;

	for($i=0; $i<$ukupno_dokumenata; $i++){
		
		$red = mysqli_fetch_row($rezultat);

		// uniformiše različite materijale	

		// vadi id
		if($vrsta_materijala == 3) {
			$id = $red[1];	
		} else {
			$id = $red[0];	
		}

		// vadi datum i opis
		if($vrsta_materijala == 1) {
			$datum = $red[1] . "." . $red[2] . "." . $red[3] . ". ";
			$opis = $red[5];
			$opis = $datum . $opis;
		}
		if($vrsta_materijala == 2) {$opis = $red[1];} 

		if($vrsta_materijala == 3) {$opis = $red[2];} 

		// vadi oblast
		if($vrsta_materijala == 1) {$oblast = $red[6];} 
		if($vrsta_materijala == 2) {$oblast = $red[13];} 
		if($vrsta_materijala == 3) {$oblast = $red[5];} 
		

		$sadrzi = preg_match($obrazac, $opis, $pogoci);		
				
		// ako sadrži eliminator ništa ne radi
		if( $eliminator != "" and ( strpos(strtolower($opis), strtolower($eliminator)) ) !== false ) {

		// i ako sadrži eliminator2 ništa ne radi
		} else if( $eliminator2 != "" and ( strpos(strtolower($opis), strtolower($eliminator2)) ) !== false ){

		// i ako sadrži eliminator3 ništa ne radi
		} else if( $eliminator3 != "" and ( strpos(strtolower($opis), strtolower($eliminator3)) ) !== false ){

		// inače kreće provera, ako sadrži regex obrazac			
		} else if($sadrzi){
		
			// i ako sadrži dodatni obrazac
			if (strpos(strtolower($opis), strtolower($dodatni_obrazac)) !== false) {

				if (strpos(strtolower($opis), strtolower($dodatni_obrazac2)) !== false) {

					// ako nije izabrana oblast ili ako je izabrana i poklapa se
					if( ($trazena_oblast == 0.5) || ($trazena_oblast == $oblast) ){
		
						// zacrveni trazeni pojam
						$opis = preg_replace($obrazac, "<span class='crveno'>$pogoci[0]</span>", $opis);
						
						if($brojac >= $pocni_od and $brojac <= $prikazi_do) {

							echo "
				<div class='odeljak_opis'>
					<p>". $brojac . ") <i>" . $id . " </i> <a target='_blank' href='../izvor.php?br=$id&vrsta=$vrsta_materijala'>" . $opis . " </a> <input value=$oblast class='oblast' ondblclick='promeniOblast(this, $id, $vrsta_materijala)'><span></span></p>\n";
								
							// da prikaže sliku
							/*if($vrsta_materijala == 3) {
								echo "<img src='../../images/$id.jpg'><br>";
							} */
							
							// pravi dugmice za ajax tagove i brisanje
							echo "
					<div class='kao-dugme' onclick='pozadinskiTaguj(this, $vrsta_materijala, $broj_entia, $id)'>Taguj ovo </div><div class='kao-dugme' onclick='pozadinskiBrisi(this, $vrsta_materijala,$broj_entia,$id)'>Obriši tag </div><span></span>\n
				</div>\n";

							if($_POST['taguj_sve']) {

								// proverava jel tagovano
								$provera = mysqli_query($konekcija, "SELECT * FROM hr_int WHERE broj=$broj_entia AND zapis=$id AND vrsta_materijala=$vrsta_materijala;");
								
								if(mysqli_num_rows($provera) == 0) {
									
									mysqli_query($konekcija, "INSERT INTO hr_int (vrsta_materijala,broj,zapis) VALUES ($vrsta_materijala,$broj_entia,$id) ");
									echo "<i class='crveno'>Tagovano! </i><br>";
								
								} else {
									echo "<i>Već je tagovano. </i><br>";
								}
								
							} // kraj if taguj_sve
							
							if($_POST['obrisi_sve']) {
								mysqli_query($konekcija, "DELETE FROM hr_int WHERE vrsta_materijala='$vrsta_materijala' AND broj='$broj_entia' AND zapis='$id'; ");
								echo "<i>Izbrisano. </i><br>";
							} // kraj if obrisi_sve
							
							if($_POST['masovno_oblast']) {
																
								if($vrsta_materijala == 1) { 
									$upit = "UPDATE hr1 SET zona=$izabrana_oblast WHERE id=$id ;";
								} 
								if($vrsta_materijala == 2) { 
									$upit = "UPDATE dokumenti SET oblast=$izabrana_oblast WHERE id=$id ;";
								} 
								if($vrsta_materijala == 3) { 
									$upit = "UPDATE fotografije SET oblast=$izabrana_oblast WHERE inv=$id ;";
								} 
								
								mysqli_query($konekcija, $upit);
								echo "<i>Oblast uneta. </i><br>";
							} // kraj if obrisi_sve

						}	// ako je vece od pocni_od
						$brojac++;

					} // kraj ako oblast

				}	// kraj dodatni obrazac2
				
			}	// kraj dodatni obrazac

		}	// kraj ako sadrzi
	}	// kraj for petlje
	
?>

		</div>

		<br>
		<input type="submit" name="taguj_sve" class="upozorenje" value="Taguj sve!">
		<input type="submit" name="obrisi_sve" class="upozorenje" value="Obriši tagove!">
		Oblast: <input id="izabrana_oblast" name="izabrana_oblast" size="5" value="" onkeyup="masovnoBiraOblast();">
		<input type="submit" name="masovno_oblast" class="upozorenje" value="Masovno oblast!">
	</form>
	
	<br>
	
</div>

<script>
var polje_za_sugestije = document.getElementById("polje_za_sugestije");
var tag = document.getElementById("tag");
var lista_predloga = document.getElementById("lista_predloga");
var id_oznake = document.getElementById("id_oznake");
var izabrana_oblast = document.getElementById("izabrana_oblast");
var oblasti = document.getElementsByClassName("oblast");

if(typeof broj_taga !== "undefined") id_oznake.value = broj_taga;

function pozadinskiTaguj(ovo, vrsta_materijala, broj_entia, id){
	var pozadinska_veza = new XMLHttpRequest();

    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextSibling.nextSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("GET","asinhron-tag.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
	pozadinska_veza.send();	
}


function pozadinskiBrisi(ovo, vrsta_materijala, broj_entia, id){
	var pozadinska_veza = new XMLHttpRequest();

    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("GET","asinhron-bris.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
	pozadinska_veza.send();	
}


function pokaziSugestije(unos) {
	var pozadinska_veza = new XMLHttpRequest();
	if (unos.length > 1) {
		polje_za_sugestije.style.display = "block";
		
		pozadinska_veza.onreadystatechange = function() {
			if (pozadinska_veza.readyState == 4 && pozadinska_veza.status == 200) {
				polje_za_sugestije.innerHTML = pozadinska_veza.responseText;
			}
		}
		pozadinska_veza.open("GET", "sugestije-sve.php?pocetno="+unos, true);
		pozadinska_veza.send();
	}
}

// pojavljuje se samo kad prikaze sugestije iz ajaxa
function izaberiOznaku(izabrano) {
	tag.value = izabrano.innerHTML;
	id_oznake.value = izabrano.nextSibling.innerHTML;
	polje_za_sugestije.style.display = "none";
}


function promeniOblast(ovo, id, vrsta_materijala){
	var oblast = ovo.value;
	var pozadinska_veza = new XMLHttpRequest();

    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("GET","menja-oblast.php?vrsta_materijala="+vrsta_materijala+"&oblast="+oblast+"&id="+id,true);
	pozadinska_veza.send();	
}


function masovnoBiraOblast() {
	for(var i = 0; i < oblasti.length; i++) {
		oblasti[i].value = izabrana_oblast.value;
	}	
}
</script>

<?php

}	// kraj else prikazuje stranicu

//include "../ukljuci/podnozje.php";
// funkcije rade totalno različito

?>
