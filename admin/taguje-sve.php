<?php
    $naslov = "Taguje sve!";
    require_once("../ukljuci/config.php");
    include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

<div class="okvir taguje-sve">

    <h1>Masovno taguje</h1>

<?php
if (!$ulogovan) {
    echo "<p>Morate biti <a href='../prijava.php'>prijavljeni</a> da biste pristupili administriranju.</p>";
    die();
}

const SVE_OBLASTI = 0.5;
$naziv_oznake = $_POST['naziv_oznake'];
$br_oznake = $_POST['br_oznake'];
$obrazac = $_POST['obrazac'] ?: " ";
$dodatni_obrazac = $_POST['dodatni_obrazac'] ?: " ";
$dodatni_obrazac2 = $_POST['dodatni_obrazac2'] ?: " ";
$eliminator = $_POST['eliminator'];
$eliminator2 = $_POST['eliminator2'];
$eliminator3 = $_POST['eliminator3'];
$eliminisi_oblast = $_POST['eliminisi_oblast'];
$eliminisi_oblast2 = $_POST['eliminisi_oblast2'];
$vrsta_oznake = $_POST['vrsta_oznake'] ?: 0;
$vrsta_materijala = $_POST['vrsta_materijala'] ?: 1;
if ($vrsta_materijala == 1) {$naziv_tabele = "hr1";}
if ($vrsta_materijala == 2) {$naziv_tabele = "dokumenti";}
if ($vrsta_materijala == 3) {$naziv_tabele = "fotografije";}
$trazena_oblast = $_POST['trazena_oblast'] ?: SVE_OBLASTI;
$izabrana_oblast = $_POST['izabrana_oblast'];
$regex_dodatno = $_POST['regex_dodatno'] || "" ? $_POST['regex_dodatno'] : "i"; // case insensitive

// salje upit i lista rezultate
$rezultat = mysqli_query($konekcija, "SELECT * FROM $naziv_tabele ; ");
$ukupno_dokumenata = mysqli_num_rows($rezultat);
$pocni_od = $_POST['pocni_od'] ?: 1;
$prikazi_do = $_POST['prikazi_do'] ?: 100;
if ($prikazi_do>$ukupno_dokumenata) {$prikazi_do = $ukupno_dokumenata;}

?>

  <form method="post" action="<?php $_SERVER[PHP_SELF]; ?>">

      Izaberi oznaku: <div class="sugestije-okvir">
          <input class="js-sugestija" name="naziv_oznake" id="naziv_oznake" autocomplete="off" value="<?php echo $naziv_oznake; ?>">
          <span></span>
          <input name="br_oznake" id="br_oznake" type="number" value="<?php echo $br_oznake; ?>">
      </div>

      vrsta oznake
      <select name="vrsta_oznake" id="vrsta_oznake">
          <option value='0'>jedinice</option>
          <option value='2'>gradovi</option>
          <option value='3'>ličnosti</option>
          <option value='4'>operacije</option>
          <option value='5'>zločini</option>
          <option value='6'>teme</option>
          <option value='7'>organizacije</option>
      </select>
      <script>vrsta_oznake.value="<?php echo $vrsta_oznake; ?>";</script>

      ili <div class="dugme" id="pravi-tag">Napravi oznaku</div>
      <br><br>

      Traženi obrazac: <input name="obrazac" value="<?php echo $obrazac; ?>">
      <input name="regex_dodatno" value="<?php echo $regex_dodatno; ?>" class="regex_dodatno">

      oblast:
      <select name="trazena_oblast" id="trazena_oblast">
          <?php include ROOT_PATH . "ukljuci/postojece-oblasti.php"; ?>
      </select>
      <script>trazena_oblast.value="<?php echo $trazena_oblast; ?>";</script>

      materijal:
      <select name="vrsta_materijala" id="vrsta_materijala">
          <option value='1'>Hronologija</option>
          <option value='2'>Dokumenti</option>
          <option value='3'>Fotografije</option>
      </select>
      <script>vrsta_materijala.value="<?php echo $vrsta_materijala; ?>";</script>
      <br>
      <br>

      dodatni uslov: <input name="dodatni_obrazac" value="<?php echo $dodatni_obrazac; ?>">
      dodatni uslov2: <input name="dodatni_obrazac2" value="<?php echo $dodatni_obrazac2; ?>">
      eliminiši oblast: <input name="eliminisi_oblast" type="number" value="<?php echo $eliminisi_oblast; ?>">
      eliminiši oblast2: <input name="eliminisi_oblast2" type="number" value="<?php echo $eliminisi_oblast2; ?>">
      <br>
      <br>

      eliminator: <input name="eliminator" value="<?php echo $eliminator; ?>">
      eliminator2: <input name="eliminator2" value="<?php echo $eliminator2; ?>">
      eliminator3: <input name="eliminator3" value="<?php echo $eliminator3; ?>">
      <br>
      <br>

      Počni od: <input type="number" name="pocni_od" value="<?php echo $pocni_od; ?>">
      prikaži do: <input type="number" name="prikazi_do" value="<?php echo $prikazi_do; ?>">
      <input type="submit" name="trazi" class="prikazi" value="Prikaži materijal"><br>
      <br>
      <br>

      <div class="rezultati">

