<?php

require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'model/Fotografija.php');
include_once(ROOT_PATH . 'model/Izvor.php');

if (empty($_GET['br'])) die();
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);

if($_POST['novi_opis']) {
    $novi_opis = $mysqli->real_escape_string($_POST['novi_opis']);
    $update_opis = "UPDATE fotografije SET opis='$novi_opis' WHERE inv=$id ;";
    $mysqli->query($update_opis);
}

$fotografija = new Fotografija($id);
$naslov = $fotografija->getNaslov();
$page_url = REMOTE_ROOT . "fotografija/" . $fotografija->id;

include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

    <article class="okvir izvor">
        <h1><?php echo $fotografija->getNaslov(); ?></h1>

        <div class="simplesharebuttons">
            <a href="https://www.facebook.com/sharer.php?u=<?php echo $page_url; ?>" target="_blank"><img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" /></a>

            <a href="https://twitter.com/share?url=<?php echo $page_url; ?>&amp;text=<?php echo $fotografija->opis; ?>" target="_blank"><img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" /></a>

            <a href="https://plus.google.com/share?url=<?php echo $page_url; ?>" target="_blank"><img src="https://simplesharebuttons.com/images/somacro/google.png" alt="Google" /></a>

            <a href="http://vkontakte.ru/share.php?url=<?php echo $page_url; ?>" target="_blank"><img src="https://simplesharebuttons.com/images/somacro/vk.png" alt="VK" /></a>
        </div>

        <img src="<?php echo $fotografija->url; ?>" class='max-100'>

        <div class="podaci_o_izvoru">
            <?php $fotografija->render_opis($ulogovan); ?>

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

            <?php Izvor::rendaj_oznake($fotografija->tagovi, $ulogovan); ?><br>
        </div>
    </article>

<input type="hidden" id="izvor_id" value="<?php echo $id; ?>">
<input type="hidden" id="vrsta" value="3">
<script src="<?php echo BASE_URL; ?>js/izvor.js"></script>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
