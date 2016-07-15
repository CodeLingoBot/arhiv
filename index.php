<?php
$naslov = "Na današnji dan";
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
include_once(ROOT_PATH . 'model/klasaIzvor.php');
include_once(ROOT_PATH . 'ukljuci/prevedi-mesec.php');

$danas = date("j");
$ovaj_mesec = date("m");

$izabran_dan = $mysqli->real_escape_string($_GET['dan']);
$izabran_mesec = $mysqli->real_escape_string($_GET['mesec']);
$izabrana_godina = $mysqli->real_escape_string($_GET['godina']);

$ratne_godine = [1942, 1943, 1944];
if ($ovaj_mesec >= 4) $ratne_godine[] = 1941;
if ($ovaj_mesec <= 5) $ratne_godine[] = 1945;
sort($ratne_godine);
$slucajna_godina = $ratne_godine[array_rand($ratne_godine)];

$dan = $izabran_dan ?: $danas;
$mesec = $izabran_mesec ?: $ovaj_mesec;
$godina = $izabrana_godina ?: $slucajna_godina;
$citljiv_mesec = prevediMesec($mesec);
$citljiv_datum = $dan . ". " . $citljiv_mesec . " " . $godina . ".";
$svi_tagovi = array();
?>

    <div class="okvir naslovna">

        <section class="slobodni-gradovi">
          <h1>Na današnji dan <?php echo $citljiv_datum; ?> godine</h1>
          <form class="mali-formular" method="get" action="index.php">
              <table>
                  <tr>
                      <td><strong>Izaberi datum</strong></td>
                  </tr>
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
              <button type="submit">Prikaži</button>
            </form>
            <div class="danasnji-dan">
                <?php
                $css_klasa = ($godina == $ratna_godina) ? 'ova-godina' : '';
                foreach ($ratne_godine as $ratna_godina) {
                  echo "<p class='$css_klasa'><a href='index.php?godina=$ratna_godina&mesec=$ovaj_mesec&dan=$danas'>$ratna_godina.</a></p>";
                }
                ?>
            </div>

            <iframe id="mapa-frejm" name="mapa-frejm" src="ukljuci/slobodni-gradovi.php?godina=<?php echo $godina;?>&mesec=<?php echo $mesec;?>&dan=<?php echo $dan;?>"></iframe>

            <div class="mapa-legenda">
                <div class="legenda-kruzic"></div>
                <span><strong>Slobodni gradovi</strong></span>
            </div>
        </section>

        <div class="dve-kolone">
          <section class="podeok kolona1">
              <h2>Događaji</h2>
              <?php
              $upit_hronologija = "SELECT * FROM hr1 WHERE yy='$godina' AND mm='$mesec' AND dd='$dan' ";
              $rezultat_hronologija = $mysqli->query($upit_hronologija);
              while ($red_hronologija = $rezultat_hronologija->fetch_assoc()){
                  $tekuci_dogadjaj_id = $red_hronologija['id'];
                  $tekuci_zapis = $red_hronologija['tekst'];
                  $ova_datoteka = new Datoteka($tekuci_dogadjaj_id, 1);
                  $ovi_tagovi = $ova_datoteka->tagovi;
                  if($ovi_tagovi) {
                      for($i = 0; $i < count($ovi_tagovi); $i++) {
                          // ako je unutra niz tagova iterira ga
                          if (is_array($ovi_tagovi[$i])){
                              for($j = 0; $j < count($ovi_tagovi[$i]); $j++) {
                                  array_push($svi_tagovi, $ovi_tagovi[$i][$j]);
                              }
                          } else array_push($svi_tagovi, $ovi_tagovi[$i]);
                      }
                  }
                  echo "<p class='zapisi'><a target='_blank' href='izvor.php?br=$tekuci_dogadjaj_id&vrsta=1'><b>" . $citljiv_datum . "</b> " . $tekuci_zapis . "</a></p>";
              } // while
              ?>
          </section>

          <section class="podeok kolona2">
              <h2>Dokumenti</h2>
              <?php
              $upit_dokumenti = "SELECT * FROM dokumenti WHERE god_izv='$godina' AND mesec_izv='$mesec' AND dan_izv='$dan' ";
              $rezultat_dokumenti = $mysqli->query($upit_dokumenti);
              while ($red_dokumenti = $rezultat_dokumenti->fetch_assoc()){
                  $tekuci_dokument_id = $red_dokumenti['id'];
                  $tekuci_opis = $red_dokumenti['opis'];
                  $ova_datoteka2 = new Datoteka($tekuci_dokument_id, 2);
                  $ovi_tagovi = $ova_datoteka2->tagovi;
                  if($ovi_tagovi) {
                      for($i = 0; $i < count($ovi_tagovi); $i++) {
                          // ako je unutra niz tagova pretresa ga
                          if(is_array($ovi_tagovi[$i])){
                              for($j = 0; $j < count($ovi_tagovi[$i]); $j++) {
                                  $svi_tagovi[] = $ovi_tagovi[$i][$j];
                              }
                          } else $svi_tagovi[] = $ovi_tagovi[$i];
                      }
                  }
                  echo "<p class='opisi'><i><a target='_blank' href='izvor.php?br=$tekuci_dokument_id&vrsta=2'>" . $tekuci_opis . "</a></i>";
              } // while
              ?>
          </section>
        </div>

        <section class="podeok fotografije">
            <h2>Fotografije </h2>
            <?php
            $upit_fotografije = "SELECT * FROM fotografije WHERE datum='$godina-00-00' ORDER BY RAND() LIMIT 20";
            $rezultat_fotografije = $mysqli->query($upit_fotografije);
            while ($red_fotografije = $rezultat_fotografije->fetch_assoc()){
                $tekuca_slika_inv = $red_fotografije['inv'];
                echo "<a target='_blank' href='izvor.php?br=$tekuca_slika_inv&vrsta=3'><img class='slike' src='slike/smanjene/$tekuca_slika_inv-200px.jpg'></a>";
            } // while
            ?>
        </section>

        <section class="podeok tagovi">
            <h2>Povezani pojmovi </h2>
            <?php
            $ukupno_pojmova = count($svi_tagovi);
            if ($ukupno_pojmova > 0) {
                // broji koliko se koji element pojavljuje i pretvara običan niz u asocijativni
                $svi_tagovi = array_count_values($svi_tagovi);
                // kopira u privremenu varijablu i redja da bi našao najveće
                $poredjani_tagovi = $svi_tagovi;
                arsort($poredjani_tagovi);
                // uzima prvi element koji ima najveću vrednost
                $najvise_ponavljanja = array_values($poredjani_tagovi)[0];
                unset($poredjani_tagovi);
                // meša niz
                $kljucevi = array_keys($svi_tagovi);
                shuffle($kljucevi);
                foreach($kljucevi as $kljuc) {
                    $novi_niz[$kljuc] = $svi_tagovi[$kljuc];
                }
                $svi_tagovi = $novi_niz;

                foreach ($svi_tagovi  as $tag => $ucestalost) {
                    $id_pojma = $tag;
                    $ponavljanje_pojma = $ucestalost;
                    $rezultat_za_naziv = $mysqli->query("SELECT naziv FROM entia WHERE id=$id_pojma ");
                    $naziv_pojma = $rezultat_za_naziv->fetch_assoc()["naziv"];

                    if ($ponavljanje_pojma > 4 && $ponavljanje_pojma > $najvise_ponavljanja * 0.5) {
                        $klasa = 'najveci_tag';
                    } else if ($ponavljanje_pojma > 4 && $ponavljanje_pojma > $najvise_ponavljanja * 0.25) {
                        $klasa = 'veliki_tag';
                    } else if ($ponavljanje_pojma > 3) {
                        $klasa = 'srednji_tag';
                    } else if ($ponavljanje_pojma > 2) {
                        $klasa = 'manji_srednji_tag';
                    } else if ($ponavljanje_pojma > 1) {
                        $klasa = 'mali_tag';
                    } else {
                        $klasa = 'najmanji_tag';
                    }    // kraj razvrstava po veličini
                    echo "<a href='pojam.php?br=$id_pojma' class='$klasa'>$naziv_pojma </a><span class='najmanji_tag'> &#9733; </span>";
                }
            } else echo "<p>Nema povezanih pojmova.</p>";
            ?>
        </section>

    </div>

<?php
include_once(ROOT_PATH . "ukljuci/podnozje.php");
?>
