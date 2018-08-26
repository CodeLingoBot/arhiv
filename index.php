<?php
$naslov = "Na današnji dan u Drugom svetskom ratu";
require_once("ukljuci/config.php");
if (empty($_GET)) {
    $kesh_trajanje = strtotime('tomorrow') - time();  // do isteka dana
}
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
include_once(ROOT_PATH . 'funkcije/prevedi-mesec.php');
include_once(ROOT_PATH . 'model/Dogadjaj.php');
include_once(ROOT_PATH . 'model/Dokument.php');
include_once(ROOT_PATH . 'model/Datum.php');

$datum = new Datum($_GET['dan'], $_GET['mesec'], $_GET['godina']);

?>

    <div class="okvir naslovna">

        <section class="slobodni-gradovi">
            <h1>Jugoslovensko ratište dana <?php echo $datum->datum; ?>. godine</h1>
            <div class="ratne-godine">
                <?php
                foreach ($datum->ratne_godine as $ratna_godina) {
                  $css_klasa = 'ratna-godina';
                  if ($datum->godina == $ratna_godina) $css_klasa .= ' ova-godina';
                  echo "<a href='index.php?godina=$ratna_godina&mesec=$datum->mesec&dan=$datum->dan'><p class='$css_klasa'>$ratna_godina.</p></a>";
                }
                ?>
            </div>
            <?php include_once(ROOT_PATH . 'ukljuci/mapa.php'); ?>
        </section>

        <div class="dve-kolone">
          <div class="hronologija-drzac relative">
            <?php include(ROOT_PATH . 'ukljuci/prstodrzaci.php'); ?>
            <section class="podeok hronologija">
                <h2>Događaji</h2>
                <?php $datum->render_dogadjaji(); ?>
            </section>
          </div>

          <div class="relative full">
            <?php include(ROOT_PATH . 'ukljuci/prstodrzaci.php'); ?>
            <section class="podeok dokumenti">
                <h2>Dokumenti</h2>
                <?php $datum->render_dokumenti(); ?>
            </section>
          </div>
        </div>

        <div class="relative">
            <?php include(ROOT_PATH . 'ukljuci/prstodrzaci.php'); ?>
            <section class="podeok fotografije">
                <h2>Fotografije </h2>
                <?php $datum->render_fotografije(); ?>
            </section>
        </div>
        
        <div class="relative">
            <div class="hide-lg kruzic prstodrzac prstodrzac-gore"></div>
            <section class="podeok tagovi">
                <h2>Povezane odrednice</h2>
                <?php $datum->render_odrednice(); ?>
            </section>
        </div>

    </div>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
