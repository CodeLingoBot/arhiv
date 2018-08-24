<?php
session_start();
$naslov = "Fotogalerija";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

$upit = "SELECT * FROM `fotografije` ORDER BY `inv` ASC";
$fraza = filter_input(INPUT_GET,'fraza',FILTER_SANITIZE_STRING) ?: "";
$slika_po_strani = filter_input(INPUT_GET,'slika_po_strani',FILTER_SANITIZE_STRING) ?: 50;
$trenutna_strana = filter_input(INPUT_GET,'stranica',FILTER_SANITIZE_STRING) ?: 1;

if($fraza){
    $upit = "SELECT * FROM `fotografije` WHERE opis LIKE '%$fraza%' ";
}

$rezultat = $mysqli->query($upit);
$ukupno_fotografija = $rezultat->num_rows;
$ukupno_stranica = ceil($ukupno_fotografija / $slika_po_strani);
if ($trenutna_strana > $ukupno_stranica) {
    $trenutna_strana = 1;
}
?>

    <div id="pokrov" onclick="nestajeProzorce()"></div>

    <div class="okvir">
        Ukupno fotografija: <?php echo $ukupno_fotografija; ?>

        <form id="formular" action="<?php $_SERVER[PHP_SELF]; ?>" method="get">
            <label for="slika_po_strani">Fotografija po stranici: </label>
            <input type="number" name="slika_po_strani" value="<?php echo $slika_po_strani; ?>">
            <label for="fraza">Fraza za pretragu: </label>
            <input type="text" name="fraza" value="<?php echo $fraza; ?>">

            <button class="izaberi">Prikaži</button>
            <br>

            <?php
                for($i = 1; $i <= $ukupno_stranica; $i++) {
                    echo "<button type='submit'";
                    if ($i == $trenutna_strana) {echo "class='trenutna_stranica'";}
                    echo "name='stranica' value='$i'>$i</button>\n";
                }
            ?>

        <?php
        $prikazuje_od = $slika_po_strani * ($trenutna_strana-1) + 1;
        $prikazuje_do = $slika_po_strani * $trenutna_strana;
        if ($prikazuje_do > $ukupno_fotografija) {
            $prikazuje_do = $ukupno_fotografija;
        }

        echo "<p>Prikazujem fotografije od $prikazuje_od do $prikazuje_do: </p>\n";

        for($j = 1; $j <= $ukupno_fotografija; $j++) {
            $red_za_fotke = $rezultat->fetch_assoc();
            $inv = $red_za_fotke['inv'];
            $opis = $red_za_fotke['opis_jpg'];
            $tekstualni_opis = $red_za_fotke['opis'];

            if($j >= $prikazuje_od && $j <= $prikazuje_do) {
                $izvor_slike = REMOTE_ROOT . "slike/smanjene/$inv-200px.jpg";
                echo "<div class='okvir-slike siva-ivica'><img class='galerija-slike' src=$izvor_slike><br>";

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

            <button id="leva-strelica" name='stranica' value='<?php echo $prethodna; ?>'>&#8592;</button>
            <button id="desna-strelica" name='stranica' value='<?php echo $naredna; ?>'>&#8594;</button>
        </form>

        <img id="prozorce" onclick="nestajeProzorce()">

        <div id="prozor-za-tekst-opis" onclick="nestajeOpis()">
            <img class='opis-slike' id="slika-opis">
        </div>

    </div>

<script src="js/fotogalerija.js"></script>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
