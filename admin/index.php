<?php

    require_once("../ukljuci/config.php");
    include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

?>

    <div class="okvir">

        <h1 id="naslov-pretraga">Administracija</h1>

        <?php
        if (!$ulogovan) {
            echo "<p>Morate biti <a href='prijava.php' class='underline'>prijavljeni</a> da biste pristupili administriranju.</p>";
            die();
        }
        ?>

        <p>Prijavljen si i imaš pristup sledećim opcijama: </p>

        <ul>
            <li><a href="admin/provera.php">Pretraži i ažuriraj dokumente</a></li>
            <li><a href="admin/taguje-sve.php">Masovno taguj</a></li>
            <li><a href="admin/unesi-zapis.php">Unesi zapis</a></li>
            <li><a href="admin/upit.php">Izvrši upit</a></li>
            <li><a href="admin/upit-izlistava.php">Izlistaj upit</a></li>
        </ul>

        <p>Takođe se možeš i <a href="<?php echo ROOT_PATH;?>odjava.php">odjaviti</a>.</p>

    </div>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
