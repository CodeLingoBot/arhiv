<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";

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

    public function __construct($id, $vrsta_materijala) {
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

    public function getNaslov() {
        return truncate($this->opis);
    }
}
