<?php
// napraviti tematske kolekcije po tagovima, oblastima i po godinama
// uneti vreme i mesto fotografijama na osnovu tagova?
  // pronaci sve tagove za datu fotografiju
  // ako medju tagovima ima bitku na neretvi, uneti mesto i vreme

session_start();
$naslov = "Fotogalerija";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

$upit_za_fotke = "SELECT * FROM `fotografije` ORDER BY `inv` ASC";

// ako potvrdimo praznu frazu, briše
if($_GET['potvrdi'] && empty($_GET['fraza']) ) {
    $fraza = "";
}
// ili ako posaljemo frazu, pamti je u varijablu
else if( $_GET['fraza'] ) {
    $fraza = filter_input(INPUT_GET,'fraza',FILTER_SANITIZE_STRING);
}
// ili ako je fraza izabrana i listamo stranice, fraza ostaje
else if($_GET['fraza']) {
    $fraza = htmlspecialchars($_GET['fraza']);
}
// ili ako nismo ništa poslali ni potvrdili (tek ulazimo), briše da bude čisto
else if(!$_GET['potvrdi'] && !$_GET['fraza']) {
    $fraza = "";
}

if($fraza){
    $upit_za_fotke = "SELECT * FROM `fotografije` WHERE opis LIKE '%$fraza%' ";
}

$rezultat_za_fotke = mysqli_query($konekcija, $upit_za_fotke);
$ukupno_fotografija = mysqli_num_rows($rezultat_za_fotke);

if($_GET['slika_po_strani']) {
    $slika_po_strani = filter_input(INPUT_GET,'slika_po_strani',FILTER_SANITIZE_STRING);
};
$slika_po_strani = $slika_po_strani ?: 50;

$ukupno_stranica = $ukupno_fotografija / $slika_po_strani;
$ukupno_stranica = ceil($ukupno_stranica);             // zaokruzuje broj navise

$trenutna_strana = filter_input(INPUT_GET,'stranica',FILTER_SANITIZE_STRING) ?: 1;
if ($trenutna_strana > $ukupno_stranica) {
    $trenutna_strana = 1;
}

?>

    <div id="pokrov" onclick="nestajeProzorce()"></div>

    <div class="okvir">

        Ukupno fotografija: <?php echo $ukupno_fotografija; ?>

        <form id="formular" action="<?php $_SERVER[PHP_SELF]; ?>" method="get">

            <label for="slika_po_strani">Fotografija po stranici: </label><input type="number" name="slika_po_strani" id="slika_po_strani">

            <label for="fraza">Fraza za pretragu: </label><input type="text" name="fraza" id="fraza">

            <button type="submit" id="potvrdi" name="potvrdi" class="izaberi" value="ok">Prikaži</button>
            <br>

            <?php

                for($i = 1; $i <= $ukupno_stranica; $i++) {

                    echo "<input type='submit'";
                    if($i == $trenutna_strana) {echo "id='trenutna_stranica'";}  // dodaje id
                    echo "name='stranica' value='$i'>\n";

                }
            ?>

            <script>
            document.getElementById('slika_po_strani').value = "<?php echo $slika_po_strani; ?>";
            document.getElementById('fraza').value = "<?php echo $fraza; ?>";
            </script>

        </form>

        <?php

        $prikazuje_od = $slika_po_strani * ($trenutna_strana-1) + 1;
        $prikazuje_do = $slika_po_strani * $trenutna_strana;
        if ($prikazuje_do > $ukupno_fotografija) {
            $prikazuje_do = $ukupno_fotografija;
        }

        echo "<p>Prikazujem fotografije od $prikazuje_od do $prikazuje_do: </p>\n";

        for($j = 1; $j <= $ukupno_fotografija; $j++) {
            // izlistava sve iz baze
            $red_za_fotke = mysqli_fetch_assoc($rezultat_za_fotke);
            $inv = $red_za_fotke['inv'];
            $opis = $red_za_fotke['opis_jpg'];
            $tekstualni_opis = $red_za_fotke['opis'];

            // prikazuje samo koje treba
            if($j >= $prikazuje_od && $j <= $prikazuje_do) {
                echo "<div class='okvir-slike siva-ivica'><img class='galerija-slike' src='http://znaci.net/damjan/slike/smanjene/$inv-200px.jpg'><br>";

                if($opis) {
                    echo "<img class='opis-slike' src='http://znaci.net/o_slikama/$opis.jpg' id='opis-$inv'>";
                } else if($tekstualni_opis) {
                    echo "<div class='tekst-opis' id='tekst-opis-$inv'>" . $tekstualni_opis . "</div>";
                } else {
                    echo "<img class='opis-slike' src='slike/bez-opisa.jpg' id='opis-$inv'>";
                }
                echo "</div>\n";
            } // if
        } // for

        ?>

        <br>

        <?php

            $prethodna = $trenutna_strana - 1;
            $naredna = $trenutna_strana + 1;

        ?>

        <form action="<?php $_SERVER[PHP_SELF]; ?>" method="get">

            <input type="number" name="slika_po_strani" id="slika_po_strani2" value="<?php echo $slika_po_strani; ?>">
            <input type="text" name="fraza" id="fraza2" value="<?php echo $fraza; ?>">

            <span id="leva-strelica">&#8592;</span>
            <input id="leva-strelica" type='submit' name='stranica' value='<?php echo $prethodna; ?>'>

            <span id="desna-strelica">&#8594;</span>
            <input id="desna-strelica" type='submit' name='stranica' value='<?php echo $naredna; ?>'>

        </form>

        <img id="prozorce" onclick="nestajeProzorce()">

        <div id="prozor-za-tekst-opis" onclick="nestajeOpis()">
            <img class='opis-slike' id="slika-opis">
        </div>

    </div>

<script src="js/fotogalerija.js"></script>


<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
