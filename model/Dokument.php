<?php

require_once __DIR__ . "/../ukljuci/povezivanje2.php";
require_once "Izvor.php";

class Dokument extends Izvor {

  function __construct($id) {
      global $mysqli;
      parent::__construct($id, 2);

          $upit = "SELECT * FROM dokumenti WHERE id = $id ";
          $rezultat = $mysqli->query($upit);
          $red = $rezultat->fetch_assoc();

          // trazi zbornik
          $src = $red['src'];
          $broj_strane = $red['p'];
          $strana_pdf = $red['strana_pdf'] ?: $red['p'];
          $broj_knjige = $src % 100;
          $broj_toma = $src / 100;
          $broj_toma = $broj_toma % 100;
          $link_do_strane = $broj_toma . "_" . $broj_knjige . ".pdf#page=" . $strana_pdf;
          $link_do_knjige = $broj_toma . "_" . $broj_knjige . ".pdf";

          // naziv zbornika
          $upit_za_naziv = "SELECT * FROM knjige WHERE broj_knjige = $src ";
          $rezultat_za_naziv = $mysqli->query($upit_za_naziv);
          $naziv_knjige = $rezultat_za_naziv->fetch_assoc()['naziv_knjige'];

          // vreme
          $dan_izv = $red['dan_izv'];
          $mesec_izv = $red['mesec_izv'];
          $god_izv = $red['god_izv'];
          $this->dan = $dan_izv;
          $this->mesec = $mesec_izv;
          $this->godina = $god_izv;
          $this->datum = $dan_izv . "." . $mesec_izv . ". " . $god_izv;

          // prevodi oblast
          $oblast = $red["oblast"];
          $upit_za_oblast = "SELECT naziv FROM mesta WHERE id='$oblast'; ";
          $rezultat_za_oblast = $mysqli->query($upit_za_oblast);
          $red_za_oblast = $rezultat_za_oblast->fetch_assoc();
          $oblast_prevedeno = $red_za_oblast['naziv'];

          // prevodi pripadnost
          $pripadnost = $red["pripadnost"];
          $upit_za_pripadnost = "SELECT strana FROM pripadnosti WHERE id='$pripadnost'; ";
          $rezultat_za_pripadnost = $mysqli->query($upit_za_pripadnost);
          $red_za_pripadnost = $rezultat_za_pripadnost->fetch_assoc();
          $pripadnost_prevedeno = $red_za_pripadnost['strana'];

          // dodaje sve ostalo
          $this->lokacija = $red['oblast'];
          $this->oblast_prevedeno = $oblast_prevedeno ?: "nepoznata";
          $this->opis = $red["opis"];
          $this->vrsta = "dokument";
          $this->izvor = "Zbornik dokumenata i podataka o narodnooslobodilačkom ratu, <i>$naziv_knjige</i>, tom $broj_toma (strana $broj_strane.)";
          $this->url = "http://znaci.net/zb/4_" . $link_do_strane;
          $this->relativ_url = "/zb/4_" . $link_do_strane;
          $this->relativ_url_do_knjige = "/zb/4_" . $link_do_knjige;
          $this->broj_strane = $strana_pdf;
          $this->pripadnost = $pripadnost_prevedeno ?: "nepoznato";

          $upit_za_tagove = "SELECT * FROM hr_int WHERE vrsta_materijala = 2 AND zapis = $id; ";
          if ($rezultat_za_tagove = $mysqli->query($upit_za_tagove)) {
              while ($red_za_tagove = $rezultat_za_tagove->fetch_assoc()) {
                  $broj_taga = $red_za_tagove["broj"];
                  $this->tagovi[] = $broj_taga;
              }
          }

          $rezultat->close();
          $rezultat_za_tagove->close();
          $rezultat_za_naziv->close();
          $rezultat_za_oblast->close();
          $rezultat_za_pripadnost->close();
  } // construct
}