<?php

session_start();
set_time_limit(0);
require_once ROOT_PATH . "ukljuci/povezivanje.php";
require_once ROOT_PATH . "ukljuci/povezivanje2.php";
$naslov = $naslov ?: "Znaci | Baza podataka o drugom svetskom ratu na tlu Jugoslavije";

$ulogovan = false;
if($_SESSION["nadimak"] == NADIMAK || $_COOKIE["nadimak"] == NADIMAK) {
    $ulogovan = true;
}

include_once ROOT_PATH . "ukljuci/kesh-pocinje.php";
$tekuca_strana = $_SERVER['REQUEST_URI'];
$tekuca_strana = str_replace("/damjan/", "", $tekuca_strana);

?>
<!doctype HTML>
<head>
  <meta charset="UTF-8">
  <title><?php echo $naslov; ?> | Arhiv Znaci</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Biblioteka Znaci, baza podataka o drugom svetskom ratu na tlu Jugoslavije. " name="description">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dist/style.css">
  <script src="<?php echo BASE_URL; ?>js/main.js"></script>
</head>

<body>

    <header class="okvir">

        <h2 id="logo" class="logo"><a href="<?php echo BASE_URL; ?>index.php">Arhiv Znaci</a></h2> <span class="sivkasto"> (u razvoju) </span>

        <ul class="meni-lista">

            <li class="meni-item <?php
            if ($tekuca_strana == "index.php" || $tekuca_strana == "" ) echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>index.php">Na današnji dan</a></li>
            <li class="meni-item <?php if ($tekuca_strana == "pretraga.php") echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>pretraga.php">Pretraga</a></li>
            <li class="meni-item <?php if ($tekuca_strana == "pojmovi.php") echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>pojmovi.php">Svi pojmovi</a></li>
            <li class="meni-item <?php if ($tekuca_strana == "fotogalerija.php") echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>fotogalerija.php">Fotogalerija</a></li>
            <li class="meni-item <?php if ($tekuca_strana == "prijava.php") echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>prijava.php">Administracija</a></li>
        </ul>
        <div class="clear"></div>
        <div class="krasnopis">Baza podataka o drugom svetskom ratu na tlu Jugoslavije</div>

    </header>
