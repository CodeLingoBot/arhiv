<?php

require_once __DIR__ . "/../ukljuci/povezivanje2.php";
require_once "Izvor.php";

class Fotografija extends Izvor {
    public $opis_jpg;

    function __construct($id) {
        global $mysqli;
        parent::__construct($id, 3);
        $upit = "SELECT * FROM fotografije WHERE inv = $id ";
        $rezultat = $mysqli->query($upit);
        $red = $rezultat->fetch_assoc();

        $oblast = $red["oblast"];
        $upit_za_oblast = "SELECT naziv FROM mesta WHERE id='$oblast'; ";
        $rezultat_za_oblast = $mysqli->query($upit_za_oblast);
        $red_za_oblast = $rezultat_za_oblast->fetch_assoc();
        $oblast_prevedeno = $red_za_oblast['naziv'];

        $this->datum = $red["datum"];
        $this->opis = $red["opis"] ?: "Nije unet. ";
        $this->opis_jpg = $red["opis_jpg"];
        $this->lokacija = $oblast;
        $this->oblast_prevedeno = $oblast_prevedeno ?: "nepoznata";
        $this->izvor = "Muzej revolucije naroda Jugoslavije";
        $this->url = "http://www.znaci.net/images/".$this->id.".jpg";
        $this->relativ_url = "/images/".$this->id.".jpg";

        $upit_za_tagove = "SELECT * FROM hr_int WHERE vrsta_materijala = 3 AND zapis = $id; ";
        if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
            while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
                $broj_taga = $red_za_tagove["broj"];
                $this->tagovi[] = $broj_taga;
            }
        }
    } // construct
}
