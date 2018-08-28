<?php

	// padajuci meni za datum?

	require_once("ukljuci/config.php");
	include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
	include_once(ROOT_PATH . 'ukljuci/povezivanje-staro.php');

	$upit_za_sve = "SELECT * FROM dokumenti; ";
	$rezultat_za_sve = mysqli_query($konekcija,$upit_za_sve);
	$ukupno_svih_dokumenata = mysqli_num_rows($rezultat_za_sve);

	$pocni_od = $_POST['pocni_od'] ? $_POST['pocni_od'] : 1;
	$broj_rez = $_POST['broj_rez'] ? $_POST['broj_rez'] : 50;

	if ($_POST['pretrazi']) {

		$fraza = $_POST['fraza'];
		$knjiga = $_POST['knjiga'];
		$oblast = $_POST['oblast'];
		$dan = $_POST['dan'];
		$mesec = $_POST['mesec'];
		$godina = $_POST['godina'];
		$tvorac = $_POST['tvorac'];

		$niz_fraza = [];
		$niz_knjiga = [];
		$niz_oblasti = [];
		$niz_dana = [];
		$niz_meseci = [];
		$niz_godina = [];
		$niz_pripadnosti = [];

		$niz_nizova = [];
	}

?>

	<div class="okvir">

		<h1 id="naslov-pretraga">Pretraga dokumenata</h1>

		<p>Pretraži bazu od <b><?php echo $ukupno_svih_dokumenata; ?></b> dokumenata iz Drugog svetskog rata.</p>

		<form action="<?php $_SERVER[PHP_SELF]; ?>" method="post">

			<TABLE>
				<TR>
				  <TD>Po frazi: </TD>
				  <TD><input class="ista-sirina" type="text" name="fraza" value="<?php echo $fraza; ?>"></TD>
				</TR>

				<TR>
				  <TD>Po zborniku: </TD>
				  <TD>
					<select name="knjiga" id="knjiga" class="ista-sirina">
						<?php include("ukljuci/knjige-zbornika.php"); ?>
					</select>

					<script>document.getElementById('knjiga').value = "<?php echo $knjiga; ?>";</script>
				  </TD>
				</TR>

				<TR>
				  <TD>Po oblasti: </TD>
				  <TD>
					<select name="oblast" id="oblast" class="ista-sirina">
						<?php include("ukljuci/postojece-oblasti.php"); ?>
					</select>

					<script>document.getElementById('oblast').value = "<?php echo $oblast; ?>";</script>
				  </TD>
				</TR>

				<TR>
				  <TD>Po datumu: </TD>
				  <TD>
					<input type='number' min='0' max='31' name='dan' value='<?php echo $dan; ?>'>
					<input type='number' min='0' max='12' name='mesec' value='<?php echo $mesec; ?>'>
					<input type='number' min='1940' max='1945' name='godina' value='<?php echo $godina; ?>'>
				  </TD>
				</TR>

				<TR>
				  <TD>Po tvorcu: </TD>
				  <TD>
					<select name="tvorac" id="tvorac" class="ista-sirina">
						<?php include("ukljuci/postojece-pripadnosti.php"); ?>
					</select>

					<script>document.getElementById('tvorac').value = "<?php echo $tvorac; ?>";</script>
				  </TD>
				</TR>

			</TABLE>

			<p>Prikaži rezultate od: <input type="number" name="pocni_od" id="pocni_od" value="<?php echo $pocni_od; ?>"> do: <input type="number" name="broj_rez" id="broj_rez" value="<?php echo $broj_rez; ?>">

			<input class="pretrazi" type="submit" name="pretrazi" value="Prikaži">

			<input class="pretrazi" type="submit" name="reset" value="Resetuj"></p>

		</form>

	<?php

	if ($_POST['pretrazi']) {

		/********************
			PUNJENJE NIZOVA
		********************/

		if($fraza) {
			$upit_za_frazu = "SELECT id FROM dokumenti WHERE opis LIKE '%$fraza%' ";

			$razultat_za_frazu = mysqli_query($konekcija,$upit_za_frazu);

			while ($red_fraza = mysqli_fetch_assoc($razultat_za_frazu)) {
				$niz_fraza[] = $red_fraza['id'];
			} // kraj while

			$niz_nizova[] = $niz_fraza;
		}

		if($knjiga) {
			$upit_za_knjigu = "SELECT id FROM dokumenti WHERE src = '$knjiga'";

			$razultat_za_knjigu = mysqli_query($konekcija,$upit_za_knjigu);

			while ($red_knjiga = mysqli_fetch_assoc($razultat_za_knjigu)) {
				$niz_knjiga[] = $red_knjiga['id'];
			} // kraj while

			$niz_nizova[] = $niz_knjiga;

		}

		if($oblast) {
			$upit_za_oblast = "SELECT dokument_id FROM mesto WHERE oblast = '$oblast'";

			$razultat_za_oblast = mysqli_query($konekcija,$upit_za_oblast);

			while ($red_oblasti = mysqli_fetch_assoc($razultat_za_oblast)) {
				$niz_oblasti[] = $red_oblasti['dokument_id'];
			} // kraj while

			$niz_nizova[] = $niz_oblasti;
		}

		if($dan) {
			$upit_za_dan = "SELECT dokument_id FROM vreme WHERE dan_izv = '$dan' ";

			$razultat_za_dan = mysqli_query($konekcija,$upit_za_dan);

			while ($red_dana = mysqli_fetch_assoc($razultat_za_dan)) {
				$niz_dana[] = $red_dana['dokument_id'];
			} // kraj while

			$niz_nizova[] = $niz_dana;
		}

		if($mesec) {
			$upit_za_mesec = "SELECT dokument_id FROM vreme WHERE mesec_izv = '$mesec' ";

			$razultat_za_mesec = mysqli_query($konekcija,$upit_za_mesec);

			while ($red_meseci = mysqli_fetch_assoc($razultat_za_mesec)) {
				$niz_meseci[] = $red_meseci['dokument_id'];
			} // kraj while

			$niz_nizova[] = $niz_meseci;
		}

		if($godina) {
			$upit_za_godinu = "SELECT dokument_id FROM vreme WHERE god_izv = '$godina' ";
			$razultat_za_godinu = mysqli_query($konekcija,$upit_za_godinu);

			while ($red_godina = mysqli_fetch_assoc($razultat_za_godinu)) {
				$niz_godina[] = $red_godina['dokument_id'];
			} // kraj while

			$niz_nizova[] = $niz_godina;
		}

		if($tvorac) {
			$upit_za_tvorca = "SELECT dokument_id FROM pripadnost WHERE strana = '$tvorac' ";

			$razultat_za_tvorca = mysqli_query($konekcija,$upit_za_tvorca);

			while ($red_pripadnosti = mysqli_fetch_assoc($razultat_za_tvorca)) {
				$niz_pripadnosti[] = $red_pripadnosti['dokument_id'];
			} // kraj while

			$niz_nizova[] = $niz_pripadnosti;
		}

		$ukupno_parametara = count($niz_nizova);
		$prvi_niz = $niz_nizova[0];
		$duzina_prvog = count($prvi_niz);

		if($ukupno_parametara==0) {
			echo "<p>Niste izabrali ni jedan kriterijum pretrage.</p>";
		} else {

			/********************
				UPOREĐIVANJE
			********************/

			// uporedjuje prvi niz sa svakim narednim
			// izbacuje sve id-eve koji se ne poklapaju

			for($i=1; $i < $ukupno_parametara; $i++){
				// pretresa od prvog do poslednjeg elementa prvog niza
				for($j=0; $j<$duzina_prvog; $j++){
					// uporeduje dal se taj element sadrzi u narednom nizu
					if(! in_array($prvi_niz[$j], $niz_nizova[$i])) {
						// ako ne, izbacuje ga iz niza
						unset($prvi_niz[$j]);
					}
				}
			}

			/********************
				PRIKAZIVANJE
			********************/

			$ukupno_dokumenata = count($prvi_niz);
			sort($prvi_niz);

			if($broj_rez > $ukupno_dokumenata) {
				$broj_rez = $ukupno_dokumenata;
			}

			for($brojac=1; $brojac<=$broj_rez; $brojac++) {
				$tekuci_id = $prvi_niz[$brojac-1];

				$upit_za_opis = "SELECT opis FROM dokumenti WHERE id='$tekuci_id';" ;
				$rezultat_za_opis = mysqli_query($konekcija, $upit_za_opis);
				$red_opisa = mysqli_fetch_assoc($rezultat_za_opis);
				$opis = $red_opisa['opis'];

				if($brojac >= $pocni_od) {
					echo "<div class='okvir'><p class='opis'><i><a href='dokument.php?br=$tekuci_id' target=_blank>" . $brojac . ") " . $opis . "</a></i></p></div>";
				}
			}

		}	// kraj else
	} // kraj if post

	?>

	</div>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
