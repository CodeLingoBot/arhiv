<?php

require_once("../ukljuci/povezivanje.php");
	
$vrsta_entia = $_GET['vrsta_entia'];
$id = $_GET['id'];

$upit = "UPDATE entia SET vrsta=$vrsta_entia WHERE id=$id ;";

$mysqli->query($upit); 

echo "<i> Izmenjeno! </i>";
//echo $upit;
?>
