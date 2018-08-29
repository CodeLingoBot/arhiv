<?php
/* odgovara na funkciju pokaziSugestije */

require_once("../ukljuci/povezivanje.php");

$slog = filter_input(INPUT_GET, 'pocetno', FILTER_SANITIZE_STRING);
if (!$slog) die;

$upit = "SELECT naziv, id, slug FROM entia WHERE naziv LIKE '%$slog%' LIMIT 15; ";
$rezultat = $mysqli->query($upit);

$i = 0;
while($red_za_pojmove = $rezultat->fetch_assoc()){
	$naziv = $red_za_pojmove['naziv'];
	$id = $red_za_pojmove['id'];
	$slug = $red_za_pojmove['slug'];
	$pojmovi[$i][] = $naziv;
	$pojmovi[$i][] = $id;
	$pojmovi[$i][] = $slug;
	$i ++;
}

echo "<ul class='lista-predloga'>";
foreach($pojmovi as $naziv_i_id) { ?>
		<li class='predlozi js-sugestije' data-id='<?php echo $naziv_i_id[1];?>' data-slug='<?php echo $naziv_i_id[2];?>'><?php echo $naziv_i_id[0]; ?></li>
<?php }
echo "</ul>";

?>
