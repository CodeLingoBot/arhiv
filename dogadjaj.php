<?php

require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'model/Dogadjaj.php');
$naslov = "Podaci o događaju";
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

if (empty($_GET['br'])) die();
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);

if($_POST['novi_opis']) {
    $novi_opis = $mysqli->real_escape_string($_POST['novi_opis']);
    $update_opis = "UPDATE hr1 SET tekst='$novi_opis' WHERE id=$id ;";
    $mysqli->query($update_opis);
}

$dogadjaj = new Dogadjaj($id);
?>

    <div class="okvir izvor">
        <h1><?php echo $dogadjaj->getNaslov(); ?></h1>

        <div class="podaci_o_izvoru">
            <form method='post'>
                <input type="hidden" id="novi_opis" name="novi_opis">
                <b>Hronološki zapis:  </b><span id='opis' <?php if($ulogovan) echo "contenteditable='true'"; ?>><?php echo $dogadjaj->opis; ?></span>
                <?php
                if($ulogovan) { ?>
                    <button type='submit' id="azuriraj_opis">Ažuriraj</button><span></span>
                <?php } ?>
            </form>
            <?php
              $datum_prikaz = $dogadjaj->datum;
              if ($datum_prikaz == "0000-00-00.") $datum_prikaz = " nepoznat";
            ?>
            <b>Datum: </b><span><?php echo $datum_prikaz . "."; ?></span>
            <?php if($ulogovan) { ?>
                <input id='dan' type='number' value='<?php echo $dogadjaj->dan; ?>' class='unos-sirina'>
                <input id='mesec' type='number' value='<?php echo $dogadjaj->mesec; ?>' class='unos-sirina'>
                <input id='godina' type='number' value='<?php echo $dogadjaj->godina; ?>' class='unos-sirina'>
                <button type='submit' id='izmeni-datum-zasebno'>Izmeni datum</button><span></span>
            <?php } ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $dogadjaj->oblast_prevedeno; ?>
            <?php
                if($ulogovan) { ?>
                    <select name='nova_oblast' id='nova_oblast' value='<?php echo $dogadjaj->lokacija; ?>'>
                        <?php include "ukljuci/postojece-oblasti.php"; ?>
                    </select>
                    <button type='submit' id='promeni-oblast'>Izmeni oblast</button><span></span>
                <?php }
            ?><br>
            <b>Izvor:</b><i> <?php echo $dogadjaj->izvor; ?></i><br>
            <b>URL:</b> <a href="<?php echo $dogadjaj->url; ?>"><?php echo $dogadjaj->url; ?></a><br>
            <b>Oznake:</b>

            <?php
            for($i=0; $i < count($dogadjaj->tagovi); $i++) {
                $broj_taga = $dogadjaj->tagovi[$i];
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
            <?php } ?>

        </div>
        <div class="clear"></div>

        <iframe id='datoteka-frejm' src='<?php echo $dogadjaj->url; ?>' frameborder='0'></iframe>
    </div>

<script src="js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
