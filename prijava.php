<?php
require_once("ukljuci/config.php");

if ($_POST['nadimak'] == NADIMAK && $_POST['lozinka'] == LOZINKA) {
    ini_set('session.gc_maxlifetime', 604800);
    setcookie("nadimak", $_POST['nadimak'], time() + 604800);  // 7 dana
    session_start();
    $_SESSION['nadimak'] = $_POST['nadimak'];
}

include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
if ($ulogovan) {
    header("Location:admin/index.php");
    die();
}
?>

    <div class="okvir">

        <h1 id="naslov-pretraga">Administracija</h1>

            <p>Prijavi se da bi pristupio administraciji. </p>

            <form action="<?php $_SERVER[PHP_SELF]; ?>" method="post" id="formular">

                Korisničko ime:<br>
                <input class="ista-širina" name="nadimak"><br>
                Lozinka:<br>
                <input class="ista-širina" type="password" name="lozinka"><br>

                <input class="pretrazi" type="submit" name="prijava" value="Ulaz">

            </form>

    </div>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
