	<?php
		// podrazumeva vezu sa bazom, ne radi sam
		$upit_za_oblasti = "SELECT * FROM mesta;";
		$rezultat_za_oblasti = mysqli_query($konekcija, $upit_za_oblasti);

		echo "<option value='0.5'>Sve oblasti</option>\n";

		while ($red_oblasti = mysqli_fetch_assoc($rezultat_za_oblasti)) {
		
			$id_oblasti = $red_oblasti['id'];
			$naziv_oblasti = $red_oblasti['naziv'];
		
			echo "\t\t\t<option value='$id_oblasti' ";
				if($id_oblasti==$prikazi_oblast) echo "selected"; 
			echo ">$naziv_oblasti ($id_oblasti)</option>\n";
			
		}
	?>
