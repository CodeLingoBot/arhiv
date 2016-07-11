<?php

    // još jedan eliminator

    $naslov = "Taguje sve!";
    require_once("../ukljuci/config.php");
    include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

?>


<div class="okvir taguje-sve">

    <h1>Masovno taguje</h1>

<?php

if (!$_SESSION['nadimak'] && !$_COOKIE['nadimak']) {
    echo "<p>Morate biti <a href='prijava.php' class='underline'>prijavljeni</a> da biste pristupili administriranju.</p>";

} else {    // prikazuje stranicu

    // ne menjati nazive varijabli zbog ajaxa!
    $tag = $_POST['tag'];
    $broj_entia = $_POST['br_oznake'];
    $obrazac = $_POST['obrazac'] ?: " ";
    $dodatni_obrazac = $_POST['dodatni_obrazac'] ?: " ";
    $dodatni_obrazac2 = $_POST['dodatni_obrazac2'] ?: " ";
    $eliminator = $_POST['eliminator'];
    $eliminator2 = $_POST['eliminator2'];
    $eliminator3 = $_POST['eliminator3'];
    $eliminisi_oblast = $_POST['eliminisi_oblast'];
    $eliminisi_oblast2 = $_POST['eliminisi_oblast2'];
    $vrsta_entia = $_POST['vrsta_entia'] ?: 0;
    $vrsta_materijala = $_POST['vrsta_materijala'] ?: 1;
    if($vrsta_materijala == 1) {$naziv_tabele = "hr1";}
    if($vrsta_materijala == 2) {$naziv_tabele = "dokumenti";}
    if($vrsta_materijala == 3) {$naziv_tabele = "fotografije";}
    $trazena_oblast = $_POST['trazena_oblast'];
    $izabrana_oblast = $_POST['izabrana_oblast'];
    $regex_dodatno = $_POST['regex_dodatno'] || "" ? $_POST['regex_dodatno'] : "i";

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
            <input name="tag" id="tag" onkeyup="pokaziSugestije(this.value, this.nextElementSibling)" autocomplete="off" value="<?php echo $tag; ?>">
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
        <input name="br_oznake" id="br_oznake" type="number" value="<?php echo $broj_entia; ?>">

        ili <input type="submit" name="napravi_tag" value="Napravi oznaku">
        <br><br>

        Traženi obrazac: <input name="obrazac" value="<?php echo $obrazac; ?>">
        <input name="regex_dodatno" value="<?php echo $regex_dodatno; ?>" class="regex_dodatno">

        oblast:
        <select name="trazena_oblast" id="trazena_oblast">
            <?php include ROOT_PATH . "ukljuci/postojece-oblasti.php"; ?>
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
        eliminiši oblast: <input name="eliminisi_oblast" type="number" value="<?php echo $eliminisi_oblast; ?>">
        eliminiši oblast2: <input name="eliminisi_oblast2" type="number" value="<?php echo $eliminisi_oblast2; ?>">
        <br>
        <br>

        eliminator: <input name="eliminator" value="<?php echo $eliminator; ?>">
        eliminator2: <input name="eliminator2" value="<?php echo $eliminator2; ?>">
        eliminator3: <input name="eliminator3" value="<?php echo $eliminator3; ?>">
        <br>
        <br>

        Počni od: <input type="number" name="pocni_od" value="<?php echo $pocni_od; ?>">
        prikaži do: <input type="number" name="prikazi_do" value="<?php echo $prikazi_do; ?>">
        <input type="submit" name="trazi" class="prikazi" value="Prikaži materijal"><br>
        <br>
        <br>

        <div class="prazno">

<?php

    $obrazac = "/" . $obrazac . "/$regex_dodatno";    // case insensitive

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

        // i ako sadrži eliminiši oblast ništa ne radi
        } else if( $eliminisi_oblast == $oblast ){

        // i ako sadrži eliminiši oblast ništa ne radi
        } else if( $eliminisi_oblast2 == $oblast ){

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
                    <p>". $brojac . ") <i>" . $id . " </i> <a target='_blank' href='izvor.php?br=$id&vrsta=$vrsta_materijala'>" . $opis . " </a> <input value=$oblast class='oblast' ondblclick='promeniOvuOblast(this, $id, $vrsta_materijala)'><span></span></p>\n";

                            // da prikaže sliku
                            /*if($vrsta_materijala == 3) {
                                echo "<img src='slike/smanjene/$id-200px.jpg'><br>";
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
                        }    // ako je vece od pocni_od
                        $brojac++;
                    } // kraj ako oblast
                }    // kraj dodatni obrazac2
            }    // kraj dodatni obrazac
        }    // kraj ako sadrzi
    }    // kraj for petlje

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

if(typeof broj_taga !== "undefined") br_oznake.value = broj_taga;

function masovnoBiraOblast() {
    var izabrana_oblast = document.getElementById("izabrana_oblast");
    var oblasti = document.getElementsByClassName("oblast");
    for(var i = 0; i < oblasti.length; i++) {
        oblasti[i].value = izabrana_oblast.value;
    }
}
</script>

<?php
include ROOT_PATH . "ukljuci/podnozje.php";
}    // kraj else prikazuje stranicu
?>
