<?php

require_once("../ukljuci/povezivanje.php");

echo "ok";

$vrsta = 2;
$upit = "SELECT entia.id, entia.vrsta, COUNT(hr_int.broj) AS ukupno FROM hr_int
INNER JOIN entia
ON hr_int.broj=entia.id
WHERE entia.vrsta=$vrsta
GROUP BY hr_int.broj
HAVING COUNT(hr_int.broj) > 10; "

$rezultat = mysqli_query($konekcija,$upit);

for($i=0; $i < 10; $i++) {

	$red = mysqli_fetch_row($rezultat);
	$prva_kolona = $red[0];
	$druga_kolona = $red[1];
	$treca_kolona = $red[2];
	$cetvrta_kolona = $red[3];
	$peta_kolona = $red[4];
	$sesta_kolona = $red[5];
	$sedma_kolona = $red[6];
	$osma_kolona = $red[7];
	$deveta_kolona = $red[8];
	
	echo $i . ") " . $prva_kolona . " | " . $druga_kolona . " | " . $treca_kolona . " | " . $cetvrta_kolona . " | " . $peta_kolona . " | " . $sesta_kolona . " | " . $sedma_kolona . " | " . $osma_kolona . " | " . $deveta_kolona . "<br>";
			
}

?>
