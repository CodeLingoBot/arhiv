<?php
require_once("../ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

    <div class="okvir">

        <h1 id="naslov-pretraga">Administracija</h1>

<?php
if (!$ulogovan) {
  echo "<p>Morate biti <a href='../prijava.php'>prijavljeni</a> da biste pristupili administriranju.</p>";
  die();
}
?>

        <p>Prijavljen si i imaš pristup sledećim opcijama: </p>

        <ul>
            <li><a href="provera.php">Pretraži i ažuriraj dokumente</a></li>
            <li><a href="taguje-sve.php">Masovno taguj</a></li>
            <li><a href="unesi-zapis.php">Unesi zapis</a></li>
            <li><a href="upit.php">Izvrši upit</a></li>
            <li><a href="upit-izlistava.php">Izlistaj upit</a></li>
        </ul>

        <p>Takođe se možeš i <a href="../odjava.php">odjaviti</a>.</p>

    </div>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
