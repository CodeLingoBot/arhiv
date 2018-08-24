<?php

require_once __DIR__ . "/../ukljuci/povezivanje2.php";

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
        $this->vrsta_materijala = $vrsta_materijala;
    }

    public function getNaslov() {
        return truncate($this->opis);
    }
}
