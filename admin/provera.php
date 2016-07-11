<?php

    // promeniti da vuče vreme i mesto iz dokumenata
    // promeniti da ih tu azurira

    session_start();
    require_once("../ukljuci/config.php");
    include_once(ROOT_PATH . '../ukljuci/header.php');

    $upit_za_sve = "SELECT * FROM dokumenti; ";
    $rezultat_za_sve = mysqli_query($konekcija,$upit_za_sve);
    $ukupno_svih_dokumenata = mysqli_num_rows($rezultat_za_sve);

    $pocni_od = $_POST['pocni_od'] ? $_POST['pocni_od'] : 1;
    $broj_rez = $_POST['broj_rez'] ? $_POST['broj_rez'] : 50;

    if ($_POST['reset']) {

        // ništa ne dodaje

    } else if($_POST)    {

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

    <?php

        if (!$_SESSION['nadimak'] && !$_COOKIE['nadimak']) {
            echo "<p>Morate biti <a href='prijava.php'>prijavljeni</a> da biste pristupili administriranju.</p>";

        } else {    // prikazuje stranicu

    ?>

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
                        <?php include("../ukljuci/knjige-zbornika.php"); ?>
                    </select>

                    <script>document.getElementById('knjiga').value = "<?php echo $knjiga; ?>";</script>
                  </TD>
                </TR>

                <TR>
                  <TD>Po oblasti: </TD>
                  <TD>
                    <select name="oblast" id="oblast" class="ista-sirina">
                        <?php include("../ukljuci/postojece-oblasti.php"); ?>
                    </select>

                    <script>document.getElementById('oblast').value = "<?php echo $oblast; ?>";</script>
                  </TD>
                </TR>

                <TR>
                  <TD>Po datumu: </TD>
                  <TD>
                    <input type='number' min='0' max='39' name='dan' value='<?php echo $dan; ?>'>
                    <input type='number' min='0' max='12' name='mesec' value='<?php echo $mesec; ?>'>
                    <input type='number' min='1940' max='1945' name='godina' value='<?php echo $godina; ?>'>
                  </TD>
                </TR>

                <TR>
                  <TD>Po tvorcu: </TD>
                  <TD>
                    <select name="tvorac" id="tvorac" class="ista-sirina">
                        <?php include("../ukljuci/postojece-pripadnosti2.php"); ?>
                    </select>

                    <script>document.getElementById('tvorac').value = "<?php echo $tvorac; ?>";</script>
                  </TD>
                </TR>

            </TABLE>

            <p>Prikaži rezultate od: <input type="number" name="pocni_od" id="pocni_od" value="<?php echo $pocni_od; ?>"> do: <input type="number" name="broj_rez" id="broj_rez" value="<?php echo $broj_rez; ?>">

            <input class="pretrazi" type="submit" name="pretrazi" value="Prikaži">

            <input class="pretrazi" type="submit" name="reset" value="Resetuj"></p>

    <?php

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
        $upit_za_oblast = "SELECT id FROM dokumenti WHERE oblast = '$oblast'";

        $razultat_za_oblast = mysqli_query($konekcija,$upit_za_oblast);

        while ($red_oblasti = mysqli_fetch_assoc($razultat_za_oblast)) {
            $niz_oblasti[] = $red_oblasti['id'];
        } // kraj while

        $niz_nizova[] = $niz_oblasti;
    }

    if($dan) {
        $upit_za_dan = "SELECT id FROM dokumenti WHERE dan_izv = '$dan' ";

        $razultat_za_dan = mysqli_query($konekcija,$upit_za_dan);

        while ($red_dana = mysqli_fetch_assoc($razultat_za_dan)) {
            $niz_dana[] = $red_dana['id'];
        } // kraj while

        $niz_nizova[] = $niz_dana;
    }

    if($mesec) {
        $upit_za_mesec = "SELECT id FROM dokumenti WHERE mesec_izv = '$mesec' ";

        $razultat_za_mesec = mysqli_query($konekcija,$upit_za_mesec);

        while ($red_meseci = mysqli_fetch_assoc($razultat_za_mesec)) {
            $niz_meseci[] = $red_meseci['id'];
        } // kraj while

        $niz_nizova[] = $niz_meseci;
    }

    if($godina) {
        $upit_za_godinu = "SELECT id FROM dokumenti WHERE god_izv = '$godina' ";
        $razultat_za_godinu = mysqli_query($konekcija,$upit_za_godinu);

        while ($red_godina = mysqli_fetch_assoc($razultat_za_godinu)) {
            $niz_godina[] = $red_godina['id'];
        } // kraj while

        $niz_nizova[] = $niz_godina;
    }

    if($tvorac) {
        $upit_za_tvorca = "SELECT id FROM dokumenti WHERE pripadnost = '$tvorac' ";

        $razultat_za_tvorca = mysqli_query($konekcija,$upit_za_tvorca);

        while ($red_pripadnosti = mysqli_fetch_assoc($razultat_za_tvorca)) {
            $niz_pripadnosti[] = $red_pripadnosti['id'];
        } // kraj while

        $niz_nizova[] = $niz_pripadnosti;
    }

    $ukupno_parametara = count($niz_nizova);
    $prvi_niz = $niz_nizova[0];
    $duzina_prvog = count($prvi_niz);

    if($ukupno_parametara==0) {

        if($_POST['pretrazi']) {
            echo "<p class='opis opis-najuzi'>Niste izabrali ni jedan kriterijum pretrage.</p>";
        }

    } else {

        /********************
            UPOREĐIVANJE
        ********************/

        for($i=1; $i < $ukupno_parametara; $i++){

            // pretresa od prvog do poslednjeg elementa prvog niza
            for($j=0; $j<$duzina_prvog; $j++){

                // uporeduje dal se taj element sadrzi u narednom nizu
                if(! in_array($prvi_niz[$j], $niz_nizova[$i])) {

                    // ako ne, izbacuje ga iz niza
                    unset($prvi_niz[$j]);

                }    // kraj if u nizu

            }    // kraj male for petlje

        } // kraj for petlje do ukupno_parametara

        /********************
            PRIKAZIVANJE
        ********************/

        echo "<div class='okvir'><h3 class='opis opis-najuzi'>Rezultati: </h3>
        <span class='oblast'>oblast</span><span class='tvorac'>tvorac</span><span class='stara_godina'>god</span><span class='stari_mesec'>mes</span><span class='stari_dan'>dan</span></div>";

        $ukupno_dokumenata = count($prvi_niz);
        sort($prvi_niz);

        if($broj_rez > $ukupno_dokumenata) {
            $broj_rez = $ukupno_dokumenata;
        }

        for($brojac=1; $brojac<=$broj_rez; $brojac++) {

            $tekuci_id = $prvi_niz[$brojac-1];

            // uzima sve iz dokumenata
            $upit_za_dokumente = "SELECT * FROM dokumenti WHERE id='$tekuci_id';" ;
            $rezultat_za_dokumente = mysqli_query($konekcija, $upit_za_dokumente);
            $red_dokumenata = mysqli_fetch_assoc($rezultat_za_dokumente);
            $dokument_id = $red_dokumenata['id'];
            $rb = $red_dokumenata['rb'];
            $opis = $red_dokumenata['opis'];
            $src = $red_dokumenata['src'];
            $broj_strane = $red_dokumenata['p'];
            $stara_oblast = $red_dokumenata['oblast'];    // svaki put drugačija
            $stari_dan = $red_dokumenata['dan_izv'];
            $stari_mesec = $red_dokumenata['mesec_izv'];
            $stara_godina = $red_dokumenata['god_izv'];
            $stara_pripadnost = $red_dokumenata['pripadnost'];

            $id1 = $dokument_id . "a";         // za jedinstvenu identifikaciju dana
            $id2 = $dokument_id . "b";         // za jedinstvenu identifikaciju meseca
            $id3 = $dokument_id . "c";         // za jedinstvenu identifikaciju godine
            $id4 = $dokument_id . "d";         // za jedinstvenu identifikaciju tvorca

            $broj_knjige = $src % 100;
            $broj_toma = $src / 100;
            $broj_toma = $broj_toma % 100;

            $link = "http://znaci.net/zb/4_" . $broj_toma . "_" . $broj_knjige . ".pdf#page=" . $broj_strane;
            $link_izvor = "izvor.php?br=$dokument_id&vrsta=2";

            if($brojac >= $pocni_od) {            // prikaz počinje od zadatog

                $prikazi_oblast = $_POST[$dokument_id] ?: $stara_oblast;
                $prikazi_dan = is_numeric($_POST[$id1]) ? $_POST[$id1] : $stari_dan;
                $prikazi_mesec = is_numeric($_POST[$id2]) ? $_POST[$id2] : $stari_mesec;
                $prikazi_godinu = is_numeric($_POST[$id3]) ? $_POST[$id3] : $stara_godina;
                $prikazi_pripadnost = $_POST[$id4] ?: $stara_pripadnost;

                echo "\n<div class='okvir'><p class='opis opis-najuzi'><i>" . $brojac . ") <a href=$link_izvor target=_blank>" . $opis . " (str. $broj_strane)</a></i></p>";

                echo "\n<select name='$dokument_id' class='oblast bira_oblast'>";
                include("../ukljuci/postojece-oblasti.php");
                echo "</select>";

                echo "\n<select name='$id4' class='tvorac bira_pripadnost'>";
                include("../ukljuci/postojece-pripadnosti2.php");
                echo "</select>";

                echo "\n<input type='number' name='$id3' value='$prikazi_godinu' class='stara_godina'>\n";
                echo "<input type='number' min='0' max='12' name='$id2' value='$prikazi_mesec' class='stari_mesec'>\n";
                echo "<input type='number' min='0' max='39' name='$id1' value='$prikazi_dan' class='stari_dan'></div>\n";

            } // kraj if pocni_od

            $nova_oblast = $_POST[$dokument_id];    // svaki put različito
            $novi_dan = $_POST[$id1];
            $novi_mesec = $_POST[$id2];
            $nova_godina = $_POST[$id3];
            $nova_pripadnost = $_POST[$id4];

            if($_POST['potvrdi']) {

                include ("../ukljuci/azurira-oblast2.php");
                include ("../ukljuci/azurira-datum2.php");
                include ("../ukljuci/azurira-pripadnost.php");

            }

        } // kraj for do broj_rez

        $prikazi_pripadnost = null;     // prazni varijablu da ne kači crveno polje

    ?>

        <div class='okvir'>

            <p class='opis opis-najuzi upozorenje'>Upozorenje: crvena polja masovno menjaju sva ostala!! </p>

            <select name="oblast_masovno" id="oblast_masovno" class="masovno" onchange="promeniOblasti()" >
                <?php include("../ukljuci/postojece-oblasti.php"); ?>
            </select>

            <select name="pripadnost_masovno" id="pripadnost_masovno" class="masovno" onchange="promeniPripadnosti()" >
                <?php include("../ukljuci/postojece-pripadnosti2.php"); ?>
            </select>

            <input type='number' min="1941" max="1945" name='godina_masovno' value='' id='godina_masovno' class='stara_godina masovno' onchange="promeniGodine(this)" >

            <input type='number' min="0" max="12" name='mesec_masovno' value='' id='mesec_masovno' class='stari_mesec masovno' onchange="promeniMesece(this)" >

            <input type='number' min="0" max="31" name='dani_masovno' value='' id='dani_masovno' class='stari_dan masovno' onchange="promeniDane(this)" >

        </div>

        <script>document.getElementById('oblast_masovno').value = "<?php echo $izabrana_oblast; ?>"; </script>

        <br>
        <br>
        <input class="potvrdi" type="submit" name="potvrdi" value="Upiši u bazu">

        <input class="potvrdi" type="submit" name="odustani" value="Odustani"></a>

    <?php

        }    // kraj else prikazuje razultate

    }    // kraj else prikazuje stranicu


    ?>

    </form>

</div>

<?php include_once(ROOT_PATH . "../ukljuci/footer.php"); ?>
