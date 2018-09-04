<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
require_once "Odrednica.php";

function truncate($string,$length=100,$append="&hellip;") {
    $string = trim($string);
    if(strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
    }
    return $string;
}

/*
    Apstraktna klasa
*/
class Izvor {

    public $id,
        $vrsta_materijala,
        $datum,
        $dan,
        $mesec,
        $godina,
        $opis,
        $izvor,
        $url,
        $relativ_url,
        $lokacija,
        $oblast_prevedeno,
        $tagovi;

    function __construct($id, $vrsta_materijala) {
        global $mysqli;
        $this->id = $id;
        $upit_za_tagove = "SELECT * FROM hr_int WHERE vrsta_materijala = $vrsta_materijala AND zapis = $id; ";
        if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
            while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
                $broj_taga = $red_za_tagove["broj"];
                $this->tagovi[] = $broj_taga;
            }
        }
        $rezultat_za_tagove->close();
    }

    function getNaslov() {
        return truncate($this->opis);
    }

    function render_opis($ulogovan) {
        echo "<form method='post' class='flex'><b>Opis:&nbsp;</b>";
        $opis = $this->opis ?: "Nije unet";
        if($ulogovan) {
            echo "
            <textarea name='novi_opis' class='full'>$this->opis</textarea>
            <button type='submit' class='nowrap'>Ažuriraj opis</button><span></span>";
        } else {
            echo "<span id='opis'>$opis</span>";
        }
        echo "</form>";
    }

    static function rendaj_oznake($oznake, $ulogovan) {
        echo "<b>Oznake: </b>";
        if ($oznake) {
            $recnik = Odrednica::prevedi_odrednice($oznake);
            foreach ($recnik as $oznaka_id => $data) {
                Odrednica::rendaj($data[0], $data[1], '');
                if ($ulogovan) echo "<button value='$oznaka_id' class='js-brisi-tag'>-</button><span></span> &nbsp";
            }
        }
        if ($ulogovan) {
            echo "
            <div class='sugestije-okvir'>
            Nova oznaka: <input class='js-sugestija unos-sirina2' autocomplete='off'>
                <span id='sugestije_oznaka'></span>
                <input type='hidden'>
                <span class='dugme js-dodaj-tag'>Dodaj tag</span><span></span>
            </div>";
        }
    }
}
