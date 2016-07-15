<?php

    require_once("ukljuci/config.php");

    if ($_POST['nadimak'] == NADIMAK && $_POST['lozinka'] == LOZINKA) {
        ini_set('session.gc_maxlifetime', 604800);
        setcookie("nadimak", $_POST['nadimak'], time() + 604800);  // 7 dana
        // session_set_cookie_params(604800);
        session_start();
        $_SESSION['nadimak'] = $_POST['nadimak'];
    }

    include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

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
            <li><a href="admin/provera.php">Pretraži i ažuriraj dokumente</a></li>
            <li><a href="admin/taguje-sve.php">Masovno taguj</a></li>
            <li><a href="admin/unesi-zapis.php">Unesi zapis</a></li>
            <li><a href="admin/upit.php">Izvrši upit</a></li>
            <li><a href="admin/upit-izlistava.php">Izlistaj upit</a></li>
        </ul>

        <p>Takođe se možeš i <a href='odjava.php'>odjaviti</a>.</p>

    <?php
        }    // kraj else
    ?>

    </div>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
