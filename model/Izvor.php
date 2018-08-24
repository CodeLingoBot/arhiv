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
    Na osnovu id i vrste materijala dobavlja podatke o izvoru
*/
class Izvor {

    public $id,
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

        switch ($vrsta_materijala) {
            case 1:
                break;

            case 2:
                break;

            case 3:
                break;

            default:
                $this->datum = "Nepoznat (unesi datum / ako postoji isprvi datum)";
                $this->opis = "Izvor ne poseduje originalan opis (unesi opis)";
                $this->izvor = "Originalni izvor ove datoteke je nepoznat (unesi izvor)";
                $this->url = "http://www.znaci.net/";
                $this->lokacija = "Lokacija nastanka je nepoznata (unesi lokaciju)";
                $this->tagovi = "Još uvek nema tagova za ovu odrednicu (unesi tag)";
                break;
        }
    }    // kraj konstrukta

    public function getNaslov() {
        return truncate($this->opis);
    }

}
