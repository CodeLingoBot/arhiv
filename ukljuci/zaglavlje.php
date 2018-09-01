<?php

session_start();
set_time_limit(0);
require_once ROOT_PATH . "ukljuci/povezivanje.php";
$naslov = $naslov ?: "Baza podataka o drugom svetskom ratu na tlu Jugoslavije";

$ulogovan = false;
if($_SESSION["nadimak"] == NADIMAK || $_COOKIE["nadimak"] == NADIMAK) {
    $ulogovan = true;
}

$tekuca_strana = $_SERVER['REQUEST_URI'];
$tekuca_strana = str_replace(BASE_URL, "", $tekuca_strana);

?>
<!doctype HTML>
<head>
  <meta charset="UTF-8">
  <title><?php echo $naslov; ?> | Arhiv Znaci</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Biblioteka Znaci, baza podataka o drugom svetskom ratu na tlu Jugoslavije. " name="description">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/dist/style.css">
  <script src="<?php echo BASE_URL; ?>js/main.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL; ?>favicon.ico"/>
</head>

<body>

    <header class="okvir">

        <label for="nav-checkbox" class="hide-lg"><img src="<?php echo BASE_URL; ?>slike/ikonice/burger.svg" alt="burger-meni" class="burger-meni"></label>

        <h2 id="logo" class="logo"><a href="<?php echo BASE_URL; ?>">Arhiv Znaci</a></h2>

        <div class="pretraga sugestije-okvir">
            &#128269; <input class="js-sugestija" autocomplete="off">
            <div id="sugestije_odrednica"></div>
            <input type="hidden">
        </div>

        <input type="checkbox" class="nav-checkbox hide" id="nav-checkbox" />
        <ul class="meni-lista">
            <li class="meni-item <?php if ($tekuca_strana == "" ) echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>">Naslovna</a></li>
            <li class="meni-item <?php if (strpos($tekuca_strana, "dokumenti") !== false) echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>dokumenti">Dokumenti</a></li>
            <li class="meni-item <?php if (strpos($tekuca_strana, "odrednice") !== false) echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>odrednice">Odrednice</a></li>
            <li class="meni-item <?php if (strpos($tekuca_strana, "fotografije") !== false) echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>fotografije">Fotografije</a></li>
            <li class="meni-item <?php if ($tekuca_strana == "prijava.php" || $tekuca_strana == "admin/index.php") echo "trenutna-strana";?>"><a href="<?php echo BASE_URL; ?>prijava.php">Administracija</a></li>
        </ul>

        <div class="clear"></div>
        <div class="krasnopis">Baza podataka o drugom svetskom ratu na tlu Jugoslavije</div>

    </header>
