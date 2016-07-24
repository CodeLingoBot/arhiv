<?php

$naslov = "Podaci o izvoru";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
include_once(ROOT_PATH . 'model/klasaIzvor.php');

if($ulogovan == false) echo "<style>.ulogovan {display:none;}</style>\n";

if (empty($_GET['br']) || empty($_GET['vrsta'])) die();

$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);
$vrsta = filter_input(INPUT_GET, 'vrsta', FILTER_SANITIZE_NUMBER_INT);
$opis = ($vrsta == 1) ? "Zapis:" : "Opis:";

// menja opis ako treba
if($_POST['novi_opis']) {
    $novi_opis = $_POST['novi_opis'];
    $novi_opis = $mysqli->real_escape_string($novi_opis);
    if ($vrsta == 1){
        $update_opis = "UPDATE hr1 SET tekst='$novi_opis' WHERE id=$id ;";
    } else if ($vrsta == 2) {
        $update_opis = "UPDATE dokumenti SET opis='$novi_opis' WHERE id=$id ;";
    } else if ($vrsta == 3) {
        $update_opis = "UPDATE fotografije SET opis='$novi_opis' WHERE inv=$id ;";
    }
    $mysqli->query($update_opis);
}

$ova_datoteka = new Datoteka($id, $vrsta);
$prikazi_oblast = $ova_datoteka->lokacija;
?>

    <div class="okvir izvor">

        <h1>Podaci o izvoru</h1>

        <div class="podaci_o_izvoru">
            <form method='post'>
                <input type="hidden" id="novi_opis" name="novi_opis">
                <b><?php echo $opis; ?> </b><span id='opis' <?php if($ulogovan) echo "contenteditable='true'"; ?>><?php echo $ova_datoteka->opis; ?></span>
                <?php
                    if($ulogovan) { ?>
                        <button type='submit' id="azuriraj_opis">Ažuriraj opis</button><span></span>
                    <?php }
                    if($vrsta == 3 && $ova_datoteka->opis_jpg) { ?>
                        <br><b>Izvorni opis:</b><br>
                        <img class="max-100" src='http://www.znaci.net/o_slikama/<?php echo $ova_datoteka->opis_jpg; ?>.jpg'/>
                <?php } ?>
            </form>
            <?php
              $datum_prikaz = $ova_datoteka->datum;
              if ($datum_prikaz == "0000-00-00.") $datum_prikaz = " nepoznat";
            ?>
            <b>Datum: </b><span><?php echo $datum_prikaz . "."; ?></span>
            <?php
                if($ulogovan == true) {
                    if($vrsta == 3) { ?>
                        <input id='datum' value='<?php echo $ova_datoteka->datum; ?>' class='unos-sirina'>
                        <button type='submit' onclick='izmeniDatum(this, <?php echo $id; ?>, <?php echo $vrsta; ?>)'>Izmeni datum</button><span></span>
                    <?php } else { ?>
                        <input id='dan' type='number' value='<?php echo $ova_datoteka->dan; ?>' class='unos-sirina'>
                        <input id='mesec' type='number' value='<?php echo $ova_datoteka->mesec; ?>' class='unos-sirina'>
                        <input id='godina' type='number' value='<?php echo $ova_datoteka->godina; ?>' class='unos-sirina'>
                        <button type='submit' onclick='izmeniDatum(this, <?php echo $id; ?>, <?php echo $vrsta; ?>)'>Izmeni datum</button><span></span>
                    <?php }
                }
            ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $ova_datoteka->oblast_prevedeno; ?>
            <?php
                if($ulogovan == true) { ?>
                    <select name='nova_oblast' id='nova_oblast' value='<?php echo $ova_datoteka->lokacija; ?>'>
                        <?php include "ukljuci/postojece-oblasti.php"; ?>
                    </select>
                    <button type='submit' onclick='promeniOblast(this, <?php echo $id; ?>, <?php echo $vrsta; ?>)'>Izmeni oblast</button><span></span>
                <?php }
            ?><br>
            <b>Vrsta podatka:</b> <?php echo $ova_datoteka->vrsta; ?><br>
            <?php if ($vrsta == 2) { ?>
                <b>Dokument izdali:</b> <?php echo $ova_datoteka->pripadnost; ?>
                <?php
                    if($ulogovan == true) {
                      $prikazi_pripadnost = $ova_datoteka->pripadnost; ?>
                        <select class="ista-sirina" id="nova_pripadnost">
                            <?php include(ROOT_PATH . "ukljuci/postojece-pripadnosti.php"); ?>
                        </select>
                        <button type='submit' onclick='promeniPripadnost(this.nextElementSibling, <?php echo $id; ?>, $("#nova_pripadnost").value)'>Izmeni tvorce</button><span></span>
                    <?php } // if ulogovan ?><br>
            <?php } // if vrsta ?>
            <b>Izvor:</b><i> <?php echo $ova_datoteka->izvor; ?></i><br
            <b>URL:</b> <a href="<?php echo $ova_datoteka->url; ?>"><?php echo $ova_datoteka->url; ?></a><br>
            <b>Oznake:</b>

            <?php
            for($i=0; $i < count($ova_datoteka->tagovi); $i++) {
                $broj_taga = $ova_datoteka->tagovi[$i];
                $rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$broj_taga ");
                $naziv_taga = $rezultat_za_naziv->fetch_assoc()["naziv"];
                echo "<a href='pojam.php?br=$broj_taga'>$naziv_taga </a> &#9733; <button class='ulogovan' value='$broj_taga' onclick='pozadinskiBrisi(this, $vrsta, this.value, $id); '>-</button><span></span> &nbsp";
                // prazan span na kraju za povratnu poruku
            }
            ?><br>

            <?php
            if ($ulogovan == true) { ?>
              Nova oznaka:
                <div class='sugestije-okvir inline-block'>
                    <input class='unos-sirina2' id='tag' autocomplete='off' value=''>
                    <div id='polje_za_sugestije'></div>
                </div>
                <input class='unos-sirina' type='number' name='br' id='br_oznake' value=''>
                <div class='dugme' onclick='pozadinskiTaguj(this, <?php echo $vrsta; ?>, this.previousElementSibling.value, <?php echo $id; ?>); isprazniPolje();'>Dodaj tag</div><span></span>
            <?php } // end if ulogovan ?>

        </div>
        <div class="clear"></div>

        <?php
            if($vrsta == 2){    // prikazuje platno i dugmiće ?>
            <a href="<?php echo $ova_datoteka->relativ_url; ?>" target="_blank">
                <img class="pdf-ikonica" src="slike/ikonice/pdf-icon.png" alt="pdf-knjiga"/>
            </a>
            <div>
                <button class="js-idi-nazad">Prethodna</button>
                <button class="js-idi-napred">Naredna</button>
                <span> Strana: <span id="trenutna_strana"></span> / <span id="ukupno_strana"></span></span>
            </div>
            <br><sup>Napomena: Broj strane u štampanom i elektronskom izdanju se često ne poklapa!</sup>
            <div class="okvir-platna">
                <canvas id='platno' class='crna-ivica'></canvas>
            </div>
            <div>
                <button class="js-idi-nazad">Prethodna</button>
                <button class="js-idi-napred">Naredna</button>
            </div>

        <?php
            } else if($vrsta == 3) {
                echo "<img src='$ova_datoteka->relativ_url' class='max-100'>";
            } else {
                echo "<iframe id='datoteka-frejm' src='$ova_datoteka->relativ_url' frameborder='0'></iframe>";
            }
        ?>

    </div>

  <input type="hidden" id="fajl_url" value="<?php echo $ova_datoteka->relativ_url; ?>">
  <input type="hidden" id="brojStrane" value="<?php echo $ova_datoteka->broj_strane; ?>">

<script src='js/libs/pdf.js'></script>
<script src="js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
