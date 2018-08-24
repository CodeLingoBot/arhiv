<?php

$naslov = "Podaci o fotografiji";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
include_once(ROOT_PATH . 'model/Fotografija.php');

if (empty($_GET['br'])) die();
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);

if($_POST['novi_opis']) {
    $novi_opis = $mysqli->real_escape_string($_POST['novi_opis']);
    $update_opis = "UPDATE fotografije SET opis='$novi_opis' WHERE inv=$id ;";
    $mysqli->query($update_opis);
}

$slika = new Fotografija($id);

?>

    <div class="okvir izvor">
        <h1><?php echo $slika->getNaslov(); ?></h1>

        <div class="podaci_o_izvoru">
            <form method='post'>
                <input type="hidden" id="novi_opis" name="novi_opis">
                <b>Opis: </b><span id='opis' <?php if($ulogovan) echo "contenteditable='true'"; ?>><?php echo $slika->opis; ?></span>
                <?php
                    if($ulogovan) { ?>
                        <button type='submit' id="azuriraj_opis">Ažuriraj opis</button><span></span>
                    <?php }
                    if($slika->opis_jpg) { ?>
                        <br><b>Izvorni opis:</b><br>
                        <img class="max-100" src='http://www.znaci.net/o_slikama/<?php echo $slika->opis_jpg; ?>.jpg'/>
                <?php } ?>
            </form>
            <?php
              $datum_prikaz = $slika->datum;
              if ($datum_prikaz == "0000-00-00.") $datum_prikaz = " nepoznat";
            ?>
            <b>Datum: </b><span><?php echo $datum_prikaz . "."; ?></span>
            <?php
                if($ulogovan) { ?>
                    <input id='datum' value='<?php echo $slika->datum; ?>' class='unos-sirina'>
                    <button type='submit' id='izmeni-datum-fotografije'>Izmeni datum</button><span></span>
                <?php }
            ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $slika->oblast_prevedeno; ?>
            <?php
                if($ulogovan) { ?>
                    <select name='nova_oblast' id='nova_oblast' value='<?php echo $slika->lokacija; ?>'>
                        <?php include "ukljuci/postojece-oblasti.php"; ?>
                    </select>
                    <button type='submit' id='promeni-oblast'>Izmeni oblast</button><span></span>
                <?php }
            ?><br>
            <b>Izvor:</b><i> <?php echo $slika->izvor; ?></i><br>
            <b>URL:</b> <a href="<?php echo $slika->url; ?>"><?php echo $slika->url; ?></a><br>
            <b>Oznake:</b>

            <?php
            for($i=0; $i < count($slika->tagovi); $i++) {
                $broj_taga = $slika->tagovi[$i];
                $rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$broj_taga ");
                $naziv_taga = $rezultat_za_naziv->fetch_assoc()["naziv"];
                echo " <a href='odrednica.php?br=$broj_taga'>$naziv_taga </a> ★ ";
                if ($ulogovan) echo "<button value='$broj_taga' id='brisi-tag'>-</button><span></span> &nbsp";
            }
            ?><br>

            <?php
            if ($ulogovan) { ?>
                <div class='sugestije-okvir inline-block'>
                Nova oznaka: <input class='unos-sirina2' id='oznaka' autocomplete='off'>
                    <span id='sugestije_oznaka'></span>
                    <input class='unos-sirina' type='number' name='br' id='id_oznake'>
                    <div class='dugme' id='dodaj-tag'>Dodaj tag</div><span></span>
                </div>
            <?php } // if ulogovan ?>

        </div>
        <div class="clear"></div>

        <img src="<?php echo $slika->url; ?>" class='max-100'>

    </div>

<script src="js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
