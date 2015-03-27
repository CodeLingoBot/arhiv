<?php 
$naslov = "Spisak pojmova";
require_once("ukljuci/config.php");
require "ukljuci/zaglavlje.php";

$upit = "SELECT * FROM entia";
$rezultat = $mysqli->query($upit);

?>

<div class="sredina pojmovi">
	
	<h1>Spisak pojmova</h1>

	<ul id="kucica">
		<a href="#Jedinice"><li>Jedinice</li></a>
		<a href="#Bitke i operacije"><li>Bitke i operacije</li></a>
		<a href="#Organizacije"><li>Organizacije</li></a>
		<a href="#Ličnosti"><li>Ličnosti</li></a>
		<a href="#Gradovi"><li>Gradovi</li></a>
		<a href="#Zločini"><li>Zločini</li></a>
		<a href="#Teme"><li>Teme</li></a>
	</ul>
	
	<?php
		while($red = $rezultat->fetch_assoc()){
			$id = $red["id"];
			$naziv = $red["naziv"];
			$vrsta = $red["vrsta"];
			$rang = $red["rang"];
			$prip = $red["prip"];
			
			if($vrsta == 0) {
				$jedinica = [];
				$jedinica['id'] = $id;
				$jedinica['naziv'] = $naziv;
				$jedinica['rang'] = $rang;
				$jedinica['prip'] = $prip;	
			}
			
			switch ($vrsta) {
				case 0:
					$jedinica = [];
					$jedinica['id'] = $id;
					$jedinica['naziv'] = $naziv;
					$jedinica['rang'] = $rang;
					$jedinica['prip'] = $prip;	
					$jedinice[] = $jedinica;				
					break;
				case 2:
					$grad = [];
					$grad['id'] = $id;
					$grad['naziv'] = $naziv;
					$grad['rang'] = $rang;
					$grad['prip'] = $prip;	
					$gradovi[] = $grad;				
					break;
				case 3:
					$licnost = [];
					$licnost['id'] = $id;
					$licnost['naziv'] = $naziv;
					$licnost['rang'] = $rang;
					$licnost['prip'] = $prip;	
					$licnosti[] = $licnost;				
					break;
				case 4:
					$operacija = [];
					$operacija['id'] = $id;
					$operacija['naziv'] = $naziv;
					$operacija['rang'] = $rang;
					$operacija['prip'] = $prip;	
					$operacije[] = $operacija;				
					break;
				case 5:
					$zlocin = [];
					$zlocin['id'] = $id;
					$zlocin['naziv'] = $naziv;
					$zlocin['rang'] = $rang;
					$zlocin['prip'] = $prip;	
					$zlocini[] = $zlocin;				
					break;
				case 6:
					$tema = [];
					$tema['id'] = $id;
					$tema['naziv'] = $naziv;
					$tema['rang'] = $rang;
					$tema['prip'] = $prip;	
					$teme[] = $tema;				
					break;
				case 7:
					$organizacija = [];
					$organizacija['id'] = $id;
					$organizacija['naziv'] = $naziv;
					$organizacija['rang'] = $rang;
					$organizacija['prip'] = $prip;	
					$organizacije[] = $organizacija;				
					break;
				default:
					$nesvrstan = [];
					$nesvrstan['id'] = $id;
					$nesvrstan['naziv'] = $naziv;
					$nesvrstan['rang'] = $rang;
					$nesvrstan['prip'] = $prip;	
					$nesvrstani[] = $nesvrstan;	
			}
		} // kraj while	
	?>
	
	<h2 id="Jedinice">Jedinice</h2>

	<ul>
		<?php
			for($i = 0; $i < count($jedinice); $i++) {
				$id = $jedinice[$i]['id'];
				$naziv = $jedinice[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $jedinice[$i]['naziv'] . "</a>";
				
				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>

	
	<h2 id="Bitke i operacije">Bitke i operacije</h2>

	<ul>
		<?php
			for($i = 0; $i < count($operacije); $i++) {
				$id = $operacije[$i]['id'];
				$naziv = $operacije[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $operacije[$i]['naziv'] . "</a>";
				
				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>
	
	<h2>Organizacije</h2>

	<ul id="Organizacije">
		<?php
			for($i = 0; $i < count($organizacije); $i++) {
				$id = $organizacije[$i]['id'];
				$naziv = $organizacije[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $organizacije[$i]['naziv'] . "</a>";
				
				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>

	
	<h2 id="Ličnosti">Ličnosti</h2>
	
	<ul>
		<?php
			for($i = 0; $i < count($licnosti); $i++) {
				$id = $licnosti[$i]['id'];
				$naziv = $licnosti[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $licnosti[$i]['naziv'] . "</a>";
				
				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>


	<h2 id="Gradovi">Gradovi</h2>
	<ul>
		<?php
			for($i = 0; $i < count($gradovi); $i++) {
				$id = $gradovi[$i]['id'];
				$naziv = $gradovi[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $gradovi[$i]['naziv'] . "</a>";
				
				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>

	
	<h2 id="Zločini">Zločini</h2>

	<ul>
		<?php
			for($i = 0; $i < count($zlocini); $i++) {
				$id = $zlocini[$i]['id'];
				$naziv = $zlocini[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $zlocini[$i]['naziv'] . "</a>";
				
				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>


	<h2 id="Teme">Teme</h2>

	<ul>
		<?php
			for($i = 0; $i < count($teme); $i++) {
				$id = $teme[$i]['id'];
				$naziv = $teme[$i]['naziv'];
				echo "<li><a href='pojam.php?br=$id' target='_blank'>" . $teme[$i]['naziv'] . "</a> ";

				if($ulogovan){
					echo " <select name='vrsta_entia' id='vrsta_entia'>";
						include "ukljuci/postojece-vrste.php";
					echo "</select> ";
					echo "<span class='tag-dugme' onclick='promeniVrstu(this, $id)'>Promeni vrstu </span><span></span></li>";
				} // kraj if ulogovan
			}
		?>
	</ul>
	
	
</div>
	
<?php 
include "ukljuci/podnozje.php";
?>