<?php

include_once "povezivanje.php";

$upit = "SELECT * FROM `pripadnosti` ORDER BY `id` ASC;";
$rezultat = $mysqli->query($upit);

echo "<option value=''></option>";		// prva opcija prazna
while($red_sve_pripadnosti = $rezultat->fetch_assoc()){
	$id_pripadnosti = $red_sve_pripadnosti['id'];	// uvek drugačiji
	$naziv_pripadnosti = $red_sve_pripadnosti['strana'];

	echo "<option value='$id_pripadnosti' ";
		if ($id_pripadnosti == $prikazi_pripadnost || $naziv_pripadnosti == $prikazi_pripadnost) echo "selected";
	echo ">$naziv_pripadnosti</option>";
}

?>
