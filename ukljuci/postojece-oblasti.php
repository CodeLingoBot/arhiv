	<?php
		include_once "povezivanje.php";

		$upit = "SELECT * FROM mesta;";
		$rezultat = $mysqli->query($upit);

		echo "<option value='0.5'>Sve oblasti</option>\n";

		while ($red_oblasti = $rezultat->fetch_assoc()) {
			$id_oblasti = $red_oblasti['id'];
			$naziv_oblasti = $red_oblasti['naziv'];
			echo "<option value='$id_oblasti' ";
				if($id_oblasti==$prikazi_oblast) echo "selected"; 
			echo ">$naziv_oblasti ($id_oblasti)</option>\n";
		}
	?>
