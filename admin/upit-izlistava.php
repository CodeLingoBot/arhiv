<?php

$naslov = "Lista upit";
require_once("../ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');

/*
// prikazuje sve tagove vrste 3
$upit = "
SELECT hr_int.broj, entia.vrsta
FROM hr_int INNER JOIN entia
ON hr_int.broj = entia.id
WHERE entia.vrsta = 3;
";

// bira sve pojmove entia.vrste 3 koji imaju više od 10 oznaki
$upit = "
SELECT entia.id, entia.vrsta, COUNT(hr_int.broj) AS ukupno
FROM hr_int INNER JOIN entia
ON hr_int.broj = entia.id
WHERE entia.vrsta = 3
GROUP BY hr_int.broj
HAVING COUNT(hr_int.broj) > 0;
";

$upit = "
SELECT `broj`, COUNT(`broj`) AS `ukupno`
FROM `hr_int`
GROUP BY `broj` HAVING COUNT(broj) > 10
ORDER BY RAND()
LIMIT 200;
";
*/

//$upit = "SELECT * FROM entia";
//$upit = "SELECT * FROM hr_int WHERE broj = 274 AND vrsta_materijala=2; ";
//$upit = "SHOW TABLES FROM znaci";
//$upit = "SELECT * FROM hr_int ORDER BY id DESC ";
$upit = "select * from hr_int where broj=10  ";


/***********************************************************************
entia:
0) id | int(11) | NO | PRI | | auto_increment | | |
1) naziv | varchar(120) | NO | UNI | | | | |
2) naziv2 | varchar(120) | NO | | | | | |
3) vrsta | int(11) | NO | | | | | |
4) rang | int(11) | NO | | | | | |
5) prip | int(11) | NO | | | | | |
6) n | decimal(6,3) | NO | | | | | |
7) e | decimal(6,3) | NO | | | | | |
8) a | int(11) | NO | | | | | |


hr_int (tj. tagovi):
0) id | bigint(20) | NO | PRI | | auto_increment | | |
1) vrsta | int(11) | NO | | | | | |
2) vrsta_materijala | int(11) | NO | | 0 | | | |
3) broj | int(11) | NO | | | | | |
4) zapis | int(11) | NO | | | | | |


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
5) oblast | int(11) | NO | | | | | |


vreme:
0) id | int(11) | NO | PRI | | auto_increment | | |
1) dokument_id | int(11) | NO | UNI | | | | |
2) dan_dog | int(11) | NO | | | | | |
3) mesec_dog | int(11) | NO | | | | | |
4) god_dog | int(11) | NO | | | | | |
5) dan_izv | int(11) | NO | | | | | |
6) mesec_izv | int(11) | NO | | | | | |
7) god_izv | int(11) | NO | | | | | |

fotografije:
0) id | int(11) | NO | PRI | | auto_increment | | |
1) inv | int(11) | NO | UNI | | | | |
2) opis | varchar(255) | NO | | | | | |
3) opis_jpg | int(11) | NO | | | | | |
4) datum | date | NO | | | | | |

eventu:
id
ko
kadd
kadmm
kadyy
sta

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
*****************************************************/

?>

<div class="okvir">

	<?php

		if($_POST['potvrdi']){
			$pocni_od = $_POST['pocni_od'] ?: 0;
			$broj_rez = $_POST['broj_rez'] ?: 10;
			$rezultat = $mysqli->query($upit);
			echo "<p>Učinio sam to. </p>";
		} else {
			echo "<p>Želiš li da izvršiš ovaj upit? </p>";
			echo "<p>" . $upit . "</p>";
		}

	?>

	<form method="post" action="upit-izlistava.php">
		Od: <input type="number" name="pocni_od" value="<?php echo $pocni_od; ?>"><br>
		Do: <input type="number" name="broj_rez" value="<?php echo $broj_rez; ?>"><br>
		<input type="submit" name="potvrdi" class="izaberi" value="Izvrši">
	</form>

	<?php

		for($i=0; $i < $broj_rez; $i++) {
			$red = $rezultat->fetch_row();
			$prva_kolona = $red[0];
			$druga_kolona = $red[1];
			$treca_kolona = $red[2];
			$cetvrta_kolona = $red[3];
			$peta_kolona = $red[4];
			$sesta_kolona = $red[5];
			$sedma_kolona = $red[6];
			$osma_kolona = $red[7];
			$deveta_kolona = $red[8];

			if($i>=$pocni_od){
				echo $i . ") " . $prva_kolona . " | " . $druga_kolona . " | " . $treca_kolona . " | " . $cetvrta_kolona . " | " . $peta_kolona . " | " . $sesta_kolona . " | " . $sedma_kolona . " | " . $osma_kolona . " | " . $deveta_kolona . "<br>";
			}
		}

	?>


</div>
