<?php

	$naslov = "Izvršava upit";
	require_once("../ukljuci/config.php");
	include_once(ROOT_PATH . 'ukljuci/header.php');

	if (!$_SESSION['nadimak'] && !$_COOKIE['nadimak']) {
		echo "<p>Morate biti <a href='../prijava.php'>prijavljeni</a> da biste pristupili administriranju.</p>";
		
	} else {	// prikazuje stranicu

		if( isset($_POST['zadan_upit']) ){
			$upit = $_POST['zadan_upit'];
			
		} else {
			
			//$upit = "DELETE FROM entia WHERE id = 1238; ";

			//$upit = "INSERT INTO `mesta` (`naziv`) VALUES ('Mađarska');";
			//$upit = "UPDATE hr1 SET dd=14, mm=9, yy=1942 WHERE id=12925";
			//$upit = "INSERT INTO hr_int (vrsta_materijala, broj, zapis) VALUES (3, 682, 16237);";
			
		}	// kraj else


/***********************************************************************
entia:
id	|	naziv	|	vrsta	|	rang	|	prip	|	n	|	e	|	a
328 | 42. divizija 	| 0 	| 4 		| 1 		| 0.000 | 0.000 | 0 	 
329 | Beograd 		| 2 	| 1 		| 1 		| 44.81 | 20.46 | 0 	 
xxx | Sremski front | 4 	| 1 		| 0 		| 0.000 | 0.000 | 0 	 
625 | Draža Mihailović | 3 	| 1 		| 55 		| 0.000 | 0.000 | 0 

hr_int (tj. tagovi):
0) id | bigint(20) | NO | PRI | | auto_increment | | | 
1) vrsta | int(11) | NO | | | | | | 
2) vrsta_materijala | int(11) | NO | | 0 | | | | 
3) broj | int(11) | NO | | | | | | 
4) zapis | int(11) | NO | | | | | | 

hr1:
0) id | int(11) | NO | PRI | | auto_increment | | | 
1) dd | int(11) | NO | | | | | | 
2) mm | int(11) | NO | | | | | | 
3) yy | int(11) | NO | | | | | | 
4) tip | int(11) | NO | | | | | | 
5) tekst | text | NO | | | | | | 
6) zona | int(11) | NO | | | | | | 
7) akteri | bigint(11) | NO | | 0 | | | | 
8) akcije | int(11) | NO | | | | | | 

dokumenti:
0) id | int(11) | NO | PRI | | auto_increment | | | 
1) opis | text | NO | | | | | | 
2) src | int(11) | NO | | | | | | 
3) rb | int(11) | NO | | | | | | 
4) p | int(11) | NO | | | | | | 
5) strana_pdf | int(11) | NO | | | | | | 
6) dan_dog | int(11) | NO | | | | | | 
7) mesec_dog | int(11) | NO | | | | | | 
8) god_dog | int(11) | NO | | | | | | 
9) dan_izv | int(11) | NO | | | | | | 
10) mesec_izv | int(11) | NO | | | | | | 
11) god_izv | int(11) | NO | | | | | | 
12) pripadnost | int(11) | NO | | | | | | 
13) oblast | int(11) | NO | | | | | | 

fotografije:
0) id | int(11) | NO | PRI | | auto_increment | | | 
1) inv | int(11) | NO | UNI | | | | | 
2) opis | varchar(255) | NO | | | | | | 
3) opis_jpg | int(11) | NO | | | | | | 
4) datum | date | NO | | | | | | 

*****************************************************/

?>

<div class="okvir">

	<?php
	
		if($_POST['potvrdi']){

			mysqli_query($konekcija,$upit);
			echo "<p>Učinio sam to. </p>";
			
		} else {
		
			echo "<p>Želiš li da izvršiš ovaj upit? </p>";
			echo "<p>" . $upit . "</p>";
		
		}

	?>

	<form method="post" action="upit.php">
	
		<input size="80" name="zadan_upit" id="zadan_upit" value="<?php echo $upit; ?>">
		<br>
		<br>
		<input type="submit" name="posalji" class="izaberi" value="Pošalji">

		<input type="submit" name="potvrdi" class="izaberi" value="Izvrši">

	</form>

</div>

<?php

}	// kraj else prikazuje stranicu

include "../ukljuci/footer.php";

?>
