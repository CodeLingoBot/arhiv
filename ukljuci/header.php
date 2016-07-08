<?php

	session_start();
	require_once ROOT_PATH . "ukljuci/povezivanje.php";
	include_once ROOT_PATH . "ukljuci/povezivanje2.php";
	$naslov = $naslov ? $naslov : "Biblioteka Znaci";

	$ulogovan = false;
	if($_SESSION["nadimak"] == "gost" || $_COOKIE["nadimak"] == "gost")
	{
		$ulogovan = true;
	}
	set_time_limit(0);
?>
<!doctype HTML>
<head>

	<meta charset="UTF-8">
	<title><?php echo $naslov; ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/stari.css">
	<script src="<?php echo BASE_URL; ?>js/masovni-izbor.js"></script>

</head>

<body>

	<header>

		<h1 id="logo">Biblioteka Znaci</h1> (u razvoju)

		<ul class="meni-lista">
			<a href="pretraga.php"><li>Dokumenti</li></a>
			<a href="mapa.php"><li>Mape</li></a>
			<a href="fotogalerija.php"><li>Fotogalerija</li></a>
			<a href="prijava.php"><li>Administracija</li></a>
		</ul>

	</header>