<?php

  $obrazac = "/" . $obrazac . "/$regex_dodatno";
  $brojac = 1;  // ogranicava prikazivanje rezultata

  for ($i = 0; $i < $ukupno_dokumenata; $i++){
      $red = mysqli_fetch_row($rezultat);
      // vadi id
      if($vrsta_materijala == 3) {
          $id = $red[1];
      } else {
          $id = $red[0];
      }
      // vadi datum i opis
      if($vrsta_materijala == 1) {
          $datum = $red[1] . "." . $red[2] . "." . $red[3] . ". ";
          $opis = $red[5];
          $opis = $datum . $opis;
      }
      if($vrsta_materijala == 2) {$opis = $red[1];}
      if($vrsta_materijala == 3) {$opis = $red[2];}

      // vadi oblast
      if($vrsta_materijala == 1) {$oblast = $red[6];}
      if($vrsta_materijala == 2) {$oblast = $red[13];}
      if($vrsta_materijala == 3) {$oblast = $red[5];}

      $sadrzi_obrazac = preg_match($obrazac, $opis, $pogoci);
      $sadrzi_eliminatore = ($eliminator != "" and (strpos(strtolower($opis), strtolower($eliminator))) !== false)
      || ($eliminator2 != "" and (strpos(strtolower($opis), strtolower($eliminator2))) !== false)
      || ($eliminator3 != "" and (strpos(strtolower($opis), strtolower($eliminator3))) !== false)
      || ($eliminisi_oblast == $oblast)
      || ($eliminisi_oblast2 == $oblast);
      $ispunjava_dodatno = (strpos(strtolower($opis), strtolower($dodatni_obrazac)) !== false)
      && (strpos(strtolower($opis), strtolower($dodatni_obrazac2)) !== false)
      && (($trazena_oblast == SVE_OBLASTI) || ($trazena_oblast == $oblast));

      if($sadrzi_obrazac && !$sadrzi_eliminatore && $ispunjava_dodatno){
          // bespotrebno dodaje crveni span na prazna polja
          $opis = preg_replace($obrazac, "<span class='crveno'>$pogoci[0]</span>", $opis);

          if($brojac >= $pocni_od and $brojac <= $prikazi_do) {

              echo "<div class='odeljak_opis'>
              <p>". $brojac . ") <i>" . $id . " </i> <a target='_blank' href='../izvor.php?br=$id&vrsta=$vrsta_materijala'>" . $opis . " </a> <input value=$oblast class='oblast' ondblclick='promeniOblast(this.nextElementSibling, $id, $vrsta_materijala, this.value)'><span></span></p>";

              if($vrsta_materijala == 3) {
                  $izvor_slike = REMOTE_ROOT . "slike/smanjene/$id-200px.jpg";
                  echo "<img src=$izvor_slike><br>";
              }

              echo "<div class='dugme js-taguj' data-id='$id'>Taguj ovo </div>
              <div class='dugme js-brisi' data-id='$id'>Obriši tag </div></div>";

              if($_POST['taguj_sve']) {
                  // proverava jel tagovano
                  $provera = mysqli_query($konekcija, "SELECT * FROM hr_int WHERE broj=$br_oznake AND zapis=$id AND vrsta_materijala=$vrsta_materijala;");

                  if(mysqli_num_rows($provera) == 0) {

                      mysqli_query($konekcija, "INSERT INTO hr_int (vrsta_materijala,broj,zapis) VALUES ($vrsta_materijala,$br_oznake,$id) ");
                      echo "<i class='crveno'>Tagovano! </i><br>";

                  } else {
                      echo "<i>Već je tagovano. </i><br>";
                  }
              } // kraj if taguj_sve

              if($_POST['obrisi_sve']) {
                  mysqli_query($konekcija, "DELETE FROM hr_int WHERE vrsta_materijala='$vrsta_materijala' AND broj='$br_oznake' AND zapis='$id'; ");
                  echo "<i>Izbrisano. </i><br>";
              } // kraj if obrisi_sve

              if($_POST['masovno_oblast']) {
                  if($vrsta_materijala == 1) {
                      $upit = "UPDATE hr1 SET zona=$izabrana_oblast WHERE id=$id ;";
                  }
                  if($vrsta_materijala == 2) {
                      $upit = "UPDATE dokumenti SET oblast=$izabrana_oblast WHERE id=$id ;";
                  }
                  if($vrsta_materijala == 3) {
                      $upit = "UPDATE fotografije SET oblast=$izabrana_oblast WHERE inv=$id ;";
                  }
                  mysqli_query($konekcija, $upit);
                  echo "<i>Oblast uneta. </i><br>";
              } // if masovno_oblast
          }    // if vece od pocni_od
          $brojac++;
      }    // if sadrzi_obrazac
  }    // for

?>

      </div>

      <br>
      <input type="submit" name="taguj_sve" class="upozorenje" value="Taguj sve!">
      <input type="submit" name="obrisi_sve" class="upozorenje" value="Obriši tagove!">
      <input id="izabrana_oblast" name="izabrana_oblast" class="masovna-oblast float-right" size="5" onkeyup="masovnoBiraOblast();">
      <input type="submit" name="masovno_oblast" class="upozorenje margin-sm-right float-right" value="Masovno oblast!">
  </form>
  <br>

</div>

<script src="<?php echo BASE_URL; ?>js/admin.js"></script>

<?php
include ROOT_PATH . "ukljuci/podnozje.php";
?>
