<?php

$naslov = "Podaci o izvoru";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'model/Dokument.php');
include_once(ROOT_PATH . 'model/Odrednica.php');
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');


if (empty($_GET['br'])) die();
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);

if($_POST['novi_opis']) {
    $novi_opis = $mysqli->real_escape_string($_POST['novi_opis']);
    $update_opis = "UPDATE dokumenti SET opis='$novi_opis' WHERE id=$id ;";
    $mysqli->query($update_opis);
}

$dokument = new Dokument($id);
?>

    <div class="okvir izvor">
        <h1><?php echo $dokument->getNaslov(); ?></h1>

        <div class="podaci_o_izvoru">
            <form method='post'>
                <input type="hidden" id="novi_opis" name="novi_opis">
                <b>Opis: </b><span id='opis' <?php if($ulogovan) echo "contenteditable='true'"; ?>><?php echo $dokument->opis; ?></span>
                <?php if($ulogovan) { ?>
                    <button type='submit' id="azuriraj_opis">Ažuriraj opis</button><span></span>
                <?php } ?>
            </form>
            <?php
              $datum_prikaz = $dokument->datum;
              if ($datum_prikaz == "0000-00-00.") $datum_prikaz = " nepoznat";
            ?>
            <b>Datum: </b><span><?php echo $datum_prikaz . "."; ?></span>
            <?php
                if($ulogovan) { ?>
                    <input id='dan' type='number' value='<?php echo $dokument->dan; ?>' class='unos-sirina'>
                    <input id='mesec' type='number' value='<?php echo $dokument->mesec; ?>' class='unos-sirina'>
                    <input id='godina' type='number' value='<?php echo $dokument->godina; ?>' class='unos-sirina'>
                    <button type='submit' id='izmeni-datum-zasebno'>Izmeni datum</button><span></span>
                <?php }
            ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $dokument->oblast_prevedeno; ?>
            <?php
                if($ulogovan) { ?>
                    <select name='nova_oblast' id='nova_oblast' value='<?php echo $dokument->lokacija; ?>'>
                        <?php include "ukljuci/postojece-oblasti.php"; ?>
                    </select>
                    <button type='submit' id='promeni-oblast'>Izmeni oblast</button><span></span>
                <?php }
            ?><br>
            <b>Dokument izdali:</b> <?php echo $dokument->pripadnost; ?>
            <?php
                if($ulogovan) {
                    $prikazi_pripadnost = $dokument->pripadnost; ?>
                    <select class="ista-sirina" id="nova_pripadnost">
                        <?php include(ROOT_PATH . "ukljuci/postojece-pripadnosti.php"); ?>
                    </select>
                    <button type='submit' id='promeni-pripadnost'>Izmeni tvorce</button><span></span>
            <?php } // if ulogovan ?><br>

            <b>Izvor:</b><i> <?php echo $dokument->izvor; ?></i><br>
            <b>URL:</b> <a href="<?php echo $dokument->url; ?>"><?php echo $dokument->url; ?></a><br>
            <b>Oznake:</b>

            <?php
            if ($dokument->tagovi) {
                $recnik = Odrednica::prevedi_odrednice($dokument->tagovi);
                foreach ($recnik as $oznaka_id => $data) {
                    $slug = $data[0];
                    $naziv = $data[1];
                    $url = BASE_URL . "odrednica/$slug";
                    echo " <a href=$url>$naziv </a> ★ ";
                    if ($ulogovan) echo "<button value='$oznaka_id' id='brisi-tag'>-</button><span></span> &nbsp";
                }
            }
            ?><br>

            <?php
            if ($ulogovan) { ?>
                <div class='sugestije-okvir inline-block'>
                Nova oznaka: <input class='js-sugestija unos-sirina2' autocomplete='off'>
                    <span id='sugestije_oznaka'></span>
                    <input class='unos-sirina' type='number' name='br' id='id_oznake'>
                    <div class='dugme' id='dodaj-tag'>Dodaj tag</div><span></span>
                </div>
            <?php } // if ulogovan ?>

        </div>
        <div class="clear"></div>

        <iframe id='datoteka-frejm' src='<?php echo $dokument->url; ?>' frameborder='0'></iframe>        
    </div>

<input type="hidden" id="izvor_id" value="<?php echo $id; ?>">
<input type="hidden" id="vrsta" value="2">
<script src="<?php echo BASE_URL; ?>js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
