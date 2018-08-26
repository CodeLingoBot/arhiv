<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
include_once "Izvor.php";

/*
  Na osnovu id-a dobavlja sve povezane materijale
*/
class Odrednica {

    public
        $id,
        $naziv,
        $vrsta,
        $dogadjaji = [],
        $dokumenti = [],
        $fotografije = [];

    public function __construct($id) {
        global $mysqli;

        $rezultat = $mysqli->query("SELECT naziv, vrsta FROM entia WHERE id=$id ");
        $red = $rezultat->fetch_assoc();

        $this->id = $id;
        $this->vrsta = $red["vrsta"];
        $this->naziv = $this->vrsta == 2 ? $red["naziv"] . " u oslobodilačkom ratu" : $red["naziv"];

        $upit_za_hronologiju = "SELECT hr_int.zapis, hr1.dd, hr1.mm, hr1.yy
        FROM hr1 INNER JOIN hr_int
        ON hr1.id = hr_int.zapis
        WHERE hr_int.broj = $id AND hr_int.vrsta_materijala = 1
        ORDER BY hr1.yy,hr1.mm,hr1.dd; ";

        $upit_za_dokumente = "SELECT hr_int.zapis, dokumenti.dan_izv, dokumenti.mesec_izv, dokumenti.god_izv
        FROM dokumenti INNER JOIN hr_int
        ON dokumenti.id = hr_int.zapis
        WHERE hr_int.broj = $id AND hr_int.vrsta_materijala = 2
        ORDER BY dokumenti.god_izv, dokumenti.mesec_izv, dokumenti.dan_izv; ";

        $upit_za_fotke = "SELECT hr_int.zapis, fotografije.datum
        FROM fotografije INNER JOIN hr_int
        ON fotografije.inv = hr_int.zapis
        WHERE hr_int.broj = $id AND hr_int.vrsta_materijala = 3
        ORDER BY fotografije.datum; ";

        if($rezultat_za_hronologiju = $mysqli->query($upit_za_hronologiju)) {
            while($red_za_hronologiju = $rezultat_za_hronologiju->fetch_assoc()) {
                $this->dogadjaji[] = $red_za_hronologiju["zapis"];
            }
            $rezultat_za_hronologiju->close();
        }

        if($rezultat_za_dokumente = $mysqli->query($upit_za_dokumente)) {
            while($red_za_dokumente = $rezultat_za_dokumente->fetch_assoc()) {
                $this->dokumenti[] = $red_za_dokumente["zapis"];
            }
            $rezultat_za_dokumente->close();
        }

        if($rezultat_za_fotke = $mysqli->query($upit_za_fotke)) {
            while($red_za_fotke = $rezultat_za_fotke->fetch_assoc()) {
                $this->fotografije[] = $red_za_fotke["zapis"];
            }
            $rezultat_za_fotke->close();
        }
    }

    static function prevedi_odrednice($ids) {
        global $mysqli;
        $upit = "SELECT id, naziv FROM entia WHERE id IN ($ids); ";
        $rezultat = $mysqli->query($upit);
        $recnik = array();
        while ($red = $rezultat->fetch_assoc()){
            $recnik[$red['id']] = $red['naziv'];
        }
        $rezultat->close();
        return $recnik;
    }

    static function rendaj($id, $naziv, $ucestalost, $najvise_ponavljanja) {
        if ($ucestalost > 4 && $ucestalost > $najvise_ponavljanja * 0.5) {
            $klasa = 'najveci_tag';
        } else if ($ucestalost > 4 && $ucestalost > $najvise_ponavljanja * 0.25) {
            $klasa = 'veliki_tag';
        } else if ($ucestalost > 3) {
            $klasa = 'srednji_tag';
        } else if ($ucestalost > 2) {
            $klasa = 'manji_srednji_tag';
        } else if ($ucestalost > 1) {
            $klasa = 'mali_tag';
        } else {
            $klasa = 'najmanji_tag';
        }
        echo "<a href='odrednica.php?br=$id' class='$klasa'>$naziv </a><span class='najmanji_tag'> &#9733; </span>";
    }

}
