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
    $_SESSION['fraza'] = "";
    $fraza = "";
}
// ili ako posaljemo frazu, pamti je u sesiju i varijablu
else if( $_GET['fraza'] ) {
    $_SESSION['fraza'] = filter_input(INPUT_GET,'fraza',FILTER_SANITIZE_STRING);
    $fraza = $_SESSION['fraza'];
}
// ili ako je fraza upamcena u sesiji i listamo stranice, fraza ostaje
else if( $_SESSION['fraza'] && $_GET ) {
    $fraza = $_SESSION['fraza'];
}
// ili ako nismo ništa poslali ni potvrdili (tek ulazimo), briše da bude čisto
else if(!$_GET['potvrdi'] && !$_GET['fraza']) {
    $_SESSION['fraza'] = "";
    $fraza = "";
}

if($fraza){
    $upit_za_fotke = "SELECT * FROM `fotografije` WHERE opis LIKE '%$fraza%' ";
}

$rezultat_za_fotke = mysqli_query($konekcija, $upit_za_fotke);
$ukupno_fotografija = mysqli_num_rows($rezultat_za_fotke);

if($_GET['slika_po_strani']) {
    $_SESSION['slika_po_strani'] = filter_input(INPUT_GET,'slika_po_strani',FILTER_SANITIZE_STRING);
};
$slika_po_strani = $_SESSION['slika_po_strani'] ?: 50;

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
                echo "<div class='okvir-slike'><img class='galerija-slike' src='slike/smanjene/$inv-200px.jpg' onclick='iskaceProzorce(this)' onmouseover='//slikaReaguje(this)' onmouseleave='//slikaNormalno(this)'><br>";

                if($opis) {
                    echo "<img class='opis-slike' src='http://znaci.net/o_slikama/$opis.jpg' id='opis-$inv'>";
                } else if($tekstualni_opis) {
                    echo "<div class='tekst-opis' id='tekst-opis-$inv'>" . $tekstualni_opis . "</div>";
                } else {
                    echo "<img class='opis-slike' src='slike/bez-opisa.jpg' id='opis-$inv'>";
                }
                // pravi dugmice za ajax tagove
                if ($ulogovan == true) {
                    echo "<br><input type='number'><span class='tag-dugme' onclick='pozadinskiTaguj(this,3,previousSibling.value,$inv)'>Taguj ovo </span>";
                }
                echo "</div>\n";
            } // if
        }    // for

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
            <img class='slike' id="slika-opis">
        </div>

    </div>

<script>
var pokrov = document.getElementById("pokrov");
var prozorce = document.getElementById("prozorce");
var prozorce_opis = document.getElementById("prozor-za-tekst-opis");
var slika_opisa = document.getElementById("slika-opis");

function slikaReaguje(ovaSlika){
    ovaSlika.style.opacity = "0.8";
}

function slikaNormalno(ovaSlika){
    ovaSlika.style.opacity = "1";
}

function iskaceProzorce(ovaSlika) {
    var izvor_slike = ovaSlika.src;
    var samo_broj = izvor_slike.match(/\d+/)[0];
    var opis = document.getElementById("opis-" + samo_broj);    // hvata opis ako ima
    var izvor_opisa = opis.src;
    slika_opisa.src = izvor_opisa;
    prozorce.src = izvor_slike;

    // iskace prozor sa slikom
    pokrov.style.display = "block";
    prozorce.style.display = "block";
    prozorce.style.left = (window.innerWidth/2 - prozorce.offsetWidth/2) + "px";
    prozorce_opis.style.display="block";

    if (opis){
        slika_opisa.style.display="block";
    } else {
    // dodaje tekstualni_opis
        var tekstualni_opis = document.getElementById("tekst-opis-" + samo_broj);
        prozorce_opis.innerHTML = tekstualni_opis.innerHTML;
        prozorce_opis.style.padding = "10px";
        prozorce_opis.style.display = "block";
    }    // kraj if opis

    prozorce_opis.style.width = (prozorce.offsetWidth - 40) + "px";
    prozorce_opis.style.left = (window.innerWidth/2 - prozorce.offsetWidth/2) + 20 + "px";

    // ako je slika položena, manji opis
    if(ovaSlika.width > ovaSlika.height) {
        prozorce_opis.style.width = (prozorce.offsetWidth - 160) + "px";
        prozorce_opis.style.left = (window.innerWidth/2 - prozorce.offsetWidth/2) + 80 + "px";
    }

}

function nestajeProzorce(){
    prozorce.style.display="none";
    pokrov.style.display="none";
    prozorce_opis.style.display="none";
}

// ne moze zatvoriti samo opis jer su spojeni kao dve pozadinske slike

function nestajeOpis(){
    prozorce_opis.style.display="none";
}

function pozadinskiTaguj(ovo, vrsta_materijala, broj_entia, id){
    var ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function() {
        if (ajax.status == 200 && ajax.readyState == 4) {
            ovo.innerHTML = ajax.responseText;
        }
    }
    ajax.open("GET","api/asinhron-tag.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
    ajax.send();
}

</script>


<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
