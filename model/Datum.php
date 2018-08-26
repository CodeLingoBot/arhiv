<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
require_once "Dogadjaj.php";
require_once "Dokument.php";
require_once "Fotografija.php";
require_once "Odrednica.php";

/*
    Prikuplja događaje, dokumente i fotografije sa određeni datum
*/
class Datum
{
    public $ratne_godine,
    $dogadjaji,
    $dokumenti,
    $fotografije, 
    $odrednice;

    // prima opciono dan, mesec i godinu, ili setuje nasumično
    function __construct($dan = null, $mesec = null, $godina = null)
    {
        global $mysqli;
        $this->dan = $dan ? $mysqli->real_escape_string($dan) : date("j");
        $this->mesec = $mesec ? $mysqli->real_escape_string($mesec) : date("m");
        $this->init_ratne_godine(); // mora pre slucajne godine
        $this->godina = $godina ? $mysqli->real_escape_string($godina) : $this->get_slucajna_godina();
        $this->datum = $this->dan . ". " . $this->mesec . ". " . $this->godina;

        $this->upit_dogadjaji();
        $this->upit_dokumenti();
        $this->upit_fotografije();
        $this->upit_odrednice(); // mora posle svih prethodnih
    }

    private function init_ratne_godine() {
        $this->ratne_godine = [1942, 1943, 1944];
        if ($this->mesec >= 4) $this->ratne_godine[] = 1941;
        if ($this->mesec <= 5) $this->ratne_godine[] = 1945;
        sort($this->ratne_godine);
    }

    private function upit_dogadjaji() {
        global $mysqli;
        $upit = "SELECT id, tekst FROM hr1 
        WHERE yy='$this->godina' AND mm='$this->mesec' AND dd='$this->dan' ";
        $rezultat = $mysqli->query($upit);
        $this->dogadjaji = array();
        while ($red = $rezultat->fetch_assoc()) {
            $this->dogadjaji[$red['id']] = $red['tekst'];
        }
        $rezultat->close();
    }

    private function upit_dokumenti() {
        global $mysqli;
        $upit = "SELECT id, opis FROM dokumenti 
        WHERE god_izv='$this->godina' AND mesec_izv='$this->mesec' AND dan_izv='$this->dan' ";
        $rezultat = $mysqli->query($upit);
        $this->dokumenti = array();
        while ($red = $rezultat->fetch_assoc()) {
            $this->dokumenti[$red['id']] = $red['opis'];
        }
        $rezultat->close();
    }

    private function upit_fotografije() {
        global $mysqli;
        $upit = "SELECT inv FROM fotografije 
        WHERE datum >= '$this->godina-$this->mesec-$this->dan' ORDER BY datum LIMIT 20";
        $rezultat = $mysqli->query($upit);
        $this->fotografije = array();
        while ($red = $rezultat->fetch_assoc()){
            $this->fotografije[] = $red['inv'];
        }
        $rezultat->close();
    }

    private function upit_odrednice() {
        global $mysqli;
        $dogadjaji = implode(',', array_keys($this->dogadjaji));
        $dokumenti = implode(',', array_keys($this->dokumenti));
        $fotografije = implode(',', $this->fotografije);
        $upit = "SELECT broj FROM hr_int 
        WHERE vrsta_materijala = 1 AND zapis IN ($dogadjaji) 
        OR vrsta_materijala = 2 AND zapis IN ($dokumenti);";
        $rezultat = $mysqli->query($upit);
        $this->odrednice = array();
        while ($red = $rezultat->fetch_assoc()){
            $this->odrednice[] = (int)$red['broj'];
        }
        $rezultat->close();
    }

    function get_slucajna_godina() {
        return $this->ratne_godine[array_rand($this->ratne_godine)];
    }

    function render_dogadjaji() {
        foreach($this->dogadjaji as $k => $v){
            Dogadjaj::rendaj($k, $this->datum, $v);
        }
    }

    function render_dokumenti() {
        foreach($this->dokumenti as $k => $v){
            Dokument::rendaj($k, $v);
        }
    }

    function render_fotografije() {
        foreach($this->fotografije as $inv){
            Fotografija::rendaj($inv);
        }
    }

    function render_odrednice() {
        if (count($this->odrednice) < 1 ) {
            echo "<p>Nema povezanih odrednica.</p>";
            return;
        }

        $broj_ponavljanja = array_count_values($this->odrednice);
        $ids = implode(',', array_keys($broj_ponavljanja));
        $recnik = Odrednica::prevedi_odrednice($ids);
        $kopija = $broj_ponavljanja;
        $najvise_ponavljanja = array_values(arsort($kopija))[0];
        unset($kopija);

        foreach ($broj_ponavljanja as $id => $ucestalost) {
            Odrednica::rendaj($id, $recnik[$id], $ucestalost, $najvise_ponavljanja);
        }
    }
}
