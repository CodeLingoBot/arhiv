<?php

require_once("../ukljuci/klasaPojam.php");
require_once("../ukljuci/povezivanje2.php");

$broj_pojma = $_POST['br'];
$god = $_POST['god'];
$oblast = $_POST['oblast'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unosi podatke fotkama</title>
    <style>
        img {
            width: 150px;
        }
    </style>
</head>
<body>

    <form method="post" action="<?php $_SERVER[PHP_SELF]; ?>">
        Broj pojma: <input type="number" name="br" value="<?php echo $broj_pojma; ?>" />
        Godina: <input type="text" name="god" value="<?php echo $god; ?>" />
        Obast: <input type="number" name="oblast" value="<?php echo $oblast; ?>" />
        <input type="submit" name="izlistaj" value="Izlistaj"><br>
        <input type="submit" name="upisi_datum" value="Upiši datum">
        <input type="submit" name="upisi_oblast" value="Upiši oblast">
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $upit_za_fotke = "SELECT zapis FROM hr_int WHERE broj = $broj_pojma AND vrsta_materijala = 3";
        $result = $mysqli->query($upit_za_fotke);

        while ($row = $result->fetch_assoc()) {
            $inv = $row["zapis"];
            echo "<a target='_blank' href='../izvor.php?br=$inv&vrsta=3'><img src='../../images/$inv.jpg'></a>";
            $unos_za_mesto = "UPDATE fotografije SET oblast=1 WHERE inv = $inv;";
            $unos_za_vreme = "UPDATE fotografije SET datum='$god' WHERE inv = $inv;";

            // proverava jel ima upisano vreme i mesto
            $upit_za_ovu_fotku = "SELECT * FROM fotografije WHERE inv = $inv";
            $rezultat_za_ovu = $mysqli->query($upit_za_ovu_fotku);
            $ovaj_red = $rezultat_za_ovu->fetch_assoc();
            $ovaj_datum = $ovaj_red["datum"];
            $ova_oblast = $ovaj_red["oblast"];
            echo $ovaj_datum;

            if($_POST['upisi_datum']) {
                if($ovaj_datum == "0000-00-00") {
                    $mysqli->query($unos_za_vreme);
                }
            }

            if($_POST['upisi_oblast']) {
                if($ova_oblast == "0") {
                    $mysqli->query($unos_za_mesto);
                }
            }

        } // kraj while
        $result->free();
    } // if post


    ?>

</body>
</html>
