<?php

$naslov = "Podaci o izvoru";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
include_once(ROOT_PATH . 'ukljuci/klasaIzvor.php');

if($ulogovan == false) echo "<style>.ulogovan {display:none;}</style>\n";

if($_GET){
    $id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);
    $vrsta = filter_input(INPUT_GET, 'vrsta', FILTER_SANITIZE_STRING);
} else {
    $id = 234;
    $vrsta = 3;
}

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

<script>
// neophodno zbog ajax brisanja, treba mu parametar id
var id = <?php echo $id; ?>;
</script>

    <div class="okvir izvor">

        <h1>Podaci o izvoru</h1>

        <div class="podaci_o_izvoru">

            <form method='post'>
                <input type="hidden" id="novi_opis" name="novi_opis">

                <b><?php echo $opis; ?></b> <?php echo "<span id='opis'>" . $ova_datoteka->opis . "&nbsp;</span>";

                    if($ulogovan == true) {
                        echo " <br><button type='submit' onclick='promeniOpis($id, $vrsta);'>Ažuriraj opis</button><span></span>\n";
                    }
                    if($vrsta == 3) {
                        if($ova_datoteka->opis_jpg) {
                            echo "<br><b>Izvorni opis:</b><br><img src='http://www.znaci.net/o_slikama/$ova_datoteka->opis_jpg.jpg'/>";
                        }
                    }
                ?>
            </form>

            <b>Datum:</b><span id="datum-prikaz"><?php echo $ova_datoteka->datum . "."; ?></span>
            <?php
                if($ulogovan == true) {
                    if($vrsta == 3) {
                        echo "<input id='datum' value='$ova_datoteka->datum' class='unos-sirina'> <button type='submit' onclick='izmeniDatum(this, $id, $vrsta)'>Izmeni datum</button><span></span>";
                    } else {
                        echo "<input id='dan' type='number' value='$ova_datoteka->dan' class='mala-sirina'><input id='mesec' type='number' value='$ova_datoteka->mesec' class='mala-sirina'><input id='godina' type='number' value='$ova_datoteka->godina' class='mala-sirina'> <button type='submit' onclick='izmeniDatum(this, $id, $vrsta)'>Izmeni datum</button><span></span>\n";
                    }
                }
            ?>
            <small>(napomena: neki datumi su okvirni)</small>
            <br>
            <b>Oblast:</b> <?php echo $ova_datoteka->oblast_prevedeno; ?>
            <?php
                if($ulogovan == true) {
                    echo "<select name='nova_oblast' id='nova_oblast' value='$ova_datoteka->lokacija'>";
                        include "ukljuci/postojece-oblasti.php";
                    echo "</select>";
                    echo "<button type='submit' onclick='promeniOblast(this, $id, $vrsta)'>Izmeni oblast</button><span></span>";
                }
            ?><br>
            <b>Vrsta podatka:</b> <?php echo $ova_datoteka->vrsta; ?><br>
            <?php if($vrsta == 2){ ?>
                <b>Dokument izdali:</b> <?php echo $ova_datoteka->pripadnost; ?><br>
            <?php } ?>
            <b>Izvor:</b><i> <?php echo $ova_datoteka->izvor; ?></i><br
            <b>URL:</b> <a href="<?php echo $ova_datoteka->url; ?>"><?php echo $ova_datoteka->url; ?></a><br>
            <b>Oznake:</b>

            <?php
            for($i=0; $i<count($ova_datoteka->tagovi); $i++) {
                $broj_taga = $ova_datoteka->tagovi[$i];
                $rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$broj_taga ");
                $naziv_taga = $rezultat_za_naziv->fetch_assoc()["naziv"];

                echo "<a href='pojam.php?br=$broj_taga'>$naziv_taga </a> &#9733; <button class='ulogovan' value='$broj_taga' onclick='pozadinskiBrisi(this, $vrsta, this.value, $id); '>-</button><span></span> &nbsp";
                // prazan span na kraju za povratnu poruku
            }
            ?><br>

            <?php
            // dodavanje taga
            if ($ulogovan == true) {
                echo "
                Nova oznaka:
                    <div class='sugestije-okvir'>
                        <input class='unos-sirina2' id='tag' onkeyup='pokaziSugestije(this.value, this.nextElementSibling)' autocomplete='off' value=''>
                        <div id='polje_za_sugestije'></div>
                    </div>
                br. oznake:
                    <input class='unos-sirina' type='number' name='br' id='br_oznake' value=''>
                    <div class='tag-dugme' onclick='pozadinskiTaguj(this, $vrsta, this.previousElementSibling.value, $id); isprazniPolje();'>
                Dodaj tag</div><span></span>";
            }
            ?>

        </div>
        <div class="clear"></div>

        <?php
            if($vrsta == 2){    // prikazuje platno i dugmiće ?>
            <a href="<?php echo $ova_datoteka->relativ_url; ?>" target="_blank">
                <img class="pdf-ikonica" src="slike/ikonice/pdf-icon.png" alt="pdf-knjiga"/>
            </a>
            <div>
                <button id="prev" onclick="idiNazad()">Prethodna</button>
                <button id="next" onclick="idiNapred()">Naredna</button>&nbsp;
                <span>Strana: <span id="trenutna_strana"></span> / <span id="ukupno_strana"></span></span>
            </div>

            <div class="okvir-platna">
                <canvas id='platno' class='crna-ivica'></canvas>
            </div>

            <br><sup>Napomena: Brojevi strana u štampanom i elektronskom izdanju se često ne poklapaju!</sup>

        <?php
            } else if($vrsta == 3) {
                echo "<img src='$ova_datoteka->relativ_url'>";
            } else {
                echo "<iframe id='datoteka-frejm' src='$ova_datoteka->relativ_url' frameborder='0'></iframe>";
            }
        ?>

    </div>

