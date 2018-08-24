<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
require_once "Izvor.php";

class Dogadjaj extends Izvor {

  function __construct($id) {
      global $mysqli;
      parent::__construct($id, 1);
      $upit = "SELECT * FROM hr1 WHERE id = $id ";
      $rezultat = $mysqli->query($upit);
      $red = $rezultat->fetch_assoc();

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

      $upit_za_tagove = "SELECT * FROM hr_int WHERE vrsta_materijala = 1 AND zapis = $id; ";
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
