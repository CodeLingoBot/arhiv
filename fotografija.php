<?php

$naslov = "Podaci o fotografiji";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
include_once(ROOT_PATH . 'model/Fotografija.php');
include_once(ROOT_PATH . 'model/Odrednica.php');

if (empty($_GET['br'])) die();
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);

if($_POST['novi_opis']) {
    $novi_opis = $mysqli->real_escape_string($_POST['novi_opis']);
    $update_opis = "UPDATE fotografije SET opis='$novi_opis' WHERE inv=$id ;";
    $mysqli->query($update_opis);
}

$fotografija = new Fotografija($id);
$opis = $fotografija->opis ?: "Nije unet";

?>

    <div class="okvir izvor">
        <h1><?php echo $fotografija->getNaslov(); ?></h1>

        <div class="podaci_o_izvoru">
            <form method='post'>
                <input type="hidden" id="novi_opis" name="novi_opis">
                <b>Opis: </b><span id='opis' <?php if($ulogovan) echo "contenteditable='true'"; ?>><?php echo $opis; ?></span>
                <?php
                    if($ulogovan) { ?>
                        <button type='submit' id="azuriraj_opis">Ažuriraj opis</button><span></span>
                    <?php }
                    if($fotografija->opis_jpg) { ?>
                        <br><b>Izvorni opis:</b><br>
                        <img class="max-100" src='http://www.znaci.net/o_slikama/<?php echo $fotografija->opis_jpg; ?>.jpg'/>
                <?php } ?>
            </form>
            <?php
              $datum_prikaz = $fotografija->datum;
              if ($datum_prikaz == "0000-00-00.") $datum_prikaz = " nepoznat";
            ?>
            <b>Datum: </b><span><?php echo $datum_prikaz . "."; ?></span>
            <?php
                if($ulogovan) { ?>
                    <input id='datum' value='<?php echo $fotografija->datum; ?>' class='unos-sirina'>
                    <button type='submit' id='izmeni-datum-fotografije'>Izmeni datum</button><span></span>
                <?php }
            ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $fotografija->oblast_prevedeno; ?>
            <?php
                if($ulogovan) { ?>
                    <select name='nova_oblast' id='nova_oblast' value='<?php echo $fotografija->lokacija; ?>'>
                        <?php include "ukljuci/postojece-oblasti.php"; ?>
                    </select>
                    <button type='submit' id='promeni-oblast'>Izmeni oblast</button><span></span>
                <?php }
            ?><br>
            <b>Izvor:</b><i> <?php echo $fotografija->izvor; ?></i><br>
            <b>URL:</b> <a href="<?php echo $fotografija->url; ?>"><?php echo $fotografija->url; ?></a><br>
            <b>Oznake:</b>

            <?php
            if ($fotografija->tagovi) {
                $recnik = Odrednica::prevedi_odrednice($fotografija->tagovi);
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

        <img src="<?php echo $fotografija->url; ?>" class='max-100'>
    </div>

<input type="hidden" id="izvor_id" value="<?php echo $id; ?>">
<input type="hidden" id="vrsta" value="3">
<script src="<?php echo BASE_URL; ?>js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
