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

            <p>Prijavi se da bi pristupio administraciji. </p>

            <form action="<?php $_SERVER[PHP_SELF]; ?>" method="post" id="formular">

                Korisničko ime:<br>
                <input class="ista-širina" name="nadimak"><br>
                Lozinka:<br>
                <input class="ista-širina" type="password" name="lozinka"><br>

                <input class="pretrazi" type="submit" name="prijava" value="Ulaz">

            </form>

    <?php

        } else {    // ako jeste prijavljen
          header("Location:admin/index.php");
          die();
        }
    ?>

    </div>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
