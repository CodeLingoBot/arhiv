<meta charset="UTF-8">

<?php
/*

pretresti sve brojeve redom 0 < 16750 uključno
	kad naleti na sliku koju nema u bazi, insert

pretresti sve opise redom 0 < 16750 uključno
	kad naleti na opis koji nema u bazi, update
*/

require("ukljuci/povezivanje.php");
set_time_limit(0);	// uklanja svaki limit

if($_POST['kreni']) {
	$od = $_POST['od'];
	$do = $_POST['do'];

	for($i=$od; $i <= $do; $i++) {
		$opis = "http://znaci.net/o_slikama/" . $i .".jpg";
		$velicina_opisa = getimagesize($opis);

		if( $velicina_opisa !== false ) {

			//$unos = "INSERT INTO fotografije (inv) VALUES ($i); ";
			$unos = "UPDATE fotografije SET opis_jpg='$i' WHERE inv='$i';";
			mysqli_query($konekcija, $unos);
			echo "$i) pokušao sam unos opisa! <br>";
			echo $unos . "<br>";

		} else {
			echo "$i) nema opisa! <br>";
		}
	} // for
	echo $i . ") završio sam!";
} // if

?>

<form action="<?php $_SERVER[PHP_SELF]; ?>" method="post">

	<input type="number" name="od" value="1">

	<input type="number" name="do" value="16750">

	<input type="submit" name="kreni" value="Kreni">

</form>
