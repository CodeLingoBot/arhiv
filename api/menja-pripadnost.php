<?php

require_once("../ukljuci/povezivanje2.php");

$broj_oznake = $_POST['broj_oznake'];
$nova_pripadnost = $_POST['nova_pripadnost'];

$nova_pripadnost = $mysqli->real_escape_string($nova_pripadnost);
$mysqli->query("UPDATE dokumenti SET pripadnost='$nova_pripadnost' WHERE id=$broj_oznake ;");

echo "<i>Promenjeno! </i>";

?>
