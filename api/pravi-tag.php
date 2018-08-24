<?php
require_once("../ukljuci/povezivanje.php");

$naziv_taga = $_POST['naziv_taga'];
$vrsta_taga = $_POST['vrsta_taga'];

$upit = "INSERT INTO entia (naziv, vrsta) VALUES ('$naziv_taga', $vrsta_taga);";
$rezultat_provere = mysqli_query($konekcija, "SELECT id FROM entia WHERE naziv='$naziv_taga' ");

if(mysqli_num_rows($rezultat_provere) == 0) {
    mysqli_query($konekcija, $upit);
    $broj_taga = mysqli_insert_id($konekcija);
    echo $broj_taga;
} else {
    $red_provere = mysqli_fetch_assoc($rezultat_provere);
    $broj_taga = $red_provere['id'];
    echo $broj_taga;
}

?>