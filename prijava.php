<?php

    require_once("ukljuci/config.php");
    include_once(ROOT_PATH . 'ukljuci/header.php');

    // proveriti da li pamti kuki i sešn

    if($_SESSION['nadimak'] == 'gost' || $_COOKIES['nadimak'] == 'gost') {
        $ulogovan = true;

    } else if ($_POST['prijava']) {
        $nadimak = $_POST['nadimak'];
        $lozinka = $_POST['lozinka'];

        if ($nadimak == "gost" && $lozinka == "gost") {
            $_SESSION['nadimak'] = $nadimak;
            setcookie("nadimak", $nadimak, time()+2500000);
            $ulogovan = true;

        } else {
            $ulogovan = false;
        }
    }

?>

    <div class="okvir">

        <h1 id="naslov-pretraga">Administracija</h1>

    <?php

        if (!$ulogovan) { ?>

            <p>Moraš biti prijavljen da bi pristupio administraciji. </p>

            <form action="<?php $_SERVER[PHP_SELF]; ?>" method="post" id="formular">

                Korisničko ime:<br>
                <input class="ista-širina" name="nadimak"><br>
                Lozinka:<br>
                <input class="ista-širina" type="password" name="lozinka"><br>

                <input class="pretrazi" type="submit" name="prijava" value="Ulaz">

            </form>

    <?php

        } else {    // ako jeste prijavljen prikazuje sve
    ?>

        <p>Prijavljen si i imaš pristup sledećim opcijama: </p>

        <ul>
            <li><a href="admin/provera.php">Pretraga i provera dokumenata</a></li>
            <li><a href="taguje-sve.php">Masovno taguje</a></li>
            <li><a href="hronoloski-zapis.php">Unosi zapise</a></li>
            <li><a href="alatke/upit.php">Izvršava upite</a></li>
        </ul>

        <p>Takođe se možeš i <a href='odjava.php'>odjaviti</a>.</p>

    <?php
        }    // kraj else
    ?>

    </div>

<?php include_once(ROOT_PATH . "ukljuci/footer.php"); ?>
