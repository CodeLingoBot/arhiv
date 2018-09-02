<?php
require_once("../ukljuci/povezivanje.php");

$naziv_taga = $_POST['naziv_taga'];
$vrsta_taga = $_POST['vrsta_taga'];
$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $naziv_taga)));

$upit = "INSERT INTO entia (naziv, slug, vrsta) VALUES ('$naziv_taga', '$slug', $vrsta_taga);";
$rezultat = $mysqli->query("SELECT id FROM entia WHERE naziv='$naziv_taga' ");

if($rezultat->num_rows == 0) {
    $mysqli->query($upit);
    $broj_taga = $mysqli->insert_id;
    echo $broj_taga;
} else {
    $red_provere = $rezultat->fetch_assoc();
    $broj_taga = $red_provere['id'];
    echo $broj_taga;
}

?>