<?php

require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

// ponuditi sugestije za naziv knjige

// proverava jesu sva obavezna polja
// proverava jel duplikat
// ako je uspešno unet, daje link do njega
// nakon unosa dodati pojmove

$zapis = $_POST['zapis'];
$knjiga = $_POST['knjiga'];
$strana = $_POST['strana'];
$strana_pdf = $_POST['strana_pdf'];
$url = $_POST['url'];
$datum = $_POST['datum'] ? $_POST['datum'] : "0000-00-00";
$oblast = $_POST['oblast'] ? $_POST['oblast'] : 0;
$sve_popunjeno = true;

?>

<div class="sredina hronoloski-zapis">

    <h2>Unesi hronološki zapis</h2>

    <div class="upozorenje">
    <?php
        if( !$datum || $datum == "0000-00-00" ) {
            $sve_popunjeno = false;
            echo "Neophodno je uneti datum, bar okvirnu godinu.";
        }


        if( !$zapis ) {
            $sve_popunjeno = false;
            echo "Zapis nije unet";
        }

        if( !$knjiga ) {
            $sve_popunjeno = false;
            echo "Izvornik nije naveden";
        }

        if( !($strana || $strana_pdf) ) {
            $sve_popunjeno = false;
            echo "Moraš uneti stranu knjige, štampane ili elektronske.";
        }
        ?>
    </div>
    <br/>

    <form action="<?php $_SERVER[PHP_SELF]; ?>" method="post">

        <label for="datum">Datum: </label><input name="datum" value="<?php echo $datum; ?>"/><br/>

        <label for="zapis">Hronološki zapis: </label><textarea name="zapis" id="zapis" cols="30" rows="10" value="<?php echo $zapis; ?>"></textarea><br/>

        <label for="knjiga">Naslov knjige: </label><input type="text" name="knjiga" value="<?php echo $knjiga; ?>" /><br/>

        <label for="strana">Strana knjige: </label><input name="strana" type="number" value="<?php echo $strana; ?>" /><br/>
        <label for="strana_pdf">Strana pdf-a: </label><input name="strana_pdf" type="number" value="<?php echo $strana_pdf; ?>" /><br/>

        <label for="url">URL: </label><input name="url" type="url" value="<?php echo $url; ?>" /><br/>

        <label for="oblast">Oblast: </label>
            <select name="oblast" id="oblast">
                <?php include "ukljuci/postojece-oblasti.php"; ?>
            </select><br/>
        <script>oblast.value="<?php echo $oblast; ?>";</script>
        <br/>

        <label></label><button type="submit" class="prikazi">Unesi podatke</button>

    </form>

</div>

<?php
    include_once(ROOT_PATH . 'ukljuci/podnozje.php');
?>