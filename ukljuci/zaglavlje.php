<?php

	session_start();
	set_time_limit(0);
	require_once ROOT_PATH . "ukljuci/povezivanje.php";
	require_once ROOT_PATH . "ukljuci/povezivanje2.php";
	$naslov = $naslov ?: "Baza dokumenata o Velikom oslobodilačkom ratu";

	$ulogovan = false;
	if($_SESSION["nadimak"] == "gost" || $_COOKIE["nadimak"] == "gost")
	{
		$ulogovan = true;
	}

	$tekuca_strana = $_SERVER['REQUEST_URI'];
	$tekuca_strana = str_replace("/damjan/", "", $tekuca_strana);

?>
<!doctype HTML>
<head>

  <meta charset="UTF-8">
  <title><?php echo $naslov; ?> | Arhiv Znaci</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Biblioteka Znaci, baza podataka o drugom svetskom ratu na tlu Jugoslavije. " name="description">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/main.css">

</head>

<body>

	<header>

		<h2 id="logo"><a href="<?php echo BASE_URL; ?>index.php">Arhiv Znaci</a></h2> <span class="bledo"> (u razvoju) </span>

		<ul class="meni-lista">

			<a href="<?php echo BASE_URL; ?>index.php"><li <?php
			if ($tekuca_strana == "index.php" || $tekuca_strana == "" ) {
				echo "class='tekuca_strana'";} ;?>>Na današnji dan</li></a>
			<a href="<?php echo BASE_URL; ?>biblioteka.php"><li>Biblioteka</li></a>
			<a href="<?php echo BASE_URL; ?>pretraga.php"><li>Pretraga</li></a>
			<a href="<?php echo BASE_URL; ?>pojmovi.php"><li>Svi pojmovi</li></a>
			<a href="<?php echo BASE_URL; ?>fotogalerija.php"><li>Fototeka</li></a>
			<a href="<?php echo BASE_URL; ?>prijava.php"><li>Administracija</li></a>
		</ul>
		<div class="clear"></div>
		<div class="krasnopis">Baza podataka o drugom svetskom ratu na tlu Jugoslavije</div>

	</header>
