<?php

require_once("../ukljuci/povezivanje2.php");
	
$id = $_GET['id'];
$vrsta_materijala = $_GET['vrsta'];
$dan = $_GET['dan'];
$mesec = $_GET['mesec'];
$godina = $_GET['godina'];
$datum = $_GET['datum'];

if($vrsta_materijala == 1) { 
	$upit = "UPDATE hr1 SET dd=$dan, mm=$mesec, yy=$godina WHERE id=$id ;";
} 
if($vrsta_materijala == 2) { 
	$upit = "UPDATE dokumenti SET dan_izv=$dan, mesec_izv=$mesec, god_izv=$godina WHERE id=$id ;";
} 
if($vrsta_materijala == 3) { 
	$upit = "UPDATE fotografije SET datum='$datum' WHERE inv=$id ;";
} 

$mysqli->query($upit); 

echo "<i> Promenjen datum! </i>";
//echo $upit;
?>
