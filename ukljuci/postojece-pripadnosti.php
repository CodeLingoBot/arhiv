<?php

$upit_za_sve_pripadnosti = "SELECT * FROM `pripadnosti` ORDER BY `id` ASC;";
$rezultat_za_sve_pripadnosti = mysqli_query($konekcija, $upit_za_sve_pripadnosti);

echo "<option value=''></option>";		// prva opcija prazna
while($red_sve_pripadnosti = mysqli_fetch_assoc($rezultat_za_sve_pripadnosti)){

	$id_pripadnosti = $red_sve_pripadnosti['id'];	// uvek drugačiji
	$naziv_pripadnosti = $red_sve_pripadnosti['strana'];

	echo "<option value='$id_pripadnosti' ";
		if ($id_pripadnosti == $prikazi_pripadnost || $naziv_pripadnosti == $prikazi_pripadnost) echo "selected";
	echo ">$naziv_pripadnosti</option>";

}	// while

?>
