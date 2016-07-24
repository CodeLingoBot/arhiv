<?php

require_once("../ukljuci/povezivanje2.php");

$dokument_id = $_POST['broj_oznake'];
$nova_pripadnost = $_POST['nova_pripadnost'];

$nova_pripadnost = $mysqli->real_escape_string($nova_pripadnost);
$mysqli->query("UPDATE dokumenti SET pripadnost='$nova_pripadnost' WHERE id=$dokument_id ;");

echo "<i>Promenjeno! </i>";

?>
