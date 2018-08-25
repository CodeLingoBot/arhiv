<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
require_once "Izvor.php";

class Fotografija extends Izvor
{
    public $opis_jpg;

    public function __construct($id)
    {
        global $mysqli;
        parent::__construct($id, 3);

        $upit = "SELECT fotografije.datum, fotografije.opis, fotografije.opis_jpg, fotografije.oblast, mesta.naziv as oblast_prevedeno
        FROM fotografije
        INNER JOIN mesta ON fotografije.oblast=mesta.id
        WHERE inv=$id";
        $rezultat = $mysqli->query($upit);
        $red = $rezultat->fetch_assoc();

        $this->datum = $red["datum"];
        $this->opis = $red["opis"];
        $this->opis_jpg = $red["opis_jpg"];
        $this->lokacija = $red["oblast"];
        $this->oblast_prevedeno = $red['oblast_prevedeno'];
        $this->izvor = "Muzej revolucije naroda Jugoslavije";
        $this->url = "http://www.znaci.net/images/" . $this->id . ".jpg";
        $this->relativ_url = "/images/" . $this->id . ".jpg";

        $rezultat->close();
    }
}
