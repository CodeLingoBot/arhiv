<?php
require_once("../ukljuci/povezivanje.php");

$dokument_id = $_POST['dokument_id'];
$nova_pripadnost = $_POST['nova_pripadnost'];
$nova_pripadnost = $mysqli->real_escape_string($nova_pripadnost);

$upit = "UPDATE dokumenti SET pripadnost='$nova_pripadnost' WHERE id=$dokument_id ;";
$mysqli->query($upit);

echo "<i>Promenjeno! </i>";
?>
