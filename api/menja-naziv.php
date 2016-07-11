<?php

require_once("../ukljuci/povezivanje2.php");

$broj_oznake = $_POST['broj_oznake'];
$novi_naziv = $_POST['novi_naziv'];

$novi_naziv = $mysqli->real_escape_string($novi_naziv);
$mysqli->query("UPDATE entia SET naziv='$novi_naziv' WHERE id=$broj_oznake ;");	

echo "<i>Promenjeno! </i>";

?>

