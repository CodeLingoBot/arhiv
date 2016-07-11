<?php
require_once("ukljuci/config.php");
require_once(ROOT_PATH . "ukljuci/klasaPojam.php");

if($_GET){
    $broj_oznake = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);
} else { $broj_oznake = 1; }

$ovaj_pojam = new Oznaka($broj_oznake);
$naslov = $ovaj_pojam->naziv;
$vrsta = $ovaj_pojam->vrsta;
$broj_tagovanih_hro = count($ovaj_pojam->tagovana_hronologija);
$broj_tagovanih_dok = count($ovaj_pojam->tagovani_dokumenti);
$broj_tagovanih_fot = count($ovaj_pojam->tagovane_slike);
$svi_tagovi = array();

// zaglavlje mora posle naslova
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

    <div class="okvir pojam">

        <section class="gornji-odeljak">
            <div class="gore-levo sugestije-okvir">
                <img class="slika-ustanak" src="slike/ustanak.jpg" alt="ustanak" />
                <h1 id='pojam' class="no-outline" contenteditable="true" onkeyup="pokaziSugestije(this.textContent || this.innerText, this.nextElementSibling)"><?php echo $ovaj_pojam->naziv ?></h1>

                <div id="polje_za_sugestije"></div>
                <input type="hidden" name="br" id="br_oznake" value="<?php echo $broj_oznake; ?>">
                <div id="izaberi-pojam" class='tag-dugme' onclick='otvoriStranu()'>Izaberi pojam</div>
                <?php
                    if($ulogovan == true) {
                        echo "<div class='tag-dugme' onclick='promeniNaziv(this, $broj_oznake);'>Promeni naziv</div><span></span>\n";
                    }
                ?><br>
                <p class="krasnopis siva-donja-crta padding-sm-bottom inline-block">Za ovaj pojam je pronađeno <span><?php echo $broj_tagovanih_hro; ?></span> hronoloških zapisa, <span><?php echo $broj_tagovanih_dok; ?></span> dokumenata i <span><?php echo $broj_tagovanih_fot; ?></span> fotografija.</p>

                <input type="hidden" id="broj_tagovanih_hro" value="<?php echo $broj_tagovanih_hro; ?>">
                <input type="hidden" id="broj_tagovanih_dok" value="<?php echo $broj_tagovanih_dok; ?>">
                <input type="hidden" id="broj_tagovanih_fot" value="<?php echo $broj_tagovanih_fot; ?>">
            </div>
            <div class="clear"></div>
        </section>

        <div class="dve-kolone">
          <section class="podeok kolona1" onscroll="ucitajJos('hronologija')">
              <h2 class="naslov-odeljka">Hronologija </h2>
              <div id="hronologija">
                  <p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Hronološki zapisi se učitavaju...</p>
              </div>
          </section>

          <section class="podeok kolona2" onscroll="ucitajJos('dokumenti')">
              <h2 class="naslov-odeljka">Dokumenti </h2>
              <div id="dokumenti">
                <?php
                  $broj_pojma = $broj_oznake;
                  require_once("../ukljuci/klasaPojam.php");
                  require_once("../ukljuci/povezivanje2.php");
                  $ovaj_pojam = new Oznaka($broj_pojma);
                  $broj_tagovanih_dok = count($ovaj_pojam->tagovani_dokumenti);
                  $svi_tagovi = array();

                  $ucitaj_od = 0;
                  $ucitaj_do = 30;
                  if($ucitaj_do > $broj_tagovanih_dok) $ucitaj_do = $broj_tagovanih_dok;

                  if ($broj_tagovanih_dok > 0) {
                      for ($i = $ucitaj_od; $i < $ucitaj_do; $i++) {
                          $tekuci_dokument = $ovaj_pojam->tagovani_dokumenti[$i];
                          $ova_datoteka = new Datoteka($tekuci_dokument, 2);
                          $ovaj_opis = $ova_datoteka->opis;
                          $ovi_tagovi = $ova_datoteka->tagovi;

                          if($ovi_tagovi) {
                              for($brojac = 0; $brojac < count($ovi_tagovi); $brojac++) {
                                  if(is_array($ovi_tagovi[$brojac])){
                                      for($j = 0; $j < count($ovi_tagovi[$brojac]); $j++) {
                                          $svi_tagovi[] = $ovi_tagovi[$brojac][$j];
                                      } // kraj petlje
                                  } else {
                                      $svi_tagovi[] = $ovi_tagovi[$brojac];
                                  }
                              } // for
                          } // if

                          echo "<p class='opisi'><i><a target='_blank' href='izvor.php?br=$tekuci_dokument&vrsta=2'>" . $ovaj_opis . "</a></i>";
                          if ($ulogovan == true) {
                              echo "<br><span class='tag-dugme' onclick='pozadinskiBrisi(this, 2, $broj_pojma, $tekuci_dokument)'>Obriši tag </span><span></span>\n";
                          }
                          echo "</p>";
                      }    // for

                      $tagovi_dokumenata = json_encode($svi_tagovi);
                      echo "<p class='prikupljeni_tagovi nevidljiv'>$tagovi_dokumenata</p>";

                      if($ucitaj_do < $broj_tagovanih_dok) {
                          echo '<p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Još materijala se učitava...</p>';
                      }

                  } else {
                      echo "Nema pronađenih dokumenata za ovaj pojam. ";
                  }

                 ?>
                  <p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Molimo sačekajte, dokumenti se učitavaju...</p>
              </div>
          </section>
        </div>

        <section class="podeok fotografije" onscroll="ucitajJos('fotografije')">
            <h2 class="naslov-odeljka">Fotografije </h2>
            <div id="fotografije">
                <p class="ucitavac"><img src="slike/ajax-loader.gif" alt="loading" /> Istorijske fotografije se učitavaju...</p>
            </div>
        </section>

        <section class="podeok tagovi">
            <h2 class="naslov-odeljka">Povezani pojmovi: </h2>
            <div id="tagovi">
                <p><img src="slike/ajax-loader.gif" alt="loading" /> Povezani pojmovi se generišu...</p>
            </div>
        </section>

    </div>
<script src="js/pojam.js"></script>

<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
