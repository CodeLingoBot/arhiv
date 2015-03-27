<?php

	require_once("ukljuci/config.php");
	include_once(ROOT_PATH . 'ukljuci/header.php');

?>

<style>

	.unos-sirina {
		width:200px;
	}
	
	#mapa-frejm{
		border:0;
		height:600px;
		width:100%;
		margin-top:10px;
	}

</style>

	<div class="sredina">

		<h1 id="naslov-pretraga">Slobodni gradovi</h1>
		
		<p>Izaberi datum za prikaz slobodnih gradova u okupiranoj Jugoslaviji (polazno stanje je današnji dan 1943. godine)</p>

		<form name="formular" method="get" action="slobodni-gradovi.php" target="mapa-frejm">
			
			<table>
				<tr>
					<td>Godina: </td>
					<td><input id="godina" name="godina" type="number" min="1941" max="1945" value="<?php echo $godina; ?>" class="unos-sirina"></td>
				</tr>
				<tr>
					<td>Mesec: </td>
					<td><input id="mesec" name="mesec" type="number" min="1" max="12" value="<?php echo $mesec; ?>" class="unos-sirina"></td>
				</tr>
				<tr>
					<td>Dan: </td>
					<td><input id="dan" name="dan" type="number" min="1" max="31" value="<?php echo $dan; ?>" class="unos-sirina"></td>
				</tr>
			</table>

			<button type="submit" id="potvrdi" name="potvrdi">Prikaži</button>

		</form>
		
		<iframe id="mapa-frejm" name="mapa-frejm" src="slobodni-gradovi.php"></iframe>

	</div>
	
<?php include_once(ROOT_PATH . "ukljuci/footer.php"); ?>