<script defer src='js/libs/pdf.js'></script>
<script defer src="js/izvor.js"></script>

<?php if($vrsta == 2) { // samo za dokumente ide pdf.js ?>
<script>

var fajl_url = '<?php echo $ova_datoteka->relativ_url; ?>';
var brojStrane = <?php echo $ova_datoteka->broj_strane; ?>;

// disable workers to avoid cross-origin issue
PDFJS.disableWorker = true;
var ovajDokument = null;

function renderujStranu(broj) {
    // koristi promise da fetchuje stranu
    ovajDokument.getPage(broj).then(function(strana) {
        // proporcionalno prilagodjava raspoloživoj širini
        var roditeljskaSirina = platno.parentElement.offsetWidth;
        var viewport = strana.getViewport( roditeljskaSirina / strana.getViewport(1.0).width );
        platno.height = viewport.height;
        platno.width = viewport.width;
        // renderuje PDF stranu u sadrzaj platna
        var renderContext = {
            canvasContext: sadrzaj,
            viewport: viewport
        };
        strana.render(renderContext);
    });
    document.getElementById('trenutna_strana').textContent = brojStrane;
    document.getElementById('ukupno_strana').textContent = ovajDokument.numPages;
}

function idiNazad() {
    if (brojStrane <= 1) return;
    brojStrane--;
    renderujStranu(brojStrane);
}

function idiNapred() {
    if (brojStrane >= ovajDokument.numPages) return;
    brojStrane++;
    renderujStranu(brojStrane);
}

// asinhrono downloaduje PDF kao ArrayBuffer
PDFJS.getDocument(fajl_url).then(function getPdfHelloWorld(_pdfDoc) {
    ovajDokument = _pdfDoc;
    if(brojStrane > ovajDokument.numPages) brojStrane = ovajDokument.numPages;
    renderujStranu(brojStrane);
});
</script>
<?php } // kraj pdfa ?>


<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
