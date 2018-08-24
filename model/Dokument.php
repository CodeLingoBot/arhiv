<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
require_once "Izvor.php";

class Dokument extends Izvor
{

    public function __construct($id)
    {
        global $mysqli;
        parent::__construct($id, 2);

        $upit = "SELECT dokumenti.*, mesta.naziv as oblast_prevedeno, knjige.naziv_knjige, knjige.vrsta, pripadnosti.strana
        FROM dokumenti
        INNER JOIN mesta ON dokumenti.oblast=mesta.id
        INNER JOIN knjige ON dokumenti.src=knjige.broj_knjige
        INNER JOIN pripadnosti ON dokumenti.pripadnost=pripadnosti.id
        WHERE dokumenti.id=$id";
        $rezultat = $mysqli->query($upit);
        $red = $rezultat->fetch_assoc();

        $src = $red['src'];
        $broj_strane = $red['p'];
        $strana_pdf = $red['strana_pdf'] ?: $red['p'];
        $broj_knjige = $src % 100;
        $broj_toma = $src / 100;
        $broj_toma = $broj_toma % 100;
        $link_do_strane = $broj_toma . "_" . $broj_knjige . ".pdf#page=" . $strana_pdf;
        $naziv_knjige = $red['naziv_knjige'];

        $this->dan = $red['dan_izv'];
        $this->mesec = $red['mesec_izv'];
        $this->godina = $red['god_izv'];
        $this->datum = $red['dan_izv'] . "." . $red['mesec_izv'] . ". " . $red['god_izv'];
        $this->lokacija = $red['oblast'];
        $this->oblast_prevedeno = $red['oblast_prevedeno'];
        $this->opis = $red["opis"];
        $izvor_zbornik = "Zbornik dokumenata i podataka o narodnooslobodilačkom ratu, <i>$naziv_knjige</i>, tom $broj_toma (strana $broj_strane.)";
        $this->izvor = $red["vrsta"] == 0 ? $izvor_zbornik : "<i>$naziv_knjige</i> (strana $broj_strane.)";
        $this->url = "http://znaci.net/zb/4_" . $link_do_strane;
        $this->relativ_url = "/zb/4_" . $link_do_strane;
        $this->broj_strane = $strana_pdf;
        $this->pripadnost = $red['strana'];

        $upit_za_tagove = "SELECT * FROM hr_int WHERE vrsta_materijala = 2 AND zapis = $id; ";
        if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
            while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
                $broj_taga = $red_za_tagove["broj"];
                $this->tagovi[] = $broj_taga;
            }
        }

        $rezultat->close();
        $rezultat_za_tagove->close();
    }
}
