<?php

require_once("../ukljuci/povezivanje2.php");

$vrsta_materijala = $_GET['vrsta_materijala'];
$oblast = $_GET['oblast'];
$id = $_GET['id'];

if($vrsta_materijala == 1) { 
	$upit = "UPDATE hr1 SET zona=$oblast WHERE id=$id ;";
} 
if($vrsta_materijala == 2) { 
	$upit = "UPDATE dokumenti SET oblast=$oblast WHERE id=$id ;";
} 
if($vrsta_materijala == 3) { 
	$upit = "UPDATE fotografije SET oblast=$oblast WHERE inv=$id ;";
} 

$mysqli->query($upit); 

echo "<i> Izmenjeno! </i>";
//echo $upit;
?>
