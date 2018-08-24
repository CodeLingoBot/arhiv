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
        $vrsta, // obrisati?
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

        switch ($vrsta_materijala) {

            /********* HRONOLOGIJA *******/
            case 1:
                $upit = "SELECT * FROM hr1 WHERE id = $id ";
                $rezultat = $mysqli->query($upit);
                $red = $rezultat->fetch_assoc();

                // traži tagove
                if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
                    while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
                        $broj_taga = $red_za_tagove["broj"];
                        $this->tagovi[] = $broj_taga;
                    }
                }

                // pravi datum
                $dan = $red["dd"];
                $mesec = $red["mm"];
                $godina = $red["yy"];
                $this->dan = $dan;
                $this->mesec = $mesec;
                $this->godina = $godina;
                $alter_dan = $dan ? $dan . ". " : "Tokom ";    // ako je neodređen dodaje reč bez tačke
                $this->datum = $alter_dan . $mesec . ". " . $godina;

                // prevodi oblast
                $oblast = $red["zona"];
                $upit_za_oblast = "SELECT naziv FROM mesta WHERE id='$oblast'; ";
                $rezultat_za_oblast = $mysqli->query($upit_za_oblast);
                $red_za_oblast = $rezultat_za_oblast->fetch_assoc();
                $oblast_prevedeno = $red_za_oblast['naziv'];

                // izvor
                $izvor = $red["izvor"];
                if($izvor == 1) {
                    $this->izvor = "Izveštaji Komande srpske državne straže za okrug Moravski 1941-1944";
                    $this->vrsta = "policijski izveštaj";
                    $this->url = "http://znaci.net/00003/470.htm";
                    $this->relativ_url = "/00003/470.htm";
                } else {
                    $this->izvor = "Hronologija narodnooslobodilačkog rata 1941-1945";
                    $this->vrsta = "hronološki zapis";
                    $this->url = "http://znaci.net/00001/53.htm";
                    $this->relativ_url = "/00001/53.htm";
                }

                // sve ostalo

                $this->opis = $red["tekst"];
                $this->lokacija = $oblast;
                $this->oblast_prevedeno = $oblast_prevedeno ?: "nepoznata";
                $rezultat->close();
                $rezultat_za_tagove->close();
                break;

            /********* ZBORNICI DOKUMENATA *******/
            case 2:
                break;

            /********* FOTOGRAFIJE *******/
            case 3:
                break;

            default:
                $this->vrsta = "nepoznato ";
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

