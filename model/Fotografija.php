<?php

require_once __DIR__ . "/../ukljuci/povezivanje.php";
require_once "Izvor.php";

class Fotografija extends Izvor
{
    public $opis_jpg;

    function __construct($id)
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

    function render_opis($ulogovan) {
        parent::render_opis($ulogovan);
        if ($this->opis_jpg) {
            echo "<div><b>Izvorni opis:</b><br>
            <img src='http://www.znaci.net/o_slikama/$this->opis_jpg.jpg' class='max-100' /></div>";
        }
    }

    static function rendaj_prazno() {
        echo "Nema pronađenih fotografija za ovaj pojam. ";
    }

    static function rendaj($id) {
        $izvor_slike = "http://znaci.net/arhiv/slike/smanjene/$id-200px.jpg";
        $url = BASE_URL . "fotografija/$id";
        echo "<a href='$url'><img class='slike' src='$izvor_slike'></a>";
    }
}
