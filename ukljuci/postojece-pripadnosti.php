<?php

include_once "povezivanje.php";

$upit_pripadnosti = "SELECT * FROM `pripadnosti` ORDER BY `id` ASC;";
$rezultat_pripadnosti = $mysqli->query($upit_pripadnosti);

echo "<option value=''></option>";		// prva opcija prazna
while($red_sve_pripadnosti = $rezultat_pripadnosti->fetch_assoc()){
	$id_pripadnosti = $red_sve_pripadnosti['id'];	// uvek drugačiji
	$naziv_pripadnosti = $red_sve_pripadnosti['strana'];

	echo "<option value='$id_pripadnosti' ";
		if ($id_pripadnosti == $prikazi_pripadnost || $naziv_pripadnosti == $prikazi_pripadnost) echo "selected";
	echo ">$naziv_pripadnosti</option>";
}

?>
